document.addEventListener("DOMContentLoaded", function () {
    const sidebarToggle = document.getElementById("sidebarToggle");
    const sidebar = document.querySelector(".sidebar");
    const mainContent = document.querySelector(".main-content");
    const toggleIcon = document.getElementById("toggleIcon");
    const sidebarLinks = document.querySelectorAll(".sidebar-link");

    // Sempre iniciar com a sidebar fechada
    sidebar.classList.remove("expanded");
    mainContent.classList.remove("sidebar-expanded");
    updateToggleIcon();

    // Função para atualizar o ícone do botão toggle
    function updateToggleIcon() {
        if (sidebar.classList.contains("expanded")) {
            // Sidebar está expandida, mostra ícone de seta para esquerda
            toggleIcon.classList.remove("bi-arrow-right-circle");
            toggleIcon.classList.add("bi-arrow-left-circle");
        } else {
            // Sidebar está recolhida, mostra ícone de seta para direita
            toggleIcon.classList.remove("bi-arrow-left-circle");
            toggleIcon.classList.add("bi-arrow-right-circle");
        }
    }

    // Evento de clique no botão toggle
    sidebarToggle.addEventListener("click", function () {
        sidebar.classList.toggle("expanded");
        mainContent.classList.toggle("sidebar-expanded");
        updateToggleIcon();
    });

    // Fechar a sidebar quando um link é clicado
    sidebarLinks.forEach((link) => {
        link.addEventListener("click", function () {
            // Apenas fecha se estiver em modo mobile ou se queremos sempre fechar
            sidebar.classList.remove("expanded");
            mainContent.classList.remove("sidebar-expanded");
            updateToggleIcon();
        });
    });
});
