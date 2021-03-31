<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'BikeShop จำหน่ายอะไหล่จักรยานออนไลน์')</title>

    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="{{asset('js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('vendor/toastr/toastr.min.js')}}"></script>
    <script src="{{asset('vendor/angularJS/js/angular.min.js')}}"></script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <a href="#" class="navbar-brand">Bike <i class="fa fa-bicycle"></i> Shop</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li> <a href="{{ url('/') }}"><i class="fa fa-home"></i> หน้าแรก</a> </li>
                    @guest
                    @else
                    <li> <a href="{{ url('/product/') }}"><i class="fa fa-shopping-cart"></i> ข้อมูลสินค้า</a> </li>
                    <li> <a href="{{ url('/category/') }}"><i class="fa fa-cart-arrow-down"></i> ข้อมูลประเภทสินค้า</a> </li>
                    <li> <a href="#"><i class="fa fa-print"></i> รายงาน</a> </li>
                    @endguest
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @guest
                    <li> <a href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> Login</a> </li>
                    <li> <a href="{{ url('/register') }}"><i class="fa fa-user-circle"></i> Register</a> </li>
                    @else
                    <li>
                        <a href="{{ URL::to('cart/view') }}"> <i class="fa fa-shopping-cart"></i> ตะกร้า
                            <span class="label label-danger">
                                @if (Session::has('cart_items'))
                                    {{ count(Session::get('cart_items')) }}
                                @else
                                    {{ count(array()) }}
                                @endif
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out"></i> Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
        @if(session('msg'))
            @if(session('ok'))
                <script> toastr.success("{{ session('msg') }}") </script>
            @else
                <script> toastr.error("{{ session('msg') }}") </script>
            @endif
        @endif
    </div>

    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>