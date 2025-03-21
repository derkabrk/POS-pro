<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
{{-- jquery confirm --}}
<script src="{{asset('assets/plugins/jquery-confirm/jquery-confirm.min.js')}}"></script>
{{-- jquery validation --}}
<script src="{{asset('assets/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
{{-- Custom --}}
<script src="{{ asset('assets/plugins/validation-setup/validation-setup.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/notification.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/form.js') }}"></script>
@stack('js')

@if(Session::has('success'))
    <script>
        Notify('success', null, "{{ Session::get('success') }}");
    </script>
@endif
@if(Session::has('error'))
    <script>
        Notify('error', null, "{{ Session::get('error') }}");
    </script>
@endif
@if(Session::has('warning'))
    <script>
        Notify('warning', null, "{{ Session::get('warning') }}");
    </script>
@endif
