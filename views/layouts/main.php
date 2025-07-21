<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD MVC - Productos</title>
    <link rel="stylesheet" href="/crud-mvc/public/css/style.css?v=<?= time() ?>">
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

    <div class="main-container">
        <?php echo $content ?? ''; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="/crud-mvc/public/js/productos.js?v=<?= time() ?>"></script>
    <script src="/crud-mvc/public/js/filtros.js?v=<?= time() ?>"></script>
</body>

</html>