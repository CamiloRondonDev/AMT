<?php require_once 'header.php'; ?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/amt/public/css/productstyle.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
</head>

<div class="container">

    <div class="product">
           
    <div class="product-image">

        <!-- esta fue la linea que cambie sebastian -->
        <!-- <img src="" alt="Imagen del Producto" id="productImage"> -->
        <div id="mediaGallery" style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;"></div>
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

<!-- Modal de imagen -->
<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<?php require_once 'footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../../public/js/products.js"></script>

<script>
  // Modal de imagen
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImage");
  const productImg = document.getElementById("productImage");

  if (productImg) {
    productImg.onclick = function () {
      modal.style.display = "block";
      modalImg.src = this.src;
    };
  }

  const closeBtn = document.querySelector(".close");
  if (closeBtn) {
    closeBtn.onclick = function () {
      modal.style.display = "none";
    };
  }
</script>