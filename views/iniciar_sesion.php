<?php
session_start();
require_once('../config/conexion.php');
 
if(isset($_POST['submit'])){

	if(isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])){
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
 
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			$sql = "select * from usuarios where email = :email ";
			$handle = $pdo->prepare($sql);
			$params = ['email'=>$email];
			$handle->execute($params);
			if($handle->rowCount() > 0){
				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
				
                if(password_verify($password, $getRow['password'])){
					unset($getRow['password']);
					$_SESSION = $getRow;
					header('location: empleados.php');
					exit();
				}
				else{
					$errors[] = "Error en  Email o Password";
				}
			}
			else
			{
				$errors[] = "Error Email o Password";
			}			
		}
		else
		{
			$errors[] = "Email no valido";	
		}
	}
	else
	{
		$errors[] = "Email y Password son requeridos";	
	} 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="./public/css/estilos.css">
    <link rel="stylesheet" href="../public/css/registro.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
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
                                   <h3 class="text-center text-white font-weight-light my-4">Inicio de Sesión de Usuarios</h3>
                               </div>
                               <div class="card-body">
                               <?php
                                    if (isset($errors) && count($errors) > 0) {
                                        foreach ($errors as $error_msg) {
                                            echo '<div class="alert alert-danger">' . $error_msg . '</div>';
                                        }
                                    }
                                ?>
                                     <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="email" id="inputEmail" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                        
                                        <div class="mt-4 mb-0">
                                            <button type="submit" name="submit" class="btn btn-primary">Inicar Sesión</button>
                                            <a class="btn btn-warning" href="registrar.php">Registrar</a>
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
</body>
</html>