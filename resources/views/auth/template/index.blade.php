<!DOCTYPE html>
<html lang="pt-br">

@include('auth.template.head')

<body class="hold-transition login-page {{ Route::is('register') ? 'register-page' : ''}}">
    @yield('content')

    @include('auth.template.javascript')
    <!-- Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
