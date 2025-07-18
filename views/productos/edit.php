<div class="cont-edit">
    <h2>Editar Producto</h2>

    <?php if (!empty($errores)): ?>
        <div class="alerta-roja">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/crud-mvc/public/productos/<?= $producto['id'] ?>/update">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre ?? $producto['nombre']) ?>" required>

        <label>Precio</label>
        <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($precio ?? $producto['precio']) ?>"
            required>

        <label>Descripción</label>
        <textarea name="descripcion"
            required><?= htmlspecialchars($descripcion ?? $producto['descripcion']) ?></textarea>

        <div class="acciones-form">
            <button type="submit" class="btn btn-naranja">Actualizar</button>
            <button type="button" class="btn btn-gris" onclick="cerrarModal()">Cancelar</button>
        </div>
    </form>

</div>