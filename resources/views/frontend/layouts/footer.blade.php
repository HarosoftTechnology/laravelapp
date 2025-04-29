<script type="text/javascript">
    let baseUrl = "{{ url('/') }}";
    let requestToken = "{{ csrf_token() }}";
    let csrf_token = "{{ csrf_token() }}";
</script>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('js/toastr.js') }}"></script>
<script src="{{ asset('js/ui-toasts.js') }}"></script>
<script src="{{ asset('js/alpine.min.js') }}"></script>
<script src="{{ asset('js/init-alpine.js') }}"></script>
<script src="{{ asset('js/scripts.js') }}"></script>

</body>
</html>