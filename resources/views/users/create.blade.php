@extends('layouts.app')

@section('title', 'Cadastro de Usuário')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0"><i class="bi bi-person-plus"></i> Cadastro de Usuário</h5>
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

                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf

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
                                                    value="{{ old('name') }}" required autofocus>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label fw-bold">Email</label>
                                                <input type="email" id="email" name="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    value="{{ old('email') }}" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-0">
                                                <label for="ramal" class="form-label fw-bold">Ramal</label>
                                                <input type="text" id="ramal" name="ramal"
                                                    class="form-control @error('ramal') is-invalid @enderror"
                                                    value="{{ old('ramal') }}">
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
                                                    value="{{ old('funcao') }}">
                                                @error('funcao')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="equipe" class="form-label fw-bold">Equipe</label>
                                                <input type="text" id="equipe" name="equipe"
                                                    class="form-control @error('equipe') is-invalid @enderror"
                                                    value="{{ old('equipe') }}">
                                                @error('equipe')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-0">
                                                <label for="unidade" class="form-label fw-bold">Unidade</label>
                                                <input type="text" id="unidade" name="unidade"
                                                    class="form-control @error('unidade') is-invalid @enderror"
                                                    value="{{ old('unidade') }}">
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
                                <div class="col-md-6">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-gear"></i> Configurações de Trabalho</h6>
                                    <div class="card border-light bg-light">
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="regime" class="form-label fw-bold">Regime</label>
                                                    <select id="regime" name="regime"
                                                        class="form-select @error('regime') is-invalid @enderror">
                                                        <option value="In Office"
                                                            {{ old('regime') === 'In Office' ? 'selected' : '' }}>
                                                            In Office
                                                        </option>
                                                        <option value="Home Office"
                                                            {{ old('regime') === 'Home Office' ? 'selected' : '' }}>
                                                            Home Office
                                                        </option>
                                                        <option value="Hibrido"
                                                            {{ old('regime') === 'Hibrido' ? 'selected' : '' }}>
                                                            Híbrido
                                                        </option>
                                                        <option value="Prestador"
                                                            {{ old('regime') === 'Prestador' ? 'selected' : '' }}>
                                                            Prestador
                                                        </option>
                                                    </select>
                                                    @error('regime')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="turno" class="form-label fw-bold">Turno</label>
                                                    <select id="turno" name="turno"
                                                        class="form-select @error('turno') is-invalid @enderror">
                                                        <option value="Integral"
                                                            {{ old('turno') === 'Integral' ? 'selected' : '' }}>
                                                            Integral
                                                        </option>
                                                        <option value="Manhã"
                                                            {{ old('turno') === 'Manhã' ? 'selected' : '' }}>
                                                            Manhã
                                                        </option>
                                                        <option value="Tarde"
                                                            {{ old('turno') === 'Tarde' ? 'selected' : '' }}>
                                                            Tarde
                                                        </option>
                                                    </select>
                                                    @error('turno')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="role" class="form-label fw-bold">Permissão</label>
                                                    <select id="role" name="role"
                                                        class="form-select @error('role') is-invalid @enderror">
                                                        <option value="usuario"
                                                            {{ old('role') === 'usuario' ? 'selected' : '' }}>
                                                            Usuário
                                                        </option>
                                                        <option value="tecnico"
                                                            {{ old('role') === 'tecnico' ? 'selected' : '' }}>
                                                            Técnico
                                                        </option>
                                                        <option value="admin"
                                                            {{ old('role') === 'admin' ? 'selected' : '' }}>
                                                            Admin
                                                        </option>
                                                    </select>
                                                    @error('role')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Senha -->
                                <div class="col-md-6">
                                    <h6 class="mb-3 text-primary"><i class="bi bi-lock"></i> Credenciais de Acesso</h6>
                                    <div class="card border-light bg-light">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="password" class="form-label fw-bold">Senha</label>
                                                <input type="password" id="password" name="password"
                                                    class="form-control @error('password') is-invalid @enderror" required>
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-0">
                                                <label for="password_confirmation" class="form-label fw-bold">Confirmar
                                                    Senha</label>
                                                <input type="password" id="password_confirmation"
                                                    name="password_confirmation" class="form-control" required>
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
                                    <i class="bi bi-save"></i> Cadastrar Usuário
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
