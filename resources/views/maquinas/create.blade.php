@extends('layouts.app')

@section('title', 'Cadastrar Máquina')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-pc-display"></i> Cadastrar Máquina</h5>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('maquinas.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <!-- Informações Básicas -->
                                <div class="col-md-12">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-info-circle"></i> Informações Básicas</h6>
                                    <div class="card border-light bg-light mb-4">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="patrimonio" class="form-label fw-bold">Patrimônio</label>
                                                    <input type="text" id="patrimonio" name="patrimonio"
                                                        class="form-control @error('patrimonio') is-invalid @enderror"
                                                        value="{{ old('patrimonio') }}" required>
                                                    @error('patrimonio')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="fabricante" class="form-label fw-bold">Fabricante</label>
                                                    <input type="text" id="fabricante" name="fabricante"
                                                        class="form-control @error('fabricante') is-invalid @enderror"
                                                        value="{{ old('fabricante') }}">
                                                    @error('fabricante')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <label for="especificacoes"
                                                        class="form-label fw-bold">Especificações</label>
                                                    <textarea id="especificacoes" name="especificacoes" class="form-control @error('especificacoes') is-invalid @enderror"
                                                        rows="2">{{ old('especificacoes') }}</textarea>
                                                    @error('especificacoes')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="tipo" class="form-label fw-bold">Tipo</label>
                                                    <select id="tipo" name="tipo"
                                                        class="form-select @error('tipo') is-invalid @enderror">
                                                        <option value="notebook"
                                                            {{ old('tipo') == 'notebook' ? 'selected' : '' }}>
                                                            Notebook
                                                        </option>
                                                        <option value="desktop"
                                                            {{ old('tipo') == 'desktop' ? 'selected' : '' }}>
                                                            Desktop
                                                        </option>
                                                    </select>
                                                    @error('tipo')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="status" class="form-label fw-bold">Status</label>
                                                    <select id="status" name="status"
                                                        class="form-select @error('status') is-invalid @enderror">
                                                        <option value="Almoxarifado"
                                                            {{ old('status') == 'Almoxarifado' ? 'selected' : '' }}>
                                                            Almoxarifado
                                                        </option>
                                                        <option value="Colaborador Integral"
                                                            {{ old('status') == 'Colaborador Integral' ? 'selected' : '' }}>
                                                            Colaborador Integral
                                                        </option>
                                                        <option value="Colaborador Meio Período"
                                                            {{ old('status') == 'Colaborador Meio Período' ? 'selected' : '' }}>
                                                            Colaborador Meio Período
                                                        </option>
                                                    </select>
                                                    @error('status')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Seleção de Usuário para Colaborador Integral -->
                            <div id="usuarioIntegralField" class="mb-4" style="display: none;">
                                <h6 class="mb-3 text-primary"><i class="bi bi-person"></i> Usuário</h6>
                                <div class="card border-light bg-light">
                                    <div class="card-body">
                                        <select name="usuario_integral"
                                            class="form-select @error('usuario_integral') is-invalid @enderror">
                                            <option value="">Selecione um usuário</option>
                                            @foreach ($usuariosDisponiveis as $usuario)
                                                <option value="{{ $usuario->id }}"
                                                    {{ old('usuario_integral') == $usuario->id ? 'selected' : '' }}>
                                                    {{ $usuario->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('usuario_integral')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Seleção de Usuários para Colaborador Meio Período -->
                            <div id="usuarioMeioPeriodoField" class="mb-4" style="display: none;">
                                <h6 class="mb-3 text-primary"><i class="bi bi-people"></i> Usuários por Turno</h6>
                                <div class="card border-light bg-light">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <span class="badge bg-info text-dark">Manhã</span>
                                                </label>
                                                <select id="usuarioManha" name="usuario_manha"
                                                    class="form-select @error('usuario_manha') is-invalid @enderror">
                                                    <option value="">Selecione um usuário</option>
                                                    @foreach ($usuariosDisponiveis as $usuario)
                                                        <option value="{{ $usuario->id }}"
                                                            {{ old('usuario_manha') == $usuario->id ? 'selected' : '' }}>
                                                            {{ $usuario->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('usuario_manha')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">
                                                    <span class="badge bg-warning text-dark">Tarde</span>
                                                </label>
                                                <select id="usuarioTarde" name="usuario_tarde"
                                                    class="form-select @error('usuario_tarde') is-invalid @enderror">
                                                    <option value="">Selecione um usuário</option>
                                                    @foreach ($usuariosDisponiveis as $usuario)
                                                        <option value="{{ $usuario->id }}"
                                                            {{ old('usuario_tarde') == $usuario->id ? 'selected' : '' }}>
                                                            {{ $usuario->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('usuario_tarde')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Equipamentos Vinculados -->
                            <div id="equipamentoField" class="mb-4" style="display: none;">
                                <h6 class="mb-3 text-primary"><i class="bi bi-devices"></i> Equipamentos Vinculados</h6>
                                <div class="card border-light bg-light">
                                    <div class="card-body">
                                        <select id="equipamentos_id" name="equipamentos_ids[]"
                                            class="form-select @error('equipamentos_ids') is-invalid @enderror"
                                            multiple="multiple" style="width: 100%;">
                                            @foreach ($equipamentos as $equipamento)
                                                <option value="{{ $equipamento->id }}"
                                                    {{ collect(old('equipamentos_ids', []))->contains($equipamento->id) ? 'selected' : '' }}>
                                                    {{ $equipamento->patrimonio }} - {{ $equipamento->produto->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('equipamentos_ids')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted mt-2">
                                            Selecione múltiplos equipamentos mantendo a tecla Ctrl pressionada.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('patrimonios.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Salvar Máquina
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Configura o estado inicial
            toggleUsuariosField();

            // Adiciona o evento change ao select de status
            document.getElementById("status").addEventListener("change", toggleUsuariosField);

            // Adiciona eventos para filtrar usuários em ambos os selects
            const usuarioManhaSelect = document.getElementById("usuarioManha");
            const usuarioTardeSelect = document.getElementById("usuarioTarde");

            if (usuarioManhaSelect) {
                usuarioManhaSelect.addEventListener("change", function() {
                    filtrarUsuariosTarde(true);
                });
            }

            if (usuarioTardeSelect) {
                usuarioTardeSelect.addEventListener("change", function() {
                    filtrarUsuariosManha(true);
                });
            }

            // Inicializa o Select2 para multi-select de equipamentos
            if (typeof $ !== "undefined") {
                $("#equipamentos_id").select2({
                    placeholder: "Selecione os equipamentos",
                    allowClear: true
                });
            }
        });

        function toggleUsuariosField() {
            const status = document.getElementById("status").value;
            const usuarioIntegralField = document.getElementById("usuarioIntegralField");
            const usuarioMeioPeriodoField = document.getElementById("usuarioMeioPeriodoField");
            const equipamentoField = document.getElementById("equipamentoField");

            if (!usuarioIntegralField || !usuarioMeioPeriodoField || !equipamentoField)
                return;

            const usuarioIntegralSelect = usuarioIntegralField.querySelector("select");
            const usuarioManhaSelect = document.getElementById("usuarioManha");
            const usuarioTardeSelect = document.getElementById("usuarioTarde");
            const equipamentoSelect = equipamentoField.querySelector("select");

            // Resetar a visibilidade
            usuarioIntegralField.style.display = "none";
            usuarioMeioPeriodoField.style.display = "none";
            equipamentoField.style.display = "none";

            // Desabilitar todos os selects
            if (usuarioIntegralSelect) usuarioIntegralSelect.disabled = true;
            if (usuarioManhaSelect) usuarioManhaSelect.disabled = true;
            if (usuarioTardeSelect) usuarioTardeSelect.disabled = true;
            if (equipamentoSelect) equipamentoSelect.disabled = true;

            // Mostrar campos com base no status selecionado
            if (status === "Colaborador Integral") {
                usuarioIntegralField.style.display = "block";
                usuarioIntegralSelect.disabled = false;
                equipamentoField.style.display = "block";
                equipamentoSelect.disabled = false;
            } else if (status === "Colaborador Meio Período") {
                usuarioMeioPeriodoField.style.display = "block";
                if (usuarioManhaSelect) usuarioManhaSelect.disabled = false;
                if (usuarioTardeSelect) usuarioTardeSelect.disabled = false;
                equipamentoField.style.display = "block";
                equipamentoSelect.disabled = false;

                // Aplicar filtros
                if (usuarioManhaSelect && usuarioTardeSelect) {
                    filtrarUsuariosTarde(false);
                    filtrarUsuariosManha(false);
                }
            }
        }

        function filtrarUsuariosManha(fromEvent = false) {
            const usuarioManhaSelect = document.getElementById("usuarioManha");
            const usuarioTardeSelect = document.getElementById("usuarioTarde");

            if (!usuarioManhaSelect || !usuarioTardeSelect) return;

            const tarde = usuarioTardeSelect.value;

            for (let i = 0; i < usuarioManhaSelect.options.length; i++) {
                if (usuarioManhaSelect.options[i].value === tarde && tarde !== "") {
                    usuarioManhaSelect.options[i].disabled = true;

                    if (fromEvent && usuarioManhaSelect.value === tarde) {
                        usuarioManhaSelect.value = "";
                    }
                } else {
                    usuarioManhaSelect.options[i].disabled = false;
                }
            }
        }

        function filtrarUsuariosTarde(fromEvent = false) {
            const usuarioManhaSelect = document.getElementById("usuarioManha");
            const usuarioTardeSelect = document.getElementById("usuarioTarde");

            if (!usuarioManhaSelect || !usuarioTardeSelect) return;

            const manha = usuarioManhaSelect.value;

            for (let i = 0; i < usuarioTardeSelect.options.length; i++) {
                if (usuarioTardeSelect.options[i].value === manha && manha !== "") {
                    usuarioTardeSelect.options[i].disabled = true;

                    if (fromEvent && usuarioTardeSelect.value === manha) {
                        usuarioTardeSelect.value = "";
                    }
                } else {
                    usuarioTardeSelect.options[i].disabled = false;
                }
            }
        }
    </script>
@endsection
