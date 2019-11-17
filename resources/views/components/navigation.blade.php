<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand mr-5 p-0" href="#">
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
                <li class="nav-item">
                    <a class="nav-link" href="#"><small class="fas fa-flag-checkered mr-2"></small> Participate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><small class="fas fa-book-reader mr-2"></small> Learn</a>
                </li>
                
            </ul>
            @if(Auth::check())
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"> <small class="fas fa-key"></small> Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sign up</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>