<?php

class Controller {

    private $modelo, $sesion, $idgrupo, $search;

    function __construct(Model $modelo) {
        $this->modelo = $modelo;
        $this->sesion = Session::getInstance('FranBo');
        $ruta = '';
        $archivos;
        $search;
        $this->modelo->addData('plantilla','proyecto/Plantillas/materialize');
        self::createController();
        
    }
    
    function createController(){
        if($this->sesion->isLogged()) {
            $this->user = $this->sesion->getUser();
            $archivos = array('pagina.html', 'footer.html');
            $data = array('titulo'=>'Notas', 'tituloLargo'=>'Guarda tus Notas', 'correo'=>$this->user->getEmail(), 'nombre'=>$this->user->getNombre(), 
            'apellido'=>$this->user->getApellido(), 'Grupos' => self::getGruposUsuarios(), 'Notas' => self::seeNotas(), 'invitacion' => self::getInvitacion(),
            'usuarios'=>self::getUsuariosGestion());
            $ruta = 'login/';
        } else {
            $archivos = array('pagina.html', 'footer.html');
            $data = array('titulo'=>'Notas', 'tituloLargo'=>'Guarda tus Notas');
            $ruta = 'nologin/';
        }
        foreach($archivos as $archivo){
            $this->modelo->addFile(substr('archivo-' . $archivo, 0 , '-' . strlen('.html')), $ruta . $archivo);
        }
        
        foreach($data as $key => $valor){
            $this->modelo->addData($key, $valor);
        }
    }
    
    function showSearchs($notas, $id){
        $this->search = $notas;
        $this->idgrupo = $id;
        self::createController();
    }

    function getModel() {
        return $this->modelo;
    }
    
    function getSession(){
        return $this->sesion;
    }
    
    function primeraVez(){
        $db = new DataBase();
        $existe = $db->getDataParameters('usuario', array('email' => Request::read('email')));
        
        if($existe != null){
            return true;
        }else{
            return false;
        }
    }
    
    function getUsuariosGestion(){
        if(!self::primeraVez()){
            $grupo = new GruposUsuarios();
            $model = new ModelGruposUsuarios();
            if(Request::read('$idgrupo') != null){
                $idgrupo = Request::read('$idgrupo');
            }else{
                $idgrupo = $this->idgrupo;
            }
        
            $gruposusuarios = $model->getGruposUsuariosId($idgrupo);
            if(is_array($gruposusuarios)){
                foreach($gruposusuarios as $gruposusuario){
                    $emails[] = $gruposusuario->getEmail();
                    $relacion[] = $gruposusuario->getRelacion();
                }
            }else{
                $emails[] = $gruposusuarios->getEmail();
                $relacion[] = $gruposusuarios->getRelacion();
            }
        
            return self::drawUsuarios($emails, $relacion);
        }else{
            return ;
        }
        
    }
    
    function getGruposUsuarios(){
        if(!self::primeraVez()){
            $grupo = new GruposUsuarios();
            $model = new ModelGruposUsuarios();
            $gruposusuarios = $model->getGruposUsuariosEmail($this->sesion->getUser());
            
            foreach($gruposusuarios as $gruposusuario){
                if($gruposusuario->getEstado() >= 0){
                    $salida[] = $gruposusuario;
                }
            }
      
            return self::seeGroups(self::getGrupos($salida));
        }else{
            return ;
        }
            
    }
    
    function getInvitacion(){
        $model = new ModelGruposUsuarios();
        $gruposusuarios = $model->getGruposUsuariosEmail($this->sesion->getUser());
        
        foreach($gruposusuarios as $gruposusuario){
            if($gruposusuario->getEstado() < 0){
                $salida[] = $gruposusuario;
                $relacion[] = $gruposusuario->getRelacion();
            }
        }
        return self::drawInvitacion(self::getGrupos($salida), $relacion);
    }
    
    function getGrupos($gruposusuarios){
        $model = new ModelGrupos();
        if(is_array($gruposusuarios)){
            foreach($gruposusuarios as $grupousuario){
                $salida[] = $grupousuario->getIdgrupo();
            }
        }
        $grupos = $model->getGrupo($salida);
        return $grupos;
    }
    
    function seeGroups($grupos){
        if(is_array($grupos)){
            foreach($grupos as $grupo){
                $salida[$grupo->getNombre()] = $grupo->getId();
            }
        }else{
            $salida[$grupos->getNombre()] = $grupos->getId(); 
        }
         return self::drawGroups($salida);
    }
    
    function seeNotas(){
        if(!self::primeraVez()){
            $modelnotas = new ModelNotas();
            $modelmedias = new ModelMedia();
            $notas = $modelnotas->getNotas($this->idgrupo);
            $medias = $modelmedias->getMedias($notas);
            return self::drawNotas($notas, $medias);
        }else{
            return ;
        }
    }
    
    function drawGroups($grupos){
        $salida = '';
        $primero = true;
        foreach($grupos as $nombre => $id){
            if($primero === true){
                if(is_null($this->idgrupo)){
                    if(!is_null(Request::read('grupo'))){
                        $this->idgrupo = Request::read('grupo');
                    }else{
                        $this->idgrupo = $id;
                    }
                }
                $primero = false;
            }
            if((strpos($nombre, '@') !== false) && (strpos($nombre, '//') !== false)){
                $nombre = substr($nombre, strpos($nombre, '//')+2);
            }
            if($this->idgrupo === $id){
                $salida .= '<option value="' . $id . '" selected >' . $nombre . '</option>';
            }else{
                $salida .= '<option value="' . $id . '" >' . $nombre . '</option>';
            }
        }
        
        return $salida;
    }
    
    
    
    function drawNotas($notas, $medias){
        if(is_null($this->search)){
            foreach($notas as $nota){
                $idnota = $nota->getId();
                $tipo = $nota->getTipo();
                $estado = $nota->getEstado();
                $idgrupo = $nota->getIdgrupo();
                $titulo = $nota->getTitulo();
                $contenido = $nota->getTexto();
                $estructuraNota .= '<div class="nota">
                                <input type="hidden" name="ruta" value="nota" >
                                <input type="hidden" name="accion" value="editNota" > 
                                <input type="hidden" class="tipo" name="tipo" value="' . $tipo . '" >
                                <input type="hidden" class="estado" name="estado" value="' . $estado . '" >
                                <input type="hidden" class="idgrupo" id="idgrupo" name="idgrupo" value="' . $idgrupo . '" >
                                <h2>Titulo</h2>
                                <p class="titulo">' . $titulo . '</p>
                                <h2>contenido</h2>
                                <textarea class="contenido">' . $contenido . '</textarea>';
                if(is_array($medias)){
                    foreach($medias as $media){
                        if($nota->getId() === $media->getIdNota()){
                            if($media->getTipo() === 'foto'){
                                $estructuraNota .= '<img class="objeto_nota" src="./Medias/' .  $media->getUrl() . '"/></br>';
                            }else if($media->getTipo() === 'video'){
                                $estructuraNota .= '<iframe class="objeto_nota" src="' .  $media->getUrl() . '"></iframe></br>';
                            }else{
                            $estructuraNota .= '<a href="Medias/' . $media->getUrl() . '" target="_blank">' . $media->getUrl() . '</a></br>'
                            . 'Tipo de archivo: ' . $media->getTipo() . '.</br>';
                            }
                        }
                    }
                }
                                $estructuraNota .='<button class="borrarBasura" value="' . $idnota . '"><img  class="fotoBasura" src="Plantillas/materialize/fotos-plantilla/trash.png"/></button>
                            </div>';
            }
        }else{
            foreach($this->search as $nota){
                $idnota = $nota->getId();
                $tipo = $nota->getTipo();
                $estado = $nota->getEstado();
                $idgrupo = $nota->getIdgrupo();
                $titulo = $nota->getTitulo();
                $contenido = $nota->getTexto();
                $estructuraNota .= '<div class="nota">
                                <input type="hidden" name="ruta" value="nota" >
                                <input type="hidden" name="accion" value="editNota" > 
                                <input type="hidden" class="tipo" name="tipo" value="' . $tipo . '" >
                                <input type="hidden" class="estado" name="estado" value="' . $estado . '" >
                                <input type="hidden" class="idgrupo" id="idgrupo" name="idgrupo" value="' . $idgrupo . '" >
                                <h2>Titulo</h2>
                                <p class="titulo">' . $titulo . '</p>
                                <h2>contenido</h2>
                                <textarea class="contenido">' . $contenido . '</textarea>';
                if(is_array($medias)){
                    foreach($medias as $media){
                        if($nota->getId() === $media->getIdNota()){
                            if($media->getTipo() === 'foto'){
                                $estructuraNota .= '<img class="objeto_nota" src="./Medias/' .  $media->getUrl() . '"/></br>';
                            }else if($media->getTipo() === 'video'){
                                $estructuraNota .= '<iframe class="objeto_nota" src="' .  $media->getUrl() . '"></iframe></br>';
                            }else{
                            $estructuraNota .= '<a href="Medias/' . $media->getUrl() . '" target="_blank">' . $media->getUrl() . '</a></br>'
                            . 'Tipo de archivo: ' . $media->getTipo() . '.</br>';
                            }
                        }
                    }
                }
                                $estructuraNota .='<button class="borrarBasura" value="' . $idnota . '"><img  class="fotoBasura" src="Plantillas/materialize/fotos-plantilla/trash.png"/></button>
                            </div>';
            }
        }
        
        return $estructuraNota;
        
    }
    
    function drawInvitacion($grupos, $relaciones){
        if(is_array($grupos)){
            foreach($grupos as $grupo){
                $nombres[] = $grupo->getNombre();
                $id[] = $grupo->getId();
            }
            foreach($relaciones as $relacion){
                $relac[] = $relacion;
            }
            
            for($i=0; $i<count($nombres); $i++){
                $salida .= '<div class="invitaciones">
                <input type="hidden" id="idgrupoinvitacion" value="' . $id[$i] . '">
                <h1 class="invitacion"> ' . $nombres[$i] . '</h1>
                <p class="invitacion"> ¿Desea pertenecer a este grupo como ' . $relac[$i] . '?</p>
                <input id="aceptarinvitacion" type="button" value="Aceptar"/>
                <input id="rechazarinvitacion" type="button" value="Rechazar"/>
                </div>';
            }
                
            
        }
        return $salida;
    }
    
    function drawUsuarios($emails, $relaciones){
        $salida .='<div id="listausuarios">';
        for($i=0; $i<count($emails); $i++){
            $salida.='<div class="usuariogrupo">
            <p data-email="' . $emails[$i] . '"> Usuario: ' . $emails[$i] . '. Relacion: ' . $relaciones[$i] . '.</p>
            <input type="hidden" class="email" value="' . $emials[$i] . '">
            <button class="borrarusuario"> Borrar Usuario </button>
            </div><br>';
        }
        $salida .= '</div>';
        return $salida;
    }

    /* acciones */
/*aqui estamos asignando el contenido de nuestro data a traves de la viesta(View.php)y nuestro controlador ejemplo en donde hemos puesto {titulo} en nuestro html va a poner (notas)etc..*/
    function main() {
        $this->modelo->addData('contenido','main');
        $this->modelo->addData('titulo','Notas');
        $this->modelo->addData('subtitulo','Guarda tus Notas');
    }
    
}