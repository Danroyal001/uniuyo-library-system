    <div class="sidebar">
        <ul class="widget widget-menu unstyled">
            <li class="{{ Route::is('home') ? 'active' : '' }}">
                <a href="{{ URL::route('home') }}">
                    <i class="menu-icon icon-home"></i>Home
                </a>
            </li>
            <li class="{{ Route::is('all-students') ? 'active' : '' }}">
                <a href="{{ URL::route('all-students', ['slug' => 'new']) }}">
                    <i class="menu-icon icon-user"></i> All Students in Library
                </a>
            </li>
            <li
                class="{{ request()->routeIs('all-books') || request()->routeIs('add-books') ? 'active' : '' }}
                ">
                <a href="{{ URL::route('all-books') }}">
                    <i class="menu-icon icon-th-list"></i>All Books in Library
                </a>
            </li>
            <li class="{{ Route::is('add-book-category') ? 'active' : '' }}">
                <a href="{{ URL::route('add-book-category') }}">
                    <i class="menu-icon icon-folder-open-alt"></i>Add Book Category
                </a>
            </li>
            {{-- <li class="{{ Route::is('add-books') ? 'active' : '' }}">
                <a href="{{ URL::route('add-books') }}">
                    <i class="menu-icon icon-folder-open-alt"></i>Add Books
                </a>
            </li> --}}

            <li class="{{ Route::is('issue-return') ? 'active' : '' }}">
                <a href="{{ URL::route('issue-return') }}">
                    <i class="menu-icon icon-signout"></i>Issue / Return Books
                </a>
            </li>
            <li class="{{ Route::is('currently-issued') ? 'active' : '' }}">
                <a href="{{ URL::route('currently-issued') }}">
                    <i class="menu-icon icon-list-ul"></i>All issued books
                </a>
            </li>
        </ul>

        <ul class="widget widget-menu unstyled">
            <li class="{{ Route::is('settings') ? 'active' : '' }}">
                <a href="{{ URL::route('settings', ['branch']) }}">
                    <i class="menu-icon icon-cog"></i>Add Settings
                </a>
            </li>
            <li><a href="{{ URL::route('account-sign-out') }}"><i class="menu-icon icon-wrench"></i>Logout </a></li>
        </ul>
    </div>

    <style>
        .active {
            background-color: orange;
        }
    </style>
