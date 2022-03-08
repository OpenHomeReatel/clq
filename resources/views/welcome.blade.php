
<html lang="en">
    <head>
        <title>Cliqlead CRM</title>
       
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="icon" type="image/png" href="{{ asset('storage/icons/logo.png') }}" />
        <style>
            /*
body {
    background: radial-gradient(#ffffff,#dedede);
}
            */
            .box {
                background: radial-gradient(#ffffff, #dedede);
            }

            .logo {
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 2s;
                animation: Slide_Up 1.4s ease;
            }


            img {
                margin-top: 250px;
                height: 100px;

            }

            @keyframes fadeIn {
                From {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }

            .crm {
                font-family: sans-serif;
                font-weight: 400;
                color: dimgray;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 2s;
                animation: Slide_Up 1.6s ease;

            }

            .crm-1 {
                font-family: sans-serif;
                font-weight: 400;
                color: dimgray;
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 2s;
                animation: Slide_Up 1.5s ease;

            }

            .button {
                display: flex;
                align-items: center;
                justify-content: center;
                animation: fadeIn 2s;
                animation: Slide_Up 1.8s ease;
            }

            .button-1 {
                background-color: #fff;
                border: 1px solid #d5d9d9;
                border-radius: 8px;
                box-shadow: rgba(213, 217, 217, .5) 0 2px 5px 0;
                box-sizing: border-box;
                color: #0f1111;
                cursor: pointer;
                display: inline-block;
                font-family: "Amazon Ember", sans-serif;
                font-size: 13px;
                line-height: 29px;
                padding: 0 10px 0 11px;
                position: relative;
                text-align: center;
                text-decoration: none;
                user-select: none;
                -webkit-user-select: none;
                touch-action: manipulation;
                vertical-align: middle;
                width: 100px;
            }

            .button-1:hover {
                background-color: #f7fafa;
            }

            .button-1:focus {
                border-color: #008296;
                box-shadow: rgba(213, 217, 217, .5) 0 2px 5px 0;
                outline: 0;
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

            @keyframes Slide_Up {
                0% {
                    transform: translateY(40px)
                }

                100% {
                    transform: translateY(0);
                }
            }

            a {
                color: darkslategrey;
            }

            .social {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: 200px;
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
        <div class=logo>
            <img type="image/png" src="{{ asset('welc/images/click-lead-crm-logo.png') }}" alt="click lead crm">

        </div>
        <h2 class="crm">Customer Relationship Management</h2>
        <h3 class="crm-1">Real Estate and Properties</h3>
        
        <div class="button">
            <div class="text-center">
                @if (Route::has('login'))

                @auth
                <a type="button" href="{{ url('/home') }}" role="button" class="button-1">Home</a>
                @else
                <a href="{{ route('login') }}"role="button"  class="button-1">Enter</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" role="button" class="button-1"">Register</a>
                @endif
                @endauth

                @endif 

            </div>

        </div>
        <div class="social">
            <a href="https://www.facebook.com/Cliqlead" class="fa fa-facebook"></a>
            <a href="https://www.instagram.com/cliqlead/" class="fa fa-instagram"></a>
            <a href="https://www.linkedin.com/company/cliqlead" class="fa fa-linkedin"></a>
            <a href="https://twitter.com/cliqlead" class="fa fa-twitter"></a>

        </div>
        <footer>
            <div class="footer">
                <h5>2022 © <a href="#">CliQLead</a> All Rights are Reserved</h5>
            </div>
        </footer>
    </body>
</html>

