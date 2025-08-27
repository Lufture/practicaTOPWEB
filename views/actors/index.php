<?php include_once '../views/layout/header.php'; ?>
<div class="content">
    <div class="search-section">
        <h2><?php echo $page_title; ?></h2>
       
        <!-- Formulario de búsqueda -->
        <form method="GET" action="index.php" class="search-form">
            <input type="text" name="search" placeholder="Buscar por nombre o apellido..."
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                   class="search-input">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="index.php" class="btn btn-secondary">Ver Todos</a>
        </form>
    </div>
    
    <?php if(isset($_GET['error'])): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>
    
    <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['success']); ?>
        </div>
    <?php endif; ?>
    
    <div class="actors-grid">
        <?php
        $num = $stmt->rowCount();
        if($num > 0) {
            echo "<p class='results-count'>Se encontraron {$num} actores</p>";
           
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                echo "<div class='actor-card'>";
                echo "<h3><a href='index.php?action=show&id={$actor_id}'>{$first_name} {$last_name}</a></h3>";
                echo "<p class='actor-id'>ID: {$actor_id}</p>";
                echo "<p class='last-update'>Actualizado: " . date('d/m/Y H:i', strtotime($last_update)) . "</p>";
                echo "<div class='card-actions'>";
                echo "<a href='index.php?action=show&id={$actor_id}' class='btn btn-info btn-sm'>Ver</a>";
                echo "<a href='index.php?action=edit&id={$actor_id}' class='btn btn-warning btn-sm'>Editar</a>";
                echo "<a href='index.php?action=delete&id={$actor_id}' class='btn btn-danger btn-sm' onclick='return confirm(\"¿Estás seguro de que deseas eliminar a {$first_name} {$last_name}?\")'>Eliminar</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-results'>";
            echo "<h3>No se encontraron actores</h3>";
            if(!empty($_GET['search'])) {
                echo "<p>No hay resultados para la búsqueda: <strong>" . htmlspecialchars($_GET['search']) . "</strong></p>";
            }
            echo "</div>";
        }
        ?>
    </div>
</div>

<style>
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

.alert-success {
    background-color: #efe;
    border-color: #cfc;
    color: #383;
}

.card-actions {
    margin-top: 10px;
    display: flex;
    gap: 8px;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 12px;
}

.btn-info {
    background-color: #17a2b8;
    color: white;
    border: 1px solid #17a2b8;
}

.btn-warning {
    background-color: #ffc107;
    color: #212529;
    border: 1px solid #ffc107;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: 1px solid #dc3545;
}

.btn-info:hover {
    background-color: #138496;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger:hover {
    background-color: #c82333;
}
</style>

<?php include_once '../views/layout/footer.php'; ?>