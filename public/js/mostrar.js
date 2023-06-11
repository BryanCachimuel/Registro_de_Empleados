const mostrarContrasenia = () => {
    let mostrar = document.getElementById('inputPassword');
    if(mostrar.type === "password"){
        mostrar.type = "text";
    }else{
        mostrar.type = "password";
    }
}

const compararContrasenia = () => {
    let mostrar = document.getElementById('inputPassword');
    let confirmarcontrasenia = document.getElementById('inputConfirmPassword');
    if(mostrar.type === "password" && confirmarcontrasenia.type === "password"){
        mostrar.type = "text";
        confirmarcontrasenia.type = "text";
    }else{
        mostrar.type = "password";
        confirmarcontrasenia.type = "password"; 
    }
}