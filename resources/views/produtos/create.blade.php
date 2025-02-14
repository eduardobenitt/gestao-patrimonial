@extends('layouts.app')

@section('title', 'Adicionar Produto')

@section('content')
    <h1>Adicionar Produto</h1>

    <form action="{{ route('produtos.store') }}" method="POST">
        @csrf
        <label for="name">Nome:</label>
        <input type="text" name="nome" id="nome" required>
        @if ($errors->has('nome'))
            <div class="text-danger">{{ $errors->first('nome') }}</div>
        @endif

        <button type="submit">Salvar</button>
    </form>

    @if ($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

@endsection
