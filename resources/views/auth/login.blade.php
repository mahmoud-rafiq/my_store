<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <title>Login</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            font-size: 62.5%;
        }

        body {
            font-family: "Poppins", sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            font-size: 1.6rem;
            overflow-x: hidden;
        }

        a {
            color: #2196f3;
            text-decoration: none;
        }

        .container {
            display: grid;
            grid-template-rows: minmax(min-content, 100vh);
            grid-template-columns: repeat(2, 50vw);
        }

        .heading-secondary {
            font-size: 3rem;
        }

        .heading-primary {
            font-size: 5rem;
        }

        .span-blue {
            color: #2196f3;
        }

        .signup-container,
        .signup-form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .signup-container {
            width: 100vw;
            padding: 10rem 10rem;
            align-items: flex-start;
            justify-content: flex-start;

            grid-column: 1 / 2;
            grid-row: 1;
        }

        .signup-form {
            max-width: 45rem;
            width: 100%;
        }

        .text-mute {
            color: #aaa;
        }

        .input-text {
            font-family: inherit;
            font-size: 1.8rem;
            padding: 3rem 5rem 1rem 2rem;
            border: none;
            border-radius: 2rem;
            background: #eee;
            width: 100%;
        }

        .input-text:focus {
            outline-color: #2196f3;
        }

        .btn {
            padding: 2rem 3rem;
            border: none;
            background: #2196f3;
            color: #fff;
            border-radius: 1rem;
            cursor: pointer;
            font-family: inherit;
            font-weight: 500;
            font-size: inherit;
        }

        .btn-login {
            align-self: flex-end;
            width: 100%;
            margin-top: 2rem;
            box-shadow: 0 5px 5px #00000020;
        }

        .btn-login:active {
            box-shadow: none;
        }

        .btn-login:hover {
            background: #2180f9;
        }

        .inp {
            position: relative;
        }

        .label {
            pointer-events: none;

            position: absolute;
            top: 2rem;
            left: 2rem;
            color: #00000070;
            font-weight: 500;
            font-size: 1.8rem;

            transition: all 0.2s;
            transform-origin: left;
        }

        .input-text:not(:placeholder-shown)+.label,
        .input-text:focus+.label {
            top: 0.7rem;
            transform: scale(0.75);
        }

        .input-text:focus+.label {
            color: #2196f3;
        }

        .input-icon {
            position: absolute;
            top: 2rem;
            right: 2rem;
            font-size: 2rem;
            color: #00000070;
        }

        .input-icon-password {
            cursor: pointer;
        }

        .btn-google {
            color: #222;
            background: #fff;
            border: solid 1px #eee;
            padding: 1.5rem;

            display: flex;
            justify-content: center;
            align-items: center;

            box-shadow: 0 1px 2px #00000020;
        }

        .btn-google img {
            width: 3rem;
            margin-right: 1rem;
        }

        .login-wrapper {
            max-width: 45rem;
            width: 100%;
        }

        .line-breaker .line {
            width: 50%;
            height: 1px;
            background: #eee;
        }

        .line-breaker {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #ccc;

            margin: 3rem 0;
        }

        .line-breaker span:nth-child(2) {
            margin: 0 2rem;
        }

        .welcome-container {
            background: url('https://i.pinimg.com/736x/0a/7e/3b/0a7e3be1edf0565d4deb9706047db287.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            grid-column: 2 / 3;
            grid-row: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 10rem;
        }

        .lg {
            font-size: 6rem;
        }

        .welcome-container img {
            width: 100%;
        }

        @media only screen and (max-width: 700px) {
            html {
                font-size: 54.5%;
            }
        }

        @media only screen and (max-width: 600px) {
            .signup-container {
                padding: 5rem;
            }
        }

        @media only screen and (max-width: 400px) {
            html {
                font-size: 48.5%;
            }

            .input-text:not(:placeholder-shown)+.label,
            .input-text:focus+.label {
                top: 0.6rem;
                transform: scale(0.75);
            }

            .label {
                font-size: 1.9rem;
            }
        }

        @media only screen and (max-width: 1200px) {
            .signup-container {
                grid-column: 1 / 3;
                grid-row: 1/3;
            }

            .welcome-container {
                display: none;
            }
        }
    </style>

</head>

<body>

    <div class="container">
        <main class="signup-container">
            <h1 class="heading-primary">Log in<span class="span-blue">.</span></h1>
            <p class="text-mute">Enter your credentials to access your account.</p>


            <form class="signup-form" method="POST" action="{{ route('login') }}">
                @csrf
                <label class="inp">
                    <input id="email" type="email" class="input-text" @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    <span class="label">Email</span>
                    <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>



                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                </label>


                <label class="inp">
                    <input id="password" type="password" class="input-text @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    <span class="label">Password</span>
                    <span class="input-icon input-icon-password" data-password><i class="fa-solid fa-eye"></i></span>

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
            <p class="text-mute">Not a member? <a href="{{route('register')}}">Sign up</a></p>
        </main>
        <div class="welcome-container">
            {{-- <h1 class="heading-secondary">Welcome to <span class="lg">Planner Buddy!</span></h1>
            <img src="https://images.unsplash.com/photo-1578916171728-46686eac8d58?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=774&q=80"
                alt=""> --}}
        </div>
    </div>

    <script>
        const eyeClick = document.querySelector("[data-password]");
        const password_elem = document.getElementById("password");

        eyeClick.onclick = () => {
            const icon = eyeClick.children[0];
            icon.classList.toggle("fa-eye-slash");
            if (password_elem.type === "password") {
                password_elem.type = "text";
            } else if (password_elem.type === "text") {
                password_elem.type = "password";
            }
        };
    </script>

</body>

</html>
