<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<style>
    .gradient-custom-2 {
        /* fallback for old browsers */
        background: #fccb90;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, #ee7724, #d8363a, #dd3675, #b44593);
    }

    @media (min-width: 768px) {
        .gradient-form {
            height: 100vh !important;
        }
    }

    @media (min-width: 769px) {
        .gradient-custom-2 {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem;
        }
    }
</style>

<body>
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black mt-3">
                        <div class="row g-0">
                            <div class="col-lg-5 d-flex align-items-center"
                                style="background: linear-gradient(98.59deg, #46B04B 36.51%, #B1B03E 105.37%)">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4 text-center">
                                    <h4 class="mb-4">Welcome Back!</h4>
                                    <p class="small">To keep connected with us please login with your personal infomation</p>
                                    <a href="{{ route('login') }}" class="btn btn-outline-light form-control p-3 mt-3"
                                        style="border-radius: 20px">Login</a>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card-body p-md-5 mx-md-4">
                            
                                    <div class="text-center">
                                        <h4 class="mt-1 mb-5 pb-1"><span class="text-success fw-bold">Create Account</span></h4>
                                    </div>
                            
                                    <form action="{{ route('register.submit') }}" method="POST">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-person-add"></i></span>
                                            <div class="form-floating">
                                                <input type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" id="floatingInputGroup1"
                                                    placeholder="Username">
                                                <label for="floatingInputGroup1">Username</label>
                                            </div>
                                        </div>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                                            <div class="form-floating">
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="floatingInputGroup2"
                                                    placeholder="Password">
                                                <label for="floatingInputGroup2">Password</label>
                                            </div>
                                        </div>
                                        @if ($errors->has('username') || $errors->has('password'))
                                            <div class="alert alert-danger">
                                                @if ($errors->has('username'))
                                                    {{ $errors->first('username') }}
                                                @elseif ($errors->has('password'))
                                                    {{ $errors->first('password') }}
                                                @endif
                                            </div>
                                        @endif 
                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button style="background-color: #23AF4F; border-radius: 20px"
                                                class="btn btn-block form-control fa-lg text-white p-3 mb-3" type="submit">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>