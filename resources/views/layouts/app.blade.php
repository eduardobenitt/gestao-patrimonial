<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>AssetFlow</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- CSS adicional do site da documentação do Bootstrap (opcional) --}}
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet" />

    {{-- Select2 CSS (se você estiver usando) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- CSS customizado --}}
    <link rel="stylesheet" href="resources/css/custom.css">
</head>

<body class="p-3 m-0 border-0 bd-example">

    {{-- Navbar superior escura --}}
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            {{-- Botão que abre o offcanvas à esquerda --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Formulário de busca (placeholder, sem funcionalidade real ainda) --}}
            <form class="d-flex mt-3" role="search">
                <input class="form-control me-2" type="search" placeholder="Somente Visual" aria-label="Search">
                <button type="submit" class="btn btn-dark">Search</button>
            </form>

            {{-- Nome/Marca do site --}}
            <a class="navbar-brand" href="#">AssetFlow</a>

            {{-- Offcanvas lateral (abre pela esquerda) --}}
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>

                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">

                        {{-- Link "Home" (leva para a listagem de usuários) --}}
                        @auth
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('users.index') }}">
                                    Home
                                </a>
                            </li>
                            @if (auth()->user()->role !== 'usuario')
                                {{-- Unificando Máquinas e Equipamentos em “Patrimônio” --}}
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('maquinas.index') }}">
                                        Patrimônio
                                    </a>
                                </li>

                                {{-- Produtos --}}
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('produtos.index') }}">
                                        Produtos
                                    </a>
                                </li>

                                {{-- Usuários (caso queira manter um link direto para gerenciar todos) --}}
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('users.index') }}">
                                        Usuários
                                    </a>
                                </li>
                            @endif

                            {{-- Logout --}}
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link nav-link active" aria-current="page">
                                        Sair
                                    </button>
                                </form>
                            </li>
                        @endauth

                        {{-- Para visitantes (não autenticados) --}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/login">
                                    Entrar
                                </a>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
            {{-- Fim do offcanvas --}}
        </div>
    </nav>

    {{-- Conteúdo principal --}}
    <main class="container" style="margin-top: 1rem;">
        <div class="bg-body-tertiary p-2 rounded">
            @yield('content')
        </div>
    </main>

    {{-- Scripts essenciais --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>

</html>
