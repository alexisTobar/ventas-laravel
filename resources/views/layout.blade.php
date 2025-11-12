<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Juegos Vikingos - POS</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/now-ui-dashboard@1.0.1/assets/css/now-ui-dashboard.min.css" rel="stylesheet" />

    <style>
        /* Pequeño ajuste para que el Chart.js sea responsivo */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }

        /* Estilo para el separador 'Admin' */
        .sidebar .nav-section {
            padding: 0.5rem 1.8rem;
            /* Alineado con los otros enlaces */
            margin-top: 1rem;
            color: #9A9A9A;
            /* Un color gris para el texto */
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar .nav-section .sidebar-mini-icon {
            display: inline-block;
            width: 30px;
            /* Alineación */
            text-align: center;
        }
    </style>
</head>

<body class="">
    <div class="wrapper">

        <div class="sidebar" data-color="orange">
            <div class="logo">
                <a href="{{ route('dashboard') }}" class="simple-text logo-mini">
                    JV
                </a>
                <a href="{{ route('dashboard') }}" class="simple-text logo-normal">
                    Juegos Vikingos
                </a>
            </div>
            <div class="sidebar-wrapper" id="sidebar-wrapper">
                <ul class="nav">
                    <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <i class="now-ui-icons design_app"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="{{ request()->routeIs('ventas.create') ? 'active' : '' }}">
                        <a href="{{ route('ventas.create') }}">
                            <i class="now-ui-icons shopping_cart-simple"></i>
                            <p>Registrar Venta</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('ventas.index') ? 'active' : '' }}">
                        <a href="{{ route('ventas.index') }}">
                            <i class="now-ui-icons files_paper"></i>
                            <p>Historial de Ventas</p>
                        </a>
                    </li>

                    @if(auth()->check() && auth()->user()->role == 'admin')
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">A</span>
                        <span class="sidebar-normal">Admin</span>
                    </li>
                    <li class="{{ request()->routeIs('productos.*') ? 'active' : '' }}">
                        <a href="{{ route('productos.index') }}">
                            <i class="now-ui-icons shopping_box"></i>
                            <p>Gestión de Productos</p>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('reportes.index') ? 'active' : '' }}">
                        <a href="{{ route('reportes.index') }}">
                            <i class="now-ui-icons business_chart-pie-36"></i>
                            <p>Reportes</p>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="main-panel" id="main-panel">

            <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="#pablo">@yield('page-title', 'Dashboard')</a>
                    </div>

                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="now-ui-icons users_single-02"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Usuario</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <a class="dropdown-item" href="#">{{ Auth::user()->name }}</a>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Mi Perfil</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Cerrar Sesión
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="panel-header panel-header-sm">
                </div>
            <div class="content">

                @yield('content') </div>
            <footer class="footer">
                <div class=" container-fluid ">
                    <div class="copyright" id="copyright">
                        &copy; <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>,
                        Diseñado por Creative Tim. Creado por Juegos Vikingos.
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/now-ui-dashboard@1.0.1/assets/js/now-ui-dashboard.min.js"></script>

    @yield('scripts')

</body>
</html>