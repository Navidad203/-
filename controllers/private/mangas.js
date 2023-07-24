//declaracion de api Mangas
const MANGA_API = 'business/dashboard/mangas.php';
// declaracion api Configs para llener los combo box
const CONFIGS_API = 'business/dashboard/otras_config.php';
//declaracion form para guardar
const SAVE_FORM = document.getElementById('mangas_form');

//form para buscar mangas
const SEARCH_FORM = document.getElementById('search');
//decñaracion para el body generos
const TBODY_GENEROS = document.getElementById('container_genders');
//declaracion menu de mangas
const TBODY_MANGAS = document.getElementById('mangas_row');
//declaracion combo box de geneross
const COMBO_GENEROS = document.getElementById('generos');


function reporte(){
        // Se declara una constante tipo objeto con la ruta específica del reporte en el servidor.
        const PATH = new URL(`${SERVER_URL}reports/dashboard/mangas.php`);
        // Se abre el reporte en una nueva pestaña del navegador web.
        window.open(PATH.href);
}


document.addEventListener('DOMContentLoaded', () => {
    // Llamada a la función para llenar la tabla con los registros disponibles.
    CargarMangas();
    //llenado de combo box para el filtro de busqueda
    fillSelect(CONFIGS_API, 'ObtenerGeneros', 'generoSR', 'Géneros');
    fillSelect(CONFIGS_API, 'ObtenerAutores', 'autorSR', 'Autores');
    fillSelect(CONFIGS_API, 'ObtenerDemografias', 'demografiaSR', 'Demografías');
    fillSelect(CONFIGS_API, 'ObtenerRevistas', 'revistaSR', 'Revistas');
});

//eventos para asegurarse que la imagen usada para el preview sea borrada si el navegador se actualiza
//o cierra durante un proceso
window.onbeforeunload = function (evt) {
    EliminarPreview();
};

window.onunload = function (evt) {
    EliminarPreview();
};

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
function openCreate() {
    // Se restauran los elementos del formulario.
    EliminarPreview();
    SAVE_FORM.reset();
    //se pone el input del archivo como rquerido
    document.getElementById('archivo').required = true;
    //se setea una ruta predeterminada para la imagen
    document.getElementById('imagen_producto').src = '../../api/images/mangas/';
    // se llama la funcion para llener los campos ComboBox del formulario
    fillSelect(CONFIGS_API, 'ObtenerGeneros', 'generos', 'Generos');
    fillSelect(CONFIGS_API, 'ObtenerAutores', 'autor', 'Autores');
    fillSelect(CONFIGS_API, 'ObtenerDemografias', 'demografia', 'Demografias');
    fillSelect(CONFIGS_API, 'ObtenerRevistas', 'revista', 'Revistas');
    fillSelect(CONFIGS_API, 'ObtenerEstados', 'estado', 'Estados');
     
    //validación para que en caso de que se haya hecho una actualización antes el form quede listo
    //para la operación respectiva
    ValidForm();
}

//Metodo para preprar el formulario para editar
async function openActualizar(tittle) {
    //se elimina la imagen de vista previa
    EliminarPreview();
    //se reseta los datos del formulario de cualquier proceso previo
    SAVE_FORM.reset();
    //se pone el input de la imagen como no obligatorio
    document.getElementById('archivo').required = false;
    //se declara el formulario
    const FORM = new FormData();
    //se declara el titulo para obtener el id del manga
    FORM.append('titulo', tittle);
     
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(MANGA_API, 'ObtenerMangaId', FORM);
     
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_manga;
        document.getElementById('titulo').value = JSON.dataset.titulo;
        document.getElementById('imagen_producto').src = '../../api/images/mangas/' + JSON.dataset.portada;
        document.getElementById('descripcion').value = JSON.dataset.descripcion;
        fillSelect(CONFIGS_API, 'ObtenerDemografias', 'demografia', 'Demografía', JSON.dataset.id_demografia);
        document.getElementById('anio').value = JSON.dataset.anio;
        document.getElementById('volumenes').value = JSON.dataset.volumenes;
        document.getElementById('revista').value = JSON.dataset.id_revista;
        fillSelect(CONFIGS_API, 'ObtenerRevistas', 'revista', 'Revista', JSON.dataset.id_revista);
        fillSelect(CONFIGS_API, 'ObtenerAutores', 'autor', 'Autor', JSON.dataset.id_autor);
        document.getElementById('estado').value = JSON.dataset.id_estado;
        fillSelect(CONFIGS_API, 'ObtenerEstados', 'estado', 'Estado', JSON.dataset.id_estado);
        fillSelect(CONFIGS_API, 'ObtenerGeneros', 'generos', 'Géneros');
        //se cargan los generos del manga
        CargarGeneros();
        //se valida la acción del formulario
        ValidForm();
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}


SEARCH_FORM.addEventListener('submit', async (event) => {
     //metodo para evitar que se recargue la pagina
    event.preventDefault();
    //se valida si hay parametros de busqueda
    if(document.getElementById('search_input').value == "" 
    && document.getElementById('revistaSR').selectedIndex == 0 
    && document.getElementById('demografiaSR').selectedIndex == 0 
    && document.getElementById('autorSR').selectedIndex == 0 
    && document.getElementById('generoSR').selectedIndex == 0 )
    {
        //si la respuesta es false se cargan los mangas sin ningun tipo de filtro
        CargarMangas();
    }else{
         
        //se declara el catalogo de mangas
        TBODY_MANGAS.innerHTML = '';
        // Constante tipo objeto con los datos del formulario.
        const FORM = new FormData(SEARCH_FORM);
        // Petición para guardar los datos del formulario.
        const JSON = await dataFetch(MANGA_API, 'FiltrosManga', FORM);
         
        if (JSON.status) {

            //se cargan los mangas
            JSON.dataset.forEach(row => {
                let rating = null
                if(row.promedio == null){
                    rating = 0.00;
                }else{
                    rating = row.promedio;
                    
                }
                // Se crean y concatenan las filas de la tabla con los datos de cada registro.
                TBODY_MANGAS.innerHTML += `
                <div class="mangacoso col-lg-3 col-sm-4">
                <img class="coverM" src="../../api/images/mangas/${row.portada}">
                <h4>${row.titulo}</h4>
                <h5><img class="star" src="../../resources/img/stars/stars.png">${Number(rating).toFixed(2)}</h5>
                <div class="row">
                    <div id="manga_but" >
                        <button href="catalogo_volumenes.html" type="button"
                            class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#manga_mod" onclick="openActualizar('${row.titulo}')">Editar</button>
                    </div>
                </div>
            </div>
                `
            });
        } else {
            //en caso de error se manda la alerta correspondiente
            sweetAlert(2, JSON.exception, false);
        }
    }
})



//metodo para guardar y actualizar el registro de un manga (no incluye los generos, esos van aparte)
SAVE_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    //declaracion del formulario
    const FORM = new FormData(SAVE_FORM);
    //conectar a la api para validar si el manga ya existe
    const JSON = await dataFetch(MANGA_API, 'ObtenerMangaId', FORM);
    //se determina la accion a mandar a la api para ingresar/actualizar datos
    (document.getElementById('id').value) ? action = 'ActualizarManga' : action = 'InsertarManga';
    //Validar Combobx´s
    if (document.getElementById('revista').selectedIndex == 0 || document.getElementById('demografia').selectedIndex == 0 || document.getElementById('autor').selectedIndex == 0 ||
        document.getElementById('estado').selectedIndex == 0) {
        sweetAlert(2, "Por favor llene todos los cambos", false);
        //validar si el manga ya existe y si es una insercion no permitir que se ingrese el dato
    } else if(JSON.status && action == 'InsertarManga'){
        sweetAlert(2, "Ya hay un manga ingresado con este nombre", false);
    }else {
        // Petición para guardar los datos del formulario.
        const JSON = await dataFetch(MANGA_API, action, FORM);
         
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            //se cargan los mangas
            CargarMangas();
            //se elimina la imagen de vista previa puesto que ya no es necesaria
            EliminarPreview();
            //se recarga el formulario en formato actualizar 
            openActualizar(document.getElementById('titulo').value);
            //se manda un mensaje de confirmacion
            sweetAlert(1, JSON.message, true);
        } else {
            //sino se manda un mensaje de error
            sweetAlert(2, JSON.exception, false);
        }
    }


    // Se verifica la acción a realizar.

});

//cargar
async function CargarMangas(form = null) {
    // Se inicializa el contenido de la tabla.
    TBODY_MANGAS.innerHTML = '';
    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : action = 'ObtenerMangas';
    action = 'ObtenerMangas';
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MANGA_API, action, form);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            let rating = null
            if(row.promedio == null){
                rating = 0.00;
            }else{
                rating = row.promedio;
                
            }
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_MANGAS.innerHTML += `
            <div class="mangacoso col-lg-3 col-sm-4">
            <img class="coverM" src="../../api/images/mangas/${row.portada}">
            <h4>${row.titulo}</h4>
            <h5><img class="star" src="../../resources/img/stars/stars.png">${Number(rating).toFixed(2)}</h5>
            <div class="row">
                <div id="manga_but" >
                    <button href="catalogo_volumenes.html" type="button"
                        class="btn btn-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#manga_mod" onclick="openActualizar('${row.titulo}')">Editar</button>
                </div>
            </div>
        </div>
            `;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}
//funccion para cargar los generos
async function CargarGeneros() {
    // Se inicializa el contenido de la tabla.
    TBODY_GENEROS.innerHTML = '';
    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : action = 'ObtenerMangas';
    action = 'ObtenerGenerosMangas';
    const FORM = new FormData(SAVE_FORM);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MANGA_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_GENEROS.innerHTML += `<button type="button" class="col divider_manga_bot" onclick="DeleteGenero(${row.id_detalle})">${row.genero}</button>`;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}


//validar si el form esta actualizando o insertando
function ValidForm() {
    //se evalua si hay un id
    if (document.getElementById('id').value.length == 0) {
        //si no hay un id se oculta el boton eliminar
        document.getElementById('BTNeliminar').hidden = true;
        //se desactiva el combobox de generos
        COMBO_GENEROS.disabled = true;
        //se carga un mensaja al modal
        TBODY_GENEROS.innerHTML = `<h5>*Debes Ingresar El Manga Antes de editar los generos*</h5>`
    } else {
        //sino se deja por dfecto
        document.getElementById('BTNeliminar').hidden = false;
        COMBO_GENEROS.disabled = false;
    }
}

COMBO_GENEROS.addEventListener('input', async function (event) {
    //obtener valor del index del genero
    event.preventDefault();
    //se obtiene el valor del combobox con el genero seleccionado
    valor = COMBO_GENEROS.selectedIndex;
    //se declara el formulario
    const FORM = new FormData(SAVE_FORM);
    //se manda a llamar a la api con la acción
    const JSON = await dataFetch(MANGA_API, 'InsertarGeneros', FORM);
    if (JSON.status) {  
        //se cargan los generos nuevamente
        CargarGeneros();
                // Se muestra un mensaje de éxito.
        sweetAlert(1, JSON.message, true);
    } else {
        sweetAlert(2, JSON.exception, false);
    }

});
//FUncion para borrar los generos de un manga. 
async function DeleteGenero(id) {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar el gener de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData();
        // se obtiene el valor del genero a borrar
        FORM.append('id_detalle', id);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(MANGA_API, 'DeleteGenerosMangas', FORM);
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

async function DeleteManga() {
    // Llamada a la función para mostrar un mensaje de confirmación, capturando la respuesta en una constante.
    const RESPONSE = await confirmAction('¿Desea eliminar este manga de forma permanente?');
    // Se verifica la respuesta del mensaje.
    if (RESPONSE) {
        // Se define una constante tipo objeto con los datos del registro seleccionado.
        const FORM = new FormData(SAVE_FORM);
        // Petición para eliminar el registro seleccionado.
        const JSON = await dataFetch(MANGA_API, 'DeleteManga', FORM);

        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            // Se carga nuevamente la tabla para visualizar los cambios.
            CargarMangas();
            //resetea el formulario
            SAVE_FORM.reset();
            //se setea el formulario en modo inserción
            openCreate();
            TBODY_GENEROS.innerHTML += `<h5>*Debes Ingresar El Manga Antes de editar los generos*</h5>`
            // Se muestra un mensaje de éxito.
            sweetAlert(1, JSON.message, true);
        } else {
            sweetAlert(2, JSON.exception, false);
        }
    }
}

//metodo para controlar la vista previa de la imagen
document.getElementById('archivo').addEventListener('input', async (event) => {
    //se define una constante con el formulario
    const FORM = new FormData(SAVE_FORM);
    //si verificia si un input invisible tiene una ruta del archivo guardado. Ya que de ser el caso
    //significaria que hay una vista previa ya ingresda
    if (document.getElementById('ruta').value) {
        //se elimina esa vista previa
        EliminarPreview();
    }
    //se llama a la api para cargar la vista previa
    const JSON = await dataFetch(MANGA_API, 'PreviewImagen', FORM);
     //se pone la ruta del archivo en un input invisible
    document.getElementById('ruta').value = JSON.dataset;
    //se coloca la ruta en la etiqueta IMG
    document.getElementById('imagen_producto').src = '../../api/images/mangas/previews/' + JSON.dataset;
});


// metodo para eliminar la vista previa del servidor
async function EliminarPreview() {

    //si el input archivo tiene un archivo ingresado se elimina este
    if (document.getElementById('archivo').value) {
        //se delcara el formulario
        const FORM = new FormData(SAVE_FORM);
        //se llama a la api a eliminar la imagen
        const JSON = await dataFetch(MANGA_API, 'DeletePreviewImagen', FORM);
         
    }
};

