@extends('layouts.app')

@section('title', 'Editar Produtos')

@section('content')
    <h1>Editar Produto</h1>
    <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Produto:</label>
        <input type="text" name="nome" id="nome" value="{{ $produto->nome }}" required>
        <button type="submit">Salvar Alterações</button>
    </form>
@endsection
