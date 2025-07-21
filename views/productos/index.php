<?php ob_start(); ?>

<div class="cont-all-info">
    <h1 class="titulo-principal">Dashboard De Productos</h1>
    <div class="estadisticas-productos">
        <div class="card-estadistica total">
            <div class="cont-left">
                <h4>Productos Totales</h4>
                <p id="total-productos"><?= $totalProductos ?></p>
            </div>
            <img width="40" height="40" src="https://img.icons8.com/material-sharp/48/007bff/bill.png" alt="bill" />
        </div>
        <div class="card-estadistica activos">
            <div class="cont-left">
                <h4>Productos Activos</h4>
                <p id="total-activos"><?= $totalActivos ?></p>
            </div>
            <img width="38" height="38" src="https://img.icons8.com/fluency-systems-filled/48/28a745/ok--v1.png"
                alt="ok--v1" />
        </div>
        <div class="card-estadistica semana">
            <div class="cont-left">
                <h4>Productos Creados Esta Semana</h4>
                <p id="total-semana"><?= $totalSemana ?></p>
            </div>
            <img width="35" height="35" src="https://img.icons8.com/ios-filled/50/ffc107/calendar.png" alt="calendar" />
        </div>
    </div>

    <hr>

    <div class="flex-cont">
        <h2>Lista De Productos</h2>
        <button id="btn-crear">
            <img width="20" height="20" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/plus-math.png"
                alt="plus-math" />
            Nuevo Producto
        </button>
    </div>

    <div class="filtros-productos">
        <button class="filtro-btn" data-filtro="todos">Todos</button>
        <button class="filtro-btn" data-filtro="activos">Activos</button>
        <button class="filtro-btn" data-filtro="inactivos">Inactivos</button>
        <button class="filtro-btn" data-filtro="semana">Creados Esta Semana</button>

        <input type="text" id="buscador-nombre" placeholder="Buscar por nombre...">
    </div>

    <?php if (empty($productos)): ?>
        <div class="mensaje-info">
            <img width="45" height="45" src="https://img.icons8.com/ios-glyphs/60/sad.png" alt="sad" />
            No hay productos.
            <a href="#" id="btn-crear-inline">
                <img width="20" height="20" src="https://img.icons8.com/ios-glyphs/30/FFFFFF/plus-math.png"
                    alt="plus-math" />
                Crear el primero
            </a>
        </div>
    <?php else: ?>
        <div class="grid-productos">
            <?php foreach ($productos as $producto): ?>
                <div class="card-producto" data-activo="<?= $producto['activo'] ?>" data-fecha="<?= $producto['created_at'] ?>"
                    data-nombre="<?= strtolower($producto['nombre']) ?>">
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