@extends('layouts.app')

@section('title', 'Lista de Usuários')

@section('content')
    <h1>Usuários</h1>
    <a href="{{ route('users.create') }}">Adicionar Usuário</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ramal</th>
                <th>Equipe</th>
                <th>Função</th>
                <th>Unidade</th>
                <th>Turno</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->ramal }}</td>
                    <td>{{ $user->equipe }}</td>
                    <td>{{ $user->funcao }}</td>
                    <td>{{ $user->unidade }}</td>
                    <td>{{ $user->turno }}</td>
                    <td>
                        <a href="{{ route('users.show', $user->id) }}">Ver</a>

                        <a href="{{ route('users.edit', $user->id) }}">Editar</a>

                        
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmModal"
                            data-action="{{ route('users.inactivate', $user->id) }}"
                            data-message="Tem certeza que deseja inativar este usuário?">
                            Inativar
                        </button>

                        
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal"
                            data-action="{{ route('users.destroy', $user->id) }}"
                            data-message="Tem certeza que deseja excluir este usuário permanentemente?">
                            Excluir
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
