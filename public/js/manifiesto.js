// ============================================
// manifiesto.js - Versión completa actualizada
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 Iniciando aplicación de manifiesto...');
    
    const form = document.getElementById('manifiestoForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('📝 Formulario enviado');
            
            if (validateManifiestoForm()) {
                saveManifiesto();
            }
        });
        
        // Auto-calcular saldo y retenciones
        setupAutoCalculations();
        
        // Auto-completar NIT cuando se selecciona empresa
        const empresaSelect = document.getElementById('nombreEmpresa');
        if (empresaSelect) {
            empresaSelect.addEventListener('change', autoCompletarNIT);
        }

        // Cargar remesas disponibles
        cargarRemesasDisponibles();

        // Establecer fecha actual como fecha de expedición por defecto
        const fechaExpedicion = document.getElementById('fechaExpedicion');
        if (fechaExpedicion && !fechaExpedicion.value) {
            fechaExpedicion.value = new Date().toISOString().split('T')[0];
        }
    }
});

let remesasAgregadas = [];

// ============================================
// CONFIGURACIÓN DE CÁLCULOS AUTOMÁTICOS
// ============================================
function setupAutoCalculations() {
    // Auto-calcular saldo a pagar
    const netoPagar = document.getElementById('netoPagar');
    const valorAnticipo = document.getElementById('valorAnticipo');
    const saldoPagar = document.getElementById('saldoPagar');
    
    if (netoPagar && valorAnticipo && saldoPagar) {
        [netoPagar, valorAnticipo].forEach(input => {
            input.addEventListener('input', function() {
                const neto = parseFloat(netoPagar.value) || 0;
                const anticipo = parseFloat(valorAnticipo.value) || 0;
                saldoPagar.value = (neto - anticipo).toFixed(2);
            });
        });
    }

    // Calcular retención en la fuente automáticamente (4%)
    const valorViaje = document.getElementById('valorViaje');
    const retencionFuente = document.getElementById('retencionFuente');
    
    if (valorViaje && retencionFuente) {
        valorViaje.addEventListener('input', function() {
            const valor = parseFloat(valorViaje.value) || 0;
            retencionFuente.value = (valor * 0.04).toFixed(2);
            calcularNetoPagar();
        });
    }

    // Calcular retención ICA
    const retencionICA = document.getElementById('retencionICA');
    const retencionICAValor = document.getElementById('retencionICAValor');
    
    if (retencionICA && retencionICAValor && valorViaje) {
        retencionICA.addEventListener('input', function() {
            const valor = parseFloat(valorViaje.value) || 0;
            const porcentaje = parseFloat(retencionICA.value) || 0;
            retencionICAValor.value = (valor * (porcentaje / 1000)).toFixed(2);
            calcularNetoPagar();
        });
    }
}

function calcularNetoPagar() {
    const valorViaje = parseFloat(document.getElementById('valorViaje').value) || 0;
    const retencionFuente = parseFloat(document.getElementById('retencionFuente').value) || 0;
    const retencionICAValor = parseFloat(document.getElementById('retencionICAValor').value) || 0;
    const netoPagar = document.getElementById('netoPagar');
    
    if (netoPagar) {
        const neto = valorViaje - retencionFuente - retencionICAValor;
        netoPagar.value = neto.toFixed(2);
        
        // Recalcular saldo
        const valorAnticipo = parseFloat(document.getElementById('valorAnticipo').value) || 0;
        const saldoPagar = document.getElementById('saldoPagar');
        if (saldoPagar) {
            saldoPagar.value = (neto - valorAnticipo).toFixed(2);
        }
    }
}

// ============================================
// AUTO-COMPLETAR NIT
// ============================================
function autoCompletarNIT() {
    const empresaSelect = document.getElementById('nombreEmpresa');
    const nitInput = document.getElementById('nitEmpresa');
    
    const nits = {
        'TRANSPORTES QUIROGA S.A.S': '8020099265',
        'ALIMENTOS DEL VALLE S.A.': '8901234567',
        'INDUSTRIAS QUÍMICAS LTDA': '8902345678'
    };
    
    if (empresaSelect && nitInput) {
        nitInput.value = nits[empresaSelect.value] || '';
    }
}

// ============================================
// CARGAR REMESAS DISPONIBLES
// ============================================
function cargarRemesasDisponibles() {
    console.log('🔄 Cargando remesas disponibles...');
    
    fetch('index.php?c=manifiesto&a=listarRemesas')
        .then(response => response.json())
        .then(data => {
            console.log('✅ Remesas recibidas:', data);
            
            if (data.success && data.remesas) {
                const select = document.getElementById('consultarRemesas');
                
                if (select) {
                    // Limpiar opciones existentes
                    select.innerHTML = '<option value="">Seleccione una remesa...</option>';
                    
                    // Agregar remesas
                    data.remesas.forEach(remesa => {
                        const option = document.createElement('option');
                        option.value = remesa.consecutivo;
                        option.textContent = `${remesa.consecutivo} - ${remesa.propietario_nombre} (${remesa.fecha_expedicion})`;
                        select.appendChild(option);
                    });

                    // Evento para autocompletar cuando se seleccione
                    select.addEventListener('change', function() {
                        if (this.value) {
                            document.getElementById('remesaDeseada').value = this.value;
                        }
                    });
                }
            }
        })
        .catch(error => {
            console.error('❌ Error cargando remesas:', error);
            showAlert('Error al cargar las remesas disponibles', 'error');
        });
}

// ============================================
// GESTIÓN DE REMESAS
// ============================================
function addRemesa() {
    const input = document.getElementById('remesaDeseada');
    const consecutivo = input.value.trim();
    
    if (!consecutivo) {
        showAlert('Por favor ingrese un consecutivo de remesa', 'warning');
        return;
    }
    
    if (remesasAgregadas.some(r => r.consecutivo === consecutivo)) {
        showAlert('Esta remesa ya fue agregada', 'warning');
        return;
    }
    
    // Buscar detalles de la remesa
    fetch(`index.php?c=manifiesto&a=detalleRemesa&consecutivo=${encodeURIComponent(consecutivo)}`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.remesa) {
                // Agregar remesa con datos completos
                remesasAgregadas.push({
                    consecutivo: consecutivo,
                    cargue: data.remesa.cargue_mun || '-',
                    descargue: data.remesa.descargue_mun || '-',
                    codigoMercancia: '-',
                    mercancia: data.remesa.producto_desc || '-',
                    cantidad: data.remesa.cantidad_producto || 0,
                    unidadMedida: 'KG',
                    horasCargue: 0,
                    minutosCargue: 0,
                    horasDescargue: 0,
                    minutosDescargue: 0
                });
                
                updateRemesasList();
                input.value = '';
                updateContadores();
                
                showAlert(`Remesa ${consecutivo} agregada exitosamente`, 'success');
            } else {
                // Si no se encuentran detalles, agregar con datos básicos
                remesasAgregadas.push({
                    consecutivo: consecutivo,
                    cargue: '-',
                    descargue: '-',
                    codigoMercancia: '-',
                    mercancia: '-',
                    cantidad: 0,
                    unidadMedida: '-',
                    horasCargue: 0,
                    minutosCargue: 0,
                    horasDescargue: 0,
                    minutosDescargue: 0
                });
                
                updateRemesasList();
                input.value = '';
                updateContadores();
                
                showAlert(`Remesa ${consecutivo} agregada (sin detalles disponibles)`, 'info');
            }
        })
        .catch(error => {
            console.error('Error consultando remesa:', error);
            
            // Agregar de todas formas con datos mínimos
            remesasAgregadas.push({
                consecutivo: consecutivo,
                cargue: '-',
                descargue: '-',
                codigoMercancia: '-',
                mercancia: '-',
                cantidad: 0,
                unidadMedida: '-',
                horasCargue: 0,
                minutosCargue: 0,
                horasDescargue: 0,
                minutosDescargue: 0
            });
            
            updateRemesasList();
            input.value = '';
            updateContadores();
            
            showAlert(`Remesa ${consecutivo} agregada`, 'info');
        });
}

function removeRemesa(consecutivo) {
    remesasAgregadas = remesasAgregadas.filter(r => r.consecutivo !== consecutivo);
    updateRemesasList();
    updateContadores();
    showAlert('Remesa eliminada', 'info');
}

function updateRemesasList() {
    const tbody = document.querySelector('#remesasTable tbody');
    
    if (!tbody) return;
    
    if (remesasAgregadas.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="12" align="center" style="color: #999; padding: 20px;">
                    No hay Registros para mostrar
                </td>
            </tr>
        `;
        return;
    }
    
    tbody.innerHTML = remesasAgregadas.map((remesa, index) => `
        <tr>
            <td>${remesa.consecutivo}</td>
            <td>${remesa.cargue}</td>
            <td>${remesa.descargue}</td>
            <td>${remesa.codigoMercancia}</td>
            <td>${remesa.mercancia}</td>
            <td>${remesa.cantidad}</td>
            <td>${remesa.unidadMedida}</td>
            <td><input type="number" min="0" value="${remesa.horasCargue}" onchange="updateRemesaTime(${index}, 'horasCargue', this.value)" style="width: 60px;"></td>
            <td><input type="number" min="0" max="59" value="${remesa.minutosCargue}" onchange="updateRemesaTime(${index}, 'minutosCargue', this.value)" style="width: 60px;"></td>
            <td><input type="number" min="0" value="${remesa.horasDescargue}" onchange="updateRemesaTime(${index}, 'horasDescargue', this.value)" style="width: 60px;"></td>
            <td><input type="number" min="0" max="59" value="${remesa.minutosDescargue}" onchange="updateRemesaTime(${index}, 'minutosDescargue', this.value)" style="width: 60px;"></td>
            <td><button type="button" onclick="removeRemesa('${remesa.consecutivo}')" class="btn-remove" style="background: #dc3545; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px;">X</button></td>
        </tr>
    `).join('');
}

function updateRemesaTime(index, field, value) {
    remesasAgregadas[index][field] = parseInt(value) || 0;
    updateContadores();
}

function updateContadores() {
    // Actualizar cantidad de remesas
    const cantidadInput = document.getElementById('cantidadRemesas');
    if (cantidadInput) {
        cantidadInput.value = remesasAgregadas.length;
    }

    // Calcular tiempos totales
    let totalHorasCargue = 0;
    let totalMinutosCargue = 0;
    let totalHorasDescargue = 0;
    let totalMinutosDescargue = 0;

    remesasAgregadas.forEach(remesa => {
        totalHorasCargue += remesa.horasCargue;
        totalMinutosCargue += remesa.minutosCargue;
        totalHorasDescargue += remesa.horasDescargue;
        totalMinutosDescargue += remesa.minutosDescargue;
    });

    // Convertir minutos excedentes a horas
    totalHorasCargue += Math.floor(totalMinutosCargue / 60);
    totalMinutosCargue = totalMinutosCargue % 60;
    totalHorasDescargue += Math.floor(totalMinutosDescargue / 60);
    totalMinutosDescargue = totalMinutosDescargue % 60;

    // Actualizar campos
    const horasCargueInput = document.getElementById('horasCargue');
    const minutosCargueInput = document.getElementById('minutosCargue');
    const horasDescargueInput = document.getElementById('horasDescargue');
    const minutosDescargueInput = document.getElementById('minutosDescargue');

    if (horasCargueInput) horasCargueInput.value = totalHorasCargue;
    if (minutosCargueInput) minutosCargueInput.value = totalMinutosCargue;
    if (horasDescargueInput) horasDescargueInput.value = totalHorasDescargue;
    if (minutosDescargueInput) minutosDescargueInput.value = totalMinutosDescargue;
}

// ============================================
// VALIDACIÓN DEL FORMULARIO
// ============================================
function validateManifiestoForm() {
    const requiredFields = document.querySelectorAll('[required]');
    let isValid = true;
    let firstInvalidField = null;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.style.borderColor = '#c33';
            isValid = false;
            if (!firstInvalidField) firstInvalidField = field;
        } else {
            field.style.borderColor = '#e0e0e0';
        }
    });
    
    if (remesasAgregadas.length === 0) {
        showAlert('Debe agregar al menos una remesa al manifiesto', 'error');
        isValid = false;
    }
    
    if (!isValid) {
        showAlert('Por favor complete todos los campos obligatorios marcados con *', 'error');
        if (firstInvalidField) {
            firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstInvalidField.focus();
        }
    }
    
    return isValid;
}

// ============================================
// GUARDAR MANIFIESTO
// ============================================
function saveManifiesto() {
    console.log('💾 Guardando manifiesto...');
    
    // Mostrar indicador de carga
    showLoading(true);

    const formData = new FormData(document.getElementById('manifiestoForm'));
    const data = {};
    
    // Convertir FormData a objeto
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }

    // Agregar remesas
    data.remesas = remesasAgregadas;
    
    console.log('📦 Datos a enviar:', data);

    // Enviar al servidor
    fetch('index.php?c=manifiesto&a=guardar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json; charset=utf-8',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('📡 Respuesta recibida, status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(result => {
        console.log('✅ Resultado:', result);
        showLoading(false);

        if (result.success) {
            showAlert(`✅ Manifiesto guardado exitosamente con consecutivo: ${result.consecutivo}`, 'success');
            
            // Preguntar si desea crear otro manifiesto
            setTimeout(() => {
                if (confirm('¿Desea crear otro manifiesto?')) {
                    resetForm();
                } else {
                    window.location.href = 'index.php?c=dashboard&a=index';
                }
            }, 2000);
        } else {
            showAlert('❌ Error al guardar: ' + (result.message || 'Error desconocido'), 'error');
        }
    })
    .catch(error => {
        console.error('❌ Error:', error);
        showLoading(false);
        showAlert('❌ Error de conexión: ' + error.message, 'error');
    });
}

// ============================================
// UTILIDADES UI
// ============================================
function showLoading(show) {
    let loader = document.getElementById('loader');
    
    if (!loader) {
        loader = document.createElement('div');
        loader.id = 'loader';
        loader.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
                        background: rgba(0,0,0,0.7); display: flex; align-items: center; 
                        justify-content: center; z-index: 9999;">
                <div style="background: white; padding: 30px; border-radius: 10px; text-align: center;">
                    <div style="border: 4px solid #f3f3f3; border-top: 4px solid #3498db; 
                                border-radius: 50%; width: 40px; height: 40px; 
                                animation: spin 1s linear infinite; margin: 0 auto 15px;"></div>
                    <p style="margin: 0; font-weight: bold;">Guardando manifiesto...</p>
                </div>
            </div>
            <style>
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }
            </style>
        `;
        document.body.appendChild(loader);
    }
    
    loader.style.display = show ? 'block' : 'none';
}

function showAlert(message, type = 'info') {
    const colors = {
        success: '#4CAF50',
        error: '#f44336',
        warning: '#ff9800',
        info: '#2196F3'
    };

    const alertDiv = document.createElement('div');
    alertDiv.innerHTML = `
        <div style="position: fixed; top: 20px; right: 20px; z-index: 10000; 
                    background: ${colors[type]}; color: white; padding: 15px 25px; 
                    border-radius: 5px; box-shadow: 0 4px 6px rgba(0,0,0,0.3);
                    animation: slideIn 0.3s ease-out; max-width: 400px;">
            <strong>${type.toUpperCase()}:</strong> ${message}
        </div>
        <style>
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
        </style>
    `;
    
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        alertDiv.style.opacity = '0';
        alertDiv.style.transition = 'opacity 0.3s';
        setTimeout(() => alertDiv.remove(), 300);
    }, 5000);
}

function resetForm() {
    document.getElementById('manifiestoForm').reset();
    remesasAgregadas = [];
    updateRemesasList();
    updateContadores();
    
    // Restablecer fecha actual
    const fechaExpedicion = document.getElementById('fechaExpedicion');
    if (fechaExpedicion) {
        fechaExpedicion.value = new Date().toISOString().split('T')[0];
    }
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
    showAlert('Formulario limpiado correctamente', 'info');
}

function logout() {
    if (confirm('¿Está seguro que desea cerrar sesión?')) {
        window.location.href = 'index.php?c=login&a=logout';
    }
}

// Log inicial
console.log('✅ manifiesto.js cargado correctamente');