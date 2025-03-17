@extends('layouts.app')

@section('title', 'Patrimônios - Máquinas e Equipamentos')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Patrimônios</h1>

            <div class="btn-group" role="group" aria-label="Tipo de patrimônio">
                <button type="button" class="btn btn-primary active" id="btn-maquinas">Máquinas</button>
                <button type="button" class="btn btn-outline-primary" id="btn-equipamentos">Equipamentos</button>
            </div>
        </div>

        <!-- Conteúdo das Máquinas -->
        <div id="content-maquinas">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <input type="text" class="form-control" id="search-maquinas" placeholder="Buscar máquina...">
                </div>
                <a href="{{ route('maquinas.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Nova Máquina
                </a>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Patrimônio</th>
                                <th>Fabricante</th>
                                <th>Tipo</th>
                                <th>Status</th>
                                <th>Usuário(s)</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($maquinas as $maquina)
                                <tr class="expandable-row">
                                    <td data-bs-toggle="collapse" data-bs-target="#collapseMaquina{{ $maquina->id }}"
                                        aria-expanded="false" style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-chevron-right me-2 expand-icon"></i>
                                            <strong>{{ $maquina->patrimonio }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $maquina->fabricante ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge {{ $maquina->tipo === 'notebook' ? 'bg-info' : 'bg-dark' }}">
                                            {{ ucfirst($maquina->tipo) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge {{ $maquina->status === 'Almoxarifado' ? 'bg-secondary' : 'bg-success' }}">
                                            {{ $maquina->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($maquina->usuarios->isNotEmpty())
                                            @foreach ($maquina->usuarios as $usuario)
                                                <span class="badge bg-primary">{{ $usuario->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Nenhum usuário</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('maquinas.edit', $maquina->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-action="{{ route('maquinas.destroy', $maquina->id) }}"
                                                data-name="{{ $maquina->patrimonio }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="collapse" id="collapseMaquina{{ $maquina->id }}">
                                    <td colspan="6" class="p-0">
                                        <div class="p-3 bg-light">
                                            <h6 class="mb-3">Equipamentos vinculados</h6>
                                            @if ($maquina->equipamentos->isNotEmpty())
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered mb-0">
                                                        <thead class="table-secondary">
                                                            <tr>
                                                                <th>Patrimônio</th>
                                                                <th>Produto</th>
                                                                <th>Fabricante</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($maquina->equipamentos as $equipamento)
                                                                <tr>
                                                                    <td>{{ $equipamento->patrimonio }}</td>
                                                                    <td>{{ $equipamento->produto->nome ?? 'Produto não definido' }}
                                                                    </td>
                                                                    <td>{{ $equipamento->fabricante ?? 'N/A' }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $equipamento->status === 'Em Uso' ? 'bg-success' : 'bg-secondary' }}">
                                                                            {{ $equipamento->status }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">Nenhum equipamento vinculado a esta máquina.</p>
                                            @endif

                                            <div class="mt-3">
                                                <h6>Especificações</h6>
                                                <p class="mb-0">{{ $maquina->especificacoes ?? 'Não informado' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Conteúdo dos Equipamentos -->
        <div id="content-equipamentos" style="display: none;">
            <div class="d-flex justify-content-between mb-3">
                <div>
                    <input type="text" class="form-control" id="search-equipamentos" placeholder="Buscar equipamento...">
                </div>
                <a href="{{ route('equipamentos.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Novo Equipamento
                </a>
            </div>

            <div class="card shadow-sm mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Patrimônio</th>
                                <th>Produto</th>
                                <th>Fabricante</th>
                                <th>Status</th>
                                <th>Máquina</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach ($equipamentos as $equipamento)
                                <tr class="expandable-row">
                                    <td data-bs-toggle="collapse"
                                        data-bs-target="#collapseEquipamento{{ $equipamento->id }}" aria-expanded="false"
                                        style="cursor: pointer;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-chevron-right me-2 expand-icon"></i>
                                            <strong>{{ $equipamento->patrimonio }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $equipamento->produto ? $equipamento->produto->nome : 'Não informado' }}</td>
                                    <td>{{ $equipamento->fabricante ?? 'N/A' }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $equipamento->status === 'Em Uso' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $equipamento->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($equipamento->maquina)
                                            <span class="badge bg-info">{{ $equipamento->maquina->patrimonio }}</span>
                                        @else
                                            <span class="text-muted">Almoxarifado</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('equipamentos.edit', $equipamento->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-action="{{ route('equipamentos.destroy', $equipamento->id) }}"
                                                data-name="{{ $equipamento->patrimonio }}">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="collapse" id="collapseEquipamento{{ $equipamento->id }}">
                                    <td colspan="6" class="p-0">
                                        <div class="p-3 bg-light">
                                            <div>
                                                <h6>Especificações</h6>
                                                <p>{{ $equipamento->especificacoes ?? 'Não informado' }}</p>
                                            </div>

                                            @if ($equipamento->maquina)
                                                <div class="mt-3">
                                                    <h6>Detalhes da Máquina</h6>
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered mb-0">
                                                            <tr>
                                                                <th>Patrimônio</th>
                                                                <td>{{ $equipamento->maquina->patrimonio }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tipo</th>
                                                                <td>{{ ucfirst($equipamento->maquina->tipo) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Usuário(s)</th>
                                                                <td>
                                                                    @if ($equipamento->maquina->usuarios->isNotEmpty())
                                                                        @foreach ($equipamento->maquina->usuarios as $usuario)
                                                                            <span
                                                                                class="badge bg-primary">{{ $usuario->name }}</span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="text-muted">Nenhum usuário</span>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal de Confirmação de Exclusão -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Exclusão</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir o patrimônio <strong id="delete-name"></strong>?</p>
                        <p class="text-danger">Esta ação não pode ser desfeita.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form id="delete-form" method="POST" action="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Excluir</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
