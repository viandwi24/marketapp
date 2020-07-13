<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">{{ env('APP_NAME', 'Marketapp') }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                <form class="d-flex">
                    <input class="form-control form-control-sm mr-2" type="search" placeholder="search product...">
                </form>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="btn btn-outline-secondary" href="#">Login</a></li>
                <li class="nav-item"><a class="btn btn-primary ml-2" href="#">Register</a></li>
            </ul>
        </div>
    </div>
</nav>