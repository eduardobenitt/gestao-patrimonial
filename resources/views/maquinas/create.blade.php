@extends('layouts.app')

@section('title', 'Cadastrar Máquina')

@section('content')
    <h1>Cadastrar Máquina</h1>

    <!-- Exibição de erros globais -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('maquinas.store') }}" method="POST">
        @csrf

        <!-- Patrimônio -->
        <div>
            <label for="patrimonio">Patrimônio:</label>
            <input type="text" id="patrimonio" name="patrimonio" value="{{ old('patrimonio') }}" required>
            @error('patrimonio')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Fabricante -->
        <div>
            <label for="fabricante">Fabricante:</label>
            <input type="text" id="fabricante" name="fabricante" value="{{ old('fabricante') }}">
            @error('fabricante')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Especificações -->
        <div>
            <label for="especificacoes">Especificações:</label>
            <input type="text" name="especificacoes" id="especificacoes" value="{{ old('especificacoes') }}">
            @error('especificacoes')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tipo -->
        <div>
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo">
                <option value="notebook" {{ old('tipo') == 'notebook' ? 'selected' : '' }}>Notebook</option>
                <option value="desktop"  {{ old('tipo') == 'desktop'  ? 'selected' : '' }}>Desktop</option>
            </select>
            @error('tipo')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Status da Máquina -->
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status" onchange="toggleUsuariosField()">
                <option value="Almoxarifado"          {{ old('status') == 'Almoxarifado'           ? 'selected' : '' }}>Almoxarifado</option>
                <option value="Colaborador Integral"   {{ old('status') == 'Colaborador Integral'   ? 'selected' : '' }}>Colaborador Integral</option>
                <option value="Colaborador Meio Período" {{ old('status') == 'Colaborador Meio Período' ? 'selected' : '' }}>Colaborador Meio Período</option>
            </select>
            @error('status')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Seleção de Usuário para Colaborador Integral -->
        <div id="usuarioIntegralField" style="display: none;">
            <label>Usuário:</label>
            <select name="usuario_integral" class="form-control">
                <option value="">Selecione um usuário</option>
                @foreach ($usuariosDisponiveis as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuario_integral') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
            @error('usuario_integral')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Seleção de Usuários para Colaborador Meio Período -->
        <div id="usuarioMeioPeriodoField" style="display: none;">
            <label>Manhã:</label>
            <select id="usuarioManha" name="usuarios[]" class="form-control" onchange="filtrarUsuarios()">
                <option value="">Selecione um usuário</option>
                @foreach ($usuariosDisponiveis as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuarios.0') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>

            <label>Tarde:</label>
            <select id="usuarioTarde" name="usuarios[]" class="form-control">
                <option value="">Selecione um usuário</option>
                @foreach ($usuariosDisponiveis as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('usuarios.1') == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->name }}
                    </option>
                @endforeach
            </select>
            @error('usuarios')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Equipamentos Vinculados -->
        <div id="equipamentoField" style="display: none;">
            <label for="equipamentos_id">Equipamentos Vinculados:</label>
            <select id="equipamentos_id" name="equipamentos_ids[]" class="block mt-1 w-full" multiple="multiple">
                @foreach ($equipamentos as $equipamento)
                    <option value="{{ $equipamento->id }}"
                        {{ collect(old('equipamentos_ids'))->contains($equipamento->id) ? 'selected' : '' }}>
                        {{ $equipamento->patrimonio }} - {{ $equipamento->produto->nome }}
                    </option>
                @endforeach
            </select>
            @error('equipamentos_ids')
                <div style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <button type="submit">Salvar Máquina</button>
        </div>
    </form>

    <!-- Scripts -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            toggleUsuariosField(); // Ajusta os campos conforme o status selecionado ao carregar a página
        });

        function toggleUsuariosField() {
            var status = document.getElementById("status").value;
            var usuarioIntegralField = document.getElementById("usuarioIntegralField");
            var usuarioMeioPeriodoField = document.getElementById("usuarioMeioPeriodoField");
            var usuarioIntegralSelect = usuarioIntegralField.querySelector("select");
            var usuarioManhaSelect = document.getElementById("usuarioManha");
            var usuarioTardeSelect = document.getElementById("usuarioTarde");
            var equipamentoField = document.getElementById("equipamentoField");
            var equipamentoSelect = equipamentoField.querySelector("select");

            if (status === "Colaborador Integral") {
                usuarioIntegralField.style.display = "block";
                usuarioMeioPeriodoField.style.display = "none";
                usuarioIntegralSelect.disabled = false;
                usuarioManhaSelect.disabled = true;
                usuarioTardeSelect.disabled = true;
                equipamentoField.style.display = "block";
                equipamentoSelect.disabled = false;
            } else if (status === "Colaborador Meio Período") {
                usuarioIntegralField.style.display = "none";
                usuarioMeioPeriodoField.style.display = "block";
                usuarioIntegralSelect.disabled = true;
                usuarioManhaSelect.disabled = false;
                usuarioTardeSelect.disabled = false;
                equipamentoField.style.display = "block";
                equipamentoSelect.disabled = false;
            } else {
                usuarioIntegralField.style.display = "none";
                usuarioMeioPeriodoField.style.display = "none";
                usuarioIntegralSelect.disabled = true;
                usuarioManhaSelect.disabled = true;
                usuarioTardeSelect.disabled = true;
                equipamentoField.style.display = "none";
                equipamentoSelect.disabled = true;
            }
        }

        function filtrarUsuarios() {
            var manha = document.getElementById("usuarioManha").value;
            var tardeSelect = document.getElementById("usuarioTarde");

            for (var i = 0; i < tardeSelect.options.length; i++) {
                if (tardeSelect.options[i].value === manha && manha !== "") {
                    tardeSelect.options[i].disabled = true;
                } else {
                    tardeSelect.options[i].disabled = false;
                }
            }
        }
    </script>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#equipamentos_id').select2({
                    placeholder: 'Equipamentos'
                });
            });
        </script>
    @endpush
@endsection
