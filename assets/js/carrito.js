
    // Variables globales
    const btnAddcarrito = document.querySelectorAll(".btnAddcarrito");
    const btnCarrito = document.querySelector("#btnCantidadCarrito");
    const verCarrito = document.querySelector('#verCarrito');
    const tableListaCarrito = document.querySelector('#tableListaCarrito tbody');
    let listaCarrito;
    let productoSeleccionado;

    // Document Ready
    document.addEventListener("DOMContentLoaded", function () {
        if (localStorage.getItem("listaCarrito") != null) {
            listaCarrito = JSON.parse(localStorage.getItem("listaCarrito"));
        } else {
            listaCarrito = [];
        }

        for (let i = 0; i < btnAddcarrito.length; i++) {
            btnAddcarrito[i].addEventListener("click", function (e) {
                e.preventDefault();
                let idProducto = btnAddcarrito[i].getAttribute("prod");
                agregarCarrito(idProducto, 1);
            });
        }
        cantidadCarrito();

        verCarrito.addEventListener('click', function () {
            getListaCarrito();
            $('#modalCarrito').modal('show');
        });

        // Resto de tu código...
    });

    // Función para agregar productos al carrito
    function agregarCarrito(idProducto, cantidad) {
    let listaCarrito = localStorage.getItem("listaCarrito") ? JSON.parse(localStorage.getItem("listaCarrito")) : [];

    if (listaCarrito.some(item => item.idProducto === idProducto)) {
        alertaPerzanalizada("EL PRODUCTO YA ESTÁ AGREGADO", "warning");
        return;
    }

    listaCarrito.push({ idProducto, cantidad });
    localStorage.setItem("listaCarrito", JSON.stringify(listaCarrito));

    alertaPerzanalizada("PRODUCTO AGREGADO AL CARRITO", "success");
        cantidadCarrito();
				location.reload();

}


    // Función para obtener la cantidad de productos en el carrito
    function cantidadCarrito() {
        let listas = JSON.parse(localStorage.getItem("listaCarrito"));
        if (listas != null) {
            btnCarrito.textContent = listas.length;
        } else {
            btnCarrito.textContent = 0;
        }
    }

    // Función para ver el carrito
    function getListaCarrito() {
        const url = base_url + 'principal/listaProductos';
        const http = new XMLHttpRequest();
        http.open('POST', url, true);
        http.send(JSON.stringify(listaCarrito));
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                let html = '';
                res.productos.forEach(producto => {
                    html += `<tr>
                        <td>
                        <img class="img-thumbnail" src="${base_url + producto.imagen}" alt="" width="100">
                        </td>
                        <td>${producto.nombre}</td>
                        <td><span class="badge bg-warning">${res.moneda + ' ' + producto.precio}</span></td>
                        <td width="100">
                        <input type="number" class="form-control agregarCantidad" id="${producto.id}" value="${producto.cantidad}">
                        </td>
                        <td>${producto.subTotal}</td>
                        <td>
                        <button class="btn btn-danger btnDeletecart" type="button" prod="${producto.id}"><i class="fas fa-times-circle"></i></button>
                        </td>
                    </tr>`;
                });
                tableListaCarrito.innerHTML = html;
                document.querySelector('#totalGeneral').textContent = res.total;
                btnEliminarCarrito();
                cambiarCantidad();
            }
        }
    }

    // Función para eliminar productos del carrito
    function btnEliminarCarrito() {
        let listaEliminar = document.querySelectorAll('.btnDeletecart');
        for (let i = 0; i < listaEliminar.length; i++) {
            listaEliminar[i].addEventListener('click', function () {
                let idProducto = listaEliminar[i].getAttribute('prod');
                eliminarListaCarrito(idProducto);
            })
        }
    }

    // Función para eliminar un producto del carrito
    function eliminarListaCarrito(idProducto) {
        for (let i = 0; i < listaCarrito.length; i++) {
            if (listaCarrito[i]['idProducto'] == idProducto) {
                listaCarrito.splice(i, 1);
            }
        }
        localStorage.setItem('listaCarrito', JSON.stringify(listaCarrito));
        getListaCarrito();
        cantidadCarrito();
        alertaPerzanalizada("PRODUCTO ELIMINADO DEL CARRITO", "success");
    }

    // Función para cambiar la cantidad de productos en el carrito
    function cambiarCantidad() {
        let listaCantidad = document.querySelectorAll('.agregarCantidad');
        for (let i = 0; i < listaCantidad.length; i++) {
            listaCantidad[i].addEventListener('change', function () {
                let idProducto = listaCantidad[i].id;
                let cantidad = listaCantidad[i].value
                incrementarCantidad(idProducto, cantidad);
            })
        }
    }

    // Función para incrementar la cantidad de productos en el carrito
    function incrementarCantidad(idProducto, cantidad) {
        for (let i = 0; i < listaCarrito.length; i++) {
            if (listaCarrito[i]['idProducto'] == idProducto) {
                listaCarrito[i].cantidad = cantidad;
            }
        }
        localStorage.setItem('listaCarrito', JSON.stringify(listaCarrito));
    }

    // Función para mostrar el modal de personalización del producto
    function mostrarModalPersonalizar(productInfo) {
        var imgElement = new Image();
        imgElement.src = obtenerImagenProducto(productInfo.id);
        imgElement.onload = function () {
            $('#personalizarImagen').attr('src', imgElement.src);
        };

        $('#modalProductName').text(obtenerNombreProducto(productInfo.id));
        $('#modalProductPrice').text('Cantidad: ' + productInfo.cantidad);
    }

    // Función para obtener la ruta de la imagen del producto
    function obtenerImagenProducto(idProducto) {
        // Implementa la lógica para obtener la imagen del producto según su ID
        // Puedes utilizar AJAX, localStorage u otros métodos según tu implementación
        // Por ahora, simplemente devolvemos un valor de ejemplo
        return 'ruta_de_la_imagen_ejemplo.jpg';
    }

    // Función para obtener el nombre del producto
    function obtenerNombreProducto(idProducto) {
        // Implementa la lógica para obtener el nombre del producto según su ID
        // Por ahora, simplemente devolvemos un valor de ejemplo
        return 'Nombre del Producto Ejemplo';
    }

    // // Añadir evento de clic para el botón "Personalizar"
    $('.btnPersonalizar').click(function (e) {
        e.preventDefault();
        var productId = $(this).data('id');
        var productImage = $(this).data('imagen');
        var productName = $(this).data('nombre');
        var productPrice = $(this).data('precio');

        // Actualizar la información en el modal
        $('#personalizarImagen').attr('src', productImage);
        $('#modalProductName').text(productName);
        $('#modalProductPrice').text('Precio: $' + productPrice);

        // Mostrar el modal
        $('#personalizarModal').modal('show');

        // Listener para el botón "Añadir al Carrito" en el modal
        /**
         * @author Hacedor
         * Comento la funcion para evitar errores con las imagenes personalizadas
         */
        /* $('#btnAddToCartFromModal').on('click', function () {
            // Añadir el producto al carrito
            agregarCarrito(productId, 1);

            // Otras acciones si es necesario

            // Cerrar el modal después de añadir al carrito
            $('#personalizarModal').modal('hide');

        }); */
    });


    // Obtener el elemento select
    const selectIcon = document.getElementById('selectIcon');

    // Listener para el cambio en el select
    selectIcon.addEventListener('change', function () {
        // Obtener la ruta del icono seleccionado
        const selectedIcon = selectIcon.value;

        // Actualizar la imagen en el modal
        $('#personalizarImagen').attr('src', selectedIcon);
    });

    // Al cargar el documento
    $(document).ready(function () {
        // Listener para el cambio en el select
        $('#selectIcon').on('change', function () {
            // Obtener el valor seleccionado en el select
            const selectedIcon = $('#selectIcon').val();

            // Obtener la ruta de la imagen con un parámetro aleatorio para evitar la caché
            const selectedImagePath = `assets/images/imgmodal/${selectedIcon}?${Date.now()}`;

            console.log('Ruta de la imagen seleccionada:', selectedImagePath);

            // Actualizar la imagen en el modal
            $('#personalizarImagen').attr('src', selectedImagePath);
        });

        // Resto de tu código...





    });



