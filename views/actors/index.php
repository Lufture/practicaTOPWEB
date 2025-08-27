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

<?php include_once '../views/layout/footer.php'; ?>