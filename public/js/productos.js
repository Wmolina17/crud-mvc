function abrirModal() {
    document.getElementById('modal-overlay').classList.remove('oculto');
}

function cerrarModal() {
    document.getElementById('modal-overlay').classList.add('oculto');
    document.getElementById('modal-body').innerHTML = '';
}

function cargarEnModal(url) {
    fetch(url)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('modal-body').innerHTML = data.html;
                abrirModal();
                vincularSubmitModal();
            } else {
                showToast("Error al cargar el formulario", "error");
            }
        })
        .catch((error) => {
            console.error(error)
            showToast("Error en la respuesta del servidor", "error");
        });
}

function verProducto(id) {
    cargarEnModal(`/crud-mvc/public/productos/${id}?modal=1`);
}

function editarProducto(id) {
    cargarEnModal(`/crud-mvc/public/productos/${id}/edit?modal=1`);
}

function eliminarProducto(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: 'Este producto será eliminado permanentemente.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/crud-mvc/public/productos/${id}/delete`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showToast(data.message);

                        if (data.estadisticas) {
                            document.getElementById('total-productos').textContent = data.estadisticas.totalProductos;
                            document.getElementById('total-activos').textContent = data.estadisticas.totalActivos;
                            document.getElementById('total-semana').textContent = data.estadisticas.totalSemana;
                        }

                        actualizarGridProductos();
                    } else {
                        showToast(data.message, "error");
                    }
                });
        }
    });
}

function enviarFormulario(e) {
    e.preventDefault();
    const form = e.target;
    const url = form.action || window.location.href;
    const method = form.method.toUpperCase();
    const formData = new FormData(form);

    fetch(url, {
        method,
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(async res => {
            const contentType = res.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return await res.json();
            } else {
                throw new Error("Respuesta no válida");
            }
        })
        .then(data => {
            if (data.success) {
                cerrarModal();
                showToast(data.message)

                if (data.estadisticas) {
                    document.getElementById('total-productos').textContent = data.estadisticas.totalProductos;
                    document.getElementById('total-activos').textContent = data.estadisticas.totalActivos;
                    document.getElementById('total-semana').textContent = data.estadisticas.totalSemana;
                }
                
                actualizarGridProductos();
            } else {
                document.getElementById('modal-body').innerHTML = data.html;
                vincularSubmitModal();
            }
        })
        .catch(() => {
            showToast("Error al procesar el formulario", "error");
        });
}

function vincularSubmitModal() {
    const form = document.querySelector('#modal-body form');
    if (form) form.addEventListener('submit', enviarFormulario);
}

document.querySelector('#form-producto')?.addEventListener('submit', enviarFormulario);

function actualizarGridProductos() {
    fetch('/crud-mvc/public/productos')
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const nuevaGrid = doc.querySelector('.grid-productos');
            const mensajeVacio = doc.querySelector('.mensaje-info');
            const gridActual = document.querySelector('.grid-productos');
            const mensajeActual = document.querySelector('.mensaje-info');

            if (nuevaGrid) {
                if (gridActual) {
                    gridActual.innerHTML = nuevaGrid.innerHTML;
                } else {
                    document.querySelector('.cont-all-info').insertAdjacentElement('beforeend', nuevaGrid);
                    if (mensajeActual) mensajeActual.remove();
                }
            } else if (mensajeVacio) {
                if (gridActual) gridActual.remove();
                if (!mensajeActual) {
                    document.querySelector('.cont-all-info').insertAdjacentElement('beforeend', mensajeVacio);
                }
            }
        });
}

document.getElementById('btn-crear')?.addEventListener('click', () => {
    cargarEnModal('/crud-mvc/public/productos/create?modal=1');
});

document.getElementById('btn-crear-inline')?.addEventListener('click', (e) => {
    e.preventDefault();
    cargarEnModal('/crud-mvc/public/productos/create?modal=1');
});

function showToast(message, type = "success") {
    Toastify({
        text: message,
        duration: 3500,
        gravity: "top",
        position: "right",
        backgroundColor: type === "success" ? "#28a745" : "#dc3545",
        stopOnFocus: true
    }).showToast();
}

const productosOriginales = [...document.querySelectorAll('.card-producto')];

function filtrarProductos(tipo) {
    const ahora = new Date();
    const haceUnaSemana = new Date();
    haceUnaSemana.setDate(ahora.getDate() - 7);

    productosOriginales.forEach(card => {
        const activo = card.dataset.activo === "1";
        const fecha = new Date(card.dataset.fecha);
        const nombre = card.dataset.nombre.toLowerCase();

        let visible = true;

        if (tipo === "activos") visible = activo;
        else if (tipo === "inactivos") visible = !activo;
        else if (tipo === "semana") visible = fecha >= haceUnaSemana;

        card.style.display = visible ? "block" : "none";
    });

    document.querySelectorAll('.filtro-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`.filtro-btn[data-filtro="${tipo}"]`).classList.add('active');
}

document.querySelectorAll('.filtro-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        filtrarProductos(btn.dataset.filtro);
    });
});

document.getElementById('buscador-nombre').addEventListener('input', (e) => {
    const texto = e.target.value.toLowerCase();
    productosOriginales.forEach(card => {
        const nombre = card.dataset.nombre.toLowerCase();
        card.style.display = nombre.includes(texto) ? "block" : "none";
    });
});
