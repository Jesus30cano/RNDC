// ============================================
// remesa.js
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('remesaForm');
    
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

function saveRemesa() {
    const formData = new FormData(document.getElementById('remesaForm'));
    const data = Object.fromEntries(formData);
    
    // Simulación de guardado
    console.log('Datos de Remesa:', data);
    
    // Aquí iría la llamada AJAX al servidor
    // fetch('/RNDC/api/remesa/guardar', { method: 'POST', body: JSON.stringify(data) })
    
    alert('Remesa guardada exitosamente');
    
    // Preguntar si desea crear otra remesa
    if (confirm('¿Desea crear otra remesa?')) {
        resetForm();
    } else {
        window.location.href = 'dashboard.php';
    }
}

function resetForm() {
    document.getElementById('remesaForm').reset();
}

function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión?')) {
        window.location.href = 'index.php?c=login&a=logout';
    }
}


