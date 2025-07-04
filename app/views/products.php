<?php require_once 'header.php'; ?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/amt/public/css/productstyle.css?v=<?php echo time(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Producto</title>
</head>

<div class="container">

    <div class="product">

           <!-- MINIATURAS A LA IZQUIERDA -->
    <div class="thumbnail-list" id="thumbnailList">
      <!-- Las miniaturas se llenarán con JS -->
    </div>


    <div class="product-image">

 
    <div class="main-image-container">
        <!-- <button class="arrow left" onclick="prevSlide()">&#10094;</button> -->
        <img id="carouselImage" src="" alt="Imagen del producto" />
        <!-- <button class="arrow right" onclick="nextSlide()">&#10095;</button> -->
        <div class="zoom-lens" id="zoomLens"></div>
        <div class="zoom-result" id="zoomResult"></div>
    </div>
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

<script>
  let images = [];
let currentIndex = 0;
const carouselImage = document.getElementById("carouselImage");

function setGalleryImageArray(imageList) {
    images = imageList;
    currentIndex = 0;
    showSlide(0);
}

function showSlide(index) {
    if (images.length === 0) return;
    currentIndex = (index + images.length) % images.length;
    carouselImage.src = images[currentIndex];
}

function nextSlide() {
    showSlide(currentIndex + 1);
}

function prevSlide() {
    showSlide(currentIndex - 1);
}

</script>


<script>
  function setGalleryImageArray(imageList) {
    images = imageList;
    currentIndex = 0;
    showSlide(0);
    renderThumbnails();
}

function renderThumbnails() {
    const thumbnailContainer = document.getElementById("thumbnailList");
    thumbnailContainer.innerHTML = "";

    images.forEach((src, index) => {
        const img = document.createElement("img");
        img.src = src;
        img.className = "thumbnail";
        img.onmouseenter = () => showSlide(index); // 👈 cambio de onclick a onmouseenter
        thumbnailContainer.appendChild(img);
    });
}
</script>  

<script>
const image = document.getElementById("carouselImage");
const zoomResult = document.getElementById("zoomResult");
const zoomLens = document.getElementById("zoomLens");

image.addEventListener("mousemove", moveZoom);
image.addEventListener("mouseenter", showZoom);
image.addEventListener("mouseleave", hideZoom);

function showZoom() {
  zoomResult.style.display = "block";
  zoomLens.style.display = "block";
  zoomResult.style.backgroundImage = `url('${image.src}')`;

  // ✅ Ajustar background-size dinámicamente según el tamaño real de la imagen (zoom 3x)
  zoomResult.style.backgroundSize = `${image.naturalWidth * 3}px ${image.naturalHeight * 3}px`;
}

function hideZoom() {
  zoomResult.style.display = "none";
  zoomLens.style.display = "none";
}

function moveZoom(e) {
  const rect = image.getBoundingClientRect();
  const lensWidth = zoomLens.offsetWidth;
  const lensHeight = zoomLens.offsetHeight;

  let x = e.clientX - rect.left - lensWidth / 2;
  let y = e.clientY - rect.top - lensHeight / 2;

  // Limitar el movimiento de la lupa dentro de la imagen
  x = Math.max(0, Math.min(x, rect.width - lensWidth));
  y = Math.max(0, Math.min(y, rect.height - lensHeight));

  // Posicionar la lupa relativa al contenedor
  zoomLens.style.left = `${x}px`;
  zoomLens.style.top = `${y}px`;

  // Calcular relación entre imagen visible y tamaño real
  const fx = (image.naturalWidth * 3) / rect.width;
  const fy = (image.naturalHeight * 3) / rect.height;

  // Mover el fondo del zoom
  zoomResult.style.backgroundPosition = `-${x * fx}px -${y * fy}px`;

  // Asegurarse que zoomResult no se salga fuera del viewport
  const zoomRect = zoomResult.getBoundingClientRect();
  const containerRect = image.getBoundingClientRect();
  const viewportWidth = window.innerWidth;

  if (containerRect.right + zoomResult.offsetWidth + 20 > viewportWidth) {
    zoomResult.style.left = `auto`;
    zoomResult.style.right = `calc(100% + 20px)`;
  } else {
    zoomResult.style.left = `calc(100% + 20px)`;
    zoomResult.style.right = `auto`;
  }
}
</script>
