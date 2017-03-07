<?php
require_once 'clases/AutoLoad.php';

class ControllerNotas extends Controller {
    
    function doinsertNota($nota = false) {
        if(!$nota){
            $nota = new Notas();
            $nota->read();
        }
        
        return $this->getModel()->insertNotas($nota);
    }
    
    function dodeleteNota($id){
        $r = $this->getModel()->deleteNotas($id);
        return $r;
    }
    
    function doeditNota($nota, $notapk){
        $r = $this->getModel()->editNota($nota, $notapk);
        return $r;
    }
    
    function getNotas($idgrupo){
        return $this->getModel()->getNotas($idgrupo);
    }
}