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
                <h3 class="text-center"> Sign In to <strong class="text-custom">UBold</strong> </h3>
            </div> 


            <div class="panel-body">
            <form class="form-horizontal m-t-20" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <div class="col-xs-12">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <input id="password" type="password" class="form-control" name="password" required placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group ">
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">
                            <input id="checkbox-signup" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="checkbox-signup">
                                Remember me
                            </label>
                        </div>
                        
                    </div>
                </div>

                <div class="form-group text-center m-t-40">
                    <div class="col-xs-12">
                        <button class="btn btn-pink btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                        <button class="btn btn-default btn-block text-uppercase waves-effect waves-light" type="button" data-toggle="modal" data-target="#experiment-account">Experiment Account</button>
                    </div>
                </div>

                <div class="form-group m-t-30 m-b-0">
                    <div class="col-sm-12">
                        <a href="{{ route('password.request') }}" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
                    </div>
                </div>
            </form> 
            
            </div>   
            </div>                              
                <div class="row">
                <div class="col-sm-12 text-center">
                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                        
                    </div>
            </div>
        </div>

        <div id="experiment-account" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">Experiment Account</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table m-0 text-center">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Username</th>
                                    <th class="text-center">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>admin@gmail.com</td>
                                    <td class="text-right"><button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Select</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Jacob</td>
                                    <td>editor@gmail.com</td>
                                    <td class="text-right"><button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Select</button></td>
                                </tr>
                                <tr>
                                    <th scope="row">3</th>
                                    <td>Larry</td>
                                    <td>manager@gmail.com</td>
                                    <td class="text-right"><button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Select</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div><!-- /.modal -->
        
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


