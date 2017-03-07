<?php
require_once 'clases/AutoLoad.php';
require_once 'clases/FileUpload.php';
$nota = new Notas();
$nota->read();
$modelo=new ModelNotas();
$modelo->insertNotas($nota);

if($_FILES['subir']['name']!=""){
    $media=new Media($nota->getId());
    $media->setTipo($_FILES['subir']['type']);
    $crearMedia=new ModelMedia();
    $crearMedia->insertMedia($media);
}
$archivoNuevo = new FileUpload('subir');
$archivoNuevo->upload();


header('Location: index.php?');