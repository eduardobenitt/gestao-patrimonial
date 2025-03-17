import "./bootstrap";

// Importar jQuery e expor globalmente
import $ from "jquery";
window.$ = $;

// Importar Select2
import "select2";

import "./sidebar";
import "./index_users_scripts";
import "./index_patrimonios_scripts";
import "./edit_maquina_scripts";
import "./index_produto";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
