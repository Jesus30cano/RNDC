const loginForm = document.getElementById('loginForm');
const btnLogin = document.getElementById('btnLogin');
const loading = document.getElementById('loading');
const errorMessage = document.getElementById('errorMessage');

console.log('🔧 Login script cargado correctamente');

loginForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    console.log('📝 Formulario enviado');

    // Obtener los datos del formulario
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    console.log('👤 Datos del formulario:', {
        username: username,
        passwordLength: password.length,
        remember: remember
    });

    // Ocultar mensaje de error previo
    errorMessage.classList.remove('show');

    // Mostrar loading y deshabilitar botón
    loading.classList.add('show');
    btnLogin.disabled = true;
    btnLogin.textContent = 'Ingresando...';

    const requestData = {
        username: username,
        password: password,
        remember: remember
    };

    console.log('📤 Datos a enviar:', requestData);

    const url = '/RNDC/index.php?c=login&a=authenticate';
    console.log('🌐 URL destino:', url);

    try {
        console.log('⏳ Iniciando petición fetch...');
        
        // Realizar la petición POST al controlador
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestData)
        });

        console.log('📡 Respuesta recibida:', {
            status: response.status,
            statusText: response.statusText,
            ok: response.ok,
            headers: {
                contentType: response.headers.get('content-type')
            }
        });

        // Intentar obtener el texto crudo primero
        const responseText = await response.text();
        console.log('📄 Respuesta cruda (primeros 500 caracteres):', responseText.substring(0, 500));

        // Intentar parsear como JSON
        let data;
        try {
            data = JSON.parse(responseText);
            console.log('✅ JSON parseado correctamente:', data);
        } catch (parseError) {
            console.error('❌ ERROR al parsear JSON:', parseError);
            console.error('📄 Texto completo de la respuesta:', responseText);
            throw new Error('La respuesta del servidor no es JSON válido. Revisa la consola para ver el contenido.');
        }

        if (response.ok && data.success) {
            console.log('✅ Login exitoso!');
            console.log('👤 Datos del usuario:', data.user);
            console.log('🔗 Redirigiendo a:', data.redirectUrl);
            
            // Login exitoso - mostrar mensaje de éxito
            errorMessage.style.backgroundColor = '#4CAF50';
            errorMessage.textContent = '¡Login exitoso! Redirigiendo...';
            errorMessage.classList.add('show');
            
            // Redirigir después de un breve delay
            setTimeout(() => {
                console.log('🚀 Ejecutando redirección...');
                window.location.href = data.redirectUrl || '/RNDC/index.php?c=dashboard&a=index';
            }, 500);
            
        } else {
            console.warn('⚠️ Login fallido');
            console.warn('Mensaje de error:', data.message);
            console.warn('Datos completos:', data);
            
            // Login fallido - mostrar error
            errorMessage.textContent = data.message || 'Usuario o contraseña incorrectos';
            errorMessage.classList.add('show');
            
            // Resetear el botón
            loading.classList.remove('show');
            btnLogin.disabled = false;
            btnLogin.textContent = 'Ingresar';
        }
    } catch (error) {
        console.error('💥 ERROR CAPTURADO EN CATCH:', error);
        console.error('Tipo de error:', error.name);
        console.error('Mensaje:', error.message);
        console.error('Stack:', error.stack);
        
        // Error de conexión o del servidor
        errorMessage.textContent = 'Error de conexión. Por favor, intente nuevamente. Ver consola para detalles.';
        errorMessage.classList.add('show');
        
        // Resetear el botón
        loading.classList.remove('show');
        btnLogin.disabled = false;
        btnLogin.textContent = 'Ingresar';
    }
});

// Limpiar mensaje de error cuando el usuario empiece a escribir
document.getElementById('username').addEventListener('input', () => {
    console.log('🔄 Campo username modificado');
    errorMessage.classList.remove('show');
});

document.getElementById('password').addEventListener('input', () => {
    console.log('🔄 Campo password modificado');
    errorMessage.classList.remove('show');
});

console.log('✅ Event listeners configurados correctamente');