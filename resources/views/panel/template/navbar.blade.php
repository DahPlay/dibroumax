<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <div class="ml-auto d-flex align-items-center">
        <ul class="navbar-nav">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="d-md-inline">Olá, {{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">

                    <a href="javascript:;" data-url="users/edit" data-id="{{ Auth::user()->id }}"
                        class="btn-edit dropdown-item py-2 ">
                        Dados cadastrais
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="post" class="mb-0">
                        @csrf
                    </form>

                    <a href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
