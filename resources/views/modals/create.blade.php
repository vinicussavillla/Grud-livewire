
 <div wire:ignore.self class="modal fade" id="addprodutoModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Adicionar novo produto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="storeprodutoData">
                    <div class="form-group row">
                        <label for="produto_id" class="col-3">produto ID</label>
                        <div class="col-9">
                            <input type="number" id="produto_id" class="form-control @if($errors->has('produto_id')) is-invalid @elseif($produto_id == NULL) @else is-valid @endif"
                             wire:model="produto_id">
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
                            <input type="text" id="name" class="form-control @if($errors->has('name')) is-invalid @elseif($name == NULL) @else is-valid @endif"
                            wire:model="name">
                            @error('name')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="font-weight-bold">Selecione a Imagem:</label>
                        <div class="col-9">
                            <input type="file" class="form-control @if($errors->has('image')) is-invalid @elseif($image == NULL) @else is-valid @endif"
                             wire:model="image"
                            style="padding: 3px 5px;" />
                            @error('image')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div wire:loading wire:target="image" wire:key="image"><i class="fa fa-spinner fa-spin mt-2 ml-2"></i> Carregando...</div>

                    {{-- ImagePreview --}}

                       {{-- @if ($image)
                            <img src="{{ $image->temporaryUrl() }}" width="100" alt="" class="mt-2">
                        @endif
                    </div> --}}

                    <div class="form-group">
                        <label for="descricao" class="col-3">descrição:</label>
                        <div class="col-9">
                            <textarea type="text" id="descricao" class="form-control @if($errors->has('descricao')) is-invalid @elseif($descricao == NULL) @else is-valid @endif"
                            wire:model="descricao" >
                            </textarea>
                            @error('descricao')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="preco" class="col-3">preço:</label>
                        <div class="col-9">
                            <input type="number" id="preco" class="form-control  @if($errors->has('preco')) is-invalid @elseif($preco == NULL) @else is-valid @endif"
                             wire:model="preco">
                            @error('preco')
                                <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for=""></label>
                        <div class="col-6">
                            <button type="submit" class="btn btn-sm btn-success">Adicionar produto</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

