<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css">
    <link rel="stylesheet" href="./css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>NINY SERVEN ADMIN | Login</title>
</head>

<body>
    <main>
        <div class="main-body">
            <div id="p1">
                <div class="row-1">
                    <div class="img-box">
                        <!-- <img src="{{ asset('images/logo.PNG') }}" alt="logo" class=""> -->
                        <H1>Ninty Serven Admin</H1>
                    </div>
                </div>
                <div class="row-2">
                    <form method="post" class="form" action="{{ route('login') }}">
                        @csrf
                        <div class="line-1">
                            <p class="title">
                                Login
                            </p>
                        </div>
                        <div class="line-2 input-box">
                            <label for="email">Email</label>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                        </div>
                        <div class="line-3 input-box">
                            <label for="password">Password</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            <div class="input-group-text" onclick="chek()">
                                <img src="./images/icon-eye.png" alt="icon-eye" class="icon-eye">
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                        <div class="line-4">
                            <p class="text">*Please enter 8 to 16 alphanumeric characters.</p>
                        </div>

                        @error('email')
                            <div class="line-5">
                                <!-- <p class="text">入力内容に誤りがあるか、登録がされていません</p> -->
                            </div>
                        @enderror

                        <div class="line-6">
                            <input id="submit" type="submit" value="Log in" class="submit">
                            <!-- <p class="forgot-pass">パスワードを忘れた方は本部まで連絡してください。</p> -->
                        </div>
                    </form>
                </div>
            </div>
    </main>
    <footer></footer>
    <script>
        var checked = 0;

        function chek() {
            var x = document.getElementById("password");
            const element = document.getElementById("chagingeye");
            if (checked == 0) {
                x.type = "text";
                checked = 1;
            } else {
                x.type = "password";
                checked = 0;
            }
        }
    </script>
</body>

</html>
