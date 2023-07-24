const CONFIGS_API = 'business/dashboard/otras_config.php';

const TBODY_ROWS_GENERO = document.getElementById('tbody-rows-genero');
const TBODY_ROWS_DEMOGRAFIA = document.getElementById('tbody-rows-demografia');
const TBODY_ROWS_AUTOR = document.getElementById('tbody-rows-autor');
const TBODY_ROWS_REVISTA = document.getElementById('tbody-rows-revista');
const SEARCH_FORM = document.getElementById('searchConfigs');
const SAVE_FORM = document.getElementById('guardar_config');


const RECORDS = document.getElementById('records');

document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    CargarGeneros();
    CargarDemografias();
    CargarAutores();
    CargarRevistas();
});



//funcion guardar
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Se verifica la acción a realizar.
    (document.getElementById('id_coso').value) ? action = 'Actualizar' : action = 'Agregar';
    //combobox para agarrar la tabla
    select = document.getElementById('tablaCombo');
    //se verifica que haya una tabla seleccionada
    if (select.selectedIndex == null) {
        sweetAlert(2, 'Selecciona una tabla', false);
    }
    //se consigue la opcion seleccionada en el combo box de tablas
    var optionSelect = select.options[select.selectedIndex];
    console.log(optionSelect.text);
    action = action + optionSelect.text
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SAVE_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(CONFIGS_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se carga nuevamente las tablas para visualizar los cambios.
        CargarGeneros();
        CargarDemografias();
        CargarAutores();
        CargarRevistas();
        // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
        // Se resetea el formularaio
        SAVE_FORM.reset();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
});


//preparar modal para insertar
async function openInsertar() {
    //se resetea el formulario
    SAVE_FORM.reset();
    //se habilida el cmb de la tabla
    select = document.getElementById('tablaCombo');
    select.disabled = false;
}
//funcion preparar actualizar Genero
async function openUpdateGenero(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_genero', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CONFIGS_API, 'ObtenerGeneroId', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        //se desactica la tabla y se coloca en el id correspondiente a la tabla
        select = document.getElementById('tablaCombo');
        select.selectedIndex = 2;
        select.disabled = true;
        // se llenan los demas campos
        document.getElementById('id_coso').value = JSON.dataset.id_genero;
        document.getElementById('coso').value = JSON.dataset.genero;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//funcion preparar actualizar demografia
async function openUpdateDemografia(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_demografia', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CONFIGS_API, 'ObtenerDemografiaId', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        //se desactica la tabla y se coloca en el id correspondiente a la tabla
        select = document.getElementById('tablaCombo');
        select.selectedIndex = 1;
        select.disabled = true;
        // se llenan los demas campos
        document.getElementById('id_coso').value = JSON.dataset.id_demografia;
        document.getElementById('coso').value = JSON.dataset.demografia;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//funcion preparar actualizar Autor
async function openUpdateAutor(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_autor', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CONFIGS_API, 'ObtenerAutorId', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();
        //se desactica la tabla y se coloca en el id correspondiente a la tabla
        select = document.getElementById('tablaCombo');
        select.selectedIndex = 3;
        select.disabled = true;
        // se llenan los demas campos
        document.getElementById('id_coso').value = JSON.dataset.id_autor;
        document.getElementById('coso').value = JSON.dataset.autor;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

async function openUpdateRevista(id) {
    // Se define una constante tipo objeto con los datos del registro seleccionado.
    const FORM = new FormData();
    FORM.append('id_revista', id);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(CONFIGS_API, 'ObtenerRevistaId', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se restauran los elementos del formulario.
        SAVE_FORM.reset();

        select = document.getElementById('tablaCombo');
        select.selectedIndex = 4;
        select.disabled = true;
        document.getElementById('id_coso').value = JSON.dataset.id_revista;
        document.getElementById('coso').value = JSON.dataset.revista;
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

// Método manejador de eventos para cuando se envía el formulario de buscar.
SEARCH_FORM.addEventListener('input', (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Llamada a la función para llenar la tabla con los resultados de la búsqueda.
    CargarAutores(FORM);
    CargarGeneros(FORM);
    CargarDemografias(FORM);
    CargarRevistas(FORM);
});



//cargar generos
async function CargarGeneros(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS_GENERO.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'BuscarGeneros' : action = 'ObtenerGeneros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(CONFIGS_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_GENERO.innerHTML += `
                <tr>
                    <td hidden>${row.id_genero}</td>
                    <td>${row.genero}</td>
                    <td>
                        <div class="col">
                            <h7>
                                <button class="btn" onclick="openUpdateGenero(${row.id_genero})"><img src="../../resources/img/pencil.png" alt="" height="30" data-bs-toggle="modal" data-bs-target="#InsertMod"></button>
                                <button class="btn" onclick="openDeleteGenero(${row.id_genero})"><img src="../../resources/img/eliminar.png" alt="" height="30"></button>
                            </h7>
                        </div>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}

//cargar Demografias
async function CargarDemografias(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS_DEMOGRAFIA.innerHTML = '';
    RECORDS.textContent = '';
    // Se verifica la acción a realizar.
    (form) ? action = 'BuscarDemografias' : action = 'ObtenerDemografias';

    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(CONFIGS_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_DEMOGRAFIA.innerHTML += `
                <tr>
                    <td hidden>${row.id_demografia}</td>
                    <td>${row.demografia}</td>
                    <td>
                        <div class="col">
                            <h7>
                            <button class="btn" onclick="openUpdateDemografia(${row.id_demografia})"><img src="../../resources/img/pencil.png" alt="" height="30" data-bs-toggle="modal" data-bs-target="#InsertMod"></button>
                            <button class="btn" onclick="openDeleteDemografia(${row.id_demografia})"><img src="../../resources/img/eliminar.png" alt="" height="30"></button>
                            </h7>
                        </div>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}


//cargar autores
async function CargarAutores(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS_AUTOR.innerHTML = '';
    RECORDS.textContent = '';

    (form) ? action = 'BuscarAutores' : action = 'ObtenerAutores';
    // Se verifica la acción a realizar.
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(CONFIGS_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_AUTOR.innerHTML += `
                <tr>
                    <td hidden>${row.id_autor}</td>
                    <td>${row.autor}</td>
                    <td>
                        <div class="col">
                            <h7>
                            <button class="btn" onclick="openUpdateAutor(${row.id_autor})"><img src="../../resources/img/pencil.png" alt="" height="30" data-bs-toggle="modal" data-bs-target="#InsertMod"></button>
                            <button class="btn" onclick="openDeleteAutor(${row.id_autor})"><img src="../../resources/img/eliminar.png" alt="" height="30"></button>
                            </h7>
                        </div>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}

async function CargarRevistas(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_ROWS_REVISTA.innerHTML = '';
    RECORDS.textContent = '';

    (form) ? action = 'BuscarRevistas' : action = 'ObtenerRevistas';
    // Se verifica la acción a realizar.
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(CONFIGS_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_ROWS_REVISTA.innerHTML += `
                <tr>
                    <td hidden>${row.id_revista}</td>
                    <td>${row.revista}</td>
                    <td>
                        <div class="col">
                            <h7>
                            <button class="btn" onclick="openUpdateRevista(${row.id_revista})"><img src="../../resources/img/pencil.png" alt="" height="30" data-bs-toggle="modal" data-bs-target="#InsertMod"></button>
                            <button class="btn" onclick="openDeleteRevista(${row.id_revista})"><img src="../../resources/img/eliminar.png" alt="" height="30"></button>
                            </h7>
                        </div>
                    </td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}


//eliminar Genero
async function openDeleteGenero(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el genero de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_genero', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CONFIGS_API, 'DeleteGenero', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            CargarGeneros();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

async function openDeleteDemografia(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la demografia de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_demografia', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CONFIGS_API, 'DeleteDemografia', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            CargarDemografias();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

async function openDeleteAutor(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el Autor de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_autor', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CONFIGS_API, 'DeleteAutor', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            CargarAutores();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

async function openDeleteRevista(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar la revista de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        FORM.append('id_revista', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(CONFIGS_API, 'DeleteRevista', FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            CargarRevistas();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

