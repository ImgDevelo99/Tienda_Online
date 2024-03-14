<?php
// detalle_producto.php

// Incluir tus configuraciones y funciones necesarias (puede variar según tu estructura)
// ...

// Obtener el ID del producto desde el parámetro en la URL
$productId = isset($_GET['id']) ? $_GET['id'] : null;
$personalizar = isset($_GET['personalizar']) ? $_GET['personalizar'] : null;

// Simulación de obtención de detalles del producto desde una base de datos
$productos = [
    1 => ["nombre" => "Producto 1", "descripcion" => "Descripción del Producto 1", "tamaño" => "Grande"],
    2 => ["nombre" => "Producto 2", "descripcion" => "Descripción del Producto 2", "tamaño" => "Pequeño"],
];

// Verificar si el ID del producto es válido
if ($productId && array_key_exists($productId, $productos)) {
    $producto = $productos[$productId];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Agregar tus meta tags, links a estilos, scripts, etc. según sea necesario -->
        <title>Detalles del Producto</title>
    </head>

    <body>
        <h1><?php echo $producto['nombre']; ?></h1>
        <p><?php echo $producto['descripcion']; ?></p>

        <!-- Mostrar detalles adicionales si se está personalizando -->
        <?php
        if ($personalizar) {
            echo "<p>Tamaño: " . $producto['tamaño'] . "</p>";
            // Puedes agregar más detalles de personalización según sea necesario
        }
        ?>

        <!-- Puedes incluir estilos y scripts adicionales si es necesario -->

    </body>

    </html>
<?php
} else {
    // Manejar el caso en que el ID del producto no es válido
    echo "Producto no encontrado.";
}
?>
