<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir='rtl'>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="حسابداری">
    <title>وب اپلیکیشن</title>
    @livewireStyles
    @vite(['resources/css/admin/app.css'])
</head>

<body dir='rtl' data-sidebar-position="right">


    <div class="wrapper">
        @include('admin.layouts.template.sidebar')

        <div class="main">
            @include('admin.layouts.template.navbar')

            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>

            @include('admin.layouts.template.footer')
        </div>
    </div>
    @livewireScripts
    @include('sweetalert::alert')
    @vite(['resources/js/admin/app.js'])
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            $(".advance-select").select2({
                placeholder: 'انتخاب کنید',
                language: {
                    noResults: function() {
                        return "موردی یافت نشد";
                    }
                }
            });
        })
    </script>
</body>

</html>
