<div class="colornav">
    <nav class="navbar navbar-expand-md">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/admin/home') }}">
                <strong><span>Grio</span></strong><strong style="color:#2146C7;">Coffee</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.home') }}"> <strong>Home</strong></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="{{ route('admin.user') }}"><strong>Daftar User</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('product')}}"><strong>Product</strong></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('transaksi')}}"><strong>Riwayat Transaksi</strong></a>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown navlog">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <strong>{{Auth::guard('adminMiddle')->user()->nama}}</strong> <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu menunav dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('admin.logout')}}">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<style>
    .navbar {
        background-color: #f8f9fa;
    }

    nav a {
        color: #2146C7;

    }
    .navlog:hover{
        background-color:#2146C7;
        color:white;
    }

    nav a:hover {
        color: black;
        transition: all .4s ease-out;
        text-decoration: underline;
    }

    nav span {
        color: black;
    }

    .menunav a {
        color: #2146C7;
    }
</style>