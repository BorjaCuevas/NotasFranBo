<?php

class ControllerGestionGrupoGrupoUsuario extends ControllerGruposUsuarios {
    
    function doinsertgrupogrupousuario($email = '') {
        
        if(!is_null(Request::read('invitarUsuario0'))){
            $invitados = self::invitados();
        }
        
        $relacion = 'miembro'; //Request::read('relacionInvitado')
        if(is_array($invitados)){
            $idgrupo = self::doinsertgrupo();
            $grupo = self::getIdGrupo($idgrupo);
            self::createGrupoUsuario($grupo);
            for($i=0; $i<count($invitados); $i++){
                self::createGrupoUsuario($grupo, $invitados[$i], $relacion);
            }
            header('location:index.php');
        }else{
            if(strlen($email) === 0){
                $idgrupo = self::doinsertgrupo();
                $grupo = self::getIdGrupo($idgrupo);
                self::createGrupoUsuario($grupo);
                header('location:index.php');
            }else{
                $idgrupo = self::doinsertgrupo($email);
                $grupo = self::getIdGrupo($idgrupo);
                self::createGrupoUsuario($grupo, $email);
                header('location:index.php');
            }
        }
        
    }
    
    function invitados(){
        $nullable = '0';
        $i = 0;
        while($nullable!=null){
            $nullable = Request::read('invitarUsuario' . $i);
            $usuario[] = Request::read('invitarUsuario' . $i);
            $i++;
        }
        if(!is_null($usuario)){
            array_pop ($usuario);
        }
        return $usuario;
    }
    
    
    function invitar(){
        
        if(!is_null(Request::read('invitarUsuario0'))){
            $invitados = self::invitados();
        }
        
        $grupo = Request::read('idgrupo');
        $relacion = 'miembro';
        for($i=0; $i<count($invitados); $i++){
                self::createGrupoUsuario($grupo, $invitados[$i], $relacion);
        }
        header('location:index.php');
    }
    
    function responderinvitacion(){
        $idgrupo = Request::read('idgrupoinvitacion');
        $respuesta = Request::read('respuesta');
        $email = $this->getSession()->getUser()->getEmail();
        if($respuesta === '0'){
            self::activarmiembro($idgrupo, $email);
        }else{
            self::deletegrupousuario($idgrupo, $email);
        }
        header('location:index.php');
    }
    
    function deletemiembro(){
        $email = Request::read('email');
        $idgrupo = Request::read('idgrupo');
        self::deletegrupousuario($idgrupo, $email);
        header('location:index.php');
    }
    
    function deleteGruposUsuarios($email){
        $grupos = self::lookForGruposDueño($email);
        self::dodeletegrupodueño($email);
        self::deleteallgrupousuario($email);
    }
    
} 
