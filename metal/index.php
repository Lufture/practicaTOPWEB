<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php" class="text-decoration-none">Inicio</a></li>
            <li class="breadcrumb-item active">Materiales</li>
        </ol>
    </nav>

    <!-- Encabezado con botón de acción -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-metal me-2"></i>
                Gestión de Materiales
            </h1>
            <p class="text-muted mb-0">Administre los tipos de Materiales disponibles</p>
        </div>
        <a href="metal.php?accion=crear" class="btn btn-success">
            <i class="bi bi-plus-circle me-2"></i>
            Nuevo Metal
        </a>
    </div>

    <!-- Barra de herramientas -->
    <div class="card mb-4">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Buscar metal...">
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="exportData('excel')">
                            <i class="bi bi-file-earmark-excel me-1"></i>Excel
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="exportData('pdf')">
                            <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="printTable()">
                            <i class="bi bi-printer me-1"></i>Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Materiales -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0">
                    <i class="bi bi-table me-2"></i>
                    Lista de Materiales
                </h6>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" style="width: auto;" id="recordsPerPage">
                        <option value="10">10 por página</option>
                        <option value="25" selected>25 por página</option>
                        <option value="50">50 por página</option>
                        <option value="100">100 por página</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0" id="materialesTable">
                <thead class="table-light">
                    <tr>
                        <th class="sortable" data-sort="id">
                            <i class="bi bi-hash me-1"></i>ID
                            <i class="bi bi-chevron-expand sort-icon"></i>
                        </th>
                        <th class="sortable" data-sort="metal">
                            <i class="bi bi-metal me-1"></i>Metal
                            <i class="bi bi-chevron-expand sort-icon"></i>
                        </th>
                        <th class="text-center">
                            <i class="bi bi-gear me-1"></i>Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($metales)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox fa-3x mb-3 d-block"></i>
                                    <h5>No hay metales registrados</h5>
                                    <p>Comience agregando su primer metal</p>
                                    <a href="metal.php?accion=crear" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Crear Metal
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($metales as $metal): ?>
                        <tr>
                            <td class="fw-bold text-primary"><?php echo $metal['id_metal']; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                        <i class="bi bi-metal"></i>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">
                                            <?php echo htmlspecialchars($metal['metal']); ?>
                                        </div>
                                        <small class="text-muted">ID: <?php echo $metal['id_metal']; ?></small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="metal.php?accion=modificar&id=<?php echo $metal['id_metal']; ?>" 
                                        class="btn btn-sm btn-outline-warning"
                                        title="Modificar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal<?php echo $metal['id_metal']; ?>"
                                            title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de confirmación de eliminación para cada metal -->
                        <div class="modal fade" id="deleteModal<?php echo $metal['id_metal']; ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?php echo $metal['id_metal']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?php echo $metal['id_metal']; ?>">
                                            <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                                            Eliminar Material
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center mb-3">
                                            <i class="bi bi-metal text-danger" style="font-size: 3rem;"></i>
                                        </div>
                                        <p class="text-center">
                                            ¿Está seguro de que desea eliminar el Material 
                                            <strong><?php echo htmlspecialchars($metal['metal']); ?></strong>?
                                        </p>
                                        <div class="alert alert-warning" role="alert">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            <strong>Advertencia:</strong> Esta acción no se puede deshacer. Se eliminará toda la información del material permanentemente.
                                        </div>
                                        <div class="row text-muted small">
                                            <div class="col-6">
                                                <strong>ID:</strong> <?php echo $metal['id_metal']; ?>
                                            </div>
                                            <div class="col-6">
                                                <strong>Metal:</strong> <?php echo htmlspecialchars($metal['metal']); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Cancelar
                                        </button>
                                        <a class="btn btn-danger" href="metal.php?accion=eliminar&id=<?php echo $metal['id_metal']; ?>">
                                            <i class="bi bi-trash me-1"></i>
                                            Eliminar Material
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pie de tabla con paginación -->
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando <span id="showingStart">1</span> a <span id="showingEnd">25</span> 
                    de <span id="totalRecords"><?php echo count($metales); ?></span> registros
                </div>
                <nav aria-label="Paginación de metales">
                    <ul class="pagination pagination-sm mb-0" id="pagination">
                        <!-- La paginación se generará dinámicamente con JavaScript -->
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 14px;
}

.sortable {
    cursor: pointer;
    user-select: none;
    position: relative;
}

.sortable:hover {
    background-color: #f8f9fa;
}

.sort-icon {
    font-size: 0.8em;
    opacity: 0.5;
    margin-left: 5px;
}

.sortable.asc .sort-icon {
    opacity: 1;
}

.sortable.desc .sort-icon {
    opacity: 1;
    transform: rotate(180deg);
}

@media print {
    .no-print { display: none !important; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Funciones de búsqueda y filtrado
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('metalesTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Calcular estadísticas
    updateStats();
    
    // Búsqueda en tiempo real
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        filterTable(searchTerm);
    });
    
    // Ordenamiento de columnas
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            sortTable(this.dataset.sort);
        });
    });
    
    function filterTable(searchTerm) {
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const shouldShow = text.includes(searchTerm);
            row.style.display = shouldShow ? '' : 'none';
        });
        updateStats();
    }
    
    function sortTable(column) {
        // Implementar ordenamiento
        console.log('Ordenar por:', column);
    }
    
    function updateStats() {
        const visibleRows = rows.filter(row => row.style.display !== 'none');
        
        // Verificar si existe el elemento antes de actualizar
        const activeMetalsElement = document.getElementById('activeMetalsCount');
        if (activeMetalsElement) {
            activeMetalsElement.textContent = visibleRows.length;
        }
    }
});

// Funciones de exportación
function exportData(format) {
    console.log(`Exportar en formato: ${format}`);
    // Aquí implementarías la lógica de exportación
    showToast(`Función de exportación ${format} en desarrollo`);
}

function printTable() {
    window.print();
}

// Función auxiliar para mostrar notificaciones (opcional)
function showToast(message) {
    // Implementar sistema de notificaciones si existe
    console.log(message);
}
</script>