<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Contratacion') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('1.ico') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custoButton.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>



    <!-- datepicker -->
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>

    <!-- select -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/select2.min.js') }}"></script>
</head>

<body>
    <div id="app">
        <a class="col-12 card disaicBrand" href="https://www.disaic.cu">
            <img class="disaicLogo" src="{{ asset('logotipo disaic2.png') }}" alt="">
        </a>
        <nav class="navbar navbar-expand-md navbar-light bg-white main-nav shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Sistema de Contratos
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Entrar</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown mx-1">
                                <a class="nav-link dropdown-toggle
                                    {{ request()->is('organismo*') || request()->is('grupo*') || request()->is('entidad*') || request()->is('user*')
                                        ? 'active'
                                        : '' }}"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Nomencladores</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->is('organismo*') ? 'active' : '' }}"
                                            href="{{ url('organismo') }}">
                                            Organismos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('grupo*') ? 'active' : '' }}"
                                            href="{{ url('grupo') }}">
                                            Grupo
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('entidad*') ? 'active' : '' }}"
                                            href="{{ url('entidad') }}">
                                            Entidades
                                        </a>
                                    </li>
                                    @if (Auth::user()->role === 'Administrador')
                                        <li>
                                            <a class="dropdown-item {{ request()->is('user*') ? 'active' : '' }}"
                                                href="{{ url('user') }}">
                                                Usuarios
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </li>

                            <li class="nav-item dropdown mx-1">
                                <a class="nav-link dropdown-toggle
                                    {{ request()->is('tipocm*') ||
                                    request()->is('estadocm*') ||
                                    request()->is('objsupcm*') ||
                                    request()->is('estadoce*') ||
                                    request()->is('objsupce*')
                                        ? 'active'
                                        : '' }}"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Nomencladores de Clientes</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->is('tipocm*') ? 'active' : '' }}"
                                            href="{{ url('tipocm') }}">
                                            Tipo de Contrato Marco
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('estadocm*') ? 'active' : '' }}"
                                            href="{{ url('estadocm') }}">
                                            Estado de Contrato Marco
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('objsupcm*') ? 'active' : '' }}"
                                            href="{{ url('objsupcm') }}">
                                            Objeto de suplemento de Contrato Marco
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('estadoce*') ? 'active' : '' }}"
                                            href="{{ url('estadoce') }}">
                                            Estado de Contrato Específico
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('objsupce*') ? 'active' : '' }}"
                                            href="{{ url('objsupce') }}">
                                            Objeto de suplemento de Contrato Específico
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown mx-1">
                                <a class="nav-link dropdown-toggle
                                    {{ request()->is('cliente*') ||
                                    request()->is('cm*') ||
                                    request()->is('ce*') ||
                                    request()->is('supcm*') ||
                                    request()->is('supce*')
                                        ? 'active'
                                        : '' }}"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Clientes</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->is('cliente*') ? 'active' : '' }}"
                                            href="{{ url('cliente') }}">
                                            Clientes
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('cm*') ? 'active' : '' }}"
                                            href="{{ url('cm') }}">
                                            Contratos Marco
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('supcm*') ? 'active' : '' }}"
                                            href="{{ url('supcm') }}">
                                            Consulta de Suplementos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('ce*') ? 'active' : '' }}"
                                            href="{{ url('ce') }}">
                                            Consulta de Contratos Específicos
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown mx-1">
                                <a class="nav-link dropdown-toggle
                                    {{ request()->is('tipocp*') || request()->is('estadocp*') || request()->is('objsupcp*') ? 'active' : '' }}"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Nomencladores de Proveedores</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->is('tipocp*') ? 'active' : '' }}"
                                            href="{{ url('tipocp') }}">
                                            Tipo de Contrato Proveedor
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('estadocp*') ? 'active' : '' }}"
                                            href="{{ url('estadocp') }}">
                                            Estado de Contrato Proveedor
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('objsupcp*') ? 'active' : '' }}"
                                            href="{{ url('objsupcp') }}">
                                            Objeto de suplemento de Contrato Proveedor
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item dropdown mx-1">
                                <a class="nav-link dropdown-toggle
                                    {{ request()->is('proveedor*') || request()->is('cp*') || request()->is('supcp*') ? 'active' : '' }}"
                                    id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">Proveedores</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item {{ request()->is('Proveedor*') ? 'active' : '' }}"
                                            href="{{ url('proveedor') }}">
                                            Proveedores
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('cp*') ? 'active' : '' }}"
                                            href="{{ url('cp') }}">
                                            Contratos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item {{ request()->is('supcp*') ? 'active' : '' }}"
                                            href="{{ url('supcp') }}">
                                            Consulta de Suplementos
                                        </a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item dropdown mx-1">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if (Auth::user()->role === 'Administrador')
                                        <a class="dropdown-item {{ request()->is('logs*') ? 'active' : '' }}"
                                            href="{{ url('logs') }}">
                                            Logs
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
