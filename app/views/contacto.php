<link rel="stylesheet" href="/amt/public/css/contacto.css">

<?php require_once 'header.php'; ?>

<div class="contacto-fondo">
    <h2 class="titulo-contacto">CONTACTO</h2>
    <section class="info-contacto">
        <div class="info-box">
            <i class="fas fa-phone-alt"></i>
            <h3>Líneas de atención</h3>
            <p class="detalle">+57 3026040049<br>+57 3153056706</p>
        </div>
        <div class="info-box">
            <i class="fas fa-map-marker-alt"></i>
            <h3>¿Dónde estamos?</h3>
            <p class="detalle">Carrera 32 #36-29 Local 101A <br>Bucaramanga (Santander)</p>
        </div>
        <div class="info-box">
            <i class="fas fa-envelope"></i>
            <h3>Email</h3>
            <p class="detalle">info@ramedicas.com</p>
        </div>
    </section>
</div>


<section class="preguntas-frecuentes">
    <h2 class="titulo-preguntas">Preguntas Frecuentes</h2>
    <div class="faq">
        <div class="pregunta">
            <h3>¿Cuál es el horario de atención?</h3>
            <p>Atendemos de lunes a viernes de 8:00 a.m. a 5:30 p.m. y sábados de 8:00 a.m. a 1:00 p.m.</p>
        </div>
        <div class="pregunta">
            <h3>¿Hacen envíos a otras ciudades?</h3>
            <p>Sí, realizamos envíos a nivel nacional a través de empresas transportadoras confiables.</p>
        </div>
        <div class="pregunta">
            <h3>¿Puedo solicitar cotización por correo?</h3>
            <p>Claro, puedes escribirnos a info@ramedicas.com y te responderemos en el menor tiempo posible.</p>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const infoContacto = document.querySelector('.info-contacto');
    const offsetToCollapse = 200; // Puedes ajustar esto

    window.addEventListener('scroll', function () {
        const scrollY = window.scrollY;

        if (scrollY > offsetToCollapse) {
            infoContacto.classList.add('colapsado');
        } else {
            infoContacto.classList.remove('colapsado');
        }
    });
});
</script>


<?php require_once 'footer.php'; ?>
