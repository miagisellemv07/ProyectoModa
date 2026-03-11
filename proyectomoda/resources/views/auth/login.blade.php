@extends('layouts.app')

@section('content')
<style>
    :root{
        --rosa-suave: #f8d9e8;
        --rosa-medio: #e9a9c4;
        --lila-suave: #d9c7f2;
        --morado-suave: #9b7cc3;
        --azul-pastel: #cfe7ff;
        --azul-medio: #9ecbf3;
        --crema: #fff9fc;
        --texto: #4f4459;
        --oscuro: #5d4b69;
        --blanco: #ffffff;
        --sombra: 0 10px 25px rgba(0,0,0,.08);
    }

    body{
        background: linear-gradient(135deg, #fff2f8 0%, #f2ebff 50%, #ebf6ff 100%);
        min-height: 100vh;
    }

    .login-wrapper{
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }

    .login-card{
        width: 100%;
        max-width: 500px;
        background: rgba(255,255,255,.92);
        border: none;
        border-radius: 28px;
        box-shadow: var(--sombra);
        overflow: hidden;
    }

    .login-header{
        background: linear-gradient(90deg, var(--rosa-suave), var(--lila-suave), var(--azul-pastel));
        padding: 24px;
        text-align: center;
    }

    .login-header h2{
        margin: 0;
        font-weight: 800;
        color: var(--oscuro);
    }

    .login-header p{
        margin: 6px 0 0;
        color: #6e6178;
        font-size: .95rem;
    }

    .login-body{
        padding: 32px;
    }

    .form-label{
        font-weight: 700;
        color: var(--oscuro);
        margin-bottom: 8px;
    }

    .form-control{
        border-radius: 14px;
        border: 1px solid #eadcf5;
        padding: 12px 14px;
        box-shadow: none !important;
    }

    .form-control:focus{
        border-color: #c7a7e2;
    }

    .form-check-label{
        color: #6b6073;
    }

    .btn-login{
        background: linear-gradient(90deg, var(--rosa-medio), var(--morado-suave));
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        padding: 12px 20px;
        width: 100%;
        transition: .3s ease;
    }

    .btn-login:hover{
        color: white;
        opacity: .95;
    }

    .login-link{
        color: #8c69a8;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link:hover{
        color: #6f4f8d;
        text-decoration: underline;
    }

    .icon-circle{
        width: 72px;
        height: 72px;
        border-radius: 50%;
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #ffddeb, #e3d1f7, #d9edff);
        color: #7b5c9c;
        font-size: 1.8rem;
        box-shadow: 0 8px 20px rgba(0,0,0,.05);
    }
</style>

<div class="container">
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="icon-circle">
                    <i class="fas fa-user-lock"></i>
                </div>
                <h2>Iniciar Sesión</h2>
                <p>Bienvenido a Virtuality Emprendedores Mall</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            placeholder="ejemplo@correo.com">

                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Ingresa tu contraseña">

                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="login-link" href="{{ route('password.request') }}">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="btn btn-login">
                            Entrar al sistema
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection