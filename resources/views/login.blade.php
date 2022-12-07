<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Sistem Informasi Logistik Digital
    </title>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Rubik:400,700'>
    <link rel="stylesheet" href="./style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        body {
            background: #f4f3ef;
            font-family: 'Rubik', sans-serif;
        }

        .login-form {
            background: #fff;
            width: 500px;
            margin: 65px auto;
            display: -webkit-box;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-direction: column;
            border-radius: 4px;
            box-shadow: 0 2px 25px rgba(0, 0, 0, 0.2);
        }

        .login-form h1 {
            padding: 35px 35px 0 35px;
            font-weight: 300;
        }

        .login-form .content {
            padding: 35px;
            text-align: center;
        }

        .login-form .input-field {
            padding: 12px 5px;
        }

        .login-form .input-field input {
            font-size: 16px;
            display: block;
            font-family: 'Rubik', sans-serif;
            width: 100%;
            padding: 10px 1px;
            border: 0;
            border-bottom: 1px solid #747474;
            outline: none;
            -webkit-transition: all .2s;
            transition: all .2s;
        }

        .login-form .input-field input::-webkit-input-placeholder {
            text-transform: uppercase;
        }

        .login-form .input-field input::-moz-placeholder {
            text-transform: uppercase;
        }

        .login-form .input-field input:-ms-input-placeholder {
            text-transform: uppercase;
        }

        .login-form .input-field input::-ms-input-placeholder {
            text-transform: uppercase;
        }

        .login-form .input-field input::placeholder {
            text-transform: uppercase;
        }

        .login-form .input-field input:focus {
            border-color: #222;
        }

        .login-form a.link {
            text-decoration: none;
            color: #747474;
            letter-spacing: 0.2px;
            text-transform: uppercase;
            display: inline-block;
            margin-top: 20px;
        }

        .login-form .action {
            display: -webkit-box;
            display: flex;
            -webkit-box-orient: horizontal;
            -webkit-box-direction: normal;
            flex-direction: row;
        }

        .login-form .action button {
            text-align: center;
            width: 100%;
            border: none;
            padding: 18px;
            font-family: 'Rubik', sans-serif;
            cursor: pointer;
            text-transform: uppercase;
            background: #51cbce;
            color: white;
            border-bottom-left-radius: 4px;
            border-bottom-right-radius: 0;
            letter-spacing: 0.2px;
            outline: 0;
            -webkit-transition: all .3s;
            transition: all .3s;
        }

        .login-form .action button:hover {
            background: #ef8159;
        }

        .login-form .action button:nth-child(2) {
            background: #2d3b55;
            color: #fff;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 4px;
        }

        .login-form .action button:nth-child(2):hover {
            background: #3c4d6d;
        }

    </style>
</head>

<body>
    <!-- partial:index.partial.html -->
    <div class="login-form">
        @if($errors->any())
        @foreach($errors->all() as $err)
        <div class="alert alert-warning" role="alert">
            {{ $err }}
          </div>
        @endforeach
        @endif
        <form action="{{ route('login.action') }}" method="POST">
            {{ csrf_field() }}
            <h1>Login</h1>
                <div class="content" >
                    <div class="form-group" style="text-align:left">
                        <label>Email</label>
                        <input type="text" class="form-control" autocomplete="nope" name="email">
                    </div>
                    <br>
                    <div class="form-group" style="text-align:left" >
                        <label>Password</label>
                        <input type="password" class="form-control" autocomplete="new-password" name="password">
                    </div>
                </div>
            
            <!-- <div class="content">
                <div class="input-field">
                    <input type="email" placeholder="Email" autocomplete="nope" name="email">
                </div>
                <div class="input-field">
                    <input type="password" placeholder="Password" autocomplete="new-password" name="password">
                </div>
            </div> -->
            <div style="text-align:center">Don't Have Account?
                <a href="{{url('register')}}">Register</a>
                <br>
                <br>
            </div>
            <div class="action">
                <button class="btn btn-primary">Sign in</button>
                {{-- <a href="{{url('/')}}">
                Register
                </a> --}}
            </div>
        </form>
    </div>
    <!-- partial -->
    <script src="./script.js"></script>

</body>

</html>
