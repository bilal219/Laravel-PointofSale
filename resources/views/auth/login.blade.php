
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | Technors POS</title>
    <link rel="shortcut icon" href="{{asset('temp/assets/images/fav.png')}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="{{asset('temp/assets/images/fav.jpg')}}">
    <link rel="stylesheet" href="{{asset('temp/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('temp/assets/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('temp/assets/css/animate.css')}}">
    <link rel="stylesheet" href="{{asset('temp/assets/plugins/slider/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('temp/assets/plugins/slider/css/owl.theme.default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('temp/assets/css/style.css')}}" />
</head>

    <body class="form-login-body img-fluid" > 
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 mx-auto login-desk">
                       <div class="row">
                           
                            <div class="col-md-5 loginform">
                                <div class="log-txt row no-margin">
                                    <h2>Most Advanced POS <br>
                                    </h2>
                                    <p> Technors POS, an Online Point Of Sale Software developed by Technic Mentors Software Solutions. </p>
                                     
                                </div>
                                
                                 <div class="login-det">
                                    <img src="{{asset('temp/assets/images/art-direction.png')}}" style="height:190px" alt="">
                                 </div>
                            </div>
                             <div class="col-md-7 detail-box">
                               
                                <div class="detailsh col-lg-7 col-md-10 col-sm-7 col-11 mx-auto">
                                      <img src="{{asset('temp/assets/images/logo.png')}}" alt=""> 
                                      <x-jet-validation-errors class="mb-1" style="color:red" />

                                        @if (session('status'))
                                            <div class="mb-1 font-medium text-sm text-green-600">
                                                {{ session('status') }}
                                            </div>
                                        @endif
                                      <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                      <div class="row form-ro no-margin">
                                          <input type="email" required placeholder="Email" class="form-control form-control-sm" name="email">
                                      </div>
                                      
                                       <div class="row form-ro no-margin">
                                          <input type="password" placeholder="Password" name="password" required class="form-control form-control-sm">
                                      </div>
                                    <div class="row form-ro fgbh">
                                      <div class="col-6">
                                          @if (Route::has('password.request'))
                                              <a href="{{ route('password.request') }}">
                                                  {{ __('Forgot password?') }}
                                              </a>
                                          @endif
                                        </div>
                                        <div class="col-6">
                                          <button class="btn btn-sm btn-primary">Sign In</button>
                                        </div>  
                                    </div>
                                    </form>
                                    <div class="row form-ro hlio fgbh">   
                                        <label for="remember_me" class="flex items-center">
                                            <x-jet-checkbox id="remember_me" name="remember" />
                                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                       </div>
                      
                    </div>
                </div>
            </div>
    </body>

    <script src="{{asset('temp/assets/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('temp/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('temp/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('temp/assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js')}}"></script>
    <script src="{{asset('temp/assets/plugins/slider/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('temp/assets/js/script.js')}}"></script>
</html>
<!doctype html>
<html lang="en">


