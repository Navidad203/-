//declarando API productos
const PRODUCTOS_API = 'business/dashboard/productos.php';
//mangfas
const MANGA_API = 'business/dashboard/mangas.php';
//formulario buscar Productos
const SEARCH_FORM = document.getElementById('search');
//formulario buscar pedidos
const SEARCH_PEDIDOS_FORM = document.getElementById('search-pedidos');
//formulario para los reportes
const REPORTS_FORM = document.getElementById('form-reports');
//declarando formulario guardar
const SAVE_FORM = document.getElementById('save-form');
//declarando tabla productos
const TBODY_PRODUCTOS = document.getElementById('tbody-rows');
//declarando tabla registros
const TBODY_REGISTROS = document.getElementById('tbody-registros');
//declarando tabla pedidos
const TBODY_PEDIDOS = document.getElementById('tbody-pedidos');
//declarando tabla valoraciones
const TBODY_VALORACIONES = document.getElementById('tbody-valoraciones');
//declarando tabla detalles
const TBODY_DETALLE = document.getElementById('tbody-detalles');


//evento cuando la pagina acabe de cargar
document.addEventListener('DOMContentLoaded', async () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    cargarProductos();
    fillSelect(MANGA_API, 'ObtenerMangas', 'mangaSR', 'Mangas');
    //llenado de combo box para el filtro de busqueda
});

//evento para cargar los productos
async function cargarProductos() {
    TBODY_PRODUCTOS.innerHTML = '';
    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';
    action = 'ObtenerProductos';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTOS_API, action);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_PRODUCTOS.innerHTML += `
            <tr>
            <td hidden>${row.id_producto}</td>
            <td><img class="coverM" src="../../api/images/productos/${row.cover}"></td>
            <td>${row.titulo}</td>
            <td>${row.volumen}</td>
            <td>${row.cantidad}</td>
            <td>$${row.precio}</td>
            <td class="text-center">
              <button data-bs-toggle="modal" data-bs-target="#insert_modal" onclick="openActualizar(${row.id_producto})" ><img id="img_ico"
                  src="../../resources/img/pencil.png">
              </button>
              <button onclick="DeleteProducto(${row.id_producto})"><img id="img_ico" src="../../resources/img/trash-can.png">
              </button>

              <button onclick="reporteProductosParam(${row.id_producto})"> <img id="img_ico" src="../../resources/img/report.png">
              </button>
            </td>
          </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};
//cargarRegistros
async function cargarRegistros() {
    TBODY_REGISTROS.innerHTML = '';
    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';
    action = 'ObtenerRegistros';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTOS_API, action);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_REGISTROS.innerHTML += `
                <tr>
                  <td>${row.titulo}</td>
                  <td>${row.volumen}</td>
                  <td>${row.cantidad}</td>
                  <td>${row.fecha}</td>
                  <td>${row.usuario}</td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};

//evento para buscar los pedidos
SEARCH_PEDIDOS_FORM.addEventListener('submit', async (event) => {
    TBODY_PEDIDOS.innerHTML = '';
    event.preventDefault();
    // Se verifica la acción a realizar.
    FORM = new FormData(SEARCH_PEDIDOS_FORM)
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';
    action = 'BuscarPedidos';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTOS_API, action, FORM);

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {

        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_PEDIDOS.innerHTML += `
                <tr>
                  <td>${row.nombre}</td>
                  <td>${row.apellido}</td>
                  <td>
                  <select class="mangaselect btn btn-light dropdown-toggle" name="estado" id="estado${row.id_factura}"
                    aria-label="Default select example" oninput="ActualizarEstado(${row.id_factura})">
                  </select>
                  </td>
                  <td>${row.fecha}</td>
                  <td><button data-bs-toggle="modal" data-bs-target="#detalle_mod" onclick="OpenDetalle(${row.id_factura})"> <img id="img_ico" src="../../resources/img/report.png">
                  </button>
                  </td>
                </tr>
            `;
            //se llena el cmb para cada registro
            fillSelect(PRODUCTOS_API, 'ObtenerEstadosFacturas', 'estado' + row.id_factura, 'estado', row.id_estado_factura);
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
});


//cargarPedidos
async function cargarPedidos() {
    TBODY_PEDIDOS.innerHTML = '';
    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';
    action = 'ObtenerPedidos';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTOS_API, action);

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_PEDIDOS.innerHTML += `
                <tr>
                  <td>${row.nombre}</td>
                  <td>${row.apellido}</td>
                  <td>
                  <select class="mangaselect btn btn-light dropdown-toggle" name="estado" id="estado${row.id_factura}"
                    aria-label="Default select example" oninput="ActualizarEstado(${row.id_factura})">
                  </select>
                  </td>
                  <td>${row.fecha}</td>
                  <td><button data-bs-toggle="modal" data-bs-target="#detalle_mod" onclick="OpenDetalle(${row.id_factura})"> <img id="img_ico" src="../../resources/img/report.png">
                  </button>
                  </td>
                </tr>
            `;
            //se llena el cmb de los registros
            fillSelect(PRODUCTOS_API, 'ObtenerEstadosFacturas', 'estado' + row.id_factura, 'estado', row.id_estado_factura);
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};
//Metodo para actualizar el estado
async function ActualizarEstado(id) {
    //se declara un formulario
    const FORM = new FormData(SAVE_FORM);
    //se añade el valor id por medio del FORM.append
    FORM.append('id', id);
    FORM.append('estado', document.getElementById('estado' + id).value);
    //Se actualiza el estado
    const JSON = await dataFetch(PRODUCTOS_API, 'ActualizarEstado', FORM);
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
    }

}

document.getElementById('archivo').addEventListener('input', async () => {
    //se define una constante con el formulario
    const FORM = new FormData(SAVE_FORM);
    //si verificia si un input invisible tiene una ruta del archivo guardado. Ya que de ser el caso
    //significaria que hay una vista previa ya ingresda
    if (document.getElementById('ruta').value) {
        //se elimina esa vista previa
        EliminarPreview();
    }
    //se llama a la api para cargar la vista previa
    const JSON = await dataFetch(PRODUCTOS_API, 'PreviewImagen', FORM);

    if (JSON.estatus != 1) {
        sweetAlert(2, JSON.exception, false);
    } else {
        //se pone la ruta del archivo en un input invisible
        document.getElementById('ruta').value = JSON.dataset;
        //se coloca la ruta en la etiqueta IMG
        document.getElementById('imagen_cover').src = '../../api/images/productos/previews/' + JSON.dataset;
    }


});


// metodo para eliminar la vista previa del servidor
async function EliminarPreview() {

    //si el input archivo tiene un archivo ingresado se elimina este
    if (document.getElementById('archivo').value) {
        //se delcara el formulario
        const FORM = new FormData(SAVE_FORM);
        //se llama a la api a eliminar la imagen
        const JSON = await dataFetch(PRODUCTOS_API, 'DeletePreviewImagen', FORM);

    }
};

//evento para asegurarse que la imagen usada para el preview sea borrada si el navegador se actualiza
//o cierra durante un proceso
window.onbeforeunload = function (evt) {
    EliminarPreview();
};

window.onunload = function (evt) {
    EliminarPreview();
};

//metodo para aumentar la cuenta en el input sumar
document.getElementById('operator_plus').addEventListener('click', async () => {
    coso = document.getElementById('sumar');
    coso.value = Number(coso.value) + 1;

});


//metodo para disminuir la cuenta en el input restar
document.getElementById('operator_minus').addEventListener('click', async () => {
    coso = document.getElementById('restar');
    coso.value = Number(coso.value) - 1;
});

//insercion
function openCreate() {
    // Se restauran los elementos del formulario.
    EliminarPreview();
    SAVE_FORM.reset();
    //se habilitan todos elementos para que los lea la api
    document.getElementById('manga').disabled = false;
    document.getElementById('volumen').disabled = false;
    document.getElementById('operator_plus').disabled = true;
    document.getElementById('operator_minus').disabled = true;
    document.getElementById('sumar').disabled = true;
    document.getElementById('restar').disabled = true;
    document.getElementById('volumen').disabled = false;
    document.getElementById('cantidad').disabled = false;
    //se pone el input del archivo como rquerido
    document.getElementById('archivo').required = false;
    //se setea una ruta predeterminada para la imagen
    document.getElementById('imagen_cover').src = '../../api/images/productos/';
    // se llama la funcion para llener los campos ComboBox del formulario

    fillSelect(MANGA_API, 'ObtenerMangas', 'manga', 'Mangas');

    //validación para que en caso de que se haya hecho una actualización antes el form quede listo
    //para la operación respectiva
    //ValidForm();
};


async function openActualizar(id) {
    //se elimina la imagen de vista previa
    EliminarPreview();
    //se reseta los datos del formulario de cualquier proceso previo

    //se pone el input de la imagen como no obligatorio
    document.getElementById('archivo').required = false;
    //se declara el formulario
    const FORM = new FormData();
    //se declara el titulo para obtener el id del manga
    FORM.append('id', id);
    document.getElementById('manga').disabled = true;
    document.getElementById('volumen').disabled = true;
    document.getElementById('operator_plus').disabled = false;
    document.getElementById('operator_minus').disabled = false;
    document.getElementById('sumar').disabled = false;
    document.getElementById('restar').disabled = false;
    document.getElementById('cantidad').disabled = true;
    document.getElementById('volumen').disabled = true;
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(PRODUCTOS_API, 'ObtenerProductoPorId', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        SAVE_FORM.reset();
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_producto;
        fillSelect(MANGA_API, 'ObtenerMangas', 'manga', 'Mangas', JSON.dataset.id_manga);
        document.getElementById('cantidad').value = JSON.dataset.cantidad;
        document.getElementById('imagen_cover').src = '../../api/images/productos/' + JSON.dataset.cover;
        document.getElementById('volumen').value = JSON.dataset.volumen;
        document.getElementById('precio').value = JSON.dataset.precio;
        //se cargan los generos del manga
        //se valida la acción del formulario
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}

//metodo para validar el numero de volumenes
document.getElementById('manga').addEventListener('input', async (event) => {


    //se detecta si hay un manga seleccionado
    if (document.getElementById('manga').value != 'Manga') {
        //si esta seleccionado entonces se declara el formulario
        const FORM = new FormData(SAVE_FORM);
        //se llena el campo id
        FORM.append('id', document.getElementById('manga').value);
        //se llama a la api
        const JSON = await dataFetch(MANGA_API, 'ObtenerMangaPorId', FORM);

        if (JSON.status) {
            //se setea los volumenes a no mas de los que tiene el manga
            volumen = document.getElementById("volumen");
            volumen.max = JSON.dataset.volumenes;
        }
    }

});

SEARCH_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    //se valida si hay parametros de busqueda
    //se declara el catalogo de mangas
    TBODY_PRODUCTOS.innerHTML = '';
    // Constante tipo objeto con los datos del formulario.
    const FORM = new FormData(SEARCH_FORM);
    // Petición para guardar los datos del formulario.
    const JSON = await dataFetch(PRODUCTOS_API, 'FiltrosProductos', FORM);

    if (JSON.status) {
        //se cargan los mangas
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_PRODUCTOS.innerHTML += `
            <tr>
            <td hidden>${row.id_producto}</td>
            <td><img class="coverM" src="../../api/images/productos/${row.cover}"></td>
            <td>${row.titulo}</td>
            <td>${row.volumen}</td>
            <td>${row.cantidad}</td>
            <td>$${row.precio}</td>
            <td class="text-center">
              <button data-bs-toggle="modal" data-bs-target="#insert_modal" onclick="openActualizar(${row.id_producto})" ><img id="img_ico"
                  src="../../resources/img/pencil.png">
              </button>
              <button onclick="DeleteProducto(${row.id_producto})"><img id="img_ico" src="../../resources/img/trash-can.png">
              </button>

              <button "> <img id="img_ico" src="../../resources/img/report.png">
              </button>
            </td>
          </tr>
            `;
        });
    } else {
        sweetAlert(2, JSON.exception, false);
    }

});


//formulario para guardar
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    //declaracion del formulario
    mas = document.getElementById('sumar').value;
    menos = document.getElementById('restar').value;
    coso = document.getElementById('cantidad').value;
    coso = Number(coso) + Number(mas) + Number(menos);
    document.getElementById('cantidad').value = coso;
    document.getElementById('manga').disabled = false;
    document.getElementById('volumen').disabled = false;
    document.getElementById('cantidad').disabled = false;
    const FORM = new FormData(SAVE_FORM);
    //conectar a la api para validar si el manga ya existe

    const JSON = await dataFetch(PRODUCTOS_API, 'ValidarVolumenesProducto', FORM);
    //se determina la accion a mandar a la api para ingresar/actualizar datos

    (document.getElementById('id').value) ? action = 'ActualizarProducto' : action = 'InsertarProducto';
    //Validar Combobx´s
    if (action == 'ActualizarProducto') {
        mod = Number(mas) + Number(menos);
        FORM.append('mod', mod);
    } else {
        mod = Number(coso);
        FORM.append('mod', mod);
    }

    if (document.getElementById('manga').selectedIndex == 0) {
        sweetAlert(2, "Por favor llene todos los cambos", false);
        //validar si el manga ya existe y si es una insercion no permitir que se ingrese el dato
    } else if (JSON.status == 1 && action == 'InsertarProducto') {
        sweetAlert(2, "Ya hay un producto con este manga y volumen", false);
    } else {


        // Petición para guardar los datos del formulario.
        const JSON = await dataFetch(PRODUCTOS_API, action, FORM);

        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {


            //se cargan los mangas
            cargarProductos();
            //se elimina la imagen de vista previa puesto que ya no es necesaria
            EliminarPreview();


            //se manda un mensaje de confirmacion

            sweetAlert(1, JSON.message, true);
            JSONA = null;
            if (JSONA = await dataFetch(PRODUCTOS_API, 'ValidarVolumenesProducto', FORM)) {

                FORM.append('id_reg', JSONA.dataset.id_producto);

                JSONA = await dataFetch(PRODUCTOS_API, 'InsertarRegistros', FORM);
                if (JSONA.status == 0) {
                    sweetAlert(2, JSONA.exception, false);
                }
            }
            //se cierra el formulario
            document.getElementById('salir').click();
        } else {
            //sino se manda un mensaje de error
            sweetAlert(2, JSON.exception, false);
        }
    }


    // Se verifica la acción a realizar.

});

async function DeleteProducto(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar este producto de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData(SAVE_FORM);
        FORM.append('id_del', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(PRODUCTOS_API, 'DeleteProducto', FORM);

        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            cargarProductos();
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

//metodo para actualizar Estado de pedidos
async function ActualizarEst(id) {
    //se declara un formulario
    const FORM = new FormData(SAVE_FORM);
    //se ingresa los campos necesarios al formulario
    FORM.append('id', id);
    //se verifica el valor de estado
    estado = document.getElementById('estado' + id).checked;
    FORM.append('estado', estado);
    //se manda a llamar a la api
    const JSON = await dataFetch(PRODUCTOS_API, 'ActualizarEst', FORM);
    //se verifica la respuesta
    if (JSON.status) {
        sweetAlert(1, JSON.message, true);
    }
    else {
        sweetAlert(2, JSON.exception, false);
    }

}
//metodo para cargar las valoraciones
async function cargarValoraciones() {
    TBODY_VALORACIONES.innerHTML = '';
    const FORM = new FormData(SAVE_FORM);

    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';

    action = 'ObtenerValoraciones';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTOS_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.

            TBODY_VALORACIONES.innerHTML += `
                <tr>
                  <td>${row.titulo}</td>
                  <td>${row.volumen}</td>
                  <td>${row.nombre}</td>
                  <td>${row.apellido}</td>
                  <td>${row.valoracion}</td>
                  <td class="comentValoPro">${row.comentario}</td>
                  <td class="text-center">
                  <span>Mostrar</span>
                  <label>
                      <input id="estado${row.id_valoracion}" type="checkbox" name="estado" onclick="ActualizarEst(${row.id_valoracion})" checked >
                      <span class="lever"></span>
                  </label>
                  </td>
                </tr>
            `;

            if (row.estado == true) {

                document.getElementById('estado' + row.id_valoracion).checked = true;
            } else {
                document.getElementById('estado' + row.id_valoracion).checked = false;
            }

        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};
async function OpenDetalle(id) {
    let total = 0.00;
    TBODY_DETALLE.innerHTML = '';

    const FORM = new FormData();
    FORM.append('id_pro', id)
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';
    action = 'ObtenerDetalle';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(PRODUCTOS_API, action, FORM);

    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {

            total = Number(total) + Number(row.sub_total);
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_DETALLE.innerHTML += `
                <tr>
                  <td>${row.producto}</td>
                  <td>${row.cantidad}</td>
                  <td>$${row.precio}</td>
                  <td>$${row.sub_total}</td>
                </tr>
            `;
        });
        TBODY_DETALLE.innerHTML += `
            <tr>
                <th scope="col">Total: </th>
                <th scope="col">$${total.toFixed(2)}</th>
        
            </tr>
            `
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};

//-------------------Reportes-----------------------

//reporte registros------------------------------
document.getElementById('checkReport').addEventListener('change', () => {
    debugger
    if (document.getElementById('checkReport').checked == true) {
        document.getElementById('filtro').hidden = false;
        document.getElementById('fecha_1').required = true;
        document.getElementById('fecha_2').required = true;
    } else {
        document.getElementById('filtro').hidden = true;
        document.getElementById('fecha_1').required = false;
        document.getElementById('fecha_2').required = false;
        document.getElementById('fecha_1').value = null;
        document.getElementById('fecha_2').value = null;
    }
}
);

REPORTS_FORM.addEventListener('submit', async (event) => {
    event.preventDefault();
    fecha1 = document.getElementById('fecha_1').value;
    fecha2 = document.getElementById('fecha_2').value;
    debugger
    // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
    const PATH = new URL(`${SERVER_URL}reports/dashboard/productos_inventario.php`);
    PATH.searchParams.append('fecha1', fecha1);
    PATH.searchParams.append('fecha2', fecha2);
    // Se abre el reporte en una nueva pestaña del navegador web.
    window.open(PATH.href);
});


//reporte pedidos------------------------------------
function reportePedidos() {
    valor = document.getElementById('search_input').value;
    fecha1 = document.getElementById('fecha_1_pedidos').value;
    fecha2 = document.getElementById('fecha_2_pedidos').value;
    debugger
    if (fecha1 == "" && fecha2 == "") {
        debugger
        // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
        const PATH = new URL(`${SERVER_URL}reports/dashboard/productos_pedidos.php`);
        PATH.searchParams.append('valor', valor);
        PATH.searchParams.append('fecha1', fecha1);
        PATH.searchParams.append('fecha2', fecha2);
        // Se abre el reporte en una nueva pestaña del navegador web.
        window.open(PATH.href);
    } else if (fecha1 != "" && fecha2 != "") {
        debugger
        // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
        const PATH = new URL(`${SERVER_URL}reports/dashboard/productos_pedidos.php`);
        PATH.searchParams.append('valor', valor);
        PATH.searchParams.append('fecha1', fecha1);
        PATH.searchParams.append('fecha2', fecha2);
        // Se abre el reporte en una nueva pestaña del navegador web.
        window.open(PATH.href);

    }
    else {
        debugger
        sweetAlert(2, "Por favor deje todos los campos de fecha ya sea vacios o llenos", false);
    }

};

function clearIn() {
    document.getElementById('fecha_2_pedidos').value = null;
    document.getElementById('fecha_1_pedidos').value = null;
}

//reporte productos----------------------------------------------
function reporteProductos(){
    const PATH = new URL(`${SERVER_URL}reports/dashboard/productos.php`);
    window.open(PATH.href);
}

//reporte productos param

function reporteProductosParam(id){
    const PATH = new URL(`${SERVER_URL}reports/dashboard/productos_param.php`);
    PATH.searchParams.append('id', id);
    window.open(PATH.href);
}
