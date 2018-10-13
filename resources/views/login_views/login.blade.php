
@extends('login_views/master')

@section('content')

    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">

                        <div class="website-logo-inside">
                            <a href="{{ url( $index ) }}">
                                <div class="logo">
                                    <img class="logo-size" src="{{url($assetsRootFolder . 'images/logo_splash.png')}}" alt="">
                                </div>
                            </a>
                        </div>

                        <form>
                            <input id="username" class="form-control" type="text" name="username" placeholder="E-mail" required>
                            <input id="password" class="form-control" type="password" name="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="sign" type="submit" class="ibtn">Login</button>
                            </div>
                        </form>

                        <!--
                            <div class="other-links">
                                <span>Or login with</span><a href="#">Facebook</a><a href="#">Google</a><a href="#">Linkedin</a>
                            </div>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
