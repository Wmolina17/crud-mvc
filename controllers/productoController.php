<?php
require_once __DIR__ . '/../models/Producto.php';

class ProductoController
{
    private $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    private function esModal()
    {
        return isset($_GET['modal']) && $_GET['modal'] == 1;
    }

    private function cargarVista($vista, $datos = [])
    {
        extract($datos);
        if ($this->esModal()) {
            include __DIR__ . '/../views/' . $vista . '.php';
        } else {
            ob_start();
            include __DIR__ . '/../views/' . $vista . '.php';
            $content = ob_get_clean();
            include __DIR__ . '/../views/layouts/main.php';
        }
    }

    private function obtenerEstadisticas()
    {
        $productos = $this->productoModel->obtenerTodos();
        $totalProductos = count($productos);
        $productosActivos = array_filter($productos, fn($p) => $p['activo'] == 1);
        $totalActivos = count($productosActivos);
        $unaSemanaAtras = date('Y-m-d', strtotime('-7 days'));
        $productosSemana = array_filter($productos, fn($p) => $p['created_at'] >= $unaSemanaAtras);
        $totalSemana = count($productosSemana);

        return [
            'totalProductos' => $totalProductos,
            'totalActivos' => $totalActivos,
            'totalSemana' => $totalSemana
        ];
    }

    public function index()
    {
        $productos = $this->productoModel->obtenerTodos();

        $this->cargarVista('productos/index', [
            'productos' => $productos,
            ...$this->obtenerEstadisticas()
        ]);
    }

    public function create()
    {
        ob_start();
        $this->cargarVista('productos/create');
        $html = ob_get_clean();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'html' => $html
        ]);
    }


    public function store()
    {
        $nombre = $_POST['nombre'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $activo = 1;

        $errores = [];
        if (empty($nombre))
            $errores[] = "El nombre es requerido";
        if (empty($precio) || !is_numeric($precio))
            $errores[] = "El precio debe ser un número";
        if (empty($descripcion))
            $errores[] = "La descripción es requerida";

        if (empty($errores)) {
            if ($this->productoModel->crear($nombre, $precio, $descripcion, $activo)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto creado exitosamente',
                    'estadisticas' => $this->obtenerEstadisticas()
                ]);
                return;
            } else {
                $errores[] = "Error al crear el producto";
            }
        }

        ob_start();
        $this->cargarVista('productos/create', [
            'errores' => $errores,
            'nombre' => $nombre,
            'precio' => $precio,
            'descripcion' => $descripcion,
            'activo' => $activo
        ]);
        $html = ob_get_clean();

        echo json_encode([
            'success' => false,
            'html' => $html
        ]);
    }

    public function show($id)
    {
        $producto = $this->productoModel->obtenerPorId($id);
        if (!$producto) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
            return;
        }

        ob_start();
        $this->cargarVista('productos/show', ['producto' => $producto]);
        $html = ob_get_clean();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'html' => $html
        ]);
    }

    public function edit($id)
    {
        $producto = $this->productoModel->obtenerPorId($id);
        if (!$producto) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
            return;
        }

        ob_start();
        $this->cargarVista('productos/edit', [
            'id' => $producto['id'],
            'nombre' => $producto['nombre'],
            'precio' => $producto['precio'],
            'descripcion' => $producto['descripcion'],
            'activo' => $producto['activo']
        ]);

        $html = ob_get_clean();

        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'html' => $html
        ]);
    }

    public function update($id)
    {
        $producto = $this->productoModel->obtenerPorId($id);
        if (!$producto) {
            echo json_encode([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
            return;
        }

        $nombre = $_POST['nombre'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $activo = isset($_POST['activo']) ? 1 : 0;

        $errores = [];
        if (empty($nombre))
            $errores[] = "El nombre es requerido";
        if (empty($precio) || !is_numeric($precio))
            $errores[] = "El precio debe ser un número";
        if (empty($descripcion))
            $errores[] = "La descripción es requerida";

        if (empty($errores)) {
            if ($this->productoModel->actualizar($id, $nombre, $precio, $descripcion, $activo)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => true,
                    'message' => 'Producto actualizado exitosamente',
                    'estadisticas' => $this->obtenerEstadisticas()
                ]);
                return;
            } else {
                $errores[] = "Error al actualizar el producto";
            }
        }

        ob_start();
        $this->cargarVista('productos/edit', [
            'producto' => $producto,
            'errores' => $errores,
            'nombre' => $nombre,
            'precio' => $precio,
            'descripcion' => $descripcion,
            'activo' => $activo
        ]);
        $html = ob_get_clean();

        echo json_encode([
            'success' => false,
            'html' => $html
        ]);
    }

    public function destroy($id)
    {
        if ($this->productoModel->eliminar($id)) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Producto eliminado exitosamente',
                'estadisticas' => $this->obtenerEstadisticas()
            ]);
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al eliminar el producto'
            ]);
        }
    }
}
?>