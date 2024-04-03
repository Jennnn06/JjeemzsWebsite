<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Pass the title -->
    <title>@yield('title', 'Title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{asset('css/layoutstyles.css')}}" rel="stylesheet">

  </head>
  <body>
    <!-- Pass the content -->
    <div style="background-color: #282828; min-height:100vh">
      <div class="mycontent" style="display: flex; flex:1; flex-direction: row; ">
        <!-- Sidebar -->
        @include('include/sidebar')
        
        <!-- Main Content -->
        <div class="flex-grow-1" style="padding-left: 210px; background-color: #282828; min-height: 100vh;">
          @include('include/header')
          @yield('content')
        </div>
        
      </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>