@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>
                    @if (auth()->id() === $user->id)
                        Meus Dados
                    @else
                        Dados do Usuário: {{ $user->name }}
                    @endif
                </h4>
            </div>

            <div class="card-body">
                <!-- Informações Pessoais -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Informações Pessoais</h5>
                        <table class="table">
                            <tr>
                                <th width="120">Nome:</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Função:</th>
                                <td>{{ $user->funcao }}</td>
                            </tr>
                            <tr>
                                <th>Equipe:</th>
                                <td>{{ $user->equipe }}</td>
                            </tr>
                            <tr>
                                <th>Ramal:</th>
                                <td>{{ $user->ramal }}</td>
                            </tr>
                            <tr>
                                <th>Turno:</th>
                                <td>{{ $user->turno }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Unidade:</th>
                                <td>{{ $user->unidade }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <span class="badge {{ $user->status == 'Ativo' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $user->status }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Máquinas do Usuário -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5>{{ auth()->id() === $user->id ? 'Minhas Máquinas' : 'Máquinas do Usuário' }}</h5>

                        @if ($maquinas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Patrimônio</th>
                                            <th>Fabricante</th>
                                            <th>Tipo</th>
                                            <th>Especificações</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($maquinas as $maquina)
                                            <tr>
                                                <td>{{ $maquina->patrimonio }}</td>
                                                <td>{{ $maquina->fabricante }}</td>
                                                <td>{{ $maquina->tipo }}</td>
                                                <td>{{ $maquina->especificacoes }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $maquina->status == 'Ativo' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $maquina->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                {{ auth()->id() === $user->id ? 'Você não possui máquinas atribuídas no momento.' : 'Este usuário não possui máquinas atribuídas.' }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Equipamentos do Usuário -->
                <div class="row">
                    <div class="col-md-12">
                        <h5>{{ auth()->id() === $user->id ? 'Meus Equipamentos' : 'Equipamentos do Usuário' }}</h5>

                        @if ($equipamentos->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Patrimônio</th>
                                            <th>Produto</th>
                                            <th>Fabricante</th>
                                            <th>Especificações</th>
                                            <th>Máquina Associada</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($equipamentos as $equipamento)
                                            <tr>
                                                <td>{{ $equipamento->patrimonio }}</td>
                                                <td>{{ $equipamento->produto->nome }}</td>
                                                <td>{{ $equipamento->fabricante }}</td>
                                                <td>{{ $equipamento->especificacoes }}</td>
                                                <td>{{ optional($equipamento->maquina)->patrimonio ?? 'N/A' }}</td>
                                                <td>
                                                    <span
                                                        class="badge {{ $equipamento->status == 'Ativo' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $equipamento->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                {{ auth()->id() === $user->id ? 'Você não possui equipamentos atribuídos no momento.' : 'Este usuário não possui equipamentos atribuídos.' }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
