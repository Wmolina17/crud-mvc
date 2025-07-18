<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD MVC - Productos</title>
    <link rel="stylesheet" href="/crud-mvc/public/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body>
    <nav class="custom-navbar">
        <div class="navbar-container">
            <a class="navbar-logo" href="/crud-mvc/public/productos">
                <img src="/crud-mvc/public/img/laodcom.png" alt="Logo">
            </a>
        </div>
    </nav>

    <div id="toast-container" class="toast-container"></div>

    <div class="main-container">
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success">Producto creado exitosamente</div>
        <?php elseif (isset($_GET['updated'])): ?>
            <div class="alert success">Producto actualizado exitosamente</div>
        <?php elseif (isset($_GET['deleted'])): ?>
            <div class="alert success">Producto eliminado exitosamente</div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert error">Error en la operación</div>
        <?php endif; ?>

        <?php echo $content ?? ''; ?>
    </div>

    <script src="/crud-mvc/public/js/productos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

</html>