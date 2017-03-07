
    (function () {
    
    var formulario = document.getElementById("formularioRegistrar");
    formulario.addEventListener("submit", comprobar, false);
    
    
    function comprobar(e) {
     
        var contraseñ =  comprobarPass();
        var corre = email();

        
        if(!contraseñ || correo ) {
            e.preventDefault();
        }
        
    };
    
    function comprobarPass() {
        var informacion =$("#password3");
        var passRepetida = $("#password4");
        var tecleado = informacion.val();
        var error = $("<span></span>");

        if (vacio(informacion))
        {
            error.text("*");
            nombre.append(error);
        }
        if (comprobarNombre(tecleado))
        {
            error.text("La contraseña no puede contener caracter especiales"); 
            nombre.append(error);
        }
        if (comprobarTamanio(15, 6, tecleado)) {
            error.text("La longitud de la contraseña tiene que ser entre 6 y 15");
            nombre.append(error);
        }
        if (comprobarCaracterPass(informacion)) {
            error.text("La contraseña solo puede tener letras numeros y _ y debe contener min una mayuscula y una minuscula");
            nombre.append(error);
        }
        if (tecleado != passRepetida) {
           error.text("Las contraseñas no coinciden");
            nombre.append(error);
        }
        
    }
    
    function email() {
        var mail = document.getElementsByName("correo")[0];
        var array = Array.from(mail.value);
        var arroba = false;
        var punto = false;
        var salida = false;
        
        for(var i = 0; i < array.length; i++){
            
            if(array[i] === '.' && (arroba === false || array[i-1] === '@')){
                salida = false;
                break;
                
            }else if(array[i] === '@'){
                if(arroba === true){
                    salida = false;
                    break;
                }else{
                    arroba = true;
                }
                
            }else if((array[i] === '.' || array[i] === '@') && i+1 === array.length){
                salida = false;
                break;
            }
            
            
        }
        if (salida === false){
            mail.nextElementSibling('Solo letras y números.');
        }else{
            mail.nextElementSibling('Solo letras y números.');
        }
        return salida;
    };
    
}) ();