<html>
    <head>
        <title>App Name - @yield('title')</title>
      @vite(['resources/js/app.js'])
    </head>
    <body>
      {{--   @section('sidebar')
            This is the master sidebar.
        @show --}}

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>

