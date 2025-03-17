@extends('layouts.app')

@section('title', 'Editar Máquina')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-pc-display"></i> Editar Máquina</h5>
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

                        <form action="{{ route('maquinas.update', $maquina->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Informações Básicas -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="patrimonio" class="form-label fw-bold">Patrimônio</label>
                                        <input type="text" id="patrimonio" name="patrimonio"
                                            class="form-control @error('patrimonio') is-invalid @enderror"
                                            value="{{ old('patrimonio', $maquina->patrimonio) }}" required>
                                        @error('patrimonio')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="fabricante" class="form-label fw-bold">Fabricante</label>
                                        <input type="text" id="fabricante" name="fabricante"
                                            class="form-control @error('fabricante') is-invalid @enderror"
                                            value="{{ old('fabricante', $maquina->fabricante) }}">
                                        @error('fabricante')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="tipo" class="form-label fw-bold">Tipo</label>
                                        <select id="tipo" name="tipo"
                                            class="form-select @error('tipo') is-invalid @enderror">
                                            <option value="notebook"
                                                {{ old('tipo', $maquina->tipo) == 'notebook' ? 'selected' : '' }}>
                                                Notebook
                                            </option>
                                            <option value="desktop"
                                                {{ old('tipo', $maquina->tipo) == 'desktop' ? 'selected' : '' }}>
                                                Desktop
                                            </option>
                                        </select>
                                        @error('tipo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label fw-bold">Status</label>
                                        <select id="status" name="status"
                                            class="form-select @error('status') is-invalid @enderror">
                                            <option value="Almoxarifado"
                                                {{ old('status', $maquina->status) == 'Almoxarifado' ? 'selected' : '' }}>
                                                Almoxarifado
                                            </option>
                                            <option value="Colaborador Integral"
                                                {{ old('status', $maquina->status) == 'Colaborador Integral' ? 'selected' : '' }}>
                                                Colaborador Integral
                                            </option>
                                            <option value="Colaborador Meio Período"
                                                {{ old('status', $maquina->status) == 'Colaborador Meio Período' ? 'selected' : '' }}>
                                                Colaborador Meio Período
                                            </option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

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
                                                    {{ old('usuario_integral', $maquina->usuariosIntegrais->first()->id ?? '') == $usuario->id ? 'selected' : '' }}>
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
                                                            {{ old('usuario_manha', $maquina->usuariosManha->first()->id ?? '') == $usuario->id ? 'selected' : '' }}>
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
                                                            {{ old('usuario_tarde', $maquina->usuariosTarde->first()->id ?? '') == $usuario->id ? 'selected' : '' }}>
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
                                                    {{ collect(old('equipamentos_ids', $maquina->equipamentos->pluck('id')))->contains($equipamento->id) ? 'selected' : '' }}>
                                                    {{ $equipamento->patrimonio }} - {{ $equipamento->produto->nome }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('equipamentos_ids')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('patrimonios.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Atualizar Máquina
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
