<!DOCTYPE html>
<html lang="pt-br">

@include('panel.template.head')

<body class="hold-transition sidebar-collapse sidebar-mini">
    <div class="carregando"></div>

    <div class="wrapper">

        @include('panel.template.navbar')

        @include('panel.template.aside-left')

        @yield('content')

        @include('panel.template.aside-right')

        @include('panel.template.footer')

    </div>

    @include('panel.template.javascript')

    <div class="modal fade" id="modal" name="modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-md">

        </div>
    </div>
</body>

</html>
