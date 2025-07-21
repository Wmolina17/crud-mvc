document.addEventListener("DOMContentLoaded", () => {

    function getCards() {
        return document.querySelectorAll('.card-producto');
    }

    let filtroActivo = "todos";

    function filtrarProductos(tipo) {
        filtroActivo = tipo;

        const ahora = new Date();
        const haceUnaSemana = new Date();
        haceUnaSemana.setDate(ahora.getDate() - 7);

        const cards = getCards();
        cards.forEach(card => {
            const activo = card.dataset.activo === "1";
            const fecha = new Date(card.dataset.fecha);
            const nombre = card.dataset.nombre.toLowerCase();

            let visible = true;

            if (tipo === "activos") visible = activo;
            else if (tipo === "inactivos") visible = !activo;
            else if (tipo === "semana") visible = fecha >= haceUnaSemana;
            else visible = true;

            card.style.display = visible ? "block" : "none";
        });

        document.querySelectorAll('.filtro-btn').forEach(btn => btn.classList.remove('active'));
        const btnActivo = document.querySelector(`.filtro-btn[data-filtro="${tipo}"]`);
        if (btnActivo) btnActivo.classList.add('active');
    }

    document.querySelectorAll('.filtro-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            filtrarProductos(btn.dataset.filtro);
        });
    });

    document.getElementById('buscador-nombre').addEventListener('input', (e) => {
        const texto = e.target.value.toLowerCase();
        const cards = getCards();

        cards.forEach(card => {
            const nombre = card.dataset.nombre.toLowerCase();
            card.style.display = nombre.includes(texto) ? "block" : "none";
        });

        document.querySelectorAll('.filtro-btn').forEach(btn => btn.classList.remove('active'));

        const btnTodos = document.querySelector('.filtro-btn[data-filtro="todos"]');
        if (btnTodos) btnTodos.classList.add('active');
    });

});