<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/loginstyles.css') }}">
</head>
<body>
    <section>
    <img src="{{ asset('assets/logosample.png') }}" alt="Logo" class = logo>
    <h2 class="logotext">CONSTRUCTION SERVICES</h2>
    <!-- Box for username/pass/remember me input -->
        <div class="form-box">  
            <div class="form-value">
                <h2 class ="logintext">Login</h2>

                <form method="POST" action="{{route('login.post')}}" >
                    @csrf

                    @if ($errors->any())
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Username -->
                    <div class="inputbox">
                        <span class="icon"><ion-icon name="person"></ion-icon></span>
                        <input name="name" type="text" required>
                        <label class="usertext">Username</label>
                    </div>
                    <!-- Password -->
                    <div class="inputbox">
                        <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                        <input name="password" type="password" required>
                        <label class="passtext">Password</label>
                    </div>
                    <!-- Forgot Password -->
                    <div class="remember-forgot">
                        <a href="{{route('register')}}">Create a new account</a>
                        <a href="#">Forgot Password?</a>
                    </div>
                    <!-- Login Button -->
                    <button type="submit" class="button">Login</button>
                </form>
            </div>
        </div>
    </section>
    
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>