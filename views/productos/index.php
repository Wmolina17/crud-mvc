<?php ob_start(); ?>

<div class="cont-all-info">
    <div class="flex-cont">
        <h1 class="titulo-principal">CRUD de Productos</h1>
        <button id="btn-crear">Nuevo Producto</button>
    </div>

    <?php if (empty($productos)): ?>
        <div class="mensaje-info">No hay productos. <a href="#" id="btn-crear-inline">Crear el primero</a></div>
    <?php else: ?>
        <div class="grid-productos">
            <?php foreach ($productos as $producto): ?>
                <div class="card-producto">
                    <div class="cont-img">
                        <img width="52" height="52" src="https://img.icons8.com/metro/52/product.png" alt="product" />
                    </div>
                    <div class="cont-info-card">
                        <div class="cont-info-desc">
                            <h3><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <p><?= htmlspecialchars(substr($producto['descripcion'], 0, 80)) ?>...</p>
                        </div>
                        <p class="precio"><small>$</small><?= number_format($producto['precio'], 2) ?></p>
                    </div>
                    <div class="acciones">
                        <button class="btn btn-azul" onclick="verProducto(<?= $producto['id'] ?>)">Detalles</button>
                        <button class="btn btn-naranja" onclick="editarProducto(<?= $producto['id'] ?>)">Editar</button>
                        <button class="btn btn-rojo" onclick="eliminarProducto(<?= $producto['id'] ?>)">Eliminar</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div id="modal-overlay" class="modal-overlay oculto">
        <div id="modal-contenido" class="modal-contenido">
            <button class="modal-cerrar" onclick="cerrarModal()">×</button>
            <div id="modal-body"></div>
        </div>
    </div>
</div>