(function () {
    
    var formulario = document.getElementById("formularioEditar");
    formulario.addEventListener("submit", comprobar, false);
    
    
    function comprobar(e) {
        var nombr = nombre();
        var apellido=apellido();
        
        if(!nombr || !apellido ) {
            e.preventDefault();
        }
        
    };
    
    function nombre() {
        var salida = false;
        var nombr = document.getElementsByid("nombre");
        
        if (nombr.value.length < 3 || nombr.value.length > 30) {
            nombr.nextElementSibling.textContent('Más de 3 caracteres y menos de 30');
        }else {
           nombr.nextElementSibling.textContent('');
            salida = true;
        }
        
        return salida;
    };
    
    function apellido() {
        var salida = false;
        var nombr = document.getElementsByid("apellido");
        
        if (nombr.value.length < 3 || nombr.value.length > 30) {
            nombr.nextElementSibling.textContent('Más de 3 caracteres y menos de 30');
        }else {
           nombr.nextElementSibling.textContent('');
            salida = true;
        }
        
        return salida;
    };
    
    function fallos(quien, donde){
        var fallo = 'No ha introducido correctamente los datos de';
        var span = quien.nextSibling;
        
        switch (donde) {
            case 'nombre': 
                fallo = fallo + 'l nombre';
                break;
            case 'contraseña':
                fallo = fallo + ' la contraseña';
                break;
            case 'correo':
                fallo = fallo + 'l correo';
                break;
        }
        span.textContent = fallo;
    }
    
}) ();