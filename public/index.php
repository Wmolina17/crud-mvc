<?php
session_start();
require_once __DIR__ . '/../controllers/ProductoController.php';

function esAjax() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
}

$controller = new ProductoController();

$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$path = parse_url($url, PHP_URL_PATH);
$segments = explode('/', trim($path, '/'));

if (!empty($segments) && $segments[0] === 'crud-mvc') {
    array_shift($segments);
    if (!empty($segments) && $segments[0] === 'public') {
        array_shift($segments);
    }
}

if (!empty($segments[0]) && $segments[0] === 'productos') {
    $id = isset($segments[1]) && is_numeric($segments[1]) ? (int)$segments[1] : null;

    if (count($segments) === 1 || empty($segments[1])) {
        if ($method === 'GET') {
            $controller->index();
        } elseif ($method === 'POST') {
            $controller->store();
        }
    } elseif ($segments[1] === 'create') {
        $controller->create();
    } elseif ($id && isset($segments[2])) {
        switch ($segments[2]) {
            case 'edit':
                $controller->edit($id);
                break;
            case 'update':
                if ($method === 'POST') {
                    $controller->update($id);
                } else {
                    http_response_code(405);
                }
                break;
            case 'delete':
                if ($method === 'POST') {
                    $controller->destroy($id);
                } else {
                    http_response_code(405);
                }
                break;
            default:
                http_response_code(404);
                echo "Página no encontrada";
                break;
        }
    } elseif ($id) {
        $controller->show($id);
    } else {
        http_response_code(404);
        echo "Página no encontrada";
    }
} else {
    http_response_code(404);
    echo "Página no encontrada";
}
