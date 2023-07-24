//llamar formulario register
const SIGN_UP_FORM = document.getElementById('register');


SIGN_UP_FORM.addEventListener('submit', async (event) => {
    //prevent the variable to load
    event.preventDefault();
    //declaración del formulario
    const FORM = new FormData(SIGN_UP_FORM);
    //llamar a la api para iniciar sesión
    const JSON = await dataFetch(USER_API, 'signup', FORM);
    //se verifica la respuesta
    if(JSON.status){
        //se envia a la pagina principal
        location.href = 'index.html';
        //si la respuesta es satisfacturia se manda un mensaje de confirmación
        sweetAlert(1, JSON.message, true, 'dashboard.html');
    }else{
         
        sweetAlert(2, JSON.exception, false);
    }
});