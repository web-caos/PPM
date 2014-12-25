@extends('layouts.master')
@section('title')
Login - PcPerformance
@stop

@section('body')

<body class="login">
<div class="row">
    <div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
        <div class="logo">
            <img src="{{asset('assets/images/logo.png')}}">
        </div>
        <!-- start: LOGIN BOX -->
        <div class="box-login">
            <h3>Login</h3>
            <p>
                Per favore, inserisci Username e Password.
            </p>
            <form class="form-login" method="POST" action="{{URL::to('login')}}">
                @if(Session::has('error'))
                    <div class="alert alert-danger">
                        <i class="fa fa-warning"></i> {{ Session::get('error') }}
                    </div>
                @endif
                <fieldset>
                    <div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="username" placeholder="Username">
									<i class="fa fa-user"></i> </span>
                    </div>
                    <div class="form-group form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="Password">
									<i class="fa fa-lock"></i>
									<a class="forgot" href="#">
                                        Ho dimenticato la password
                                    </a> </span>
                    </div>
                    <div class="form-actions">
                        <label for="remember" class="checkbox-inline">
                            <input type="checkbox" class="grey remember" id="remember" name="remember">
                            Ricordati di me
                        </label>
                        <button type="submit" class="btn btn-green pull-right">
                            Login <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
            <!-- start: COPYRIGHT -->
            <div class="copyright">
                2014 &copy; PcPerformance - Developed by Webcaos.com
            </div>
            <!-- end: COPYRIGHT -->
        </div>
        <!-- end: LOGIN BOX -->
        <!-- start: FORGOT BOX -->
        <div class="box-forgot">
            <h3>Password dimenticata?</h3>
            <p>
                Inserisci il tuo indirizzo email per recuperare la tua password.
            </p>
            <form class="form-forgot">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-remove-sign"></i> Errore. Per favore controlla in basso.
                </div>
                <fieldset>
                    <div class="form-group">
								<span class="input-icon">
									<input type="email" class="form-control" name="email" placeholder="Email">
									<i class="fa fa-envelope"></i> </span>
                    </div>
                    <div class="form-actions">
                        <a class="btn btn-light-grey go-back">
                            <i class="fa fa-chevron-circle-left"></i> Login
                        </a>
                        <button type="submit" class="btn btn-green pull-right">
                            Invia <i class="fa fa-arrow-circle-right"></i>
                        </button>
                    </div>
                </fieldset>
            </form>
            <!-- start: COPYRIGHT -->
            <div class="copyright">
                2014 &copy; PcPerformance - Developed by Webcaos.com
            </div>
            <!-- end: COPYRIGHT -->
        </div>
        <!-- end: FORGOT BOX -->
    </div>
</div>

@stop

@section('extraJS')
<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script src="{{asset('assets/plugins/jquery-validation/dist/jquery.validate.min.js')}}"></script>
<script src="{{asset('assets/plugins/jquery-validation/localization/messages_it.js')}}"></script>
<script src="{{asset('assets/js/login.js')}}"></script>
<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
<script>
    jQuery(document).ready(function() {
        Main.init();
        Login.init();
    });
</script>
@stop