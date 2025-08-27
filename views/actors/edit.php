<?php include_once '../views/layout/header.php'; ?>
<div class="content">
    <div class="form-container">
        <h2>Editar Actor</h2>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($_GET['error']); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?action=update&id=<?php echo $this->actor->actor_id; ?>" class="actor-form">
            <div class="form-group">
                <label for="first_name">Nombre:</label>
                <input type="text" 
                       id="first_name" 
                       name="first_name" 
                       value="<?php echo htmlspecialchars($this->actor->first_name); ?>" 
                       required 
                       maxlength="45"
                       class="form-control">
            </div>
            
            <div class="form-group">
                <label for="last_name">Apellido:</label>
                <input type="text" 
                       id="last_name" 
                       name="last_name" 
                       value="<?php echo htmlspecialchars($this->actor->last_name); ?>" 
                       required 
                       maxlength="45"
                       class="form-control">
            </div>
            
            <div class="form-group">
                <label>ID del Actor:</label>
                <span class="readonly-field"><?php echo htmlspecialchars($this->actor->actor_id); ?></span>
                <small class="help-text">El ID no puede ser modificado</small>
            </div>
            
            <div class="form-group">
                <label>Última actualización:</label>
                <span class="readonly-field"><?php echo date('d/m/Y H:i:s', strtotime($this->actor->last_update)); ?></span>
                <small class="help-text">Se actualizará automáticamente al guardar</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="index.php?action=show&id=<?php echo $this->actor->actor_id; ?>" class="btn btn-secondary">Cancelar</a>
                <a href="index.php" class="btn btn-primary">Volver a la Lista</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.actor-form {
    background: #f9f9f9;
    padding: 30px;
    border-radius: 8px;
    border: 1px solid #ddd;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0,123,255,0.3);
}

.readonly-field {
    display: block;
    padding: 10px;
    background-color: #e9ecef;
    border: 1px solid #ced4da;
    border-radius: 4px;
    color: #495057;
}

.help-text {
    display: block;
    margin-top: 5px;
    color: #6c757d;
    font-size: 12px;
}

.form-actions {
    margin-top: 30px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.btn-success {
    background-color: #28a745;
    color: white;
    border: 1px solid #28a745;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

.alert {
    padding: 12px 16px;
    margin: 16px 0;
    border-radius: 4px;
    border: 1px solid;
}

.alert-error {
    background-color: #fee;
    border-color: #fcc;
    color: #c33;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        text-align: center;
    }
}
</style>

<?php include_once '../views/layout/footer.php'; ?>