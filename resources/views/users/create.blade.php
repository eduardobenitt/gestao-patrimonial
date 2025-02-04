@extends('layouts.app')

@section('title', 'Adicionar Usuário')

@section('content')
    <h1>Adicionar Usuário</h1>
    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" name="name" id="name" required>
        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required>
        <button type="submit">Salvar</button>
    </form>
@endsection
