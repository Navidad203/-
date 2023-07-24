
const TBODY_VOLUMENES = document.getElementById('volumenes_row');



//evento para cargar los productos
async function cargarProductos(id_manga) {

    location.href = "/Tienda-en-linea-7mangas/views/public/catalogo_volumenes.html";
    TBODY_VOLUMENES.innerHTML = '';
    // Se verifica la acción a realizar.
    const FORM = new FormData(); 

    FORM.append('manga', id_manga)
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';
    action = 'ObtenerProductoPorManga';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MANGA_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_VOLUMENES.innerHTML += `
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

              <button> <img id="img_ico" src="../../resources/img/report.png">
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
/*SEARCH_PEDIDOS_FORM.addEventListener('submit', async (event) => {
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
});*/


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
async function ActualizarEstado(id){
    //se declara un formulario
    const FORM = new FormData(SAVE_FORM);
    //se añade el valor id por medio del FORM.append
    FORM.append('id', id);
    FORM.append('estado', document.getElementById('estado'+id).value);
    //Se actualiza el estado
    const JSON = await dataFetch(PRODUCTOS_API, 'ActualizarEstado', FORM);
    if(JSON.status){
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
/*
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
*/
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



//metodo para actualizar Estado de pedidos
async function ActualizarEst(id){
    //se declara un formulario
    const FORM = new FormData(SAVE_FORM);
    //se ingresa los campos necesarios al formulario
    FORM.append('id', id);
    //se verifica el valor de estado
    estado = document.getElementById('estado'+id).checked;
    FORM.append('estado', estado);
    //se manda a llamar a la api
    const JSON = await dataFetch(PRODUCTOS_API, 'ActualizarEst', FORM);
     //se verifica la respuesta
    if(JSON.status){
        sweetAlert(1, JSON.message, true);
    }
    else{
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
                  <td>${row.comentario}</td>
                  <td class="text-center">
                  <span>Bloquear</span>
                  <label>
                      <input id="estado${row.id_valoracion}" type="checkbox" name="estado" onclick="ActualizarEst(${row.id_valoracion})" checked >
                      <span class="lever"></span>
                  </label>
                  </td>
                </tr>
            `;

            if(row.estado == true){
                 
                document.getElementById('estado'+row.id_valoracion).checked = true;
            }else{
                document.getElementById('estado'+row.id_valoracion).checked = false;
            }
             
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};
async function OpenDetalle(id) {
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
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_DETALLE.innerHTML += `
                <tr>
                  <td>${row.id_factura}</td>
                  <td>${row.titulo}</td>
                  <td>${row.volumen}</td>
                  <td>${row.cantidad}</td>
                </tr>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};