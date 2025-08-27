<?php include_once '../views/layout/header.php'; ?>
<div class="content">
    <div class="actor-detail">
        <h2>Detalles del Actor</h2>
       
        <div class="actor-info">
            <div class="info-item">
                <label>ID:</label>
                <span><?php echo htmlspecialchars($this->actor->actor_id); ?></span>
            </div>
           
            <div class="info-item">
                <label>Nombre:</label>
                <span><?php echo htmlspecialchars($this->actor->first_name); ?></span>
            </div>
           
            <div class="info-item">
                <label>Apellido:</label>
                <span><?php echo htmlspecialchars($this->actor->last_name); ?></span>
            </div>
           
            <div class="info-item">
                <label>Última actualización:</label>
                <span><?php echo date('d/m/Y H:i:s', strtotime($this->actor->last_update)); ?></span>
            </div>
        </div>
       
        <div class="actions">
            <a href="index.php" class="btn btn-primary">Volver a la lista</a>
            <a href="index.php?action=edit&id=<?php echo $this->actor->actor_id; ?>" class="btn btn-warning">Editar Actor</a>
            <a href="index.php?action=delete&id=<?php echo $this->actor->actor_id; ?>" 
               class="btn btn-danger" 
               onclick="return confirm('¿Estás seguro de que deseas eliminar a <?php echo htmlspecialchars($this->actor->first_name . ' ' . $this->actor->last_name); ?>?')">
                Eliminar Actor
            </a>
        </div>
    </div>
</div>

<style>
.actions {
    margin-top: 20px;
    display: flex;
    gap: 12px;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: 1px solid #dc3545;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-warning {
    background-color: #ffc107;
    color: #212529;
    border: 1px solid #ffc107;
    padding: 8px 16px;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-danger:hover {
    background-color: #c82333;
    border-color: #bd2130;
}

.btn-warning:hover {
    background-color: #e0a800;
    border-color: #d39e00;
}
</style>

<?php include_once '../views/layout/footer.php'; ?>