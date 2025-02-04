@extends('layouts.app')

@section('title', 'Adicionar Produto')

@section('content')
    <h1>Adicionar Produto</h1>
    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        <button type="submit">Salvar</button>
    </form>
@endsection
