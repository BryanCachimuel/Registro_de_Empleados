<?php
session_start();
if(!$_SESSION['id']){
    header('location:./index.php');
}
?>
<?php
// llamdo al archivo que tiene la lógica del crud
include("../controller/empleados.controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Empleados</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</head>
<body>
    <!--
        enctype -> va a hacer que cuando la información contenga una imagen 
        esta aumaticamente se pueda recepcionar 
    -->
    <div class="container mt-4">
        <form action="" method="POST" enctype="multipart/form-data">
        <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Empleado</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
        
                <div class="form-row">
                    <!--borrar el id para que no sea visible en el formulario-->
                
                    <input type="hidden" name="txtId" value="<?php echo $txtId;?>" placeholder="" id="txtId" required>
                    
                    <!--isset($error['nombre']))?"is-invalid":"" -> poner el input de color rojo-->
                    <div class="col-md-4">
                        <label for="">Nombres:</label>
                        <input type="text" class="form-control <?php echo(isset($error['nombre']))?"is-invalid":"";?>"  name="txtNombre" value="<?php echo $txtNombre;?>" id="txtNombre">
                        <div class="invalid-feedback">
                        <?php echo(isset($error['nombre']))?$error['nombre']:"";?>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <label for="">Apellido Paterno:</label>
                        <input type="text" class="form-control <?php echo(isset($error['apellidoP']))?"is-invalid":"";?>"  name="txtApellidoP" value="<?php echo $txtApellidoP;?>" id="txtApellidoP" >
                        <div class="invalid-feedback">
                        <?php echo(isset($error['apellidoP']))?$error['apellidoP']:"";?>
                        </div>
                        <br>
                    </div>
                    <div class="col-md-4">
                        <label for="">Apellido Materno:</label>
                        <input type="text" class="form-control <?php echo(isset($error['apellidoM']))?"is-invalid":"";?>"  name="txtApellidoM" value="<?php echo $txtApellidoM;?>" id="txtApellidoM">
                        <div class="invalid-feedback">
                        <?php echo(isset($error['apellidoM']))?$error['apellidoM']:"";?>
                        </div>
                        <br>
                    </div>   
                    <div class="col-md-12">
                        <label for="">Correo:</label>
                        <input type="email" class="form-control <?php echo(isset($error['correo']))?"is-invalid":"";?>" name="txtCorreo" value="<?php echo $txtCorreo;?>" id="txtCorreo">
                        <div class="invalid-feedback">
                        <?php echo(isset($error['correo']))?$error['correo']:"";?>
                        </div>
                        <br>
                    </div>
                    <!--
                        accept="image/*"-> * es para aceptar cualquier tipo de archivo siempre y cuando sea imagen
                    -->
                    <div class="col-md-12">
                        <label for="">Foto:</label>
                        <?php if($txtFoto!=""){?>
                        <br/>
                            <img class="img-thumbnail rounded mx-auto d-block" width="100px" src="../public/images/<?php echo $txtFoto;?>"/>
                        <br/>
                        <?php } ?>
                        <input type="file" class="form-control" accept="image/*" name="txtFoto" value="<?php echo $txtFoto;?>" placeholder="" id="txtFoto" require=""><br>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                    <button value="btnAgregar" <?php echo $accionAgregar;?> class="btn btn-success" type="submit" name="accion">Agregar</button>
                    <button value="btnModificar" <?php echo $accionModificar;?> class="btn btn-warning" type="submit" name="accion">Modificar</button>
                    <button value="btnEliminar" onclick="return Confirmar('¿Realmente deseas borrar?');" <?php echo $accionEliminar;?> class="btn btn-danger" type="submit" name="accion">Eliminar</button>
                    <button value="btnCancelar" <?php echo $accionCancelar;?> class="btn btn-primary" type="submit" name="accion">Cancelar</button>
            </div>
            </div>
        </div>
        </div>

                    <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Añadir Empleado</button>
            <a href="logout.php?logout=true" class="btn btn-danger">Cerrar Sesión</a>
 </form>
        <div class="row mt-4">
            <table class="table table-hover table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>Foto</th>
                        <th>Nombre Completo</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <?php foreach($listaEmpleados as $empleado){ ?>
                    <tr>
                        <td><img class="img-thumbnail" width="100px" src="../public/images/<?php echo $empleado['foto'];?>" /></td>
                        <td><?php echo $empleado['nombre'];?> <?php echo $empleado['apellidoP'];?> <?php echo $empleado['apellidoM'];?></td>
                        <td><?php echo $empleado['correo'];?></td>
                        <td>
                            <!--crear un formulario para enviar la información por cada registro-->
                            <form action="" method="POST">
                              <input type="hidden" name="txtId" value="<?php echo $empleado['id'];?>">
                              <!--
                                  Estos se elimina debido a que se esta poniendo en el boton seleccionar el código necesario 
                                  para que se vea esos mismos atributos mediante el boton
                              <input type="hidden" name="txtNombre" value="<?php echo $empleado['nombre'];?>">
                              <input type="hidden" name="txtApellidoP" value="<?php echo $empleado['apellidoP'];?>">
                              <input type="hidden" name="txtApellidoM" value="<?php echo $empleado['apellidoM'];?>">
                              <input type="hidden" name="txtCorreo" value="<?php echo $empleado['correo'];?>">
                              <input type="hidden" name="txtFoto" value="<?php echo $empleado['foto'];?>">
                            -->
                              <input type="submit" value="Seleccionar"  class="btn btn-success" name="accion">
                              <button value="btnEliminar" onclick="return Confirmar('¿Realmente deseas borrar?');" type="submit"  class="btn btn-danger" name="accion">Eliminar</button>
                                <!--para que la alerta no aparezca al momento de ejecutar la aplicación es necesario
                             poner un return-->
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
            <!--para que se muestre el modal cuando se click en seleccionar-->        
            <?php if($mostrarModal){ ?>
                <script>
                    $('#exampleModal').modal('show');
                </script>
            <?php } ?> 
            <script>
                function Confirmar(Mensaje){
                    return (confirm(Mensaje))?true:false;
                }
            </script>   
    </div>
</body>
</html>