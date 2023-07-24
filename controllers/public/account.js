// Constante para completar la ruta de la API.
const USER_API = "business/dashboard/usuario_cliente.php";
// Constantes para obtener la etiqueta donde va el usuario
const USER_LOG = document.getElementById("users");

//--------------------------------------------------
//verifying if the seassion belongs to clients or admins.
//---------------------------------------------------
document.addEventListener("DOMContentLoaded", async () => {
  //Se verifica si hay una sesión en la base
  const JSON = await dataFetch(USER_API, "verifyusers");
  //const JSON = await dataFetch(USER_API, 'getUser');
  //de ser el caso true se envia a validar la sesion
  if (JSON.session == 1) {
    
    if (JSON.status) {

      if (location.pathname == "/Tienda-en-linea-7mangas/views/public/login.html") {
        location.href = "index.html";
      } else {

        USER_LOG.innerHTML = "";
        document.getElementById('valoracionesNav').hidden = false;
        document.getElementById('historialNav').hidden = false;
        //cambiando e lelemento de lcarito a visible
        USER_LOG.innerHTML = `       
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="../../resources/img/user.png" height="20">${JSON.usuario}
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="perfil.html">Ver Perfil</a></li>
                <li><button class="dropdown-item" onclick="logOut()"> Cerrar Sesión</button></li>
              </ul>
            
          `;
        document.getElementById("carrito").hidden = false;
      }
    } else {

      //se manda un mensaje informando al usuarios
      sweetAlert(2, JSON.exception, false);
      //se cierra cualquier session
      console.log(await dataFetch(USER_API, "logOut"));
      //se redirecciona al formulario de log in
    }
    // Se comprueba si existe un alias definido para el usuario, de lo contrario se muestra un mensaje con la excepción.
  } else {
    if (location.pathname != "/Tienda-en-linea-7mangas/views/public/login.html") {
      USER_LOG.innerHTML = `          

    <a type="button" href="login.html" class="btn btn-primary">Iniciar Sesión</a>
    <a type="button" href="sing_up.html" class="btn btn-secondary">Registrarse</a>
  
        `
    };
  }
  //se verifica que la ubicacion sea el formulario de log in
  // Se comprueba si la página web es la principal, de lo contrario se direcciona a iniciar sesión
});
