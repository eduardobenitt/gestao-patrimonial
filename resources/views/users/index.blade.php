@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle shadow-sm rounded-3 overflow-hidden">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ramal</th>
                    <th>Equipe</th>
                    <th>Função</th>
                    <th>Unidade</th>
                    <th>Turno</th>

                    @if (auth()->user()->role !== 'usuario')
                        <th>Ações</th>
                    @endif
                </tr>
            </thead>
            <tbody class="table-striped">
                @foreach ($users as $user)
                    {{-- Linha principal: clicável para expandir os detalhes --}}
                    <tr class="expandable-row">

                        <td data-bs-toggle="collapse" data-bs-target="#collapseUser{{ $user->id }}" aria-expanded="false"
                            style="cursor: pointer;">
                            {{ $user->name }}
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
                        <td>{{ $user->funcao }}</td>
                        <td>{{ $user->unidade }}</td>
                        <td>{{ $user->turno }}</td>
                        @if (auth()->user()->role !== 'usuario')
                            <td>
                                <a class="btn btn-info btn-sm text-white shadow-sm btn-edit"
                                    href="{{ route('users.edit', $user->id) }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>

                                {{-- <a class="btn btn-outline-warning btn-sm" href="{{ route('users.inactivate', $user->id) }}"
                            data-message="Tem certeza que deseja inativar este usuário?">
                            ⚠ Inativar
                        </a>  --}}
                            </td>
                        @endif

                    </tr>
            </tbody>
            {{-- Linha extra que será exibida ao clicar na linha principal --}}
            <tr class="collapse bg-light bg-opacity-75" id="collapseUser{{ $user->id }}">
                <td colspan="8">
                    @forelse ($user->maquina as $maquina)
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Patrimônio</th>
                                    <th scope="col">Fabricante</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Equipamentos Vinculados</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <!-- Patrimônio -->
                                    <td>{{ $maquina->patrimonio }}</td>

                                    <!-- Fabricante -->
                                    <td>{{ $maquina->fabricante ?? 'N/A' }}</td>

                                    <!-- Tipo (Notebook ou Desktop) -->
                                    <td>{{ ucfirst($maquina->tipo) }}</td>

                                    <!-- Equipamentos Vinculados -->
                                    <td>

                                        <ul style="list-style-type: none; padding: 0; margin: 0;">
                                            @forelse ($maquina->equipamentos as $equipamento)
                                                <li>
                                                    {{ $equipamento->produto->nome ?? 'Produto não definido' }} -
                                                    {{ $equipamento->patrimonio }}
                                                </li>
                                            @empty
                                                <li>Nenhum equipamento vinculado</li>
                                            @endforelse
                                        </ul>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                    @empty
                        <li>Nenhuma máquina vinculada</li>
                    @endforelse
                </td>
            </tr>
            @endforeach

        </table>
    </div>

    @if ($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

    {{-- Exemplo de modal de confirmação (caso ainda não exista em outro lugar) --}}
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
            const confirmModal = document.getElementById('confirmModal');
            confirmModal.addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget;
                let action = button.getAttribute('data-action');
                let message = button.getAttribute('data-message');

                let form = confirmModal.querySelector('#confirmForm');
                let msgContainer = confirmModal.querySelector('#confirmMessage');

                form.action = action;
                msgContainer.textContent = message;
            });
        </script>
    @endpush
@endsection
