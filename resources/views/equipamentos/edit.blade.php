@extends('layouts.app')

@section('title', 'Editar Equipamento')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-keyboard"></i> Editar Equipamento</h5>
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

                        <form action="{{ route('equipamentos.update', $equipamento->id) }}" method="POST">
                            @csrf
                            @method('PUT')

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
                                                        value="{{ old('patrimonio', $equipamento->patrimonio) }}" required>
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
                                                                {{ old('produto_id', $equipamento->produto_id) == $produto->id ? 'selected' : '' }}>
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
                                                        value="{{ old('fabricante', $equipamento->fabricante) }}">
                                                    @error('fabricante')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="status" class="form-label fw-bold">Status</label>
                                                    <select id="status" name="status"
                                                        class="form-select @error('status') is-invalid @enderror"
                                                        onchange="toggleMaquinaField()">
                                                        <option value="Almoxarifado"
                                                            {{ old('status', $equipamento->status) === 'Almoxarifado' ? 'selected' : '' }}>
                                                            Almoxarifado
                                                        </option>
                                                        <option value="Em Uso"
                                                            {{ old('status', $equipamento->status) === 'Em Uso' ? 'selected' : '' }}>
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
                                                        rows="3">{{ old('especificacoes', $equipamento->especificacoes) }}</textarea>
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
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="maquina_id" class="form-label fw-bold">Selecione a
                                                    Máquina</label>
                                                <select id="maquina_id" name="maquina_id"
                                                    class="form-select @error('maquina_id') is-invalid @enderror">
                                                    <option value="">Selecione uma máquina</option>
                                                    @foreach ($maquinas as $maquina)
                                                        <option value="{{ $maquina->id }}"
                                                            {{ old('maquina_id', $equipamento->maquina_id) == $maquina->id ? 'selected' : '' }}>
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
                                                    A máquina à qual este equipamento está ou será vinculado.
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Histórico -->
                            @if (isset($equipamento->historicoAlteracoes) && $equipamento->historicoAlteracoes->count() > 0)
                                <div class="mb-4">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-clock-history"></i> Histórico de
                                        Alterações</h6>
                                    <div class="card border-light">
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-sm table-hover mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Data</th>
                                                            <th>Descrição</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($equipamento->historicoAlteracoes->sortByDesc('alterado_em')->take(5) as $historico)
                                                            <tr>
                                                                <td class="text-nowrap">
                                                                    {{ $historico->alterado_em->format('d/m/Y H:i') }}</td>
                                                                <td>{{ $historico->descricao }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('patrimonios.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Atualizar Equipamento
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
        });

        function toggleMaquinaField() {
            const status = document.getElementById("status").value;
            const maquinaField = document.getElementById("maquinaField");
            const maquinaSelect = document.getElementById("maquina_id");

            if (status === "Em Uso") {
                maquinaField.style.display = "block";
                if (maquinaSelect) maquinaSelect.disabled = false;
            } else {
                maquinaField.style.display = "none";
                if (maquinaSelect) maquinaSelect.disabled = true;
            }
        }
    </script>
@endsection
