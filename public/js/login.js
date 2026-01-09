const loginForm = document.getElementById('loginForm');
        const btnLogin = document.getElementById('btnLogin');
        const loading = document.getElementById('loading');
        const errorMessage = document.getElementById('errorMessage');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Obtener los datos del formulario
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const remember = document.getElementById('remember').checked;

            // Ocultar mensaje de error previo
            errorMessage.classList.remove('show');

            // Mostrar loading y deshabilitar botón
            loading.classList.add('show');
            btnLogin.disabled = true;
            btnLogin.textContent = 'Ingresando...';

            try {
                // Realizar la petición POST
                const response = await fetch('/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password,
                        remember: remember
                    })
                });

                const data = await response.json();
                console

                if (response.ok && data.success) {
                    // Login exitoso - redirigir según el tipo de usuario o respuesta
                    if (data.redirectUrl) {
                        window.location.href = data.redirectUrl;
                    } else {
                        // URL por defecto si no viene en la respuesta
                        window.location.href = '/dashboard';
                    }
                } else {
                    // Login fallido - mostrar error
                    errorMessage.textContent = data.message || 'Usuario o contraseña incorrectos';
                    errorMessage.classList.add('show');
                    
                    // Resetear el botón
                    loading.classList.remove('show');
                    btnLogin.disabled = false;
                    btnLogin.textContent = 'Ingresar';
                }
            } catch (error) {
                // Error de conexión o del servidor
                errorMessage.textContent = 'Error de conexión. Por favor, intente nuevamente.';
                errorMessage.classList.add('show');
                
                // Resetear el botón
                loading.classList.remove('show');
                btnLogin.disabled = false;
                btnLogin.textContent = 'Ingresar';
                
                console.error('Error:', error);
            }
        });

        // Limpiar mensaje de error cuando el usuario empiece a escribir
        document.getElementById('username').addEventListener('input', () => {
            errorMessage.classList.remove('show');
        });

        document.getElementById('password').addEventListener('input', () => {
            errorMessage.classList.remove('show');
        });