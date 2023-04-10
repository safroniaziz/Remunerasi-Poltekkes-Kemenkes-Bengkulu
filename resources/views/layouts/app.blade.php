
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistem Remunerasi | @yield('subTitle')</title>
    <link rel="icon" href="{{ asset('assets/img/logo.svg') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.partials.assets.css')
  </head>
  <body class="hold-transition skin-blue-light fixed sidebar-mini">
    <div class="preloader">
      <div class="do-loader"></div>
    </div>
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><i class="fa fa-home"></i></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg" style="font-size:16px;"><b>SISTEM</b> REMUNERASI </span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>

          @include('layouts.partials.navbar')
        </nav>
      </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel" style="padding: 14px 10px !important;">
            <div class="pull-left image">
              <img src="{{ asset('assets/img/logo.svg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info" style="padding: 2px 5px 5px 15px;">
              <p>Login Administrator</p>
              <a href="#"><i class="fa fa-user"></i> Alexander Pierce</a>
            </div>
          </div>
      
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            @include('layouts.partials.sidebar')
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Sistem Remunerasi Khusus Dosen
            <small>Politeknik Kesehatan Kementerian kesehatan Bengkulu</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i>Remunerasi</a></li>
            <li><a href="#">@yield('page')</a></li>
            <li class="active">@yield('subPage')</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Poltekkes Kemenkes Bengkulu</b>
        </div>
        <strong>Copyright &copy; 2023 <a href="https://poltekkesbengkulu.ac.id/">Poltekkes Kemenkes</a>.</strong> Bengkulu
        reserved.
      </footer>

    </div>
    <!-- ./wrapper -->

    @include('layouts.partials.assets.js')
  </body>
</html>
