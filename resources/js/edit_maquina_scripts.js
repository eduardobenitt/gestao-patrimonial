// Funções globais (para uso em atributos onchange, se necessário)
window.toggleUsuariosField = toggleUsuariosField;
window.filtrarUsuariosManha = filtrarUsuariosManha;
window.filtrarUsuariosTarde = filtrarUsuariosTarde;

document.addEventListener("DOMContentLoaded", function () {
    // Verificar se estamos na página correta
    const statusSelect = document.getElementById("status");
    if (!statusSelect) return;

    // Configura o estado inicial
    toggleUsuariosField();

    // Adiciona o evento change ao select de status
    statusSelect.addEventListener("change", toggleUsuariosField);

    // Adiciona eventos para filtrar usuários em ambos os selects
    const usuarioManhaSelect = document.getElementById("usuarioManha");
    const usuarioTardeSelect = document.getElementById("usuarioTarde");

    if (usuarioManhaSelect) {
        usuarioManhaSelect.addEventListener("change", function () {
            filtrarUsuariosTarde(true);
        });
    }

    if (usuarioTardeSelect) {
        usuarioTardeSelect.addEventListener("change", function () {
            filtrarUsuariosManha(true);
        });
    }

    // Executa os filtros iniciais para garantir estado consistente
    if (usuarioManhaSelect && usuarioTardeSelect) {
        filtrarUsuariosTarde(false);
        filtrarUsuariosManha(false);
    }

    // Inicializa o Select2 para multi-select de equipamentos
    if (typeof $ !== "undefined") {
        $("#equipamentos_id").select2({
            placeholder: "Selecione os equipamentos",
            allowClear: true,
            theme: "bootstrap-5",
        });
    }
});

function toggleUsuariosField() {
    const status = document.getElementById("status");
    if (!status) return;

    const statusValue = status.value;
    const usuarioIntegralField = document.getElementById(
        "usuarioIntegralField"
    );
    const usuarioMeioPeriodoField = document.getElementById(
        "usuarioMeioPeriodoField"
    );
    const equipamentoField = document.getElementById("equipamentoField");

    if (!usuarioIntegralField || !usuarioMeioPeriodoField || !equipamentoField)
        return;

    const usuarioIntegralSelect = usuarioIntegralField.querySelector("select");
    const usuarioManhaSelect = document.getElementById("usuarioManha");
    const usuarioTardeSelect = document.getElementById("usuarioTarde");
    const equipamentoSelect = equipamentoField.querySelector("select");

    if (!usuarioIntegralSelect || !equipamentoSelect) return;

    // Resetar a visibilidade
    usuarioIntegralField.style.display = "none";
    usuarioMeioPeriodoField.style.display = "none";
    equipamentoField.style.display = "none";

    // Desabilitar todos os selects
    if (usuarioIntegralSelect) usuarioIntegralSelect.disabled = true;
    if (usuarioManhaSelect) usuarioManhaSelect.disabled = true;
    if (usuarioTardeSelect) usuarioTardeSelect.disabled = true;
    if (equipamentoSelect) equipamentoSelect.disabled = true;

    // Mostrar campos com base no status selecionado
    if (statusValue === "Colaborador Integral") {
        usuarioIntegralField.style.display = "block";
        usuarioIntegralSelect.disabled = false;
        equipamentoField.style.display = "block";
        equipamentoSelect.disabled = false;
    } else if (statusValue === "Colaborador Meio Período") {
        usuarioMeioPeriodoField.style.display = "block";
        if (usuarioManhaSelect) usuarioManhaSelect.disabled = false;
        if (usuarioTardeSelect) usuarioTardeSelect.disabled = false;
        equipamentoField.style.display = "block";
        equipamentoSelect.disabled = false;

        // Aplicar filtros
        if (usuarioManhaSelect && usuarioTardeSelect) {
            filtrarUsuariosTarde(false);
            filtrarUsuariosManha(false);
        }
    }
}

// Função para filtrar usuários da manhã (não permite selecionar o mesmo usuário da tarde)
function filtrarUsuariosManha(fromEvent = false) {
    const usuarioManhaSelect = document.getElementById("usuarioManha");
    const usuarioTardeSelect = document.getElementById("usuarioTarde");

    if (!usuarioManhaSelect || !usuarioTardeSelect) return;

    const tarde = usuarioTardeSelect.value;

    for (let i = 0; i < usuarioManhaSelect.options.length; i++) {
        if (usuarioManhaSelect.options[i].value === tarde && tarde !== "") {
            usuarioManhaSelect.options[i].disabled = true;

            // Se o valor atual é o que estamos desabilitando, limpe-o
            if (fromEvent && usuarioManhaSelect.value === tarde) {
                usuarioManhaSelect.value = "";
            }
        } else {
            usuarioManhaSelect.options[i].disabled = false;
        }
    }
}

// Função para filtrar usuários da tarde (não permite selecionar o mesmo usuário da manhã)
function filtrarUsuariosTarde(fromEvent = false) {
    const usuarioManhaSelect = document.getElementById("usuarioManha");
    const usuarioTardeSelect = document.getElementById("usuarioTarde");

    if (!usuarioManhaSelect || !usuarioTardeSelect) return;

    const manha = usuarioManhaSelect.value;

    for (let i = 0; i < usuarioTardeSelect.options.length; i++) {
        if (usuarioTardeSelect.options[i].value === manha && manha !== "") {
            usuarioTardeSelect.options[i].disabled = true;

            // Se o valor atual é o que estamos desabilitando, limpe-o
            if (fromEvent && usuarioTardeSelect.value === manha) {
                usuarioTardeSelect.value = "";
            }
        } else {
            usuarioTardeSelect.options[i].disabled = false;
        }
    }
}

// Validação extra do formulário
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        const status = document.getElementById("status").value;

        if (status === "Colaborador Meio Período") {
            const manhaValue = document.getElementById("usuarioManha").value;
            const tardeValue = document.getElementById("usuarioTarde").value;

            if (!manhaValue && !tardeValue) {
                e.preventDefault();
                alert(
                    "Pelo menos um usuário (manhã ou tarde) deve ser informado."
                );
            }
        }
    });
});

// Se você precisa do jQuery e Select2
if (typeof jQuery !== "undefined") {
    jQuery(function ($) {
        $("#equipamentos_id").select2({
            placeholder: "Selecione os equipamentos",
        });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Pega o formulário
    const form = document.querySelector("form");
    if (!form) return;

    // Adiciona validação antes do envio
    form.addEventListener("submit", function (e) {
        const status = document.getElementById("status").value;

        if (status === "Colaborador Meio Período") {
            const manhaValue = document.getElementById("usuarioManha").value;
            const tardeValue = document.getElementById("usuarioTarde").value;

            if (!manhaValue && !tardeValue) {
                e.preventDefault();
                alert(
                    "Pelo menos um usuário (manhã ou tarde) deve ser informado."
                );
            }
        }
    });
});
