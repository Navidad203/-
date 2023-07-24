//API valoraciones declaracion
const VALORACIONES_API = 'business/public/valoraciones.php';

const VALORACIONES_FORM = document.getElementById("valoracionForm");

const VALORACIONESYA_CONT = document.getElementById("contyavalo");

const VALORACIONESNO_CONT = document.getElementById("contnovalo");

let id_valo = null;

let id_detalle = null;

document.addEventListener('DOMContentLoaded', () => {
    CargarYaValorados();
    CargarNoValorados();
});

async function CargarYaValorados() {
    VALORACIONESYA_CONT.innerHTML = '<h2 class="title">Ya valorados </h2>';
    //-----Cargar un carrito activo del usuario--------
    //Llamando a la API
    const JSON = await dataFetch(VALORACIONES_API, 'ObtenerValoraciones');
    //comprobando respuesta de la API
    if (JSON.status) {
        repetido = false;
        let productosA = ['producto'];
        //se inicia loop para llenar el contenido
        JSON.dataset.forEach(row => {
            for (let index = 0; index < productosA.length; index++) {
                if (productosA[index] == row.producto) {
                    repetido = true;
                }
            }
            productosA.push(row.producto);
            
            //se suma el subtotal del producto obtenido desde la API
            //arreglo para guardar las cantidades al momento de guardar el producto
            // se crean las filas de cada registro
            if (repetido == false) {
            VALORACIONESYA_CONT.innerHTML += `
            <div class="row">
            <div class="col-sm-0 col-md-2">
            </div>
            <div class="col">
            <img class="coverM" src="../../api/images/productos/${row.cover}"></td>
            <h5>V. Promedio</h5>
            <h5><img  class="star" src="../../resources/img/stars/stars.png">${Number(row.promedio).toFixed(2)}</h5>
            </div>
            <div class="col">
                <h4>${row.producto}</h4>
                <h5>Tu valoración</h5>
                    <h5 class="col-8"><img  class="star col-4" src="../../resources/img/stars/stars.png">${row.valoracion}</h5>
                <div id="manga_but" class="col-13">
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#ValoModal" onclick="OpenActualizar(${row.id_valoracion})">Cambiar valoración</button>
                </div>
            </div>
            <div class="col-sm-0 col-md-2">
            </div>
            </div>
            <hr>
            `;
            };
        });
    };
};

//open actualizar
async function OpenActualizar(id_valoracion){
    //se resetea el formulario
    VALORACIONES_FORM.reset();
    id_valo = id_valoracion;
    FORM = new FormData();
    //se pone el input de la imagen como no obligatorio
    FORM.append('id', id_valoracion);
    //se llama a la apu
    const JSON = await dataFetch(VALORACIONES_API, 'ObtenerValoracionId', FORM);

    //se verifica el resultado
    if (JSON.status) {
        document.getElementById('valoracion').selectedIndex = JSON.dataset.valoracion;
        document.getElementById('comentario').value = JSON.dataset.comentario;
    }else{
        sweetAlert(2, 'Ocurrio un error al cargar los datos', false);
    }

    
}

//fincion cargar form para actualizar
async function OpenCrear(id_detalle_factura){
    //se resetea el formulario
    VALORACIONES_FORM.reset();
    id_detalle = id_detalle_factura;
    id_valo = null;

    
}

async function CargarNoValorados() {
    VALORACIONESNO_CONT.innerHTML = '<h2 class="title">Por valorar</h2>';
    //-----Cargar un carrito activo del usuario--------
    //Llamando a la API
    const JSON = await dataFetch(VALORACIONES_API, 'ObtenerNoValoraciones');
    //comprobando respuesta de la API
    if (JSON.status) {
        repetido = false;
        let productosA = ['producto'];
        //se inicia loop para llenar el contenido
        JSON.dataset.forEach(row => {
            for (let i = 0; i < productosA.length; i++) {
                if (productosA[i] == row.producto) {
                    repetido = true;
                }
            }
            productosA.push(row.producto);
            if (repetido == false && row.id_valoracion == null) {
                VALORACIONESNO_CONT.innerHTML += `
                    <div class="row">
                    <div class="col-sm-0 col-md-2">
                    </div>
                    <div class="col">
                        <img class="coverM" src="../../api/images/productos/${row.cover}">
                        <div class="col">
                        <h5>V. Promedio</h5>
                        <h5><img class="star" src="../../resources/img/stars/stars.png">${Number(row.promedio).toFixed(2)}</h5>
                        </div>
                    </div>
                    <div class="col">
                        <h4>${row.producto}</h4>
                        <div id="manga_but" class="col-13">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ValoModal" onclick="OpenCrear(${row.id_detalle_factura})">Valorar</button>
                        </div>
                    </div>
                    <div class="col-sm-0 col-md-2">
                    </div>
                    </div>
                    <hr>
                    `;
            } else {
                repetido == false;
            }
            //se suma el subtotal del producto obtenido desde la API
            //arreglo para guardar las cantidades al momento de guardar el producto
            // se crean las filas de cada registro
        });
    }
};

VALORACIONES_FORM.addEventListener('submit', async (event) => {
    // Se evita recargar la página web después de enviar el formulario.
    event.preventDefault();
    //declaracion del formulario
    const FORM = new FormData(VALORACIONES_FORM);
    //conectar a la api para validar si el manga ya existe
    //se determina la accion a mandar a la api para ingresar/actualizar datos
    (id_valo != null) ? action = 'ActualizarValoracion' : action = 'AgregarValoracion';
    FORM.append('idvalo', id_valo);
    FORM.append('id_detalle', id_detalle);
    //Validar Combobx´s
    if (document.getElementById('valoracion').selectedIndex == 0) {
        sweetAlert(2, "Por favor llene todos los campos", false);
        //validar si el manga ya existe y si es una insercion no permitir que se ingrese el dato
    }else {
        // Petición para guardar los datos del formulario.
        const JSON = await dataFetch(VALORACIONES_API, action, FORM);
        // Se comprueba si la respuesta es satisfactoria, de lo contrario se muestra un mensaje con la excepción.
        if (JSON.status) {
            //se cargan los mangas
            CargarNoValorados();
            CargarYaValorados();
            //se elimina la imagen de vista previa puesto que ya no es necesaria
            //se recarga el formulario en formato actualizar 
            document.getElementById('close').click();
            //se manda un mensaje de confirmacion
            sweetAlert(1, JSON.message, true);
        } else {
            //sino se manda un mensaje de error
            sweetAlert(2, JSON.exception, false);
        }
    }
});