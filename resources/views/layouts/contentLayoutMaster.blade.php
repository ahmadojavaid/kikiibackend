<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-textdirection="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>@yield('title')</title>
    <!-- <link rel="shortcut icon" type="image/x-icon" href="images/logo/favicon.ico"> -->

    {{-- Include core + vendor Styles --}}
    @include('panels/styles')

</head>

<body
  class="vertical-layout vertical-menu-modern 2-columns navbar-floating footer-static menu-expanded pace-done"
  data-menu="vertical-menu-modern" data-col="2-columns" data-layout="light">
  {{-- Include Sidebar --}}
  @include('panels.sidebar')

  <!-- BEGIN: Content-->
  <div class="app-content content">
    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>

    {{-- Include Navbar --}}
    @include('panels.navbar')

    <div class="content-wrapper">
      {{-- Include Breadcrumb --}}
      @include('panels.breadcrumb')

      <div class="content-body">
        {{-- Include Page Content --}}
        @include('panels.flash-message')


        @yield('content')
      </div>
    </div>

  </div>
  <!-- End: Content-->

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  {{-- include footer --}}
  @include('panels/footer')

  {{-- include default scripts --}}
  @include('panels/scripts')

 

</body>

</html>