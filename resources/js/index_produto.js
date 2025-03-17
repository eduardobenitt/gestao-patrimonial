// produto-index.js

/**
 * Script para gerenciar interações na página de índice de produtos
 */
document.addEventListener("DOMContentLoaded", function () {
    initDeleteModal();
    checkFormErrors();

    /**
     * Inicializa o modal de exclusão para configurar dinamicamente o produto a ser excluído
     */
    function initDeleteModal() {
        const deleteModal = document.getElementById("deleteProdutoModal");
        if (deleteModal) {
            deleteModal.addEventListener("show.bs.modal", function (event) {
                const button = event.relatedTarget;
                const produtoId = button.getAttribute("data-produto-id");
                const produtoNome = button.getAttribute("data-produto-nome");

                // Atualiza as informações no modal
                const nomeElement = document.getElementById("produtoNome");
                if (nomeElement) {
                    nomeElement.textContent = produtoNome;
                }

                const formElement =
                    document.getElementById("deleteProdutoForm");
                if (formElement) {
                    formElement.action = `/produtos/${produtoId}`;
                }
            });
        }
    }

    /**
     * Verifica se existem erros de validação e reabre o modal de criação se necessário
     */
    function checkFormErrors() {
        // Verifica se há erros de validação no formulário enviado
        const hasErrors =
            document.querySelectorAll(".invalid-feedback").length > 0;
        const createModal = document.getElementById("createProdutoModal");

        // Se houver erros e o token existir (indicando que um formulário foi enviado), abre o modal
        if (hasErrors && createModal) {
            const bsModal = new bootstrap.Modal(createModal);
            bsModal.show();
        }
    }

    /**
     * Inicializa o filtro de pesquisa de produtos, se existir
     */
    const searchInput = document.getElementById("searchProdutos");
    if (searchInput) {
        searchInput.addEventListener("keyup", function () {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll("tbody tr");

            tableRows.forEach((row) => {
                const produtoNome = row
                    .querySelector("td:first-child strong")
                    .textContent.toLowerCase();
                const match = produtoNome.includes(searchTerm);
                row.style.display = match ? "" : "none";
            });
        });
    }

    /**
     * Reseta o formulário quando o modal é fechado para limpar erros
     */
    const createModal = document.getElementById("createProdutoModal");
    if (createModal) {
        createModal.addEventListener("hidden.bs.modal", function () {
            const form = this.querySelector("form");
            if (form) {
                form.reset();
                // Remove mensagens de erro
                form.querySelectorAll(".is-invalid").forEach((el) => {
                    el.classList.remove("is-invalid");
                });
                form.querySelectorAll(".invalid-feedback").forEach((el) => {
                    el.remove();
                });
            }
        });
    }
});
