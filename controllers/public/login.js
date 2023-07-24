//llamar formulario log in
const LOGIN_FORM = document.getElementById('login');

//evento cuando la pagina recien carga
LOGIN_FORM.addEventListener('submit', async (event) => {
    //prevent the variable to load
    event.preventDefault();
    //declaración del formulario
    const FORM = new FormData(LOGIN_FORM);
    //llamar a la api para iniciar sesión
    const JSON = await dataFetch(USER_API, 'login', FORM);
    //se verifica la respuesta
     
    if(JSON.status){
        //si la respuesta es satisfacturia se manda un mensaje de confirmación
        location.href = 'index.html';
        sweetAlert(1, JSON.message, true, 'index.html');
        //se envia a la pagina principal

    }else{
         
        sweetAlert(2, JSON.exception, false);
    }
});
