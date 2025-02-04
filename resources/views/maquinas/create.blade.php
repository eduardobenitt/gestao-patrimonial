@extends('layouts.app')

@section('title', 'Cadastrar Máquina')

@section('content')
    <h1>Cadastrar Máquina</h1>

    <form action="{{ route('maquinas.store') }}" method="POST">
        @csrf

        <div>
            <label for="patrimonio">Patrimônio:</label>
            <input type="text" id="patrimonio" name="patrimonio" value="{{ old('patrimonio') }}" required>
            @error('patrimonio')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="fabricante">Fabricante:</label>
            <input type="text" id="fabricante" name="fabricante" value="{{ old('fabricante') }}" required>
            @error('fabricante')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="especificacoes">Especificações:</label>
            <textarea id="especificacoes" name="especificacoes" rows="4">{{ old('especificacoes') }}</textarea>
            @error('especificacoes')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>


        <div>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="em uso" {{ old('status') == 'em uso' ? 'selected' : '' }}>Em Uso</option>
                <option value="no almoxarifado" {{ old('status') == 'no almoxarifado' ? 'selected' : '' }}>No Almoxarifado
                </option>
            </select>
            @error('status')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>


        <div>
            <label for="user_id">Usuário Vinculado:</label>
            <select id="user_id" name="user_id">
                <option value="">Nenhum</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>


        <div>
            <button type="submit">Salvar Máquina</button>
        </div>
    </form>
@endsection
