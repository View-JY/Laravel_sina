{{-- Default --}}
<!DOCTYPE html>
<html>
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sample App') - Laravel 入门教程</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
  </head>
  <body>
    @include('layouts._header')
      
    <div class="container" id="app">
      <div class="col-md-offset-1 col-md-10">
          
        @include('layouts._header')

        @yield('content')

        @include('layouts._footer')

      </div>
    </div>
   
    <script src="{{asset('/js/app.js')}}"></script>
  </body>
</html>