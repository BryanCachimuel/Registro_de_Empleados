<?php
session_start();
require_once('../config/conexion.php');

if(isset($_POST['submit']))
{
    if(isset($_POST['nombre'],$_POST['apellido'],$_POST['email'],$_POST['password']) && !empty($_POST['nombre']) && !empty($_POST['apellido']) && !empty($_POST['email']) && !empty($_POST['password']))
    {
        $firstName = trim($_POST['nombre']);
        $lastName = trim($_POST['apellido']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        $hashPassword = $password;
        $options = array("cost"=>4);
        $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);
        $date = date('Y-m-d H:i:s');

        if(filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $sql = 'select * from usuarios where email = :email';
            $stmt = $pdo->prepare($sql);
            $p = ['email'=>$email];
            $stmt->execute($p);
            
            if($stmt->rowCount() == 0)
            {
                $sql = "insert into usuarios (nombre, apellido, email, `password`, created_at,updated_at) values(:vnombre,:vapellido,:email,:pass,:created_at,:updated_at)";

                try{
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':vnombre'=>$firstName,
                        ':vapellido'=>$lastName,
                        ':email'=>$email,
                        ':pass'=>$hashPassword,
                        ':created_at'=>$date,
                        ':updated_at'=>$date
                    ];
                    
                    $handle->execute($params);
                    
                    $success = 'Usuario creado correctamente!!';
                    
                }
                catch(PDOException $e){
                    $errors[] = $e->getMessage();
                }
            }
            else
            {
                $valFirstName = $firstName;
                $valLastName = $lastName;
                $valEmail = '';
                $valPassword = $password;

                $errors[] = 'el Email ya esta registrado';
            }
        }
        else
        {
            $errors[] = "el Email no es valido";
        }
    }
    else
    {
        if(!isset($_POST['nombre']) || empty($_POST['nombre']))
        {
            $errors[] = 'el nombre es requerido';
        }
        else
        {
            $valFirstName = $_POST['apellido'];
        }
        if(!isset($_POST['apellido']) || empty($_POST['apellido']))
        {
            $errors[] = 'el apellido es requerido';
        }
        else
        {
            $valLastName = $_POST['apellido'];
        }

        if(!isset($_POST['email']) || empty($_POST['email']))
        {
            $errors[] = 'Email es requerido';
        }
        else
        {
            $valEmail = $_POST['email'];
        }

        if(!isset($_POST['password']) || empty($_POST['password']))
        {
            $errors[] = 'el Password es requerido';
        }
        else
        {
            $valPassword = $_POST['password'];
        }
        
    }

}
?>
 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registro de Empleados</title>
        <link rel="stylesheet" href="../public/css/estilos.css">
        <link rel="stylesheet" href="../public/css/registro.css">
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <header id="header">
        <div class="container__header">
            <div class="logo">
                <a style="text-decoration: none;" href="../index.php"><h3>Registro de Empleados</h3></a>
            </div>
        </div>
    </header>
    <body class="sb-nav-fixed">
    <div id="layoutSidenav_content">
       
       <main>
               <div class="container mt-5">
                   <div class="row justify-content-center">
                       <div class="col-lg-7">
                           <div class="card shadow-lg border-0 rounded-lg mt-5">
                               <div class="card-header bg-dark">
                                   <h3 class="text-center text-white font-weight-light my-4">Registrar Usuarios</h3>
                               </div>
                               <div class="card-body">
                               <?php 
                                   if(isset($errors) && count($errors) > 0)
                                   {
                                       foreach($errors as $error_msg)
                                       {
                                           echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                    <strong>'. $error_msg .'</strong>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                 </div>';
                                       }
                                   }
                                   
                                   if(isset($success))
                                   {
                                       
                                       echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                <strong>'. $success .'</strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>';
                                   }
                               ?>
                                   <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                       <div class="row mb-3">
                                           <div class="col-md-6">
                                               <div class="form-floating mb-3 mb-md-0">
                                                   <input class="form-control" name="nombre" id="inputFirstName" type="text" placeholder="Enter first name" />
                                                   <label class="small mb-1" for="inputFirstName">Nombre</label>
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-floating mb-3 mb-md-0">
                                                   <input class="form-control" name="apellido" id="inputLastName" type="text" placeholder="Enter last name" />
                                                   <label class="small mb-1" for="inputLastName">Apellido</label>
                                               </div>
                                           </div>
                                        </div>
                                        
                                        <div class="form-floating mb-3">
                                           <input class="form-control" name="email" id="inputEmailAddress" type="email" aria-describedby="emailHelp" placeholder="Enter email address" />
                                           <label class="small mb-1" for="inputEmailAddress">Email</label>
                                       </div>
                                       
                                       <div class="row mb-3">
                                           <div class="col-md-6">
                                               <div class="form-floating mb-3 mb-md-0">
                                                   <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Enter password" />
                                                   <label class="small mb-1" for="inputPassword">Password</label>
                                               </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-floating mb-3 mb-md-0">
                                                   <input class="form-control" name="repassword" id="inputConfirmPassword" type="password" placeholder="Confirm password" />
                                                    <label class="small mb-1" for="inputConfirmPassword">Confirme el  Password</label>
                                               </div>
                                           </div>
                                       </div>

                                       <input type="checkbox" onclick="compararContrasenia()"> Mostrar Contraseñas

                                       <div class="mt-4 mb-0">
                                           <button type="submit" name="submit" class="btn btn-primary">Registrarse</button>
                                           <a href="iniciar_sesion.php" class="btn btn-success">Login</a>
                                       </div>
                                   </form>
                               </div>
                               <!--<div class="card-footer text-center">
                                   <div class="small"><a href="login.php">¿Tener una cuenta? Ir a iniciar sesión</a></div>
                               </div>-->
                           </div>
                       </div>
                   </div>
               </div>
       </main>
    
   </div>
      
</div> <!-- /form -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script src="../public/js/mostrar.js"></script>
    </body>
</html>
