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
        </div>
    </div>
</div>

<?php include_once '../views/layout/footer.php'; ?>