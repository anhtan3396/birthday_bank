<!DOCTYPE html>
<html>

<head>
  @include('Frontend.masterpage.head')
</head>

<body>
  @include('Frontend.masterpage.header')
  <div class="container bg-color">
    @yield('content')
  </div>
  @include('Frontend.masterpage.footer')
</body>

</html>