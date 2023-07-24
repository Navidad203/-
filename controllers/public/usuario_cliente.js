// Constante para completar la ruta de la API.
const USUARIO_CLIENTE_API = 'business/dashboard/usuario_cliente.php';

// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const FORM_PERFIL = document.getElementById('usuario_cliente');

const USER_UPDATE = document.getElementById('user-update');

const RECORDS = document.getElementById('records');

let Id_Usuario = null;
let Id_Cliente = null;
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    openUpdate();
});
// Método manejador de eventos para cuando se envía el formulario de guardar.

FORM_PERFIL.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    action = 'update';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(FORM_PERFIL);
     
    FORM.append('id', Id_Cliente);
     
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(USUARIO_CLIENTE_API, action, FORM);
     
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

/*
*   Función asíncrona para preparar el formulario al momento de actualizar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openUpdate(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_CLIENTE_API, 'ObtenerUsuarioCliente', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
         
        // Se inicializan los campos del formulario.
        document.getElementById('usuarioTitulo').innerHTML = JSON.dataset.usuario;
        document.getElementById('nombre').value = JSON.dataset.nombre;
        document.getElementById('apellido').value = JSON.dataset.apellido;
        document.getElementById('correo').value = JSON.dataset.correo;
        document.getElementById('direccion').value = JSON.dataset.direccion;
        document.getElementById('telefono').value = JSON.dataset.telefono;
        Id_Usuario = JSON.dataset.id_usuario_cliente;
        Id_Cliente = JSON.dataset.id_cliente;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
};

async function openUpdateUs() {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData(SAVE_FORM);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_CLIENTE_API, 'GetUsuario', FORM);
     
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se restauran los elementos del formulario.
        FORM_PERFIL.reset();
        // Se inicializan los campos del formulario.
        document.getElementById('idUs').value = JSON.dataset.id_usuario_cliente;
        document.getElementById('usuario').value = JSON.dataset.usuario;
        fillSelect(USUARIO_API, 'readEst', 'estado', 'estado', JSON.dataset.id_estado);
        document.getElementById('cliente').value = JSON.dataset.nombre + " " + JSON.dataset.apellido;
        document.getElementById('cliente').disabled = true;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
};