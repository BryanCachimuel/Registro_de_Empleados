<?php

include("../config/conexion.php");

// utilizaremos los valores ternarios para decir que si encuentra el
// valor lo almacene en la variable txtId y caso contrario se pondrá vacio
$txtId=(isset($_POST['txtId']))?$_POST['txtId']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtApellidoP=(isset($_POST['txtApellidoP']))?$_POST['txtApellidoP']:"";
$txtApellidoM=(isset($_POST['txtApellidoM']))?$_POST['txtApellidoM']:"";
$txtCorreo=(isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
$txtFoto=(isset($_FILES['txtFoto']["name"]))?$_FILES['txtFoto']["name"]:"";

$accion=(isset($_POST['accion']))?$_POST['accion']:"";

// este dato va a servir para guardar todos los errores
$error=array();

/* se crean estas acciones para poder controlar el modal cuando se trata solo 
de pulsar en el boton de añadir empleados y de seleccionar*/

$accionAgregar="";
$accionModificar=$accionEliminar=$accionCancelar="disabled";
$mostrarModal=false;

/*pdo -> obtiene la conexión que se creo en el archivo conexion además 
prepare -> prepara lo que es la instruccion sql para que se inserte en la base de datos.*/

switch ($accion) {
    case "btnAgregar":

        // validación
        if($txtNombre==""){
            $error['nombre']="Escribe el nombre";
        }
        if($txtApellidoP==""){
            $error['apellidoP']="Escribe el apellido Paterno";
        }
        if($txtApellidoM==""){
            $error['apellidoM']="Escribe el apellido Materno";
        }
        if($txtCorreo==""){
            $error['correo']="Escribe el correo";
        }
        if(count($error)>0){
            $mostrarModal=true;
            break;
        }

        $query=$pdo->prepare("INSERT INTO empleados(nombre,apellidoP,apellidoM,correo,foto) VALUES(:nombre,:apellidoP,:apellidoM,:correo,:foto)");

        $query->bindParam(':nombre',$txtNombre);
        $query->bindParam(':apellidoP',$txtApellidoP);
        $query->bindParam(':apellidoM',$txtApellidoM);
        $query->bindParam(':correo',$txtCorreo);

        /*va a repcionar la foto y la va adjuntar a la carpeta imagenes y despues la pasa a la bdd*/
        $fecha=new DateTime();
        $nombreArchivo=($txtFoto!="")?$fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jpg";
        $tmpFoto=$_FILES["txtFoto"]["tmp_name"];
        if($tmpFoto!=""){
            move_uploaded_file($tmpFoto,"../imagenes/".$nombreArchivo);
        }
        $query->bindParam(':foto',$nombreArchivo);
        $query->execute();
        header("Location:index.php");

    break;

    case "btnModificar":
        $query=$pdo->prepare("UPDATE empleados SET nombre=:nombre,apellidoP=:apellidoP,apellidoM=:apellidoM,correo=:correo WHERE id=:id");

        $query->bindParam(':nombre',$txtNombre);    
        $query->bindParam(':apellidoP',$txtApellidoP);
        $query->bindParam(':apellidoM',$txtApellidoM);
        $query->bindParam(':correo',$txtCorreo);
     
        $query->bindParam(':id',$txtId);
        $query->execute();

        $fecha=new DateTime();
        $nombreArchivo=($txtFoto!="")?$fecha->getTimestamp()."_".$_FILES["txtFoto"]["name"]:"imagen.jpg";
        $tmpFoto=$_FILES["txtFoto"]["tmp_name"];
        if($tmpFoto!=""){
            move_uploaded_file($tmpFoto,"../imagenes/".$nombreArchivo);
                
           // mediante este código se modifica la imagen ya que si se tiene una imagen guardada anteriormenete
           // y se sube otra esta se cambia 
            $query=$pdo->prepare("SELECT foto FROM empleados WHERE id=:id");
            $query->bindParam(':id',$txtId);
            $query->execute();
            
            $empleado=$query->fetch(PDO::FETCH_LAZY);
            if(isset($empleado["foto"])){
                if(file_exists("../imagenes/".$empleado["foto"])){
                   if($item['foto']!="imagen-jpg"){
                     unlink("../imagenes/".$empleado["foto"]);
                   }
                }
            }
            // seccion solo para actualizar el campo foto
            $query=$pdo->prepare("UPDATE empleados SET foto=:foto WHERE id=:id");
            $query->bindParam(':foto',$nombreArchivo);
            $query->bindParam(':id',$txtId);
            $query->execute();
        }
        header("Location:index.php");

    break;

    case "btnEliminar":
        $query=$pdo->prepare("SELECT foto FROM empleados WHERE id=:id");
        $query->bindParam(':id',$txtId);
        $query->execute();

        // PDO::FETCH_LAZY -> solo nos va a devolver un dato de la tabla seleccionada 
        // file_exist -> verifica si existe un archivo 
        // unlink -> borra de la carpeta la imagen si existe
        $empleado=$query->fetch(PDO::FETCH_LAZY);
        if(isset($empleado["foto"]) && ($item['foto']!="imagen.jpg")){
            if(file_exists("../imagenes/".$empleado["foto"])){
                unlink("../imagenes/".$empleado["foto"]);
            }
        }
        
        $query=$pdo->prepare("DELETE FROM empleados WHERE id=:id");
        $query->bindParam(':id',$txtId);
        $query->execute();
   
        header("Location:index.php");
        
    break;

    case "Seleccionar":
        $accionAgregar="disabled";
        $accionModificar=$accionEliminar=$accionCancelar="";
        $mostrarModal=true;

        $query=$pdo->prepare("SELECT * FROM empleados WHERE id=:id");
        $query->bindParam(':id',$txtId);
        $query->execute();
        $empleado=$query->fetch(PDO::FETCH_LAZY);

        $txtNombre=$empleado['nombre'];
        $txtApellidoP=$empleado['apellidoP'];
        $txtApellidoM=$empleado['apellidoM'];
        $txtCorreo=$empleado['correo'];
        $txtFoto=$empleado['foto'];
    break;

    case "btnCancelar":
        header("Location:index.php");
    break;
}
// se va a ejecutar la consulta sql con esto $query->execute();
// seguido $query se va almacenar en la variable $listaEmpleados con la cual se va a obtener la información 
// mediante PDO::FETCH_ASSOC que es lo que hace es devolver o asociar información de la base de datos a un arreglo
$query=$pdo->prepare("SELECT * FROM empleados WHERE 1");
$query->execute();
$listaEmpleados=$query->fetchAll(PDO::FETCH_ASSOC);



?>