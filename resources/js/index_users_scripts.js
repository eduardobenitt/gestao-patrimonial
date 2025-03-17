document.addEventListener("DOMContentLoaded", function () {
    // Configuração do modal de confirmação
    const confirmModal = document.getElementById("confirmModal");
    confirmModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        const action = button.getAttribute("data-action");
        const message = button.getAttribute("data-message");

        document.getElementById("confirmMessage").textContent = message;
        document.getElementById("confirmForm").action = action;
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

    // Filtro de busca para usuários
    const searchUsers = document.getElementById("search-users");
    searchUsers.addEventListener("keyup", function () {
        const term = this.value.toLowerCase();
        const rows = document.querySelectorAll("tbody > tr.expandable-row");

        rows.forEach((row) => {
            const nome = row
                .querySelector("td:nth-child(1) strong")
                .textContent.toLowerCase();
            const email = row
                .querySelector("td:nth-child(2)")
                .textContent.toLowerCase();
            const ramal = row
                .querySelector("td:nth-child(3)")
                .textContent.toLowerCase();
            const equipe = row
                .querySelector("td:nth-child(4)")
                .textContent.toLowerCase();
            const regime = row
                .querySelector("td:nth-child(5)")
                .textContent.toLowerCase();
            const funcao = row
                .querySelector("td:nth-child(6)")
                .textContent.toLowerCase();
            const unidade = row
                .querySelector("td:nth-child(7)")
                .textContent.toLowerCase();
            const turno = row
                .querySelector("td:nth-child(8)")
                .textContent.toLowerCase();

            if (
                nome.includes(term) ||
                email.includes(term) ||
                ramal.includes(term) ||
                equipe.includes(term) ||
                regime.includes(term) ||
                funcao.includes(term) ||
                unidade.includes(term) ||
                turno.includes(term)
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
