<?php
session_start();
require_once('./config/conexion.php');
 
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
					header('location: ./views/empleados.php');
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