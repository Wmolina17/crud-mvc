<div class="cont-show">
    <h2>Detalles de producto</h2>
    <p><strong>Nombre</strong> <?= htmlspecialchars($producto['nombre']) ?></p>
    <p><strong>Precio</strong> $<?= number_format($producto['precio'], 2) ?></p>
    <p><strong>Descripción</strong><?= nl2br(htmlspecialchars($producto['descripcion'])) ?></p>

    <hr>
    <div class="acciones-form">
        <button class="btn-naranja" onclick="editarProducto(<?= $producto['id'] ?>)">Editar</button>
        <button class="btn-rojo" onclick="eliminarProducto(<?= $producto['id'] ?>)">Eliminar</button>
        <button class="btn-gris" onclick="cerrarModal()">Cerrar</button>
    </div>
</div>