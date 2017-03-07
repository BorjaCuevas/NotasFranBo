(function(){
    var concatenacionName=1;
    
$(document).ready(function(){
    var val = $('#grupopantalla option:selected').val();
    var input = document.createElement('input');
    var input2 = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('value', val);
    input.setAttribute('name', 'idgrupo');
    input2.setAttribute('type', 'hidden');
    input2.setAttribute('value', val);
    input2.setAttribute('name', 'idgrupo');
    document.getElementById('textAreaEscribir').parentNode.appendChild(input);
    document.getElementById('formInvitar').appendChild(input2);

});

document.getElementById("fotoPerfil" ).addEventListener( "click",invisibleDesplegable);
document.getElementById("desplegableEditar").addEventListener("click",invisibleEditar);
document.getElementById("salirEditar").addEventListener("click",invisibleEditar);
document.getElementById("salirGrupo").addEventListener("click",invisibleGrupo);
document.getElementById("enlaceCrearGrupo").addEventListener("click",invisibleGrupo);   
document.getElementById("agregarUsuarioGrupo").addEventListener("click",crearInputUsuario);  
document.getElementById("agregarUsuarioAcordeon").addEventListener("click",crearInputUsuarioAcordeon);
document.getElementById("plusNota").addEventListener("click",invisibleNota);
document.getElementById("h3CrearNota").addEventListener("click",invisibleNota);
document.getElementsByClassName("salirNota")[0].addEventListener("click",invisibleNota); 
document.getElementById("botonCrearNota").addEventListener("click",crearNota);
document.getElementById("grupopantalla").addEventListener("change",montarGrupo);
document.getElementById("borrarcuenta").addEventListener("click",borrarCuenta);
document.getElementById("realizarBusqueda").addEventListener("click",buscarMedias);
// document.getElementById("botonSubirMedia").addEventListener("click",subirMedia);
// document.getElementById("botonCrearGrupo").addEventListener("click", asociarMiembro);

// function asociarMiembro(e){
//     e.preventDefault();
//     location.replace('index.php?ruta=gestiongrupogrupousuario&accion=doinsertgrupogrupousuario');
// }

/*
function crearInputUsuario(e){
   var input = '<input type="text" name="invitarUsuario" placeholder="Correo del Usuario">';
   $("#agregarUsuario").append(input);
}*/

$(".usuariogrupo").each(function(){/*Cambiar el childnodes5 ponerle una clase*/
    this.childNodes[5].addEventListener("click",borrarUsuario);
})
   

$(".nota").each(function(){
     $(this).bind("click",visualizarModal);
     $(".borrarBasura").bind("click",borrarNota);
})

function buscarMedias(e){
    var grupo = e.currentTarget.previousSibling.previousSibling.value;
    var inputs = e.currentTarget.parentNode.getElementsByTagName('form')[0].getElementsByTagName('input');
    var tipos = '';
    for (var i = 0; i<inputs.length; i++){
        if(inputs[i].checked){
            tipos += inputs[i].name;
        }
    }
    var form = document.createElement( "form" );

    form.setAttribute( "name", "formulario" );
    form.setAttribute( "action", "index.php?ruta=buscarmedia&accion=buscarmedia" );
    form.setAttribute( "method", "post" );
    
    var input = document.createElement( "input" );
    var input2 = document.createElement( "input" );
    var input3 = document.createElement( "input" );
    
    input.setAttribute( "name", "idgrupo" );
    input.setAttribute( "value", grupo );
    input2.setAttribute( "name", "tipo" );
    input2.setAttribute( "value", tipos );
    
    form.appendChild( input );
    form.appendChild( input2 );
    
    form.submit();
}

function crearInputUsuario(e){
    var nombre="invitarUsuario"+concatenacionName;
    concatenacionName++;
    e.preventDefault();
    var input=$('<br>'+'<input type="text" placeholder="Correo del Usuario" class="inputInvitar">'+"<button class='borrarInput2'>"+"<img  class='fotoBasura' src='Plantillas/materialize/fotos-plantilla/cancel.png'/>"+ "</button>");
    input.attr("name",nombre);
    $('#agregarUsuarioGrupo').after(input);
} 

function crearInputUsuarioAcordeon(e){
    var nombre="invitarUsuario"+concatenacionName;
    concatenacionName++;
    e.preventDefault();
    var input=$('<div>'+'<input type="text" name="' + nombre +'"placeholder="Correo del Usuario" class="inputInvitar2">'+"<button class='borrarInput'>"+"<img  class='fotoCance' src='Plantillas/materialize/fotos-plantilla/cancel.png'/>"+ "</button>"+'<br>'+'</div>');
    $('#agregarUsuarioAcordeon').before(input);
}

function crearNota(e){
    var titulo=$("#titulo").val();
    var informacion=$("#textAreaEscribir").val();
    var borrarDiv=$("<button class='borrarBasura'>"+"<img src='Plantillas/materialize/fotos-plantilla/trash.png'>"+ "</button>");
    var nuevoDiv=$("<div class='nota'>"+"<span>"+"Titulo "+"</span>"+"<br>"+titulo+"<br>"+"<p>"+"Contenido "+"</p>"+"<br>"+informacion+"<button class='borrarBasura'>"+"<img  class='fotoBasura' src='Plantillas/materialize/fotos-plantilla/trash.png'>"+ "</button>"+ "</div>");
    nuevoDiv.bind("click",visualizarModal);
    // nuevoDiv.bind("blur",quitarModal);
    $("#todasNotas").append(nuevoDiv);
    
} 

function actualizarNota(e){
    e.preventDefault();
    var thi = e.currentTarget;
    
    location.replace('index.php?ruta=media&accion=doedit&id=' + thi.parentNode.getElementsByTagName("button")[0].value + '&titulo=' + thi.parentNode.getElementsByClassName("titulo")[0].value
     + '&texto=' + thi.parentNode.getElementsByClassName("contenido")[0].value);
}

function visualizarModal(){
    $(this).addClass("modalVisualizarNota");
    $(this).css("cursor", "default");
    $(this).append($('<button class="salirNota" name="salir" value="salir">'+"Actualizar"+'</button>'));
    $(this).unbind("click");
    // $(this).find("button").on("click",quitarModal);
    $(".salirNota").bind("click",actualizarNota);
    
}

function quitarModal(e){
    $(this).parent().css("cursor", "zoom-in");
    $(this).parent().removeClass("modalVisualizarNota");
    $(this).remove();
}

function invisibleNota(){
     var target=document.getElementById("modalNota");
     invisibleOk(target);
}  

function invisibleDesplegable(){
     var target=document.getElementById("desplegableDerecho");
     invisibleOk(target);
}

function invisibleEditar(){ 
     var target=document.getElementById("editarPerfil");
     invisibleOk(target);
}

function invisibleGrupo(){ 
     var target=document.getElementById("crearGrupo");
     invisibleOk(target);

}  

function invisibleOk(objetivo){
       if(objetivo.className==='oculto')
            {
              objetivo.className='mostrar';
           
            }else{
              objetivo.className='oculto';
            } 
            
 }
 
function montarGrupo(){
    var id = $('#grupopantalla option:selected').val();
    location.replace('index.php?grupo='+id);
}

function borrarNota(e){
    var id = e.currentTarget.value;
    location.replace('index.php?ruta=media&accion=dodelete&id='+ id);
}

function borrarUsuario(e){
    var thi = e.currentTarget;
    location.replace('index.php?ruta=gestiongrupogrupousuario&accion=deletemiembro&email='
    + thi.parentNode.getElementsByTagName("p")[0].dataset.email + '&idgrupo=' + document.getElementsByClassName('idgrupo')[0].value);
}

function borrarCuenta(e){
    location.replace("index.php?ruta=borrar&accion=dodelete");
}

$("#accordian h3").click(function(){
		//slide up all the link lists
		$("#accordian div").slideUp();
		//slide down the link list below the h3 clicked - only if its closed
		if(!$(this).next().is(":visible"))
		{
			$(this).next().slideDown();
		}
	})

$("#liInvitar").click(function(){
     $("#formInvitar").slideUp();
      if(!$("#formInvitar").is(":visible")){
            $("#formInvitar").slideDown();
        }
})	
	

$('#aceptarinvitacion').on('click', function(event){
    var idgrupo = $('#idgrupoinvitacion').val();
    location.replace('index.php?ruta=gestiongrupogrupousuario&accion=responderinvitacion&idgrupoinvitacion='+idgrupo+'&respuesta=0');
});

$('#rechazarinvitacion').on('click', function(event){
    var idgrupo = $('#idgrupoinvitacion').val();
    location.replace('index.php?ruta=gestiongrupogrupousuario&accion=responderinvitacion&idgrupoinvitacion='+idgrupo+'&respuesta=-1');
});

$('#botonCrearInvitado').on('click', function(event){
    var idgrupo = $('#idgrupoinvitacion').val();
    location.replace('index.php?ruta=gestiongrupogrupousuario&accion=invitar&idgrupoinvitacion='+idgrupo+'&relacion=');
});

})();