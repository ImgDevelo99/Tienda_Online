<?php
class Principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    //obtener producto a partir de la lista de carrito
    public function listaProductos()
    {
        $datos = file_get_contents('php://input');
        $json = json_decode($datos, true);
        $array['productos'] = array();
        $total = 0.00;
        if (!empty($json)) {
            foreach ($json as $producto) {
                $result = $this->model->getProducto($producto['idProducto']);
                $subTotal = $result['precio'] * $producto['cantidad'];
                $data = [
                    'id' => $producto['idProducto'] ? $producto['idProducto'] : $result['id'],
                    'nombre' => isset($producto['productName']) ? $producto['productName'] : $result['nombre'],
                    'imagen' => isset($producto['imagen']) ? $producto['imagen'] : $result['imagen'],
                    'precio' => $result['precio'],
                    'cantidad' => $producto['cantidad'],
                    'subTotal' => number_format($subTotal, 2)

                ];
                $total += $subTotal;
                array_push($array['productos'], $data);
            }
        }
        $array['total'] = number_format($total, 2);
        $array['totalPaypal'] = number_format($total, 2, '.', '');
        $array['moneda'] = MONEDA;
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function busqueda($valor)
    {
        $data = $this->model->getBusqueda($valor);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
