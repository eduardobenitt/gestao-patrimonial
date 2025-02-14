@extends('layouts.app')

@section('title', 'Editar Produtos')

@section('content')
    <h1>Editar Produto</h1>
    <form action="{{ route('produtos.update', $produto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Produto:</label>
        <input type="text" name="nome" id="nome" value="{{ $produto->nome }}" required>
        
        @if ($errors->has('nome'))
            <div class="text-danger">{{ $errors->first('nome') }}</div>
        @endif
        
        <button type="submit">Salvar Alterações</button>
    </form>

    @if ($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

@endsection
