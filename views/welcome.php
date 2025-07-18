<?php ob_start(); ?>
<h1>Bienvenido al sistema CRUD MVC</h1>
<p>Usa el menú para comenzar a administrar tus productos.</p>
<?php 
$content = ob_get_clean();
include __DIR__ . '/layouts/main.php';
?>
