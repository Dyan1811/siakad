<!--
NAME: Rian Firmansyah
NIM: 3202416045
DATE: 3/11/2026
 -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Masuk') | {{ config('app.name') }}</title>

    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
     <!--Tambahkan CSS sweetalert2 dibawah  -->
    <link href="{{ asset('vendor/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/siakad.css') }}" rel="stylesheet">

</head>
<body class="bg-body-tertiary">
    <main class="container min-vh-100 py-4 d-flex align-items-center justify-content-center">
        <div class="w-100" style="max-width: 420px;">
            @yield('content')
        </div>
    </main>
    
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Tambah JS sweetalert2 dibawah -->
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- Tambahkan dibawah -->
    @stack('scripts')
</body>
</body>
</html>