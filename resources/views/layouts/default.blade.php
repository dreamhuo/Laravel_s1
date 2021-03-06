
<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', 'Weibo App') -  社区化分享</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  </head>

  <body>
    @include('layouts._header')

    <div class="container">
      <div class="offset-md-1 col-md-10">
        @include('shared._messages')
        @yield('content')
        @include('layouts._footer')
      </div>
    </div>
    <!-- {{--引入app.js--}} -->
    <script src="{{ mix('js/app.js') }}"></script>
  </body>
</html>
