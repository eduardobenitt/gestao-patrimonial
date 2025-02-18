@extends('layouts.app')

@section('title', 'Editar Equipamento')

@section('content')
    <h1>Editar Equipamento</h1>

    <form action="{{ route('equipamentos.update', $equipamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="patrimonio">Patrimônio:</label>
        <input type="text" name="patrimonio" id="patrimonio" value="{{ old('patrimonio', $equipamento->patrimonio) }}" required>

        
        <label for="produto_id">Produto:</label>
        <select id="produto_id" name="produto_id" class="block mt-1 w-full" required>
            <option value="">Selecione um produto</option>
            @foreach ($produtos as $produto)
                <option value="{{ $produto->id }}" {{ old('produto_id', $equipamento->produto_id) == $produto->id ? 'selected' : '' }}>
                    {{ $produto->nome }}
                </option>
            @endforeach
        </select>

        
        <label for="fabricante">Fabricante:</label>
        <input type="text" name="fabricante" id="fabricante" value="{{ old('fabricante', $equipamento->fabricante) }}">

        
        <label for="especificacoes">Especificações:</label>
        <input type="text" name="especificacoes" id="especificacoes" value="{{ old('especificacoes', $equipamento->especificacoes) }}">

        
        <div class="mt-4">
            <label for="status">Status:</label>
            <select id="status" name="status" class="block mt-1 w-full" onchange="toggleMaquinaField()">
                <option value="Almoxarifado" {{ old('status', $equipamento->status) === 'Almoxarifado' ? 'selected' : '' }}>Almoxarifado</option>
                <option value="Em Uso" {{ old('status', $equipamento->status) === 'Em Uso' ? 'selected' : '' }}>Em Uso</option>
            </select>
        </div>

        
        <div id="maquinaField" style="display: none;">
            <label for="maquina_id">Patrimônio da Máquina:</label>
            <select id="maquina_id" name="maquina_id" class="block mt-1 w-full">
                <option value="">Selecione uma máquina</option>
                @foreach ($maquinas as $maquina)
                    <option value="{{ $maquina->id }}" {{ old('maquina_id', $equipamento->maquina_id) == $maquina->id ? 'selected' : '' }}>
                        {{ $maquina->patrimonio }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Atualizar</button>
    </form>

    @if ($errors->has('error'))
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

   
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toggleMaquinaField();
        });

        function toggleMaquinaField() {
            var status = document.getElementById("status").value;
            var maquinaField = document.getElementById("maquinaField");

            if (status === "Em Uso" || status === "Em uso") {
                maquinaField.style.display = "block"; 
            } else {
                maquinaField.style.display = "none"; 
            }
        }
    </script>
@endsection
