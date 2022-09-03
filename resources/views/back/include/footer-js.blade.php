<script src="{{ asset('assets/back/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/back/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/back/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{ asset('assets/back/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('assets/back/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{ asset('assets/back/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{ asset('assets/back/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{ asset('assets/back/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- overlayScrollbars -->
<script src="{{ asset('assets/back/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/back/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/back/dist/js/demo.js')}}"></script>
<script src="{{ asset('assets/back/dist/js/pages/dashboard.js')}}"></script>
<script src="{{ asset('assets/back/js/toastr.min.js')}}"></script>
@stack('extra-script')
<script type="text/javascript">

    @if(session()->has('alert'))
    @php
        $alert = session()->get('alert');
        $alertType = $alert['type'];
        $alertMessage = $alert['message'];
    @endphp

    @if($alertType == 'success')
    toastr.success('{{ $alertMessage }}');
    @endif
    @if($alertType == 'warning')
    toastr.warning('{{ $alertMessage }}');
    @endif
    @if($alertType == 'error')
    toastr.error('{{ $alertMessage }}');
    @endif

    @endif
</script>
