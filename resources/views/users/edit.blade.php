@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-person-badge"></i> Editar Usuário</h5>
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

                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <!-- Informações Pessoais -->
                                <div class="col-md-6">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-person"></i> Informações Pessoais</h6>
                                    <div class="card border-light bg-light mb-3">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="name" class="form-label fw-bold">Nome</label>
                                                <input type="text" id="name" name="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    value="{{ old('name', $user->name) }}" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label fw-bold">Email</label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email', $user->email) }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-0">
                                                <label for="ramal" class="form-label fw-bold">Ramal</label>
                                                <input type="text" id="ramal" name="ramal"
                                                    class="form-control @error('ramal') is-invalid @enderror"
                                                    value="{{ old('ramal', $user->ramal) }}">
                                                @error('ramal')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Profissionais -->
                                <div class="col-md-6">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-briefcase"></i> Informações Profissionais
                                    </h6>
                                    <div class="card border-light bg-light mb-3">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="funcao" class="form-label fw-bold">Função</label>
                                                <input type="text" id="funcao" name="funcao"
                                                    class="form-control @error('funcao') is-invalid @enderror"
                                                    value="{{ old('funcao', $user->funcao) }}">
                                                @error('funcao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="equipe" class="form-label fw-bold">Equipe</label>
                                                <input type="text" id="equipe" name="equipe"
                                                    class="form-control @error('equipe') is-invalid @enderror"
                                                    value="{{ old('equipe', $user->equipe) }}">
                                                @error('equipe')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-0">
                                                <label for="unidade" class="form-label fw-bold">Unidade</label>
                                                <input type="text" id="unidade" name="unidade"
                                                    class="form-control @error('unidade') is-invalid @enderror"
                                                    value="{{ old('unidade', $user->unidade) }}">
                                                @error('unidade')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mt-2">
                                <!-- Configurações de Trabalho -->
                                <div class="col-md-12">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-gear"></i> Configurações de Trabalho</h6>
                                    <div class="card border-light bg-light">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-3">
                                                    <label for="regime" class="form-label fw-bold">Regime</label>
                                                    <select id="regime" name="regime"
                                                        class="form-select @error('regime') is-invalid @enderror">
                                                        <option value="In Office"
                                                            {{ old('regime', $user->regime) === 'In Office' ? 'selected' : '' }}>
                                                            In Office
                                                        </option>
                                                        <option value="Home Office"
                                                            {{ old('regime', $user->regime) === 'Home Office' ? 'selected' : '' }}>
                                                            Home Office
                                                        </option>
                                                        <option value="Hibrido"
                                                            {{ old('regime', $user->regime) === 'Hibrido' ? 'selected' : '' }}>
                                                            Híbrido
                                                        </option>
                                                        <option value="Prestador"
                                                            {{ old('regime', $user->regime) === 'Prestador' ? 'selected' : '' }}>
                                                            Prestador
                                                        </option>
                                                    </select>
                                                    @error('regime')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="turno" class="form-label fw-bold">Turno</label>
                                                    <select id="turno" name="turno"
                                                        class="form-select @error('turno') is-invalid @enderror">
                                                        <option value="Integral"
                                                            {{ old('turno', $user->turno) === 'Integral' ? 'selected' : '' }}>
                                                            Integral
                                                        </option>
                                                        <option value="Manhã"
                                                            {{ old('turno', $user->turno) === 'Manhã' ? 'selected' : '' }}>
                                                            Manhã
                                                        </option>
                                                        <option value="Tarde"
                                                            {{ old('turno', $user->turno) === 'Tarde' ? 'selected' : '' }}>
                                                            Tarde
                                                        </option>
                                                    </select>
                                                    @error('turno')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-3">
                                                    <label for="role" class="form-label fw-bold">Permissão</label>
                                                    <select id="role" name="role"
                                                        class="form-select @error('role') is-invalid @enderror"
                                                        @cannot('promover', $user) disabled @endcannot>
                                                        <option value="usuario"
                                                            {{ old('role', $user->role) === 'usuario' ? 'selected' : '' }}>
                                                            Usuário
                                                        </option>
                                                        <option value="tecnico"
                                                            {{ old('role', $user->role) === 'tecnico' ? 'selected' : '' }}>
                                                            Técnico
                                                        </option>
                                                        <option value="admin"
                                                            {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                                            Admin
                                                        </option>
                                                    </select>
                                                    @error('role')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>


                                                <div class="col-md-3">
                                                    <label for="status" class="form-label fw-bold">Status</label>
                                                    <select id="status" name="status"
                                                        class="form-select @error('status') is-invalid @enderror">
                                                        <option value="Ativo"
                                                            {{ old('status', $user->status) === 'Ativo' ? 'selected' : '' }}>
                                                            Ativo
                                                        </option>
                                                        <option value="Inativo"
                                                            {{ old('status', $user->status) === 'Inativo' ? 'selected' : '' }}>
                                                            Inativo
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

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Voltar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Salvar Alterações
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
