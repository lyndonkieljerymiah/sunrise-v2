<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse-menu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="collapse-menu">
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-envelope-o fa-lg" aria-hidden="true"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="fa fa-envelope-open-o" aria-hidden="true"></i> INBOX</a></li>
            <li><a href="#"> <i class="fa fa-envelope-open" aria-hidden="true"></i> DRAFT MESSAGE</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-calendar fa-lg" aria-hidden="true"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">CALENDAR</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i> Notification 1</a></li>
            <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i> Notification 2</a></li>
            <li><a href="#"><i class="fa fa-bell" aria-hidden="true"></i> Notification 3</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle fa-lg" aria-hidden="true"></i> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i> Profile</a></li>
            <li><hr/></li>
            <li>
                <a href="#" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                  <i class="fa fa-power-off" aria-hidden="true"></i> Logout

                </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div id="wrapper">
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="/">SUNRISE HOME</a>
            </li>
            <li>
              <a href="{!! url('contract') !!}"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"></i>  CONTRACTS</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-users fa-lg" aria-hidden="true"></i>  ACCOUNTS</a>
            </li>
            <li>
              <a href="#"><i class="fa fa-wrench fa-lg" aria-hidden="true"></i>  RECIEVABLE</a>
            </li>
            <li>
              <a href="{!!url('villa')!!}"><i class="fa fa-folder-open-o fa-lg" aria-hidden="true"></i>  MASTER FILE</a>
            </li>
            <li><a href="#"><i class="fa fa-folder-open-o fa-lg" aria-hidden="true"></i>  OTHERS</a></li>
            <li><a href="#"><i class="fa fa-folder-open-o fa-lg" aria-hidden="true"></i>  MORE</a></li>
            <li><a href="#"><i class="fa fa-user fa-lg" aria-hidden="true"></i>  USER</a></li>
        </ul>
    </div>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <a href="#menu-toggle" class="btn btn-default menu-toggle"><i class="fa fa-align-justify fa-lg" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

