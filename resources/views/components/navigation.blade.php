<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand mr-5 p-0" href="/">
            <img src="{{ url('storage/'.setting('site.logo') )}}" alt="{{ setting('site.title')}}" height="42"/>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto button">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><small class="fas fa-compass mr-2"></small>Explore</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#"><small class="fas fa-flag-checkered mr-2"></small> Participate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><small class="fas fa-book-reader mr-2"></small> Learn put Explore</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="#"><small class="fas fa-book mr-2"></small> Journals and Issues</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{Auth::check() ? '#new-post' :'#loginModal'}}" data-toggle="modal" ><small class="fas fa-camera-retro mr-2"></small> Submit your photos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about-us"><small class="fas fa-users mr-2"></small> About us</a>
                </li>
                
            </ul>
            @if(Auth::check())
                <ul class="navbar-nav ml-auto user-navs d-flex align-items-center">
                    @if(!Auth::guest() && Auth::user()->hasPermission('browse_admin'))
                        <li class="nav-item ml-3">
                            <a href="/admin" target="_blank" class="btn btn-primary" ><small class="fab fa-trello mr-2"></small> Dashboard</a>
                        </li>
                    @endif
                    <li class="nav-item ml-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#new-post"><small class="fas fa-camera mr-2"></small> Upload</button>
                    </li>
                    <li class="nav-item ml-3">
                        <i class="fas fa-bell p-2 color-light"></i>
                    </li>
                    <li class="nav-item dropdown ml-3">
                        <a class="nav-link dropdown-toggle avatar" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" style="background-image: url({{ url('storage/'.Auth::user()->avatar) }})" ></a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="/profile">Dashboard</a>
                            {{-- <a class="dropdown-item" href="#">Another action</a> --}}
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="/logout">Logout</a>
                        </div>
                    </li>
                <ul>
            @else
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ml-3">
                        <button class="btn btn-primary" data-toggle="modal" data-target="#loginModal"><small class="fas fa-camera mr-2"></small> Upload</button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal"> <small class="fas fa-key"></small> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-toggle="modal" data-target="#registerModal">Sign up</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>