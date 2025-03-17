document.addEventListener("DOMContentLoaded", function () {
    // Alternância entre máquinas e equipamentos
    const btnMaquinas = document.getElementById("btn-maquinas");
    const btnEquipamentos = document.getElementById("btn-equipamentos");
    const contentMaquinas = document.getElementById("content-maquinas");
    const contentEquipamentos = document.getElementById("content-equipamentos");

    btnMaquinas.addEventListener("click", function () {
        contentMaquinas.style.display = "block";
        contentEquipamentos.style.display = "none";
        btnMaquinas.classList.add("active");
        btnMaquinas.classList.remove("btn-outline-primary");
        btnMaquinas.classList.add("btn-primary");
        btnEquipamentos.classList.remove("active");
        btnEquipamentos.classList.remove("btn-primary");
        btnEquipamentos.classList.add("btn-outline-primary");
    });

    btnEquipamentos.addEventListener("click", function () {
        contentMaquinas.style.display = "none";
        contentEquipamentos.style.display = "block";
        btnEquipamentos.classList.add("active");
        btnEquipamentos.classList.remove("btn-outline-primary");
        btnEquipamentos.classList.add("btn-primary");
        btnMaquinas.classList.remove("active");
        btnMaquinas.classList.remove("btn-primary");
        btnMaquinas.classList.add("btn-outline-primary");
    });

    // Animação de ícone ao expandir linhas
    document.querySelectorAll(".expandable-row").forEach((row) => {
        row.addEventListener("click", function (e) {
            const target = e.currentTarget.querySelector(
                '[data-bs-toggle="collapse"]'
            );
            if (target && e.target.closest('[data-bs-toggle="collapse"]')) {
                const icon = target.querySelector(".expand-icon");
                if (icon) {
                    icon.classList.toggle("bi-chevron-right");
                    icon.classList.toggle("bi-chevron-down");
                }
            }
        });
    });

    // Configuração do modal de exclusão
    const deleteModal = document.getElementById("deleteModal");
    deleteModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute("data-action");
        const name = button.getAttribute("data-name");

        document.getElementById("delete-name").textContent = name;
        document.getElementById("delete-form").action = action;
    });

    // Filtro de busca para máquinas
    const searchMaquinas = document.getElementById("search-maquinas");
    searchMaquinas.addEventListener("keyup", function () {
        const term = this.value.toLowerCase();
        const rows = contentMaquinas.querySelectorAll(
            "tbody > tr.expandable-row"
        );

        rows.forEach((row) => {
            const patrimonio = row
                .querySelector("td:first-child strong")
                .textContent.toLowerCase();
            const fabricante = row
                .querySelector("td:nth-child(2)")
                .textContent.toLowerCase();
            const tipo = row
                .querySelector("td:nth-child(3)")
                .textContent.toLowerCase();
            const status = row
                .querySelector("td:nth-child(4)")
                .textContent.toLowerCase();
            const usuario = row
                .querySelector("td:nth-child(5)")
                .textContent.toLowerCase();

            if (
                patrimonio.includes(term) ||
                fabricante.includes(term) ||
                tipo.includes(term) ||
                status.includes(term) ||
                usuario.includes(term)
            ) {
                row.style.display = "";
                // Encontrar o próximo tr que é um collapse
                let collapseRow = row.nextElementSibling;
                if (collapseRow && collapseRow.classList.contains("collapse")) {
                    collapseRow.style.display = "";
                }
            } else {
                row.style.display = "none";
                // Encontrar o próximo tr que é um collapse
                let collapseRow = row.nextElementSibling;
                if (collapseRow && collapseRow.classList.contains("collapse")) {
                    collapseRow.style.display = "none";
                }
            }
        });
    });

    // Filtro de busca para equipamentos
    const searchEquipamentos = document.getElementById("search-equipamentos");
    searchEquipamentos.addEventListener("keyup", function () {
        const term = this.value.toLowerCase();
        const rows = contentEquipamentos.querySelectorAll(
            "tbody > tr.expandable-row"
        );

        rows.forEach((row) => {
            const patrimonio = row
                .querySelector("td:first-child strong")
                .textContent.toLowerCase();
            const produto = row
                .querySelector("td:nth-child(2)")
                .textContent.toLowerCase();
            const fabricante = row
                .querySelector("td:nth-child(3)")
                .textContent.toLowerCase();

            if (
                patrimonio.includes(term) ||
                produto.includes(term) ||
                fabricante.includes(term)
            ) {
                row.style.display = "";
                // Encontrar o próximo tr que é um collapse
                let collapseRow = row.nextElementSibling;
                if (collapseRow && collapseRow.classList.contains("collapse")) {
                    collapseRow.style.display = "";
                }
            } else {
                row.style.display = "none";
                // Encontrar o próximo tr que é um collapse
                let collapseRow = row.nextElementSibling;
                if (collapseRow && collapseRow.classList.contains("collapse")) {
                    collapseRow.style.display = "none";
                }
            }
        });
    });
});
