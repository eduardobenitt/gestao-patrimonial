<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>AssetFlow</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Google Fonts para título estilizado --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">

    {{-- CSS adicional do site da documentação do Bootstrap (opcional) --}}
    <link href="https://getbootstrap.com/docs/5.2/assets/css/docs.css" rel="stylesheet" />

    {{-- Select2 CSS (se você estiver usando) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- CSS customizado --}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

</head>

<body>
    {{-- Navbar superior escura --}}
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            {{-- Área esquerda da navbar --}}
            <div>
                {{-- Botão que abre o offcanvas (para dispositivos móveis) --}}
                <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            {{-- Nome/Marca do site (centralizado) --}}
            <a class="navbar-brand app-title" href="#">AssetFlow</a>

            {{-- Área direita da navbar --}}
            <div>
                {{-- Ícone de notificação --}}
                <button class="btn text-white notification-btn" type="button">
                    <i class="bi bi-bell-fill fs-5"></i>
                    <span class="notification-badge"></span>
                </button>
            </div>

            {{-- Offcanvas lateral (para dispositivos móveis) --}}
            <div class="offcanvas offcanvas-start text-bg-dark d-lg-none" tabindex="-1" id="offcanvasDarkNavbar"
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
                                    <i class="bi bi-house-door-fill"></i> Home
                                </a>
                            </li>
                            @if (auth()->user()->role !== 'usuario')
                                {{-- Unificando Máquinas e Equipamentos em "Patrimônio" --}}
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('patrimonios.index') }}">
                                        <i class="bi bi-pc-display"></i> Patrimônios
                                    </a>
                                </li>

                                {{-- Produtos --}}
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="{{ route('produtos.index') }}">
                                        <i class="bi bi-box-seam"></i> Produtos
                                    </a>
                                </li>
                            @endif

                            {{-- Usuários (caso queira manter um link direto para gerenciar todos) --}}
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page"
                                    href="{{ route('users.show', auth('web')->user()) }}">
                                    <i class="bi bi-people-fill"></i> Meus Dados
                                </a>
                            </li>

                            {{-- Logout --}}
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link nav-link active" aria-current="page">
                                        <i class="bi bi-box-arrow-right"></i> Sair
                                    </button>
                                </form>
                            </li>
                        @endauth

                        {{-- Para visitantes (não autenticados) --}}
                        @guest
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/login">
                                    <i class="bi bi-box-arrow-in-right"></i> Entrar
                                </a>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
            {{-- Fim do offcanvas --}}
        </div>
    </nav>

    {{-- Sidebar (visível apenas em telas maiores) --}}
    <div class="sidebar d-none d-lg-block">
        {{-- Botão de toggle para expandir/colapsar com ícone de seta --}}
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-arrow-right-circle" id="toggleIcon"></i>
        </button>

        {{-- Links da sidebar --}}
        <ul class="sidebar-nav">
            @auth
                <li>
                    <a href="{{ route('users.index') }}"
                        class="nav-link sidebar-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>
                </li>

                @if (auth()->user()->role !== 'usuario')
                    <li>
                        <a href="{{ route('patrimonios.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('patrimonios.index') ? 'active' : '' }}">
                            <i class="bi bi-pc-display"></i>
                            <span>Patrimônios</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('produtos.index') }}"
                            class="nav-link sidebar-link {{ request()->routeIs('produtos.index') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i>
                            <span>Produtos</span>
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('users.show', auth('web')->user()) }}"
                        class="nav-link sidebar-link {{ request()->routeIs('users.show') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Meus Dados</span>
                    </a>
                </li>

                <li>
                    <a href="#" class="nav-link sidebar-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sair</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            @endauth

            @guest
                <li>
                    <a href="/login" class="nav-link sidebar-link">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <span>Entrar</span>
                    </a>
                </li>
            @endguest
        </ul>
    </div>

    {{-- Conteúdo principal --}}
    <div class="main-content">
        {{-- Container principal --}}
        <main class="container mt-2">
            <div class="bg-body-tertiary p-2 rounded">
                @yield('content')
            </div>
        </main>
    </div>

    {{-- Scripts essenciais --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Script para controlar a sidebar --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarToggle = document.getElementById("sidebarToggle");
            const sidebar = document.querySelector(".sidebar");
            const mainContent = document.querySelector(".main-content");
            const toggleIcon = document.getElementById("toggleIcon");
            const sidebarLinks = document.querySelectorAll(".sidebar-link");

            // Sempre iniciar com a sidebar fechada
            sidebar.classList.remove("expanded");
            mainContent.classList.remove("sidebar-expanded");
            updateToggleIcon();

            // Função para atualizar o ícone do botão toggle
            function updateToggleIcon() {
                if (sidebar.classList.contains("expanded")) {
                    // Sidebar está expandida, mostra ícone de seta para esquerda
                    toggleIcon.classList.remove("bi-arrow-right-circle");
                    toggleIcon.classList.add("bi-arrow-left-circle");
                } else {
                    // Sidebar está recolhida, mostra ícone de seta para direita
                    toggleIcon.classList.remove("bi-arrow-left-circle");
                    toggleIcon.classList.add("bi-arrow-right-circle");
                }
            }

            // Evento de clique no botão toggle
            sidebarToggle.addEventListener("click", function() {
                sidebar.classList.toggle("expanded");
                mainContent.classList.toggle("sidebar-expanded");
                updateToggleIcon();
            });

            // Fechar a sidebar quando um link é clicado
            sidebarLinks.forEach((link) => {
                link.addEventListener("click", function() {
                    // Apenas fecha se estiver em modo mobile ou se queremos sempre fechar
                    sidebar.classList.remove("expanded");
                    mainContent.classList.remove("sidebar-expanded");
                    updateToggleIcon();
                });
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
