<!DOCTYPE html>
<html>

<head>
  @include('Frontend.masterpage.head')
</head>

<body>
  @include('Frontend.masterpage.header')
    @yield('content')
  @include('Frontend.masterpage.footer')
</body>

</html>
