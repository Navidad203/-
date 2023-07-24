// Constante para completar la ruta de la API.
const PEDIDOS_API = "business/public/pedidos.php";
// Constantes para obtener el contenedor defacturas
const CONT_FACTURAS = document.getElementById("compracont");
//constante para obtener el contenedor de detalles
const CONT_DETALLE = document.getElementById("detalleCont");



document.addEventListener('DOMContentLoaded', () => {
    //cargar las facturas del usuario logeado
    CargarFacturas();
});

async function CargarFacturas(){
     
    //-----Cargar las facturas del usuario--------
    //declaración de un formularios
    //Llamando a la API
    const JSON = await dataFetch(PEDIDOS_API, 'ObtenerFacturas');
     
    //comprobando respuesta de la API
    if(JSON.status){
        JSON.dataset.forEach(row =>  {
            // se crean las filas de cada registro
            CONT_FACTURAS.innerHTML += `
            <div id="factura${row.id_factura}" class="row compraposicion">
                            <div class="col">
                                <p>${row.fecha}</p>
                            </div>
                            <div class="col">
                                <p>$${row.total}</p>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-success btn-sm" onclick="CargarDetalles(${row.id_factura}, '${row.total}', '${row.fecha}')">ver detalles</button>
                            </div>
                        </div>
            `;
        });

    }else{
        console.log('No hay coincidencias'); 
    }
};

async function CargarDetalles(id_factura, total, fecha){

    
    const FORM = new FormData();
    FORM.append('id_factura', id_factura);
    CONT_DETALLE.innerHTML = `
    <div id="compraposicion" class="row">
        <div class="col">
            <h5>Fecha:</h5>
        </div>
        <div id="fechaDetalle" class="col">
            <p></p>
        </div>
        <div id="NombreCliente" class="col">

        </div>
        <div id="EstadoFactura" class="col">
        <h5>Estado:</h5>
        </div>
    </div>
    <div id="compraposicion" class="row">
        <div class="col">
            <h6>producto</h6>
        </div>
        <div class="col">
            <h6>Cantidad</h6>
        </div>
        <div class="col">
            <h6>Precio.U</h6>
        </div>
        <div class="col">
            <h6>Sub Total</h6>
        </div>
    </div>`
        ;
     
    //-----Cargar las facturas del usuario--------
    //declaración de un formularios
    //Llamando a la API
    const JSON = await dataFetch(PEDIDOS_API, 'ObtenerDetallesFacturas', FORM);
     
    //comprobando respuesta de la API
    if(JSON.status){
         
        document.getElementById('fechaDetalle').innerHTML = `<p>${fecha}</p>`;
        document.getElementById('NombreCliente').innerHTML += `<p>${JSON.dataset[0].nombre}</p>`;
        document.getElementById('EstadoFactura').innerHTML += `<p>${JSON.dataset[0].estado}</p>`;
        JSON.dataset.forEach(row =>  {
            // se crean las filas de cada registro
            CONT_DETALLE.innerHTML += `
            <div id="compraposicion" class="row">
                <div class="col">
                    <p>${row.producto}</p>
                </div>
                <div class="col">
                    <p>${row.cantidad}</p>
                </div>
                <div class="col">
                    <p>$${row.precio}</p>
                </div>
                <div class="col">
                    <p>$${row.sub_total}</p>
                </div>
            </div>
            `;
        });
        CONT_DETALLE.innerHTML += `
        <div id="compraposicion" class="row">
        <div class="col">
            <h6>TOTAL</h6>
        </div>
        <div class="col">
            <h6>$${total}</h6>
        </div>
        <div class="col">
            <h6></h6>
        </div>
        <div class="col">
            <h6></h6>
        </div>
    </div>
        `;
        

    }else{
        console.log('No hay coincidencias'); 
    }
}
