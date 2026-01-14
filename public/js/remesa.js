// ============================================
// remesa.js
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('remesaForm');
    // ===============================
    // AUTOLLENADO DE NIT POR EMPRESA
    // ===============================
    const empresaSelect = document.getElementById('nombreEmpresa');
    const nitInput = document.getElementById('nitEmpresa');

    const empresasNIT = {
        "TRANSPORTES QUIROGA S.A.S": "8020099265",
        "ALIMENTOS DEL VALLE S.A.": "8901234567",
        "INDUSTRIAS QUÍMICAS LTDA": "8902345678"
    };

    if (empresaSelect && nitInput) {
        empresaSelect.addEventListener('change', function () {
            const empresaSeleccionada = this.value;

            if (empresasNIT[empresaSeleccionada]) {
                nitInput.value = empresasNIT[empresaSeleccionada];
            } else {
                nitInput.value = "";
            }
        });
    }
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateRemesaForm()) {
                saveRemesa();
            }
        });
    }
});

function validateRemesaForm() {
    const requiredFields = document.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#c33';
            isValid = false;
        } else {
            field.style.borderColor = '#e0e0e0';
        }
    });
    
    if (!isValid) {
        alert('Por favor complete todos los campos obligatorios');
    }
    
    return isValid;
}

async function saveRemesa() {
    const formData = new FormData(document.getElementById('remesaForm'));
    const data = Object.fromEntries(formData);
    console.log('Datos de remesa a guardar:', data);
    
    // URL del endpoint para guardar remesa
    const url = '/RNDC/index.php?c=remesa&a=guardar';
    
    try {
        // Mostrar indicador de carga
        const submitButton = document.querySelector('button[type="submit"]');
        const originalText = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = 'Guardando...';
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });
        
        // Restaurar botón
        submitButton.disabled = false;
        submitButton.textContent = originalText;
        
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        
        const result = await response.json();
        console.log('Resultado de guardar remesa:', result);
        
        if (result.success) {
            alert('Remesa guardada exitosamente');
            
            // Preguntar si desea crear otra remesa
            if (confirm('¿Desea crear otra remesa?')) {
                resetForm();
            } else {
                window.location.href = 'index.php?c=dashboard&a=index';
            }
        } else {
            alert('Error al guardar la remesa: ' + (result.message || 'Error desconocido'));
        }
        
    } catch (error) {
        console.error('Error al guardar remesa:', error);
        alert('Error de conexión. Por favor intente nuevamente.');
        
        // Restaurar botón en caso de error
        const submitButton = document.querySelector('button[type="submit"]');
        submitButton.disabled = false;
        submitButton.textContent = 'Guardar Remesa';
    }
}

function resetForm() {
    document.getElementById('remesaForm').reset();
    
    // Resetear colores de borde
    const allFields = document.querySelectorAll('input, select, textarea');
    allFields.forEach(field => {
        field.style.borderColor = '#e0e0e0';
    });
}

function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión?')) {
        window.location.href = 'index.php?c=login&a=logout';
    }
}