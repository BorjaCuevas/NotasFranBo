(function(){

document.getElementById("fotoPerfil" ).addEventListener( "click",invisibleDesplegable);
document.getElementById("desplegableEditar").addEventListener("click",invisibleEditar);
document.getElementById("salirEditar").addEventListener("click",invisibleEditar);
document.getElementById("salirGrupo").addEventListener("click",invisibleGrupo);
document.getElementById("enlaceCrearGrupo").addEventListener("click",invisibleGrupo);   
document.getElementById("agregarUsuario").addEventListener("click",crearInputUsuario);   
document.getElementById("plusNota").addEventListener("click",invisibleNota);
document.getElementsByClassName("salirNota")[0  ].addEventListener("click",invisibleNota);  

document.getElementById("botonCrearNota").addEventListener("click",crearNota);  
function crearInputUsuario(){
   var inputNuevo=document.createElement("input"); 
   inputNuevo.setAttribute("type","text");
   inputNuevo.setAttribute("name","invitarUsuario");
   inputNuevo.setAttribute("placeholder","Correo del Usuario");
   document.getElementById("inputInvitar").appendChild(inputNuevo);      
    
}  
function crearNota(e){
   
    var titulo=$("#titulo").val();
    var informacion=$("#textAreaEscribir").val();
    var borrarDiv=$("<button class='borrarBasura'>"+"<img src='trash.png'/>"+ "</button>");
    var nuevoDiv=$("<div class='nota'>"+"<span>"+"Titulo "+"</span>"+"<br>"+titulo+"<br>"+"<p>"+"Contenido "+"</p>"+"<br>"+informacion+"<button class='borrarBasura'>"+"<img  class='fotoBasura' src='trash.png'/>"+ "</button>"+ "</div>");
    nuevoDiv.bind("click",visualizarModal);
    nuevoDiv.bind("blur",quitarModal);
    $("#todasNotas").append(nuevoDiv);
    
} 
function visualizarModal(){
    $(this).addClass("modalVisualizarNota");
    $(this).append($('<button class=salirNota name=salir value=salir>'+"Salir"+'</button>'));
    $(this).unbind("click");
    $(this).find("button").on("click",quitarModal);
}
function quitarModal(e){
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
    
$("#accordian h3").click(function(){
		//slide up all the link lists
		$("#accordian div").slideUp();
		//slide down the link list below the h3 clicked - only if its closed
		if(!$(this).next().is(":visible"))
		{
			$(this).next().slideDown();
		}
	})
})();