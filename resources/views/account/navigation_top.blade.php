<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ URL::route('home') }}">{{ getAppName() }}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu1">
                <marquee class1="brand" style="color:#fff" behavior="" direction="">Welcome to {{ getAppName() }}
                </marquee>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        padding-left: 50px;
        padding-right: 100px;
    }

    .dropdown-item {
        text-decoration: none;
    }

    .dropdown-toggle {
        text-decoration: none !important;
    }

    /* Profile Picture */
    .profile-pic {
        display: inline-block;
        vertical-align: middle;
        width: 30px;
        height: 30px;
        overflow: hidden;
        border-radius: 50%;
    }

    .profile-pic img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .profile-menu .dropdown-menu {
        right: 0;
        left: unset;
    }

    .profile-menu .fa-fw {
        margin-right: 10px;
    }

    .toggle-change::after {
        border-top: 0;
        border-bottom: 0.3em solid;
    }
</style>
