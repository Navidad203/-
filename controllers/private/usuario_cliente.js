// Constante para completar la ruta de la API.
const USUARIO_CLIENTE_API = 'business/dashboard/usuario_cliente.php';

const USUARIO_API = 'business/dashboard/usuario.php';
// Constante para establecer el formulario de buscar.
const SEARCH_FORM = document.getElementById('search');
// Constante para establecer el formulario de guardar.
const SAVE_FORM = document.getElementById('save-form');
// Constante para establecer el título de la modal.
const MODAL_TITLE = document.getElementById('modal-title');
// Constantes para establecer el contenido de la tabla.
const TBODY_ROWS = document.getElementById('tbody-rows');

const USERS_FORM = document.getElementById('users-form');

const RECORDS = document.getElementById('records');
// Constante tipo objeto para establecer las opciones del componente Modal.
const OPTIONS = {
    dismissible: false
}
// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    fillTable();
});
// Método manejador de eventos para cuando se envía el formulario de buscar.
/*SEARCH_FORM.addEventListener('submit', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    fillTable(FORM);
});*/
// Método manejador de eventos para cuando se envía el formulario de guardar.
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id').value) ? action = 'update' : action = 'create';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
     
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(USUARIO_CLIENTE_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente la tabla para visualizar los cambios.
        fillTable();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});

USERS_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    action = 'updateUs';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(USERS_FORM);
     
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
*   Función asíncrona para llenar la tabla con los registros disponibles.
*   Parámetros: form (objeto opcional con los datos de búsqueda).
*   Retorno: ninguno.
*/
async function fillTable() {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    // Se verifica la acción a realizar.
    action = 'readAll';
     
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(USUARIO_CLIENTE_API, action);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td hidden>${row.id_cliente}</td>
                    <td>${row.nombre}</td>
                    <td>${row.apellido}</td>
                    <td>${row.correo}</td>
                    <td>${row.telefono}</td>
                    <td>${row.direccion}</td>
                    <td>
                        <button onclick="openUpdate(${row.id_cliente})" href="../index.html" data-bs-toggle="modal" data-bs-target="#exampleModal"><img id="img_ico"
                      src="../../resources/img/pencil.png"data-tooltip="Actualizar">
                  </button>
                  <button onclick="openDelete(${row.id_cliente})" href="../index.html"><img id="img_ico" src="../../resources/img/trash-can.png" data-tooltip="Eliminar">
                  </button>
                  <button href="../index.html"> <img id="img_ico" src="../../resources/img/report.png">
                  </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        sweetAlert(4, JSON.exception, true);
    }
}

SEARCH_FORM.addEventListener('submit', async (event) =>  {
    event.preventDefault();
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS.innerHTML = '';
    // Se verifica la acción a realizar.
    action = 'Buscar';
    const FORM = new FormData(SEARCH_FORM);
     
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(USUARIO_CLIENTE_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS.innerHTML += `
                <tr>
                    <td hidden>${row.id_cliente}</td>
                    <td>${row.nombre}</td>
                    <td>${row.apellido}</td>
                    <td>${row.correo}</td>
                    <td>${row.telefono}</td>
                    <td>${row.direccion}</td>
                    <td>
                        <button onclick="openUpdate(${row.id_cliente})" href="../index.html" data-bs-toggle="modal" data-bs-target="#exampleModal"><img id="img_ico"
                      src="../../resources/img/pencil.png"data-tooltip="Actualizar">
                  </button>
                  <button onclick="openDelete(${row.id_cliente})" href="../index.html"><img id="img_ico" src="../../resources/img/trash-can.png" data-tooltip="Eliminar">
                  </button>
                  <button href="../index.html"> <img id="img_ico" src="../../resources/img/report.png">
                  </button>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        sweetAlert(4, JSON.exception, true);
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
    const JSON = await dataFetch(USUARIO_CLIENTE_API, 'readOne', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_cliente;
        document.getElementById('nombre').value = JSON.dataset.nombre;
        document.getElementById('apellido').value = JSON.dataset.apellido;
        document.getElementById('correo').value = JSON.dataset.correo;
        document.getElementById('direccion').value = JSON.dataset.direccion;
        document.getElementById('telefono').value = JSON.dataset.telefono;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}
async function openUpdateUs() {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData(SAVE_FORM);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(USUARIO_CLIENTE_API, 'GetUsuario', FORM);
     
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        USERS_FORM.reset();
        // Se inicializan los campos del formulario.
        document.getElementById('idUs').value = JSON.dataset.id_usuario_cliente;
        document.getElementById('usuario').value = JSON.dataset.usuario;
        fillSelect(USUARIO_API, 'readEst', 'estado', 'estado', JSON.dataset.id_estado);
        document.getElementById('cliente').value = JSON.dataset.nombre + " " + JSON.dataset.apellido;
        document.getElementById('cliente').disabled = true;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}
/*
*   Función asíncrona para eliminar un registro.
*   Parámetros: id (identificador del registro seleccionado).
*   Retorno: ninguno.
*/
async function openDelete(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el usuario de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_cliente', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(USUARIO_CLIENTE_API, 'delete', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            fillTable();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}