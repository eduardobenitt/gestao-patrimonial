@extends('layouts.app')

@section('title', 'Editar Máquina')

@section('content')
    <h1>Editar Máquina</h1>

    <form action="{{ route('maquinas.update', $maquina->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Patrimônio -->
        <div>
            <label for="patrimonio">Patrimônio:</label>
            <input type="text" id="patrimonio" name="patrimonio" value="{{ old('patrimonio', $maquina->patrimonio) }}" required>
            @error('patrimonio')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fabricante -->
        <div>
            <label for="fabricante">Fabricante:</label>
            <input type="text" id="fabricante" name="fabricante" value="{{ old('fabricante', $maquina->fabricante) }}">
        </div>

        <!-- Tipo -->
        <div>
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo">
                <option value="notebook" {{ old('tipo', $maquina->tipo) == 'notebook' ? 'selected' : '' }}>Notebook</option>
                <option value="desktop" {{ old('tipo', $maquina->tipo) == 'desktop' ? 'selected' : '' }}>Desktop</option>
            </select>
        </div>

        <!-- Status da Máquina -->
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" onchange="toggleUsuariosField()">
                <option value="Almoxarifado" {{ old('status', $maquina->status) == 'Almoxarifado' ? 'selected' : '' }}>Almoxarifado</option>
                <option value="Colaborador Integral" {{ old('status', $maquina->status) == 'Colaborador Integral' ? 'selected' : '' }}>Colaborador Integral</option>
                <option value="Colaborador Meio Período" {{ old('status', $maquina->status) == 'Colaborador Meio Período' ? 'selected' : '' }}>Colaborador Meio Período</option>
            </select>
        </div>

        <!-- Seleção de Usuários -->
        <div id="usuarioIntegralField" style="display: none;">
            <label>Usuário:</label>
            <select name="usuarios[0][id]" class="form-control">
                <option value="">Selecione um usuário</option>
                @foreach ($usuariosDisponiveis as $usuario)
                    <option value="{{ $usuario->id }}" 
                        {{ old('usuarios.0.id', optional($maquina->usuarios->first())->id) == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Seleção de Usuários para Colaborador Meio Período -->
        <div id="usuarioMeioPeriodoField" style="display: none;">
            <label>Manhã:</label>
            <select name="usuarios[0][id]" class="form-control">
                <option value="">Selecione um usuário</option>
                @foreach ($usuariosDisponiveis as $usuario)
                    <option value="{{ $usuario->id }}" 
                        {{ old('usuarios.0.id', $maquina->usuarios->where('pivot.turno', 'Manhã')->first()?->id) == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>

            <label>Tarde:</label>
            <select name="usuarios[1][id]" class="form-control">
                <option value="">Selecione um usuário</option>
                @foreach ($usuariosDisponiveis as $usuario)
                    <option value="{{ $usuario->id }}" 
                        {{ old('usuarios.1.id', $maquina->usuarios->where('pivot.turno', 'Tarde')->first()?->id) == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit">Atualizar Máquina</button>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toggleUsuariosField();
        });

        function toggleUsuariosField() {
            var status = document.getElementById("status").value;
            var usuarioIntegralField = document.getElementById("usuarioIntegralField");
            var usuarioMeioPeriodoField = document.getElementById("usuarioMeioPeriodoField");

            if (status === "Colaborador Integral") {
                usuarioIntegralField.style.display = "block";
                usuarioMeioPeriodoField.style.display = "none";
            } else if (status === "Colaborador Meio Período") {
                usuarioIntegralField.style.display = "none";
                usuarioMeioPeriodoField.style.display = "block";
            } else {
                usuarioIntegralField.style.display = "none";
                usuarioMeioPeriodoField.style.display = "none";
            }
        }
    </script>
@endsection
