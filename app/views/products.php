<?php require_once 'header.php'; ?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/amt/public/css/productstyle.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
</head>

<div class="container">
    <div class="product">
        <div>
            <img src="" alt="Imagen del Producto" id="productImage">
        </div>
        <div class="product-info">
            <h1 id="productName">Cargando...</h1>
            <p><strong>Fábrica:</strong> <span id="productFactory">Cargando...</span></p>
            <p><strong>Descripción:</strong> <span id="productDescription">Cargando...</span></p>
            <p><strong>Disponibilidad:</strong> <span id="productAvailability">Cargando...</span></p>
            <p><strong>Tipo:</strong> <span id="productType">Cargando...</span></p>
            <p><strong>Categoría:</strong> <span id="productCategory">Cargando...</span></p>
            <p><strong>Red Social:</strong> <a href="#" id="productSocial">Cargando...</a></p>
            <p><strong>Observaciones:</strong> <span id="productObservations">Cargando...</span></p>
            <p class="price" id="productPrice">Cargando...</p>
    
            <div class="contact-info">
                <p><strong>Vendedor:</strong> <span id="sellerName">Cargando...</span></p>
                <p><strong>Contacto:</strong> <span id="sellerContact">Cargando...</span></p>
                <p><strong>Correo:</strong> <span id="sellerEmail">Cargando...</span></p>
            </div>
    
            <a href="#" id="buyButton" class="buy-button">Comprar Ahora</a>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/products.js"></script>
