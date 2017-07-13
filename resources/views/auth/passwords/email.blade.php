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
                    <h3 class="text-center"> Reset Password </h3>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }} role="form" class="form-horizontal text-center">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                ×
                            </button>
                            Enter your <b>Email</b> and instructions will be sent to you!
                        </div>
                        <div class="form-group m-b-0">
                            <div class="input-group">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Enter Email">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif

                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-pink w-sm waves-effect waves-light">
                                        Reset
                                    </button> 
                                </span>
                            </div>
                        </div>

                    </form>
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