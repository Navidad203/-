const PRODUCTO_API = 'business/dashboard/productos.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoBarrasProductoMasVendido();
    graficoBarrasGeneroMasVendido();
    graficoProductos();
});

/*
*   Función asíncrona para mostrar en un gráfico de barras la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoBarrasProductoMasVendido() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'ProductoMasVendido');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let titulo = [];
        let cuenta = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            titulo.push(row.titulo);
            cuenta.push(row.cuenta);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart1', titulo, cuenta, 'Volumen', 'Producto mas vendido');
    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}

async function graficoBarrasGeneroMasVendido() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'GeneroMasVendido');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let cuenta = [];
        let genero = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            cuenta.push(row.cuenta);
            genero.push(row.genero);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart2', genero, cuenta, 'Cantidad de productos vendidos', 'Genero del manga');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.exception);
    }
}
    /*
*   Función asíncrona para mostrar en un gráfico de barras la cantidad de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoProductos(){
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'graficoProductos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let manga = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            manga.push(row.id_manga);
            cantidad.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart3', manga, cantidad, 'productos', 'cantidad de productos');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.exception);
    }
}
