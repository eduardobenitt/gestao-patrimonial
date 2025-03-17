@extends('layouts.guest')

@section('title', 'Lista de Usuários')

@section('content')
    <div class="login-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card login-card shadow-lg">
                        <div class="card-body p-5">
                            <!-- Logo e Título -->
                            <div class="text-center mb-4">
                                <h4 class="text-white mb-1">Bem-vindo ao Sistema</h4>
                                <p class="text-white-50">Acesse sua conta para continuar</p>
                            </div>

                            <!-- Session Status -->
                            <x-auth-session-status class="mb-4" :status="session('status')" />

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email Address -->
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label text-white">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                                            class="form-control @error('email') is-invalid @enderror" required autofocus
                                            autocomplete="username" placeholder="seu-email@exemplo.com">
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-4">
                                    <div class="d-flex justify-content-between">
                                        <label for="password" class="form-label text-white">Senha</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}"
                                                class="text-white-50 text-decoration-none small">
                                                Esqueceu a senha?
                                            </a>
                                        @endif
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror" required
                                            autocomplete="current-password" placeholder="••••••••">
                                        <button type="button"
                                            class="input-group-text bg-transparent border-start-0 toggle-password"
                                            tabindex="-1">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Remember Me -->
                                <div class="form-check mb-4">
                                    <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                                    <label for="remember_me" class="form-check-label text-white-50">
                                        Lembrar-me
                                    </label>
                                </div>

                                <!-- Login Button -->
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                                    </button>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="text-white-50 mb-0">
                                        Não tem uma conta?
                                        <a href="{{ route('users.create') }}" class="text-white fw-medium">
                                            Cadastre-se
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Informações Adicionais -->
                    <div class="text-center mt-4 text-white-50">
                        <p class="mb-1 small">© {{ date('Y') }} AssetFlow | Todos os direitos reservados</p>
                        <p class="small">v1.0.0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
