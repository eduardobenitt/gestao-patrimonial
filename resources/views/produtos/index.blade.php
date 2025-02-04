@extends('layouts.app')

@section('title', 'Lista de Produtos')

@section('content')
    <h1>Usuários</h1>
    <a href="{{ route('produtos.create') }}">Adicionar Produto</a>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produtos as $produto)
                <tr>
                    <td>{{ $produto->nome }}</td>
                    <td>
                        <a href="{{ route('produtos.show', $produto->id) }}">Ver</a>
                        <a href="{{ route('produtos.edit', $produto->id) }}">Editar</a>
                        <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
