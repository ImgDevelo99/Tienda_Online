<?php include_once 'Views/template/header-principal.php'; ?>
<link rel="stylesheet" href="ruta/a/select2.min.css">


<!-- banner section start -->
<div class="banner_section layout_padding">
    <div class="container">
        <div id="my_slider" class="carousel slide" data-ride="carousel">
            <!-- ... (código del banner) ... -->
        </div>
    </div>
</div>
<!-- banner section end -->

</div>
<!-- banner bg main end -->

<!-- fashion section start -->
<div class="banner_section layout_padding">
    <!-- ... Tu código existente ... -->
</div>
<!-- banner section end -->
<?php
$category_id;
$producy_watched;
?>
<!-- fashion section start -->
<?php foreach ($data['categorias'] as $categoria) { ?>
    <div class="fashion_section">
        <div class="container" id="categoria_<?php echo $categoria['id']; ?>">
            <h1 class="fashion_taital text-uppercase"><?php echo $categoria['categoria']; ?></h1>
            <div class="row <?php echo (count($categoria['productos']) > 0) ? 'multiple-items' : ''; ?>">
                <?php foreach ($categoria['productos'] as $producto) { ?>
                    <div class="<?php echo (count($categoria['productos']) > 2) ? 'col-lg-4' : 'col-lg-12'; ?>">
                        <div class="box_main">
                            <h4 class="shirt_text"><?php echo $producto['nombre']; ?></h4>
                            <p class="price_text">Precio <span style="color: #262626;">$ <?php echo $producto['precio']; ?></span></p>
                            <div class="text-center">
                                <img data-lazy="<?php echo BASE_URL . $producto['imagen'];
                                                $producy_watched = $producto['imagen'];  ?>" />
                            </div>
                            <div class="btn_main">
                                <div class="buy_bt">
                                    <a href="#" class="btnAddcarrito" prod="<?php echo $producto['id']; ?>">Añadir</a>
                                </div>
                                <!-- Modificación del enlace para "Personalizar" -->
                                <div class="buy_bt">
                                    <!-- <a href="#" class="btnPersonalizar" data-id="<?php echo $producto['id']; ?>" data-imagen="<?php echo BASE_URL . $producto['imagen']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-precio="<?php echo $producto['precio']; ?>">Personalizar</a> -->
                                    <div class="buy_bt">
                                        <a href="#" class="btnPersonalizar" data-id="<?php echo $producto['id']; ?>" data-categoria="<?php echo $category_id = $categoria['id']; ?>" data-imagen="<?php echo BASE_URL . $producto['imagen']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-precio="<?php echo $producto['precio']; ?>">Personalizar</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>

<!-- fashion section start -->

<style>
    .resaltado {
        color: #ff5733;
        /* Cambia el color según tus preferencias */
        font-weight: bold;
        text-align: center;
        font-size: 20px;
    }

    .miniatura {
        cursor: pointer;
        /* Cambia el cursor al pasar sobre las miniaturas */
    }
</style>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="personalizarModal" tabindex="-1" role="dialog" aria-labelledby="personalizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title resaltado" id="personalizarModalLabel">Personalizar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column-reverse align-items-center">
                    <div class="miniaturas-container">

                    </div>
                    <div class="imagen-principal mt-3">
                        <img id="personalizarImagen" class="img-fluid resaltado" style="width: 250px; height: 300px;" src="" alt="Producto a Personalizar">
                    </div>
                </div>
                <!-- Mostrar información del producto en el modal -->
                <h4 id="modalProductName" class="mt-3 resaltado"></h4>
                <p id="modalProductPrice" class="resaltado"></p>
                <!-- Botón "Añadir al Carrito" en el modal -->
                <div class="text-center">
                    <a href="#" id="btnAddToCartFromModal" class="btn btn-primary" data-product-id="<?php echo $productId; ?>" data-product-name="<?php echo $productName; ?>" onclick="anadirPersonalizadoAlcarrito(event)">Añadir al Carrito</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    function cambiarImagen(selectedImage) {
        var imgElement = new Image();
        imgElement.src = selectedImage;
        imgElement.onload = function() {
            if (imgElement.complete) {
                $('#personalizarImagen').attr('src', imgElement.src);
            }
        };
    }

    /**
     * @author Hacedor
     * Guarda el id del producto junto a la foto personalizada
     */
    let imagenSeleccionada = null;

    function seleccionarImgPersonalizada(imgId) {
        imagenSeleccionada = imgId;
    }

    function anadirPersonalizadoAlcarrito(event) {
        event.preventDefault();
        const productId = event.target.dataset.productId;
        const productName = event.target.dataset.productName;

        if (imagenSeleccionada) {
            const producto = {
                idProducto: productId,
                productName: productName,
                imagen: imagenSeleccionada,
                cantidad: 1,
            };

            const listaCarrito = localStorage.getItem("listaCarrito") ? JSON.parse(localStorage.getItem("listaCarrito")) : [];
            listaCarrito.push(producto);
            localStorage.setItem("listaCarrito", JSON.stringify(listaCarrito));
            location.reload();
        }
    }
</script>



<?php include_once 'Views/template/footer-principal.php'; ?>
<script>
    $('.multiple-items').slick({
        lazyLoad: 'ondemand',
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
</script>
<script>
    // Añadir evento de clic para el botón "Personalizar"
    $('.btnPersonalizar').click(function(e) {
        e.preventDefault();
        var productId = $(this).data('id');
        var categoryId = $(this).data('categoria');
        var productImage = $(this).data('imagen');
        var productName = $(this).data('nombre');
        var productPrice = $(this).data('precio');

        $('#btnAddToCartFromModal').attr('data-product-id', productId);
        $('#btnAddToCartFromModal').attr('data-product-name', productName);
        // Obtener los datos de la categoría seleccionada
        var currentCategory = <?php echo json_encode($data['categorias']); ?>;
        currentCategory.forEach(function(categoria) {
            if (categoria.id == categoryId) {
                var categoryProducts = categoria.productos;
                categoryProducts.forEach(function(producto) {
                    if (producto.id == productId) {
                        // Actualizar la información en el modal
                        $('#personalizarContenido').html(`
                        <img class="img-fluid" src="${productImage}" alt="Producto a Personalizar">
                        <h2>${productName}</h2>
                        <p>Categoría: ${categoria.categoria}</p>
                        <p>Precio: $${productPrice}</p>
                        <div class="miniaturas-container">
                        </div>
                        <!-- Agrega aquí los campos de personalización si es necesario -->
                    `);

                        // Crear las miniaturas
                        for (let i = 0; i < 10; i++) {
                            const producy_watched = "assets/images/productos/" + categoria.categoria + '/logo ' + (i + 1);
                            const img = document.createElement('img');
                            img.setAttribute('data-categoria', categoria.id);
                            img.setAttribute('src', producy_watched + '/0.png');
                            img.setAttribute('alt', 'Icono');
                            img.setAttribute('class', 'miniatura');
                            img.setAttribute('style', 'width: 50px; height: 50px;');
                            img.setAttribute('onclick', `cambiarImagen('${producy_watched}/${producto.id}.jpg'); seleccionarImgPersonalizada('${producy_watched}/${producto.id}.jpg');`);

                            // Agregar la imagen al contenedor de miniaturas
                            const miniaturasContainer = document.querySelector('.miniaturas-container');
                            miniaturasContainer.appendChild(img);
                        }
                    }
                });
                // Mostrar el modal
                $('#personalizarModal').modal('show');
            }
        });
    });
</script>
<!-- Scripts de jQuery y Bootstrap -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="ruta/a/jquery.min.js"></script>
<script src="ruta/a/select2.min.js"></script>

</body>

</html>
