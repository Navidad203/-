const MANGA_API = 'business/public/catalogo.php';
// declaracion api Configs para llener los combo box
const CONFIGS_API = 'business/dashboard/otras_config.php';

//declaracion form para guardar
const ANIADIR_FORM = document.getElementById('AniadirForm');

//form para buscar mangas
const SEARCH_FORM = document.getElementById('search');

//decñaracion para el body generos
const TBODY_GENEROS = document.getElementById('container_genders');
//declaracion menu de mangas
const TBODY_MANGAS = document.getElementById('mangas_row');
//declaracion combo box de geneross
const COMBO_GENEROS = document.getElementById('generos');
//
let idProducto = null;



document.addEventListener('DOMContentLoaded', () => {

        // Se direcciona a la página web de bienvenida.
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

/*
*   Función para preparar el formulario al momento de insertar un registro.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/

//Metodo para preprar el formulario para editar
async function openActualizar(tittle) {
    //se elimina la imagen de vista previa
    //se reseta los datos del formulario de cualquier proceso previo
    //se pone el input de la imagen como no obligatorio
    //se declara el formulario
    const FORM = new FormData();
    //se declara el titulo para obtener el id del manga
    FORM.append('titulo', tittle);
    // Petición para obtener los datos del registro solicitado.
    const JSON = await dataFetch(MANGA_API, 'CargarCatalogoId', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        // Se inicializan los campos del formulario.
        document.getElementById('id').value = JSON.dataset.id_manga;
        document.getElementById('titulo').innerHTML = JSON.dataset.titulo;
        document.getElementById('imagen_producto').src = '../../api/images/mangas/' + JSON.dataset.portada;
        document.getElementById('descripcion').innerHTML = JSON.dataset.descripcion;
        document.getElementById('demografia').innerHTML = JSON.dataset.demografia;
        document.getElementById('anio').innerHTML = JSON.dataset.anio;
        document.getElementById('volumenes').innerHTML = JSON.dataset.volumenes;
        document.getElementById('revista').innerHTML = JSON.dataset.revista;
        document.getElementById('autor').innerHTML = JSON.dataset.autor;
        document.getElementById('estado').innerHTML = JSON.dataset.estado;
        //se cargan los generos del manga
        CargarGeneros(JSON.dataset.id_manga);
        //se valida la acción del formulario
    } else {
        sweetAlert(2, JSON.exception, false);
    }
}


SEARCH_FORM.addEventListener('submit', async (event) => {
    //metodo para evitar que se recargue la pagina
    event.preventDefault();
    //se valida si hay parametros de busqueda
    if (document.getElementById('search_input').value == ""
        && document.getElementById('revistaSR').selectedIndex == 0
        && document.getElementById('demografiaSR').selectedIndex == 0
        && document.getElementById('autorSR').selectedIndex == 0
        && document.getElementById('generoSR').selectedIndex == 0) {
        //si la respuesta es false se cargan los mangas sin ningun tipo de filtro
        CargarMangas();
    } else {
        //se declara el catalogo de mangas
        TBODY_MANGAS.innerHTML = '';
        // Constante tipo objeto con los datos del formulario.
        const FORM = new FormData(SEARCH_FORM);
        // Petición para guardar los datos del formulario.
        const JSON = await dataFetch(MANGA_API, 'FiltrosManga', FORM);
        if (JSON.status) {
            //se cargan los mangas
                    // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            let rating = null
            if (row.promedio == null) {
                rating = 0.00;
            } else {
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
                <Button href="catalogo_volumenes.html" type="button" class="btn btn-success btn-sm"
                onclick="cargarProductos('${row.id_manga}')">Ver volúmenes</button>
                        <button href="catalogo_volumenes.html" type="button"
                            class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#manga_mod" onclick="openActualizar('${row.titulo}')">Ver Detalles</button>
                    
                        </div>
                </div>
            </div>
            `;
            });
        } else {
            //en caso de error se manda la alerta correspondiente
            sweetAlert(2, JSON.exception, false);
        }
    }
})



//metodo para guardar y actualizar el registro de un manga (no incluye los generos, esos van aparte)


    // Se verifica la acción a realizar.

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
            if (row.promedio == null) {
                rating = 0.00;
            } else {
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
                <Button href="catalogo_volumenes.html" type="button" class="btn btn-success btn-sm"
                onclick="cargarProductos('${row.id_manga}')">Ver volúmenes</button>
                        <button href="catalogo_volumenes.html" type="button"
                            class="btn btn-success btn-sm" data-bs-toggle="modal"
                            data-bs-target="#manga_mod" onclick="openActualizar('${row.titulo}')">Ver Detalles</button>
                    
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
async function CargarGeneros(id) {
    // Se inicializa el contenido de la tabla.
    TBODY_GENEROS.innerHTML = '';
    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : action = 'ObtenerMangas';
    action = 'ObtenerGenerosMangas';
     
    const FORM = new FormData();

    FORM.append('id', id);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MANGA_API, action, FORM);
     
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
         
        // Se recorre el conjunto de registros fila por fila.
        JSON.dataset.forEach(row => {
            // Se crean y concatenan las filas de la tabla con los datos de cada registro.
            TBODY_GENEROS.innerHTML += `<div class="col divider_manga_bot">${row.genero}</div >`;
        });
        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}


//validar si el form esta actualizando o insertando
/*function ValidForm() {
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
}*/


//FUncion para borrar los generos de un manga. 




//metodo para controlar la vista previa de la imagen



// metodo para eliminar la vista previa del servidor



//-------------------------------VOLUMENES------------------------------------------
async function cargarProductos(id_manga) {
    //
    document.getElementById('titulo_volumenes').hidden = false;
    SEARCH_FORM.hidden = true;
    TBODY_MANGAS.innerHTML = '';
    // Se verifica la acción a realizar.
    //(form) ? action = 'BuscarMangas' : ObtenerGenerosMangasction = 'ObtenerMangas';
    action = 'ObtenerProductoPorManga';
    //
    const FORM = new FormData();

    FORM.append('manga', id_manga);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MANGA_API, action, FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
         



        JSON.dataset.forEach(row => {
             
            let TituloManga = row.titulo+' V'+row.volumen;
            TBODY_MANGAS.innerHTML += `
            <div class="mangacoso col-lg-3 col-sm-4">
            <img class="coverM" src="../../api/images/productos/${row.cover}">
            <h4>${TituloManga}</h4>
            <h5><img class="star" src="../../resources/img/stars/stars.png">${Number(row.promedio).toFixed(2)}</h5>
            <div class="row">
                <div id="manga_but">
                <Button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                data-bs-target="#DetallesCar" onclick="PrepararAniadirCarrito(${row.id_producto}, '${TituloManga}', '${row.cover}')">Añadir al carrito</button>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-toggle="modal" data-bs-target="#ValosPro"
                onclick="CargarValoracionesProductos(${row.id_producto})">
                Ver Valoraciones
              </button>
                    
                    </div>
                </div>
            </div>
            `;
        });

        // Se recorre el conjunto de registros fila por fila.

        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
};

function PrepararAniadirCarrito(id_producto, TituloManga, cover){
    ANIADIR_FORM.reset();
     
    idProducto = id_producto;
    document.getElementById('tituloAniadir').innerHTML = TituloManga;
    document.getElementById('coverCar').src = "../../api/images/productos/"+cover;
};

async function CargarValoracionesProductos(id_producto){
    document.getElementById('valosBody').innerHTML = 
    `<div class="row">
    <div class="col-4 text-start">
        <h5>Calificación</h5>
    </div>
    <div class="col-8 text-start">
        <h5>Comentario</h5>
    </div>
</div>`;
    const FORM = new FormData();
    FORM.append('producto', id_producto);
    // Petición para obtener los registros disponibles.
    const JSON = await dataFetch(MANGA_API, 'ObtenerValoracionesProducto', FORM);
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
    if (JSON.status) {
        JSON.dataset.forEach(row => {
             
            let TituloManga = row.titulo+' V'+row.volumen;
            document.getElementById('valosBody').innerHTML += `
            <div class="row">
            <div class="col-4 text-start">
                <p>${row.valoracion}</p>
            </div>
            <div class="col-8 text-start">
            <section id="descripcion" name="descripcion"
            class="form-control manga_container descripcion-public "
            id="exampleFormControlTextarea1"
            placeholder="Descripción..."
            maxlength="1000">${row.comentario}</section>
            </div>
        </div>
        <hr>
            `;
        });

        // Se recorre el conjunto de registros fila por fila.

        // Se muestra un mensaje de acuerdo con el resultado.
    } else {
        console.log('No hay coincidencias');
    }
}

ANIADIR_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    //declaracion del formulario
    const FORM = new FormData(ANIADIR_FORM);
    FORM.append('producto', idProducto);
    //conectar a la api para validar si el manga ya existe
    const JSON = await dataFetch(MANGA_API, 'AniadirACarrito', FORM);
    //se determina la accion a mandar a la api para ingresar/actualizar datosmuestra un mensaje con la excepción.
        if (JSON.status) {
            //se cargan los mangas
            sweetAlert(1, JSON.message, true);
        } else {
            //sino se manda un mensaje de error
            sweetAlert(2, JSON.exception, false);
        }
    });

