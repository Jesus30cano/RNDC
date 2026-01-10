
// ============================================
// manifiesto.js
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('manifiestoForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateManifiestoForm()) {
                saveManifiesto();
            }
        });
        
        // Calcular saldo automáticamente
        const netoPagar = document.querySelector('[name="netoPagar"]');
        const valorAnticipo = document.querySelector('[name="valorAnticipo"]');
        const saldoPagar = document.querySelector('[name="saldoPagar"]');
        
        if (netoPagar && valorAnticipo && saldoPagar) {
            [netoPagar, valorAnticipo].forEach(input => {
                input.addEventListener('input', function() {
                    const neto = parseFloat(netoPagar.value) || 0;
                    const anticipo = parseFloat(valorAnticipo.value) || 0;
                    saldoPagar.value = (neto - anticipo).toFixed(2);
                });
            });
        }
    }
});

let remesasAgregadas = [];

function addRemesa() {
    const input = document.getElementById('remesaInput');
    const consecutivo = input.value.trim();
    
    if (!consecutivo) {
        alert('Por favor ingrese un consecutivo de remesa');
        return;
    }
    
    if (remesasAgregadas.includes(consecutivo)) {
        alert('Esta remesa ya fue agregada');
        return;
    }
    
    remesasAgregadas.push(consecutivo);
    updateRemesasList();
    input.value = '';
}

function removeRemesa(consecutivo) {
    remesasAgregadas = remesasAgregadas.filter(r => r !== consecutivo);
    updateRemesasList();
}

function updateRemesasList() {
    const list = document.getElementById('remesasList');
    
    if (remesasAgregadas.length === 0) {
        list.innerHTML = '<p style="color: #999; text-align: center; padding: 20px;">No hay remesas agregadas</p>';
        return;
    }
    
    list.innerHTML = remesasAgregadas.map(remesa => `
        <div class="remesa-item">
            <span>Remesa: ${remesa}</span>
            <button type="button" class="btn-remove" onclick="removeRemesa('${remesa}')">Eliminar</button>
        </div>
    `).join('');
}

function validateManifiestoForm() {
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
    
    if (remesasAgregadas.length === 0) {
        alert('Debe agregar al menos una remesa al manifiesto');
        isValid = false;
    }
    
    if (!isValid) {
        alert('Por favor complete todos los campos obligatorios');
    }
    
    return isValid;
}

function saveManifiesto() {
    const formData = new FormData(document.getElementById('manifiestoForm'));
    const data = Object.fromEntries(formData);
    data.remesas = remesasAgregadas;
    
    // Simulación de guardado
    console.log('Datos de Manifiesto:', data);
    
    // Aquí iría la llamada AJAX al servidor
    // fetch('/RNDC/api/manifiesto/guardar', { method: 'POST', body: JSON.stringify(data) })
    
    alert('Manifiesto guardado exitosamente');
    
    // Preguntar si desea crear otro manifiesto
    if (confirm('¿Desea crear otro manifiesto?')) {
        resetForm();
        remesasAgregadas = [];
        updateRemesasList();
    } else {
        window.location.href = 'dashboard.php';
    }
}

function resetForm() {
    document.getElementById('manifiestoForm').reset();
    remesasAgregadas = [];
    updateRemesasList();
}

function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión?')) {
        window.location.href = 'index.php?c=login&a=logout';
    }
}