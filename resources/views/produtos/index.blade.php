@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800"><i class="bi bi-box-seam"></i> Produtos</h1>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProdutoModal">
                <i class="bi bi-plus-circle"></i> Adicionar Produto
            </button>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Nome</th>
                                <th scope="col" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @forelse ($produtos as $produto)
                                <tr>
                                    <td>
                                        <strong>{{ $produto->nome }}</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">

                                            <a href="{{ route('produtos.edit', $produto->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteProdutoModal"
                                                data-produto-id="{{ $produto->id }}"
                                                data-produto-nome="{{ $produto->nome }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                                            <p class="text-muted mt-2">Nenhum produto cadastrado</p>
                                            <button type="button" class="btn btn-sm btn-primary mt-1"
                                                data-bs-toggle="modal" data-bs-target="#createProdutoModal">
                                                <i class="bi bi-plus-circle"></i> Adicionar Produto
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Total: {{ $produtos->count() }} produtos</small>
                    </div>
                    @if ($produtos instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div>
                            {{ $produtos->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Adicionar Produto -->
    <div class="modal fade" id="createProdutoModal" tabindex="-1" aria-labelledby="createProdutoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createProdutoModalLabel">
                        <i class="bi bi-box-seam"></i> Adicionar Novo Produto
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <form action="{{ route('produtos.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label fw-bold">Nome do Produto</label>
                            <input type="text" id="nome" name="nome"
                                class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}"
                                required autofocus>
                            <small class="form-text text-muted">
                                Exemplos: Mouse, Teclado, Monitor, Headset, etc.
                            </small>
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Salvar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para Confirmar Exclusão -->
    <div class="modal fade" id="deleteProdutoModal" tabindex="-1" aria-labelledby="deleteProdutoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteProdutoModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> Confirmar Exclusão
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir o produto <strong id="produtoNome"></strong>?</p>
                    <p class="text-danger">
                        <small>
                            <i class="bi bi-exclamation-circle"></i>
                            Esta ação não pode ser desfeita e pode afetar equipamentos vinculados.
                        </small>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form id="deleteProdutoForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Excluir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
