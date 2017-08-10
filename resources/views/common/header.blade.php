<div class="topbar">

    {{--<!-- LOGO -->--}}
    {{--<div class="topbar-left">--}}
        {{--<div class="text-center">--}}
            {{--<!-- Image Logo here -->--}}
            {{--<a href="/" class="logo">--}}
                {{--<i class="icon-c-logo"> <img src="/logo.png" height="20"/> </i>--}}
                {{--<span><img src="/logo.png" height="50"/></span>--}}
            {{--</a>--}}
        {{--</div>--}}
    {{--</div>--}}

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
            <div class="">
                    {{--<div class="pull-left">--}}
                        {{--<button class="button-menu-mobile open-left waves-effect waves-light">--}}
                            {{--<i class="md md-menu"></i>--}}
                        {{--</button>--}}
                        {{--<span class="clearfix"></span>--}}
                    {{--</div>--}}

                    {{--<ul class="nav navbar-nav hidden-xs">--}}
                        {{--<li><a href="#" class="waves-effect waves-light">Files</a></li>--}}
                    {{--</ul>--}}

                    {{--<form role="search" class="navbar-left app-search pull-left hidden-xs">--}}
                        {{--<input type="text" placeholder="Search..." class="form-control">--}}
                        {{--<a href=""><i class="fa fa-search"></i></a>--}}
                    {{--</form>--}}


                <ul class="nav navbar-nav navbar-right pull-right">
                    <li class="hidden-xs">
                        <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i class="icon-size-fullscreen"></i></a>
                    </li>
                    <li class="dropdown top-menu-item-xs">
                        <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><img src="/vendor/ubold/assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle"> </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('profiles.index') }}"><i class="ti-user m-r-10 text-custom"></i> Profile</a></li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
