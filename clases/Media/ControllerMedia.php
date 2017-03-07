<?php

class ControllerMedia extends ControllerNotas {
    
    function doinsertMedia() {
        $nota = new Notas();
        $gestor = new GestorNotas();
        $nota->read();
        $r = self::doinsertNota($nota);
        $nomArchivo = self::subirArchivos($r);
        if($nomArchivo != '' && $nomArchivo[2] === 0){
            $media = $this->getModel()->insertMedia($r, $nomArchivo[0] ,$nomArchivo[1]);
            header('Location: index.php?op=insert&r=' . $media);
            exit();
        }
        switch ($nomArchivo[2]) {
            case '1':
                $error = 'Ya existe un archivo con este nombre';
                break;
            case '2':
                $error = 'Error en el proceso de subida del archivo';
                break;
            case '3':
                $error = 'Error en el proceso de subida del archivo';
                break;
            case '4':
                $error = 'Este archivo supera el máximo de subida permitido';
                break;
            case '5':
                $error = 'Extensión de archivo no permitida';
                break;
            case '6':
                $error = 'Carpeta de destino inexistente';
                break;
            case '7':
                $error = 'Ya existe este archivo';
                break;
        }
        $nota->setTexto($nota->getTexto() . $error);
        self::doeditNota($nota, $r);
        header('Location: index.php?op=insert&r=0');
        exit();
    }
    
    function subirArchivos(){
        $archivoNuevo = new FileUpload('subir');
        if($archivoNuevo->getName() === ""){
            return 0;
        }
        $archivoNuevo->upload();
        $salida [] = $archivoNuevo->getName();
        $salida [] = $archivoNuevo->getExtension();
        $salida [] = $archivoNuevo->getTypeError();
        return $salida;
    }
    
    function dodelete(){
        $id = Request::read('id');
        $media = $this->getModel()->getMedia($id);
        $r = self::dodeleteNota($id);
        $this->getModel()->deleteMedia($id);
        if($media != null){
            unlink('Medias/' . $media->getUrl());
        }
        header('Location: index.php?ruta=usuario&accion=viewlist&op=delete&r=' . $r);
        exit();
    }
    
    function doedit(){
        $nota = new Notas();
        $nota->read();
        $notapk = Request::read('id');
        $r = self::doeditNota($nota, $notapk);
        header('Location: index.php?ruta=usuario&accion=viewlist&op=edit&r=' . $r);
        exit();
    }
    
    function getMedias($notas, $tipo){
        return $this->getModel()->getMediasTipo($notas, $tipo);
    }
    /*
    
    
    function doinsert() {
        $usuario = new Usuario();
        $usuario->read();
        if($usuario->isValid()){
            $r = $this->getModel()->insertUsuario($usuario);
            header('Location: index.php?ruta=usuario&accion=viewlist&op=insert&r=' . $r);
            exit();
        }else{
            $this->viewinsert($usuario);
        }
    }
    
    function viewedit(){
        $id = Request::read('email');
        $usuario = $this->getModel()->getUsuario($id);
        $email = $usuario->getEmail();
        
        $form = <<<ABC
        $error<br>
        <form action="index.php">
            <input type='text' value="$email" name='email' required placeholder='email' /><br/>
            <input type='password' name='password' placeholder='clave de acceso' /><br/>
            <input type='hidden' value="$email" name='emailpk'/><br/>
            <input type='hidden' name='ruta' value='usuario' />
            <input type='hidden' name='accion' value='doedit' />
            <input type='submit' value='edicion' /><br/>
        </form>
ABC;
        $this->getModel()->addData('form', $form);
    }
    
    function viewinsert(Usuario $usuario = null) {
        $error = "";
        if($usuario == null){
            $usuario = new Usuario();
        }else{
            $error = "Ha habido un error";
        }
        $email = $usuario->getEmail();
        
        $form = <<<ABC
        $error<br>
        <form action="index.php">
            <input type='email' name='email' value='$email' required placeholder='correo electrónico' /><br/>
            <input type='password' name='password' placeholder='clave de acceso' /><br/>
            <input type='hidden' name='ruta' value='usuario' />
            <input type='hidden' name='accion' value='doinsert' />
            <input type='submit' value='alta' /><br/>
        </form>
ABC;
        $this->getModel()->addData('form', $form);
    }
    
    function viewlist(){
        $lista = $this->getModel()->getList();
        $datoFinal = <<<DEF
        <script>
        var confirmarBorrar = function(evento) {
            var objeto = evento.target;
            var r = confirm('Borrar?');
            if (r) {
            } else {
                evento.preventDefault();
            }
        }
        var a = document.getElementsByClassName('borrar');
        for (var i = 0; i < a.length; i++) {
            a[i].addEventListener('click', confirmarBorrar, false);
        }
        </script>
DEF;
        $dato = '';
        foreach($lista as $usuario) {
            $dato .= $usuario;
            $dato .= '<a class="borrar" href="index.php?ruta=usuario&accion=dodelete&email=' . $usuario->getEmail() . '">borrar este Usuario</a> ';
            $dato .= '<a href="index.php?ruta=usuario&accion=viewedit&email=' . $usuario->getEmail() . '">editar este Usuario</a>';
            $dato .= '<br>';
        }
        $dato .= $datoFinal;
        $dato .= '<a href="index.php?ruta=usuario&accion=viewinsert" > Insertar</a>';
        $this->getModel()->addData('lista', $dato);
    }*/
}