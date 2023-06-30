@push('scripts')
    <style>
      #ubahSesi:hover{
        color: #9FA6B2 !important;
        transition: 300ms ease-in-out;
      }
    </style>
@endpush

<div class="navbar-custom-menu">
  <ul class="nav navbar-nav">
    </li>
    <!-- Messages: style can be found in dropdown.less-->
    <li class="dropdown messages-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success">4</span>
      </a>
      <ul class="dropdown-menu">
        <li class="header">You have 4 messages</li>
        <li>
          <!-- inner menu: contains the actual data -->
          <ul class="menu">
            <li><!-- start message -->
              <a href="#">
                <div class="pull-left">
                  <img src="{{ asset('assets/img/logo.svg') }}" class="img-circle" alt="User Image">
                </div>
                <h4>
                  Support Team
                  <small><i class="fa fa-clock-o"></i> 5 mins</small>
                </h4>
                <p>Why not buy a new awesome theme?</p>
              </a>
            </li>
            <!-- end message -->
          </ul>
        </li>
        <li class="footer"><a href="#">See All Messages</a></li>
      </ul>
    </li>
  
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="text-transform: capitalize">
          <i class="fa fa-user"></i>
          <span class="hidden-xs">
              @yield('user-login2') 
          </span>
      </a>
    </li>
    <!-- Control Sidebar Toggle Button -->
    <li style="background:#dc3545;">
      @if (isset($_SESSION['nama']))
        <a data-toggle="control-sidebar" href="{{ route('logoutDosen') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off"></i>&nbsp; {{ __('logoutDosen') }}
        </a>
      @else
        <a data-toggle="control-sidebar" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <i class="fa fa-power-off"></i>&nbsp; {{ __('Logout') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      @endif
      
    </li>
  </ul>
</div>

@if (!empty(session()->has('nip_dosen')))
  <div class="center-navbar hidden-xs" style="display: block; text-align: left; color: white; padding: 15px; /* adjust based on your layout * margin-left: 50px; margin-right: 300px;">
    <b style="text-transform: uppercase">
      {{ session('nama_dosen') }} - {{ session('jurusan') }}&nbsp;
      |&nbsp;
      <a href="{{ route('cari_dosen.remove_session') }}" id="ubahSesi" style="color:white"><i class="fa fa-edit"></i>&nbsp;Ubah Dosen</a>
    </b>
  </div>
@endif