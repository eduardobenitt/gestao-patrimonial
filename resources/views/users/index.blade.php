@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">

            @if (auth()->user()->role !== 'usuario')
                <a href="{{ route('users.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Novo Usuário
                </a>
            @endif
        </div>

        <div class="d-flex justify-content-between mb-3">
            <div class="w-50">
                <input type="text" class="form-control" id="search-users" placeholder="Buscar usuário...">
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Ramal</th>
                            <th>Equipe</th>
                            <th>Regime</th>
                            <th>Função</th>
                            <th>Unidade</th>
                            <th>Turno</th>
                            @if (auth()->user()->role !== 'usuario')
                                <th>Ações</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($users as $user)
                            <tr class="expandable-row">
                                <td data-bs-toggle="collapse" data-bs-target="#collapseUser{{ $user->id }}"
                                    aria-expanded="false" style="cursor: pointer;">
                                    <div class="d-flex align-items-center">
                                        @if (auth()->user()->role !== 'usuario')
                                            <i class="bi bi-chevron-right me-2 expand-icon"></i>
                                        @endif

                                        <strong>{{ $user->name }}</strong>
                                    </div>
                                    @if ($errors->has('name'))
                                        <div class="text-danger">{{ $errors->first('name') }}</div>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->email }}
                                    @if ($errors->has('email'))
                                        <div class="text-danger">{{ $errors->first('email') }}</div>
                                    @endif
                                </td>
                                <td>{{ $user->ramal }}</td>
                                <td>{{ $user->equipe }}</td>
                                <td>{{ $user->regime }}</td>
                                <td>{{ $user->funcao }}</td>
                                <td>{{ $user->unidade }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $user->turno }}</span>
                                </td>
                                @if (auth()->user()->role !== 'usuario')
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-sm btn-outline-primary"
                                                href="{{ route('users.edit', $user->id) }}">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal" data-bs-target="#confirmModal"
                                                data-action="{{ route('users.inactivate', $user->id) }}"
                                                data-message="Tem certeza que deseja inativar o usuário {{ $user->name }}?">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @if (auth()->user()->role !== 'usuario')
                                <tr class="collapse" id="collapseUser{{ $user->id }}">
                                    <td colspan="{{ auth()->user()->role !== 'usuario' ? '9' : '8' }}" class="p-0">
                                        <div class="p-3 bg-light">
                                            <h6 class="mb-3">Máquinas Vinculadas</h6>
                                            @if ($user->maquina->isNotEmpty())
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-bordered mb-0">
                                                        <thead class="table-secondary">
                                                            <tr>
                                                                <th>Patrimônio</th>
                                                                <th>Fabricante</th>
                                                                <th>Tipo</th>
                                                                <th>Equipamentos Vinculados</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($user->maquina as $maquina)
                                                                <tr>
                                                                    <td>{{ $maquina->patrimonio }}</td>
                                                                    <td>{{ $maquina->fabricante ?? 'N/A' }}</td>
                                                                    <td>
                                                                        <span
                                                                            class="badge {{ $maquina->tipo === 'notebook' ? 'bg-info' : 'bg-dark' }}">
                                                                            {{ ucfirst($maquina->tipo) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>
                                                                        @if ($maquina->equipamentos->isNotEmpty())
                                                                            <ul class="list-unstyled mb-0">
                                                                                @foreach ($maquina->equipamentos as $equipamento)
                                                                                    <li>
                                                                                        <i class="bi bi-dot"></i>
                                                                                        <span
                                                                                            class="badge bg-secondary">{{ $equipamento->produto->nome ?? 'Produto não definido' }}</span>
                                                                                        <small>{{ $equipamento->patrimonio }}</small>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        @else
                                                                            <span class="text-muted">Nenhum equipamento
                                                                                vinculado</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">Nenhuma máquina vinculada a este usuário.</p>
                                            @endif

                                            <div class="mt-3">
                                                <h6>Informações Adicionais</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p class="mb-1"><strong>Status:</strong>
                                                            <span
                                                                class="badge {{ $user->status == 'Ativo' ? 'bg-success' : 'bg-secondary' }}">
                                                                {{ $user->status ?? 'Ativo' }}
                                                            </span>
                                                        </p>

                                                        <p class="mb-1"><strong>Tipo de Usuário:</strong>
                                                            <span
                                                                class="badge {{ $user->role == 'admin' ? 'bg-danger' : ($user->role == 'tecnico' ? 'bg-warning text-dark' : 'bg-info') }}">
                                                                {{ ucfirst($user->role) }}
                                                            </span>
                                                        </p>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($errors->has('error'))
            <div class="alert alert-danger">
                {{ $errors->first('error') }}
            </div>
        @endif
    </div>

    <!-- Modal de confirmação -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="confirmForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmação</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <div class="modal-body">
                        <p id="confirmMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Confirmar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Configuração do modal de confirmação
                const confirmModal = document.getElementById('confirmModal');
                confirmModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const action = button.getAttribute('data-action');
                    const message = button.getAttribute('data-message');

                    document.getElementById('confirmMessage').textContent = message;
                    document.getElementById('confirmForm').action = action;
                });

                // Animação de ícone ao expandir linhas
                document.querySelectorAll('.expandable-row').forEach(row => {
                    row.addEventListener('click', function(e) {
                        const target = e.currentTarget.querySelector('[data-bs-toggle="collapse"]');
                        if (target && e.target.closest('[data-bs-toggle="collapse"]')) {
                            const icon = target.querySelector('.expand-icon');
                            if (icon) {
                                icon.classList.toggle('bi-chevron-right');
                                icon.classList.toggle('bi-chevron-down');
                            }
                        }
                    });
                });

                // Filtro de busca para usuários
                const searchUsers = document.getElementById('search-users');
                searchUsers.addEventListener('keyup', function() {
                    const term = this.value.toLowerCase();
                    const rows = document.querySelectorAll('tbody > tr.expandable-row');

                    rows.forEach(row => {
                        const nome = row.querySelector('td:nth-child(1) strong').textContent
                            .toLowerCase();
                        const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                        const equipe = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                        const funcao = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

                        if (nome.includes(term) || email.includes(term) || equipe.includes(term) ||
                            funcao.includes(term)) {
                            row.style.display = '';
                            // Encontrar o próximo tr que é um collapse
                            let collapseRow = row.nextElementSibling;
                            if (collapseRow && collapseRow.classList.contains('collapse')) {
                                collapseRow.style.display = '';
                            }
                        } else {
                            row.style.display = 'none';
                            // Encontrar o próximo tr que é um collapse
                            let collapseRow = row.nextElementSibling;
                            if (collapseRow && collapseRow.classList.contains('collapse')) {
                                collapseRow.style.display = 'none';
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
