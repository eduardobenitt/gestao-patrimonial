@extends('layouts.app')

@section('title', 'Editar Máquina')

@section('content')
    <h1>Editar Máquina</h1>
    <form action="{{ route('maquinas.update', $maquina->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Patrimônio:</label>
        <input type="text" name="nome" id="nome" value="{{ $maquina->patrimonio }}" required>

        <label for="name">Fabricante:</label>
        <input type="text" name="nome" id="nome" value="{{ $maquina->fabricante }}" required>

        
        <button type="submit">Salvar Alterações</button>
    </form>
@endsection
