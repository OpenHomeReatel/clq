
<!DOCTYPE html>
<html>

    <head>
        <title>Login - click Lead</title>
        
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('storage/icons/logo.png') }}" />
       

       

        

        <style>

            .box {
                background: radial-gradient(#ffffff,#dedede);
            }
            .title{
                width: 300px;
                margin: auto;
                margin-top: 200px;
                text-align: center;
                font-family: sans-serif;
                color: #243841;
                animation: fadeIn 1.6s;
                animation: Slide_Up 1.3s ease;
            }
            .login-block {
                width: 320px;
                padding: 30px;
                background: #f6f6f6;
                border-top: 5px solid #0e85a5;
                margin: auto;
                margin-top: 20px;
                box-shadow: 5px 5px 20px -10px #888888;
                animation: fadeIn 2s;
                animation: Slide_Up 1.4s ease;
            }

            .login-block h1 {
                text-align: center;
                color: #0e85a5;
                font-size: 18px;
                font-family: sans-serif;
                text-transform: uppercase;
                margin-top: 0;
                margin-bottom: 20px;
            }

            .login-block input {
                width: 100%;
                height: 42px;
                box-sizing: border-box;
                border: 1px solid #ccc;
                margin-bottom: 20px;
                font-size: 14px;
                font-family: Montserrat;
                padding: 0 20px 0 50px;
                outline: none;
            }

            .login-block input#email {
                background: #fff url('welc/images/user-icon-1.png') 20px center no-repeat;
                background-size: 20px 20px;
            }

            .login-block input#email:focus {
                background: #fff url('welc/images/user-icon-2.png') 20px center no-repeat;
                background-size: 20px 20px;
            }

            .login-block input#password {
                background: #fff url('welc/images/user-icon-password-1.png') 20px center no-repeat;
                background-size: 20px 20px;
            }

            .login-block input#password:focus {
                background: #fff url('welc/images/user-icon-password-2.png') 20px center no-repeat;
                background-size: 20px 20px;
            }

            .login-block input:active, .login-block input:focus {
                border: 1px solid #0e85a5;
            }

            .login-block button {
                width: 100%;
                height: 40px;
                background: #0e85a5;
                box-sizing: border-box;
                border: 1px solid #243841;
                color: #fff;
                font-weight: bold;
                text-transform: uppercase;
                font-size: 14px;
                font-family: Montserrat;
                outline: none;
                cursor: pointer;
            }

            .login-block button:hover {
                background: #13b1d6;
            }

            @keyframes fadeIn{
                From {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }
            @keyframes Slide_Up{
                0%{
                    transform: translateY(40px)
                }
                100%{
                    transform: translateY(0);
                }
            }
            .footer {
                position: fixed;
                left: 0;
                bottom: 20px;
                width: 100%;
                color: darkslategrey;
                text-align: center;
                font-family: sans-serif;
            }
            a {
                color: darkslategrey;
            }
            .social {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 100px;
                animation: fadeIn 2s;

            }
            .fa {
                padding: 10px;
                font-size: 30px;
                width: 30px;
                text-align: center;
                text-decoration: none;
                margin: 5px 2px;
                color: #0e85a5;
                animation: Slide_Up 1.4s ease;
            }

            .fa:hover {
                opacity: 0.7;
            }


        </style>
    </head>

    <body>

        <div class="box"></div>
        <div class=title>
            <h1>Cliqlead</h1>
            <p>The simplest way
                to manage your sales</p>
        </div>
        <div class="login-block">
            <h1>User Login</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
               
                    <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">
                    @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
               
              
                    <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">

                    @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                    @endif
               
                        <button type="submit" class="btn btn-block btn-primary">
                            {{ trans('global.login') }}
                        </button>
                 
            </form>
        </div>
        <div class="social">
            <a href="https://www.facebook.com/Cliqlead" class="fa fa-facebook"></a>
            <a href="https://www.instagram.com/cliqlead/" class="fa fa-instagram"></a>
            <a href="https://www.linkedin.com/company/cliqlead" class="fa fa-linkedin"></a>
            <a href="https://twitter.com/cliqlead" class="fa fa-twitter"></a>

        </div>
        <footer>
            <div class="footer">
                <h5>2022 © <a href="index.html">ClickLead</a> All Rights are Reserved</h5>
            </div>
        </footer>

    </body>

</html>