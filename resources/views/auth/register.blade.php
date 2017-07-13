<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <link rel="shortcut icon" href="/vendor/ubold/assets/images/favicon_1.ico">

        <title>{{ config('app.name') }}</title>

        <link href="/vendor/ubold/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="/vendor/ubold/assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="/vendor/ubold/assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="/vendor/ubold/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="/vendor/ubold/assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="/vendor/ubold/assets/css/responsive.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src="/vendor/ubold/assets/js/modernizr.min.js"></script>
        
    </head>
    <body>

        <div class="account-pages"></div>
        <div class="clearfix"></div>
        <div class="wrapper-page">
            <div class=" card-box">
                <div class="panel-heading">
                    <h3 class="text-center"> Sign Up to <strong class="text-custom">UBold</strong> </h3>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal m-t-20" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Username">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="col-xs-12">
                                <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Password Confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="checkbox checkbox-primary">
                                    <input id="checkbox-signup" type="checkbox" checked="checked">
                                    <label for="checkbox-signup">I accept <a href="#">Terms and Conditions</a></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center m-t-40">
                            <div class="col-xs-12">
                                <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">
                                    Register
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 text-center">
                    <p>
                        Already have account?<a href="{{ route('login') }}" class="text-primary m-l-5"><b>Sign In</b></a>
                    </p>
                </div>
            </div>

        </div>

      
        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="/vendor/ubold/assets/js/jquery.min.js"></script>
        <script src="/vendor/ubold/assets/js/bootstrap.min.js"></script>
        <script src="/vendor/ubold/assets/js/detect.js"></script>
        <script src="/vendor/ubold/assets/js/fastclick.js"></script>
        <script src="/vendor/ubold/assets/js/jquery.slimscroll.js"></script>
        <script src="/vendor/ubold/assets/js/jquery.blockUI.js"></script>
        <script src="/vendor/ubold/assets/js/waves.js"></script>
        <script src="/vendor/ubold/assets/js/wow.min.js"></script>
        <script src="/vendor/ubold/assets/js/jquery.nicescroll.js"></script>
        <script src="/vendor/ubold/assets/js/jquery.scrollTo.min.js"></script>


        <script src="/vendor/ubold/assets/js/jquery.core.js"></script>
        <script src="/vendor/ubold/assets/js/jquery.app.js"></script>
    
    </body>
</html>