<li class="dropdown user user-menu">
    <!-- Menu Toggle Button -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- The user image in the navbar-->
        <img src="{{ Auth::user()->picture() }}" class="user-image" alt="User Image">
        <!-- hidden-xs hides the username on small devices so only the image appears. -->
        <span class="hidden-xs">{{ Auth::user()->username }}</span>
    </a>
    <ul class="dropdown-menu">
        <!-- The user image in the menu -->
        <li class="user-header">
            <img src="{{ Auth::user()->picture() }}" class="img-circle" alt="User Image">

            <p>
                {{ Auth::user()->first_name ." "  .Auth::user()->last_name ." - " .Auth::user()->role->title }}
                <small>Member since <?php
                    $dt = new \Carbon\Carbon(Auth::user()->created_at);
                    echo $dt->toFormattedDateString();
                    ?></small>
            </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
            <div class="row">
            </div>
            <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
            <div class="pull-left">
                <a href="{{ url('profile') }}" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
                <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
            </div>
        </li>
    </ul>
</li>