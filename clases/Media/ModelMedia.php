<?php

class ModelMedia extends ModelNotas {
    
     function getMedia($id){
        $gestor = new GestorMedia();
        return $gestor->get($id);
    }

    function insertMedia($idnota, $nomArchivo, $tipo){
        $media = new Media();
        $media->setIdNota($idnota);
        if($tipo === 'jpg' || $tipo === 'jpeg' || $tipo === 'png' || $tipo === 'svg'){
            $media->setTipo('foto'); //El tipo de archivo k se sube
        }elseif($tipo === 'mp4' || $tipo === '3gp'){
            $media->setTipo('video'); //El tipo de archivo k se sube
        }elseif($tipo === 'mp3'){
            $media->setTipo('sonido'); //El tipo de archivo k se sube
        }
        $media->setUrl($nomArchivo);//La url de donde esté el archivo
        $gestor = new GestorMedia();
        return $gestor->add($media);
    }
    
    function deleteMedia($id){
        $gestor=new GestorMedia();
        return $gestor->delete($id);
    }
    
     function editMedia(Media $media, $idpk){
        $gestor = new GestorMedia();
        return $gestor->saveMedia($media, $idpk);
    }
    
    function getMedias($notas){
        $gestor = new GestorMedia();
        $salida;
        foreach($notas as $nota){
            $que = $gestor->get($nota->getId());
            if($que != null){
                $salida[] = $que;
            }
        }
        return $salida;
    }
    
        
    function getMediasTipo($notas, $tipo){
        $gestor = new GestorMedia();
        foreach($notas as $nota){
            $idnotas[] = $nota->getId();
        }
        return $gestor->getTipo($idnotas, $tipo);
    }

    /*
    function getList(){
        $gestor = new GestorUsuario();
        return $gestor->getList();
    }
    
    
    
    function getUsuario($email){
        $gestor = new GestorUsuario();
        return $gestor->get($email);
    }
    
   */
}