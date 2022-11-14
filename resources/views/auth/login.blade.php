<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css");
        @import url("https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css");
        @import url("https://cdnjs.cloudflare.com/ajax/libs/hamburgers/0.9.3/hamburgers.min.css");
        @import url("https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Poppins-Regular, sans-serif;
        }

        /*---------------------------------------------*/
        a {
            font-family: Poppins-Regular, serif;
            font-size: 14px;
            line-height: 1.7;
            color: #666666;
            margin: 0;
            transition: all 0.4s;
            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
        }

        a:focus {
            outline: none !important;
        }

        a:hover {
            text-decoration: none;
            color: #57b846;
        }

        /*---------------------------------------------*/
        h1, h2, h3, h4, h5, h6 {
            margin: 0;
        }

        p {
            font-family: Poppins-Regular, serif;
            font-size: 14px;
            line-height: 1.7;
            color: #666666;
            margin: 0;
        }

        ul, li {
            margin: 0;
            list-style-type: none;
        }


        /*---------------------------------------------*/
        input {
            outline: none;
            border: none;
        }

        textarea {
            outline: none;
            border: none;
        }

        textarea:focus, input:focus {
            border-color: transparent !important;
        }

        input:focus::-webkit-input-placeholder {
            color: transparent;
        }

        input:focus:-moz-placeholder {
            color: transparent;
        }

        input:focus::-moz-placeholder {
            color: transparent;
        }

        input:focus:-ms-input-placeholder {
            color: transparent;
        }

        textarea:focus::-webkit-input-placeholder {
            color: transparent;
        }

        textarea:focus:-moz-placeholder {
            color: transparent;
        }

        textarea:focus::-moz-placeholder {
            color: transparent;
        }

        textarea:focus:-ms-input-placeholder {
            color: transparent;
        }

        input::-webkit-input-placeholder {
            color: #999999;
        }

        input:-moz-placeholder {
            color: #999999;
        }

        input::-moz-placeholder {
            color: #999999;
        }

        input:-ms-input-placeholder {
            color: #999999;
        }

        textarea::-webkit-input-placeholder {
            color: #999999;
        }

        textarea:-moz-placeholder {
            color: #999999;
        }

        textarea::-moz-placeholder {
            color: #999999;
        }

        textarea:-ms-input-placeholder {
            color: #999999;
        }

        /*---------------------------------------------*/
        button {
            outline: none !important;
            border: none;
            background: transparent;
        }

        button:hover {
            cursor: pointer;
        }

        iframe {
            border: none !important;
        }

        .limiter {
            width: 100%;
            margin: 0 auto;
        }

        .container-login100 {
            width: 100%;
            min-height: 100vh;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: #9053c7;
            background: -webkit-linear-gradient(-135deg, #c850c0, #4158d0);
            background: -o-linear-gradient(-135deg, #c850c0, #4158d0);
            background: -moz-linear-gradient(-135deg, #c850c0, #4158d0);
            background: linear-gradient(-135deg, #c850c0, #4158d0);
        }

        .wrap-login100 {
            width: 960px;
            background: #fff;
            overflow: hidden;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 103px 112px 63px 81px;
        }

        .login100-pic {
            width: 316px;
        }

        .login100-pic img {
            max-width: 100%;
        }

        .login100-form {
            width: 290px;
        }

        .login100-form-title {
            font-family: Poppins-Bold, serif;
            font-size: 24px;
            color: #333333;
            line-height: 1.2;
            text-align: center;

            width: 100%;
            display: block;
            padding-bottom: 54px;
        }


        /*---------------------------------------------*/
        .wrap-input100 {
            position: relative;
            width: 100%;
            z-index: 1;
            margin-bottom: 10px;
        }

        .input100 {
            font-family: Poppins-Medium, serif;
            font-size: 15px;
            line-height: 1.5;
            color: #666666;
            display: block;
            width: 100%;
            background: #e6e6e6;
            height: 50px;
            padding: 0 30px 0 68px;
        }


        /*------------------------------------------------------------------
[ Focus ]*/


        @-webkit-keyframes anim-shadow {
            to {
                box-shadow: 0 0 70px 25px;
                opacity: 0;
            }
        }

        @keyframes anim-shadow {
            to {
                box-shadow: 0 0 70px 25px;
                opacity: 0;
            }
        }

        .symbol-input100 {
            font-size: 15px;

            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            align-items: center;
            position: absolute;
            border-radius: 25px;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            padding-left: 35px;
            pointer-events: none;
            color: #666666;

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .input100:focus + .focus-input100 + .symbol-input100 {
            color: #57b846;
            padding-left: 28px;
        }

        /*------------------------------------------------------------------
[ Button ]*/
        .container-login100-form-btn {
            width: 100%;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding-top: 20px;
        }

        .login100-form-btn {
            font-family: Montserrat-Bold, serif;
            font-size: 15px;
            line-height: 1.5;
            color: #fff;
            text-transform: uppercase;

            width: 100%;
            height: 50px;
            background: #57b846;
            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0 25px;

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .login100-form-btn:hover {
            background: #333333;
        }


        @media (max-width: 992px) {
            .wrap-login100 {
                padding: 177px 90px 33px 85px;
            }

            .login100-pic {
                width: 35%;
            }

            .login100-form {
                width: 50%;
            }
        }

        @media (max-width: 768px) {
            .wrap-login100 {
                padding: 100px 80px 33px 80px;
            }

            .login100-pic {
                display: none;
            }

            .login100-form {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .wrap-login100 {
                padding: 100px 15px 33px 15px;
            }
        }


        /*------------------------------------------------------------------
[ Alert validate ]*/

        .validate-input {
            position: relative;
        }


    </style>
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="https://colorlib.com/etc/lf/Login_v1/images/img-01.png" alt="IMG">
            </div>

            <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
                @method('post')
                @csrf
                <span class="login100-form-title">
						Member Login
					</span>

                <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="email" placeholder="Email">
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                </div>


                <div class="wrap-input100 validate-input" data-validate="Password is required">
                    <input class="input100" type="password" name="password" placeholder="Password">

                    @foreach($errors as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>

                {{--     <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
                    <a class="txt2" href="#">
                        Username / Password?
                    </a>
                </div>

                <div class="text-center p-t-136">
                    <a class="txt2" href="#">
                        Create your Account
                        <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                    </a>
                </div> --}}
            </form>
        </div>
    </div>
</div>
</body>
</html>
<!------ Include the above in your HEAD tag ---------->

