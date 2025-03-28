<script src="{{ asset('Auth-Panel/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('Auth-Panel/plugins/jquery.mask.js') }}"></script>
<script src="{{ asset('Auth-Panel/plugins/select2/js/select2.full.min.js') }} "></script>

@yield('javascriptLocal')

<script>
    $(function() {
        $(document).on('click', '.btn-lock', clickLock);
    });

    function clickLock(e) {
        e.preventDefault();

        if ($("#password").attr('type') == 'text') {
            $("#password").attr('type', 'password');
            $(this).attr('class', 'fa fa-lock text-black-50 btn-lock');
        } else {
            $("#password").attr('type', 'text');
            $(this).attr('class', 'fa fa-unlock text-black-50 btn-lock');
        }
    }
</script>
