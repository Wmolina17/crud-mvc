<div class="cont-create">
    <h2>Crear Producto</h2>

    <?php if (!empty($errores)): ?>
        <div class="alerta-roja">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/crud-mvc/public/productos/<?= $producto['id'] ?>/create">
        <label>Nombre</label>
        <input type="text" name="nombre" placeholder="escriba aqui el nombre del producto"
            value="<?= htmlspecialchars($nombre ?? '') ?>" required>

        <label>Precio</label>
        <input type="number" step="0.01" name="precio" placeholder="escriba aqui el precio del producto"
            value="<?= htmlspecialchars($precio ?? '') ?>" required>

        <label>Descripción</label>
        <textarea name="descripcion" placeholder="escriba aqui la descripcion del producto"
            required><?= htmlspecialchars($descripcion ?? '') ?></textarea>

        <div class="acciones-form">
            <button type="submit" class="btn btn-verde">Guardar</button>
            <button type="button" class="btn btn-gris" onclick="cerrarModal()">Cancelar</button>
        </div>
    </form>
</div>