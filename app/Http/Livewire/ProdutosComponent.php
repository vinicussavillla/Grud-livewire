<?php

namespace App\Http\Livewire;

use App\Models\Produtos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


class ProdutosComponent extends Component
{
    use WithFileUploads;
    public $produto_id, $name, $image, $descricao, $preco;
    public $produto_edit_id;
    public $deleteId = '';
    public $searchTerm;

    public function updated($fields)
    {
       // Input fields on update validation
       $this->validateOnly($fields, [
          'produto_id'=>'required|unique:produtos',
          'name'=>'required',
          'image' => 'required',
          'descricao' => 'required',
          'preco' => 'required|numeric',
       ]);
    }

    public function storeprodutoData()
    {
       //on form submit validation
       $this-> validate([
        'produto_id'=>'required|unique:produtos',
        'name'=>'required',
        'image' => 'required',
        'descricao' => 'required',
        'preco' => 'required|numeric',
       ]);

    // Add Produto Data
    $produto = new Produtos();
    $produto-> produto_id = $this->produto_id;
    $produto->name = $this->name;
    $produto->descricao = $this->descricao;
    $produto->preco = $this->preco;
    $imageName = Carbon::now()->timestamp. '.' .$this->image->extension();
    $this->image->storeAs('image_uploads', $imageName);
    $produto->image = $imageName;

    $produto->save();

    session()->flash('message', 'Novo produto foi adicionado com sucesso');

        $this->produto_id = '';
        $this->name = '';
        $this->image = '';
        $this->descricao = '';
        $this->preco = '';

        //For hide modal after add produto success
        $this->dispatchBrowserEvent('close-modal');

    }

    // ---------------------------------------------

    public function editprodutos($id)
    {
        $produto = Produtos::where('id', $id)->first();

        $this->produto_edit_id = $produto->id;
        $this->produto_id = $produto->produto_id;
        $this->name = $produto->name;
        $this->descricao = $produto->descricao;
        $this->preco = $produto->preco;

        $this->dispatchBrowserEvent('show-edit-produto-modal');
    }

    public function editprodutoData()
    {
        // on form submit validation
        $this->validate([
            'produto_id' => 'required|unique:Produtos,produto_id,'.$this->produto_edit_id.'', //Validation with ignoring own data
            'name'=>'required',
            'image' => 'required',
            'descricao' => 'required',
            'preco' => 'required|numeric',
        ]);

        $produto = Produtos::where('id', $this->produto_edit_id)->first();
        $produto->produto_id = $this->produto_id;
        $produto->name = $this->name;
        $produto->descricao = $this->descricao;
        $produto->preco = $this->preco;

        $produto->save();

        session()->flash('message', 'produto foi atualizado com sucesso');

        //For hide modal after add produto success
        $this->dispatchBrowserEvent('close-modal');
    }

    //Delete Confirmation
    public function deleteConfirmation($id)
    {
        $this->deleteId = $id; //produto id
        $this->dispatchBrowserEvent('show-delete-confirmation-modal');
    }

    public function deletes($id)
    {
       $produtos = Produtos::findOrFail($id);
       Storage::delete($produtos->image);
       $produtos->delete();
       $this->reset();
    }


    public function resetInputs()
    {
        $this->produto_id = '';
        $this->name = '';
        $this->image = '';
        $this->descricao = '';
        $this->preco = '';
    }


    public function close()
    {
        $this->resetInputs();
    }


    public function render()
    {
        // Get all produtos
        $produtos = Produtos::where('name', 'like', '%'.$this->searchTerm.'%')->orWhere('descricao', 'like', '%'.$this->searchTerm.'%')->orWhere('produto_id', 'like', '%'.$this->searchTerm.'%')->orWhere('preco', 'like', '%'.$this->searchTerm.'%')->get();

        return view('livewire.produtos-component', ['produtos'=>$produtos])->layout('livewire.layouts.base');
    }
}
