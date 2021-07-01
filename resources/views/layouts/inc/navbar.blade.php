<a class="col-12 card" href = "http://www.disaic.cu" style="background: rgb(255,255,255);
background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(29,86,253,1) 96%, rgba(69,73,252,1) 100%);">
<img src="{{ asset('frontend/img/logotipo disaic2.png') }}" style="width: 20%;" alt="">
</a>

<nav class="navbar navbar-expand-lg navbar-light " style="background: rgb(255,255,255);
background: radial-gradient(circle, rgba(255,255,255,1) 0%, rgba(194,209,254,1) 36%, rgba(203,215,254,1) 76%, rgba(255,255,255,1) 100%);">
  <div class="container">
    <a class="navbar-brand" href="#">Sistema de Contratos</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @guest
            @if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Entrar') }}</a>
                </li>
            @endif
            @else
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Nomencladores</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ url('organismos') }}">
                                Organismos
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Grupos Empresariales
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Clientes
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Tipos de Contratos
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Servicios
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Configuración del servidor de correo
                            </a>
                            <a class="dropdown-item" href="{{url('user')}}">
                                Usuarios
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Contratos</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Contratos Marco
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Contrato Proveedores
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Consulta de Suplementos
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Contratos Marco por Vencer
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Reportes VERSAT</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Ventas por Centro de Costo
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Ventas de la Producción Terminada
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Ventas de las Mercancías
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Ventas de Servicios por Centro de Costo
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Ventas por Servicios
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Ventas Totales
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}">
                                Prefijo de las Facturas en VERSAT
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('user')}}">Ayuda</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                             onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            {{ __('Cerrar sesión') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
