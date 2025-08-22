<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item"><a href="metal.php" class="text-decoration-none">Metales</a></li>
            <li class="breadcrumb-item active"><?php echo (isset($_GET['id'])) ? 'Modificar Metal' : 'Nuevo Metal'; ?></li>
        </ol>
    </nav>

    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-<?php echo (isset($_GET['id'])) ? 'pencil-square' : 'plus-circle'; ?> me-2"></i>
                <?php echo (isset($_GET['id'])) ? 'Modificar Metal' : 'Nuevo Metal'; ?>
            </h1>
            <p class="text-muted mb-0">Complete la información del Material</p>
        </div>
        <a href="/proyectos/pulidora/admin/metal.php" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver al listado
        </a>
    </div>

    <!-- Formulario -->
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-metal me-2"></i>
                        Información del Material
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/proyectos/pulidora/admin/metal.php?accion=<?php echo (isset($_GET['id'])) ? 'modificar&id=' . $_GET['id'] : 'crear' ?>" novalidate>
                        
                        <!-- Información del Metal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary border-bottom pb-2 mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Detalles del Material
                                </h6>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <label for="metalInput" class="form-label">
                                    <i class="bi bi-metal me-1"></i>
                                    Nombre del Material <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                        class="form-control" 
                                        id="metalInput" 
                                        name="datos[metal]" 
                                        value="<?php echo (isset($_GET['id'])) ? htmlspecialchars($info['metal']) : ''; ?>" 
                                        maxlength="30" 
                                        required 
                                        placeholder="Ingrese el nombre del material (ej: Oro, Plata, Cobre)">
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre del Material.
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Máximo 30 caracteres permitidos
                                </div>
                            </div>
                        </div>

                        <!-- Vista previa del metal -->
                        <div class="row g-3 mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="card-title text-muted mb-2">
                                            <i class="bi bi-eye me-1"></i>Vista Previa
                                        </h6>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <i class="bi bi-metal"></i>
                                            </div>
                                            <div>
                                                <div class="fw-semibold" id="previewName">
                                                    <?php echo (isset($_GET['id'])) ? htmlspecialchars($info['metal']) : 'Nombre del metal'; ?>
                                                </div>
                                                <small class="text-muted">Material registrado en el sistema</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="row">
                            <div class="col-12">
                                <hr class="my-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="/proyectos/pulidora/admin/metal.php" class="btn btn-outline-secondary">
                                        <i class="bi bi-x-circle me-2"></i>Cancelar
                                    </a>
                                    <button type="submit" name="enviar" class="btn btn-success">
                                        <i class="bi bi-check-circle me-2"></i>
                                        <?php echo (isset($_GET['id'])) ? 'Actualizar Metal' : 'Guardar Metal'; ?>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <?php if (isset($_GET['id'])): ?>
            <div class="card mt-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle me-2"></i>
                        Información del Metal
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>ID del Metal:</strong>
                            <span class="text-muted"><?php echo $_GET['id']; ?></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Estado:</strong>
                            <span class="badge bg-success">Activo</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
    }
    
    .d-flex.gap-2 .btn {
        width: 100%;
    }
}
</style>

<!-- Script para validación del formulario y vista previa -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del formulario
    const form = document.querySelector('form');
    const metalInput = document.getElementById('metalInput');
    const previewName = document.getElementById('previewName');
    
    // Actualizar vista previa en tiempo real
    metalInput.addEventListener('input', function() {
        const value = this.value.trim();
        previewName.textContent = value || 'Nombre del metal';
    });
    
    // Validación del formulario con Bootstrap
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
    
    // Validación en tiempo real
    const inputs = form.querySelectorAll('input[required], select[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });
        
        // Limpiar validación al escribir
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
    
    // Auto-focus en el campo principal
    metalInput.focus();
    
    // Capitalizar primera letra automáticamente
    metalInput.addEventListener('input', function() {
        const cursorPosition = this.selectionStart;
        const value = this.value;
        
        // Capitalizar primera letra de cada palabra
        const capitalizedValue = value.replace(/\b\w/g, l => l.toUpperCase());
        
        if (value !== capitalizedValue) {
            this.value = capitalizedValue;
            this.setSelectionRange(cursorPosition, cursorPosition);
        }
    });
});
</script>

