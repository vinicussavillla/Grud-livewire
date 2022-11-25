<div>

    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h3><strong>Cardápio</strong></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="float: left;"><strong>Todos os Produtos</strong></h5>
                        <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal" data-target="#addprodutoModal">Adicionar novo produto</button>
                    </div>

                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-success text-center">{{ session('message') }}</div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <input type="search" style="float: left;" class="form-control w-25" placeholder="search" wire:model="searchTerm" style="float: right;" />
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Descrição</th>
                                    <th>Preço</th>
                                    <th>imagem </th>
                                    <th style="text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($produtos->count() > 0)
                                    @foreach ($produtos as $produto)
                                        <tr>
                                            <td>{{ $produto->id }}</td>
                                            <td>{{ $produto->name }}</td>
                                            <td>{{ $produto->descricao }}</td>
                                            <td>{{ $produto->preco }}</td>
                                            <td><img src="{{ asset('uploads/image_uploads') }}/{{ $produto->image }}" class="img-fluid" width="100" alt=""></td>
                                            <td style="text-align: center;">
                                                <button class="btn btn-sm btn-primary" wire:click="editprodutos({{ $produto->id }})">Edit</button>
                                                <button class="btn btn-sm btn-danger" wire:click="deletes({{ $produto->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" style="text-align: center;"><small>No produto Found</small></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        @include('modals.create')
                    </div>
                </div>
            </div>
        </div>
    </div>

{{-- Modals --}}



<div wire:ignore.self class="modal fade" id="editprodutoModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="editprodutoData">
                    <div class="form-group row">
                        <label for="produto_id" class="col-3">produto ID</label>
                        <div class="col-9">
                            <input type="number" id="produto_id" class="form-control @if($errors->has('produto_id')) is-invalid @elseif($produto_id == NULL) @else is-valid @endif" wire:model="produto_id">
                            @error('produto_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-3">Nome:</label>
                        <div class="col-9">
                            <input type="text" id="name" class="form-control @if($errors->has('name')) is-invalid @elseif($name == NULL) @else is-valid @endif" wire:model="name">
                            @error('name')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="image" class="font-weight-bold">Selecione a Imagem:</label>
                        <div class="col-9">
                            <input type="file" class="form-control" wire:model="image" style="padding: 3px 5px;" />
                            @error('image')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div wire:loading wire:target="image" wire:key="image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Uploading</div>

                    {{-- ImagePreview --}}

                       @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" width="100" alt="" class="mt-2">
                        @endif
                    </div>

                    <div class="form-group ">
                        <label for="descricao" class="col-3">descrição:</label>
                        <div class="col-9">
                            <textarea type="text" id="descricao" class="form-control" wire:model="descricao" >
                            </textarea>
                            @error('descricao')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="preco" class="col-3">preço:</label>
                        <div class="col-9">
                            <input type="number" id="preco" class="form-control" wire:model="preco">
                            @error('preco')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for=""></label>
                        <div class="col-6">
                            <button type="submit" class="btn btn-sm btn-success">Editar produto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    window.addEventListener('close-modal', event =>{
    $('#addprodutoModal').modal('hide');
    $('#editprodutoModal').modal('hide');
  $('#deleteprodutoModal').modal('hide');
});

window.addEventListener('show-edit-produto-modal', event =>{
    $('#editprodutoModal').modal('show');
});
// window.addEventListener('show-delete-confirmation-modal', event =>{
// $('#deleteprodutoModal').modal('show');
// });
// window.addEventListener('show-view-produto-modal', event =>{
//     $('#viewprodutoModal').modal('show');
// });
</script>
@endpush
