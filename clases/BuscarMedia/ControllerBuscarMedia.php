<?php

class ControllerBuscarMedia extends ControllerMedia {
    
    function buscarmedia(){
        $tipo = Request::read('tipo');
        $grupo = Request::read('idgrupo');
        $notas = self::getNotas($grupo);
        $medias = self::getMedias($notas, $tipo);
        foreach($medias as $media){
            foreach($notas as $nota){
                if($media->getIdNota() === $nota->getId()){
                    $salida[] = $nota;
                }
            }
        }
        self::showSearchs($salida, $grupo);
    }
}