         <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('guest_book/assets/images/favicon.ico') }}">

        <!-- DataTables -->
        <link href="{{ asset('guest_book/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('guest_book/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        
        <!-- Custom box css -->
        <link href="{{ asset('guest_book/plugins/custombox/css/custombox.min.css') }}" rel="stylesheet">

        <link href="{{ asset('guest_book/plugins/jquery-toastr/jquery.toast.min.css') }}" rel="stylesheet" />

        <!-- App css -->
        <link href="{{ asset('guest_book/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('guest_book/assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('guest_book/assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('guest_book/assets/css/style.css') }}" rel="stylesheet" type="text/css" />

        <script src="{{ asset('guest_book/assets/js/modernizr.min.js') }}"></script>
        @yield('style')
