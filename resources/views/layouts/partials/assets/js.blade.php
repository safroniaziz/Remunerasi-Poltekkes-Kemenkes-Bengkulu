<!-- jQuery 3 -->
<script src="{{ asset('/assets/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('/assets/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('/assets/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/assets/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/template/js/adminlte.min.js') }}"></script>

{{-- Toast Notification asset --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

{{-- Sidebar Setting --}}
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>

<script>

  // Toast Notification Setting
  @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.options = {"closeButton": true,"debug": false,"progressBar": true,"positionClass": "toast-top-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'warning':
        toastr.options = {"closeButton": true,"debug": false,"progressBar": true,"positionClass": "toast-top-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","extendedTimeOut": "1000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
            toastr.warning("{{ Session::get('message') }}");
            break;
        case 'success':
        toastr.options = {"closeButton": true,"progressBar": true,"positionClass": "toast-top-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
            toastr.success("{{ Session::get('message') }}");
            break;
        case 'error':
        toastr.options = {"closeButton": true,"progressBar": true,"positionClass": "toast-top-right","showDuration": "300","hideDuration": "1000","timeOut": "10000","showEasing": "swing","hideEasing": "linear","showMethod": "fadeIn","hideMethod": "fadeOut"};
            toastr.error("{{ Session::get('message') }}");
            break;
    }
  @endif

  // Load Animation Logo Setting
  $(window).on('load', function(){
      // will first fade out the loading animation
      jQuery(".status").fadeOut();
      // will fade out the whole DIV that covers the website.
      jQuery(".preloader").delay(0).fadeOut("slow");
  });
</script>

@stack('scripts')