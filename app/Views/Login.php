<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNDC - Inicio de Sesión</title>
    <link rel="stylesheet" href="/RNDC/public/css/login.css">
</head>
<body>
    <header>
        <img src="/RNDC/public/assets/images/colombia-potencia.webp" alt="Colombia Potencia de la Vida" class="logo-left">
        <div class="header-center">
            <h1>Registro Nacional Despacho de Carga</h1>
            
        </div>
        <img src="/RNDC/public/assets/images/transporte.webp" alt="Ministerio de Transporte" class="logo-right">
    </header>

    <div class="main-content">
        <div class="login-container">
            <div class="login-header">
                <h2>Iniciar Sesión</h2>
                <p>Ingrese sus credenciales para acceder al sistema</p>
            </div>

            <div class="error-message" id="errorMessage"></div>

            <form id="loginForm">
                <div class="form-group">
                    <label for="username">Usuario</label>
                    <input type="text" id="username" name="username" required placeholder="Ingrese su usuario">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña">
                </div>

                <div class="remember-forgot">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" id="remember">
                        Recordarme
                    </label>
                    <a href="#" class="forgot-password">¿Olvidó su contraseña?</a>
                </div>

                <button type="submit" class="btn-login" id="btnLogin">Ingresar</button>

                <div class="loading" id="loading">
                    <div class="loading-spinner"></div>
                </div>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Ministerio de Transporte - Todos los derechos reservados</p>
    </footer>

    <script src="/RNDC/public/js/login.js"></script>
        
    </script>
</body>
</html>