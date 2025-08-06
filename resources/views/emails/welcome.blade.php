<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bienvenido</title>
    <style>
        body {
            background: #f7fafc;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #2d3748;
            margin: 0;
            padding: 0;
        }
        .container {
            background: #fff;
            max-width: 480px;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 24px;
            text-align: center;
        }
        .logo {
            width: 64px;
            height: 64px;
            margin-bottom: 16px;
        }
        .brand {
            font-size: 28px;
            font-weight: bold;
            color: #38b2ac;
            margin-bottom: 8px;
        }
        .welcome-title {
            font-size: 22px;
            margin: 24px 0 12px 0;
            color: #2d3748;
        }
        .message {
            font-size: 16px;
            margin-bottom: 24px;
        }
        .verify-btn {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(90deg,#38b2ac 0,#4299e1 100%);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border-radius: 6px;
            text-decoration: none;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(56,178,172,0.15);
            transition: background 0.2s;
        }
        .verify-btn:hover {
            background: linear-gradient(90deg,#4299e1 0,#38b2ac 100%);
        }
        .footer {
            margin-top: 32px;
            font-size: 13px;
            color: #a0aec0;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://laravel.com/img/notification-logo.png" alt="Logo" class="logo">
        <div class="brand">{{ config('app.name') }}</div>
        <div class="welcome-title">¡Bienvenido, {{ $user->name }}!</div>
        <div class="message">
            Gracias por registrarte en <b>{{ config('app.name') }}</b>.<br>
            Estamos encantados de tenerte con nosotros.<br>
            Tu contraseña temporal es: 'M4r1a.25'. Esta, se te pedira modificarla al iniciar sesión por primera vez.<br>
            Haz clic en el siguiente botón para verificar tu correo electrónico y activar tu cuenta.
        </div>
        <a href="{{ url('/api/user/verify-email/'.$user->id) }}" class="verify-btn">
            Verificar mi correo electrónico
        </a>
        <div class="footer">
            Si no creaste esta cuenta, puedes ignorar este mensaje.<br>
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>
</body>
</html>
