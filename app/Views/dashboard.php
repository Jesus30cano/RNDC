<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RNDC - Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background: white;
            padding: 15px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo-left {
            height: 60px;
        }

        .header-center {
            text-align: center;
            flex-grow: 1;
        }

        .header-center h1 {
            color: #333;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .logo-right {
            height: 50px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-name {
            color: #333;
            font-weight: 500;
        }

        .btn-logout {
            padding: 8px 20px;
            background: #c33;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            background: #a22;
        }

        .main-content {
            flex: 1;
            padding: 40px 20px;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .welcome-section {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            text-align: center;
        }

        .welcome-section h2 {
            color: #D97744;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .welcome-section p {
            color: #666;
            font-size: 16px;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .module-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .module-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .module-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #D97744 0%, #c46838 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            font-size: 40px;
            color: white;
        }

        .module-card h3 {
            color: #333;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .module-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }

        .module-card.remesa .module-icon {
            background: linear-gradient(135deg, #4CAF50 0%, #388E3C 100%);
        }

        .module-card.manifiesto .module-icon {
            background: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }

        .module-card.consulta .module-icon {
            background: linear-gradient(135deg, #FF9800 0%, #F57C00 100%);
        }

        footer {
            background: white;
            padding: 20px;
            text-align: center;
            color: #666;
            font-size: 13px;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.05);
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                gap: 15px;
                padding: 20px;
            }

            .modules-grid {
                grid-template-columns: 1fr;
            }

            .logo-left, .logo-right {
                height: 45px;
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="/RNDC/public/assets/images/colombia-potencia.webp" alt="Colombia Potencia de la Vida" class="logo-left">
        <div class="header-center">
            <h1>Registro Nacional Despacho de Carga</h1>
        </div>
        <div class="user-info">
            <span class="user-name">TRANSPORTES QUIROGA S.A.S</span>
            <button class="btn-logout" onclick="logout()">Cerrar Sesión</button>
        </div>
        <img src="/RNDC/public/assets/images/transporte.webp" alt="Ministerio de Transporte" class="logo-right">
    </header>

    <div class="main-content">
        <div class="welcome-section">
            <h2>Bienvenido al Sistema RNDC</h2>
            <p>Seleccione el módulo al que desea acceder</p>
        </div>

        <div class="modules-grid">
            <a href="index.php?c=remesa&a=index" class="module-card remesa">
                <div class="module-icon">📋</div>
                <h3>Remesa Terrestre</h3>
                <p>Crear y gestionar remesas terrestres de carga. Registre la información del propietario, sitios de cargue y descargue, productos y mercancías.</p>
            </a>

            <a href="index.php?c=manifiesto&a=index" class="module-card manifiesto">
                <div class="module-icon">🚛</div>
                <h3>Manifiesto de Carga</h3>
                <p>Expedir manifiestos de carga con información del vehículo, conductores, titular y datos del viaje completo.</p>
            </a>

            <a href="index.php?c=consultaManifiesto&a=index" class="module-card consulta">
                <div class="module-icon">🔍</div>
                <h3>Consultar Manifiestos</h3>
                <p>Buscar y visualizar manifiestos expedidos. Consulte por número de manifiesto, fecha, placa o conductor.</p>
            </a>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Ministerio de Transporte - Todos los derechos reservados</p>
    </footer>

    <script>
        function logout() {
            if (confirm('¿Está seguro que desea cerrar sesión?')) {
                window.location.href = 'index.php?c=login&a=logout';
            }
        }
    </script>
</body>
</html>