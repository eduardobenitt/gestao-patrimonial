@extends('layouts.app')

@section('title', 'Cadastro de Equipamento')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-keyboard"></i> Cadastro de Equipamento</h5>
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

                        <form action="{{ route('equipamentos.store') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <!-- Informações Básicas -->
                                <div class="col-md-12">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-info-circle"></i> Informações do
                                        Equipamento</h6>
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
                                                    <label for="produto_id" class="form-label fw-bold">Produto</label>
                                                    <select id="produto_id" name="produto_id"
                                                        class="form-select @error('produto_id') is-invalid @enderror"
                                                        required>
                                                        <option value="">Selecione um produto</option>
                                                        @foreach ($produtos as $produto)
                                                            <option value="{{ $produto->id }}"
                                                                {{ old('produto_id') == $produto->id ? 'selected' : '' }}>
                                                                {{ $produto->nome }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('produto_id')
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

                                                <div class="col-md-6">
                                                    <label for="status" class="form-label fw-bold">Status</label>
                                                    <select id="status" name="status"
                                                        class="form-select @error('status') is-invalid @enderror">
                                                        <option value="Almoxarifado"
                                                            {{ old('status') === 'Almoxarifado' ? 'selected' : '' }}>
                                                            Almoxarifado
                                                        </option>
                                                        <option value="Em Uso"
                                                            {{ old('status') === 'Em Uso' ? 'selected' : '' }}>
                                                            Em Uso
                                                        </option>
                                                    </select>
                                                    @error('status')
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Máquina Vinculada (aparece apenas se o status for "Em Uso") -->
                            <div id="maquinaField" class="mb-4" style="display: none;">
                                <h6 class="mb-3 text-primary"><i class="bi bi-pc-display"></i> Máquina Vinculada</h6>
                                <div class="card border-light bg-light">
                                    <div class="card-body">
                                        <select id="maquina_id" name="maquina_id"
                                            class="form-select @error('maquina_id') is-invalid @enderror">
                                            <option value="">Selecione uma máquina</option>
                                            @foreach ($maquinas as $maquina)
                                                <option value="{{ $maquina->id }}"
                                                    {{ old('maquina_id') == $maquina->id ? 'selected' : '' }}>
                                                    {{ $maquina->patrimonio }} - {{ ucfirst($maquina->tipo) }}
                                                    @if ($maquina->fabricante)
                                                        ({{ $maquina->fabricante }})
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('maquina_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted mt-2">
                                            Selecione a máquina à qual este equipamento será vinculado.
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('equipamentos.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Salvar Equipamento
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
            toggleMaquinaField();

            // Adiciona evento ao alterar o status
            document.getElementById("status").addEventListener("change", toggleMaquinaField);
        });

        function toggleMaquinaField() {
            const status = document.getElementById("status").value;
            const maquinaField = document.getElementById("maquinaField");
            const maquinaSelect = document.getElementById("maquina_id");

            if (status === "Em Uso") {
                maquinaField.style.display = "block";
                maquinaSelect.disabled = false;
            } else {
                maquinaField.style.display = "none";
                maquinaSelect.disabled = true;
            }
        }
    </script>
@endsection
