<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{asset('css/alerts.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>
<body>
    <div class="custom__container row row-cols-lg-2 row-cols-1" style="height: 100vh;">
        <div class="custom__container__left col-lg-5 col-12">
            <form action="{{ route("login.ingresar") }}" method="POST">  
                @csrf
                <h1 class="text-center mb-3">MundiToys</h1>
                <div class="img__logo">
                    <img src="{{ asset('images/logo.png') }}" alt="" width="100">
                </div>

                <div class="d-flex justify-content-center">
                    <div class="d-flex flex-column w-75">
                        <label for="roleSelected" class="fw-bold">Rol:</label>
                        <select class="role-select" name="id_role" id="roleSelected">
                            @foreach (App\Models\Role::all() as $role)
                                <option class="fs-5" value="{{ $role->id }}">
                                    {{ $role->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="email d-flex justify-content-center">

                    <div class="d-flex flex-column w-75">
                        <label for="email" class="fw-bold">
                            Email
                        </label>
                        <input 
                            class="p-3"
                            type="text"
                            id="email"
                            name="email"
                            placeholder="example@gmail.com"
                            value="{{old('email')}}"
                        >
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
    
                <div class="password d-flex justify-content-center mt-3">
                    <div class="d-flex flex-column w-75">
                        <label for="password" class="fw-bold">
                            Contraseña
                        </label>
                        <input
                            class="p-3"
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••••"
                        >
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    <label for="" class="fs-6 me-2 fw-bold">Recuerdame</label>
                    <input type="checkbox" name="remember">
                </div>
    
                <div class="d-flex justify-content-center mt-4">
                    <button type="submit" class="btn-ingresar col-4">Ingresar</button>
                </div>
            </form>
        </div>
        <div class="custom__container__right col-lg-7 d-lg-block d-none">
            
        </div>
    </div>

    @if (session("info"))
        <x-alert2
            icon="bi bi-exclamation-circle"
            color="crimson"
            title="Login"
            description="{{session('info')}}"
        />
    @endif
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>