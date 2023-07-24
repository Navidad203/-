// Constante para completar la ruta de la API.
const PEDIDOS_API = "business/public/pedidos.php";
// Constantes para obtener el contenedor de los detalles
const CONT_CARRITO = document.getElementById("carrito_cont");
//declarando variable del id_factura
let Id_Factura;


document.addEventListener('DOMContentLoaded', () => {
  //cargar las facturas del usuario logeado
  CargarCarrito();
});

async function CargarCarrito() {
  CONT_CARRITO.innerHTML = " ";
  //-----Cargar un carrito activo del usuario--------
  //Llamando a la API
  const JSON = await dataFetch(PEDIDOS_API, 'ObtenerDetallesCarrito');
  //comprobando respuesta de la API
  if (JSON.status) {
    Id_Factura = JSON.dataset[0].id_factura;
    //declaración de variable para obtener el total
    totalSum = 0.00;
    //se inicia loop para llenar el contenido
    JSON.dataset.forEach(row => {
      //se suma el subtotal del producto obtenido desde la API
      totalSum = Number(totalSum) + Number(row.sub_total);
      //arreglo para guardar las cantidades al momento de guardar el producto
      // se crean las filas de cada registro
      CONT_CARRITO.innerHTML += `
            <div  class="row">
            <div class="col">
              <img class="coverM" src="../../api/images/productos/${row.cover}">
              <h5>${row.producto}</h5>
            </div>
            <div class="col">
              <img class="star" src="../../resources/img/stars/stars.png">
              <h4>Cantidad: ${row.cantidad}</h4>
              <h5 id="price">P.Unidad: $${row.precio}</h5>
              <h5 id="price">Sub.Total: $${row.sub_total}</h5>
              <div class="row">
                <div class="col">
                  <button type="button" class="btn btn-danger btn-sm" onclick="EliminarDetalle(${row.id_detalle_factura},${row.cantidad},${row.id_producto})">Eliminar del carrito</button>
                </div>
              </div>
            </div>
          </div>
          
          <hr>
            `;
    });
    //Se llena el total a pagar
    document.getElementById('total').innerHTML = '$' + totalSum.toFixed(2);


  } else {
    //se envia un mensaje al log sobre el error
    console.log('No hay coincidencias');
    //se coloca un mensaje para el usuario
    CONT_CARRITO.innerHTML = `
            <h4>No hay nada en el carrito, Ve a catálogo para agregar productos</h4>
            `;
    //se esconden los botones de confirmar pedido y total mediante un arreglo
    things = document.getElementsByClassName('Hider');
    for (let index = 0; index < things.length; index++) {
      things[index].hidden = true;
    }

  }
};

//función para eliminar un elemento especifico del carrito
async function EliminarDetalle(id_detalle, cantidad, id_producto) {

  const RESPONSE = await confirmAction('¿Desea eliminar este producto del carrito?');
  // Se verifica la respuesta del mensaje.
  if (RESPONSE) {
    //Declaración del formulario
    FORM = new FormData();
    //se añade el campo detalle
    FORM.append('id_detalle', id_detalle);
    FORM.append('cantidad', cantidad);
    FORM.append('id_producto', id_producto);
    //llamado a la api para restablecer los productos
     
    const JSON = await dataFetch(PEDIDOS_API, 'RestablecerProductos', FORM);
    if (JSON.status) {
      const JSON = await dataFetch(PEDIDOS_API, 'EliminarElementoCarrito', FORM);

      //Se verifica la respuesta del servidor
      if (JSON.status) {
        //se carga el carrito nuevamente
        CargarCarrito();
        //Cargar
        //se envia mensaje al usuario
        sweetAlert(1, JSON.message, true);
        //Restablecer Productos

      } else {
        //se envia el mensaje al usuario
        sweetAlert(2, 'Ocurrio un error al eliminar este elemento', false);
        //se recarga el carrito
        CargarCarrito();
      }
    }
    else {
      sweetAlert(2, 'Ocurrio un error al actualizar el inventario', false);
    }
  }

  //Mandando orden a la API



}

//evento click para completar el pedido
document.getElementById('confirmar').addEventListener('click', async () => {
  //se declara un formulario
  const FORM = new FormData();
  //se añade el campo factura al formulario
  FORM.append('id', Id_Factura);
  //se llama a la API 
  const JSON = await dataFetch(PEDIDOS_API, 'CancelarCarrito', FORM);
  //se verfica la respuesta del servidor
  if (JSON.status) {
    //Se carga el carrito
    CargarCarrito();
    //se envia un mensaje de confirmación al usuario
    sweetAlert(1, JSON.message, true);
  } else {
    //se envia un mensaje de error
    sweetAlert(2, 'ocurrió un error al realizar tu pedido, comprueba tu conexión o contactate con un administrador', false);
    //se carga el carrito
    CargarCarrito();
  }

});



