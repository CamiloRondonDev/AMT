<?php require_once 'header.php'; ?>

<section class="products-section">
    <h2>Productos Destacados</h2>

    <div class="search-container">
        <input type="text" id="search" placeholder="Buscar...">
        <button id="btnBuscar">Buscar</button>
    </div>

    <div class="sidebar">
           
                <div class="filter-category">
                    <h4>Tipo</h4>
                    <select>
                        <option value="todo">Todo</option>
                        <option value="tipo1">Bien</option>
                        <option value="tipo2">Servicio</option>
                    </select>
                </div>
                <div class="filter-category">
                    <h4>Categoría</h4>
                    <select>
                        <option value="categoria1">Categoría 1</option>
                        <option value="categoria2">Categoría 2</option>
                        <option value="categoria3">Categoría 3</option>
                    </select>
                </div>
                <div class="filter-category">
                    <h4>Rango de Precios</h4>
                    <input type="range" min="0" max="200000" value="100000">
                    <p>Hasta: $100,000</p>
                </div>
            </div>

<div id="productos-container">
    <?php if (!empty($productos)): ?>
        <?php foreach ($productos as $producto): ?>
            <div class="product-card">
                <img class="product-image" src="<?= htmlspecialchars($producto['img_prod']) ?>" alt="<?= htmlspecialchars($producto['fabrica_prod']) ?>">
                <div class="product-info">
                    <h3><?= htmlspecialchars($producto['nom_prod']) ?></h3>
                    <p><?= htmlspecialchars($producto['desc_prod']) ?></p>
                    <p class="price">$<?= htmlspecialchars($producto['precio_prod']) ?></p>
                    <a href="products.php?id=<?= htmlspecialchars($producto['id_prod']) ?>" class="button">Ver Producto</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay productos disponibles.</p>
    <?php endif; ?>
</div>
</section>

<?php require_once 'footer.php'; ?>

<!-- Cargar jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Enlace a tu script JS -->
<script src="../../public/js/home.js"></script>
