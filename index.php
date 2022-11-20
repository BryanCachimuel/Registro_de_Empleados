<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú con portada - MagtimusPro</title>

    <link rel="stylesheet" href="./public/css/estilos.css">
    <script src="https://kit.fontawesome.com/41bcea2ae3.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>   

    <header id="header">
        <div class="container__header">
            <div class="logo">
                <a style="text-decoration: none;" href="index.php"><h3>Registro de Empleados</h3></a>
            </div>
            <div class="container__nav">
                <nav id="nav">
                    <ul>
                        <li><a href="./views/iniciar_sesion.php" class="select">Iniciar Sesión</a></li>
                    </ul>
                </nav>         
                <div class="btn__menu" id="btn_menu"><i class="fas fa-bars"></i></div>
            </div>
        </div>
    </header>

    <div class="container__all" id="container_all">

        <div class="cover">

            <div class="container__cover">

                <div class="container__info">
                    <h1>Registro de</h1>
                    <h2>Empleados</h2>
                    <p>Sistema creado para el registro de empleados de la empresa</p>
                    <a href="./views/registrar.php" class="btn btn-warning">Registrar</a>
                </div>
                <div class="container__vector">
                    <img src="./public/images/undraw_Code_thinking_re_gka2.svg">
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Iniciar Sesión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                    
                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                        <button type="submit" name="submit" class="btn btn-primary">Inicar Sesión</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>