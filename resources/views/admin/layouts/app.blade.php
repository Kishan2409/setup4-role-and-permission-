<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layouts.files.hade')
</head>

<body>

    @include('admin.layouts.files.navbar')

    @include('admin.layouts.files.sidebar')

    @yield('main')

    @include('admin.layouts.files.footer')

    @include('admin.layouts.files.script')

    @yield('script')
</body>

</html>
