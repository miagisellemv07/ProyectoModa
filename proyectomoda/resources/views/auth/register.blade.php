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

    .register-wrapper{
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 15px;
    }

    .register-card{
        width: 100%;
        max-width: 650px;
        background: rgba(255,255,255,.92);
        border: none;
        border-radius: 28px;
        box-shadow: var(--sombra);
        overflow: hidden;
    }

    .register-header{
        background: linear-gradient(90deg, var(--rosa-suave), var(--lila-suave), var(--azul-pastel));
        padding: 24px;
        text-align: center;
    }

    .register-header h2{
        margin: 0;
        font-weight: 800;
        color: var(--oscuro);
    }

    .register-header p{
        margin: 6px 0 0;
        color: #6e6178;
        font-size: .95rem;
    }

    .register-body{
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

    .btn-register{
        background: linear-gradient(90deg, var(--rosa-medio), var(--morado-suave));
        color: white;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        padding: 12px 20px;
        width: 100%;
        transition: .3s ease;
    }

    .btn-register:hover{
        color: white;
        opacity: .95;
    }

    .register-link{
        color: #8c69a8;
        text-decoration: none;
        font-weight: 600;
    }

    .register-link:hover{
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
    <div class="register-wrapper">
        <div class="register-card">
            <div class="register-header">
                <div class="icon-circle">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h2>Crear cuenta</h2>
                <p>Regístrate en Virtuality Emprendedores Mall</p>
            </div>

            <div class="register-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input id="nombre" type="text"
                                class="form-control @error('nombre') is-invalid @enderror"
                                name="nombre"
                                value="{{ old('nombre') }}"
                                required
                                autofocus
                                placeholder="Ingresa tu nombre">

                            @error('nombre')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input id="apellido" type="text"
                                class="form-control @error('apellido') is-invalid @enderror"
                                name="apellido"
                                value="{{ old('apellido') }}"
                                required
                                placeholder="Ingresa tu apellido">

                            @error('apellido')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="ejemplo@correo.com">

                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tel" class="form-label">Teléfono</label>
                        <input id="tel" type="text"
                            class="form-control @error('tel') is-invalid @enderror"
                            name="tel"
                            value="{{ old('tel') }}"
                            placeholder="Ingresa tu teléfono">

                        @error('tel')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input id="direccion" type="text"
                            class="form-control @error('direccion') is-invalid @enderror"
                            name="direccion"
                            value="{{ old('direccion') }}"
                            placeholder="Ingresa tu dirección">

                        @error('direccion')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Ingresa tu contraseña">

                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="password-confirm" class="form-label">Confirmar contraseña</label>
                            <input id="password-confirm" type="password"
                                class="form-control"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Confirma tu contraseña">
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-register">
                            Registrarme
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="register-link">
                            ¿Ya tienes cuenta? Inicia sesión
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection