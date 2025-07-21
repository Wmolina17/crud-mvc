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

    <form method="POST" action="/crud-mvc/public/productos/<?= $id ?>/update">
        <label>Nombre</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>

        <label>Precio</label>
        <input type="number" step="0.01" name="precio" value="<?= htmlspecialchars($precio) ?>"
            required>

        <label>Descripción</label>
        <textarea name="descripcion"
            required><?= htmlspecialchars($descripcion) ?></textarea>

        <div class="switch-wrapper">
            <label class="switch-title">Activo</label>
            <label class="switch">
                <input type="checkbox" name="activo" class="checkbox-input" <?= (isset($activo) && $activo == 1) ? 'checked' : '' ?>>
                <span class="slider"></span>
            </label>
        </div>

        <div class="acciones-form">
            <button type="submit" class="btn btn-naranja">Actualizar</button>
            <button type="button" class="btn btn-gris" onclick="cerrarModal()">Cancelar</button>
        </div>
    </form>
</div>

<script>
    const activoDesdePHP = <?= json_encode($activo ?? null) ?>;
    console.log("Valor de 'activo' desde PHP:", activoDesdePHP);
</script>