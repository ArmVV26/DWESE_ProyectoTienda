<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?=URL_BASE ?>public/media/img/Logo-HiperArmando.ico">
    <link rel="stylesheet" href="<?=URL_BASE ?>public/css/estilo.css">
    <title><?=$titulo?></title>
</head>
<body>
    <header>
        <a href="<?=URL_BASE?>" class="logo">
            <img class="logo-web" src="<?=URL_BASE ?>public/media/img/Logo-HiperArmando.svg" alt="Logo de la Tienda">
        </a>
        <nav class="menu">
            <ul>
                <li><a href="<?=URL_BASE?>">Inicio</a></li>
                <?php
                    if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']['rol'] === 'cliente') {
                        echo "
                            <li class='menu-user'>
                                <a href=''>". $_SESSION['inicioSesion']['nombre'] ."</a>
                                <ul class='submenu'>
                                    <li><a href='".URL_BASE."'>Perfil</a></li>
                                    <li><a href='".URL_BASE."usuario/actualizarUsuario/".$_SESSION['inicioSesion']['id']."'>Editar Perfil</a></li>
                                    <li><a href='".URL_BASE."usuario/cerrarSesion'>Cerrar Sesion</a></li>
                                </ul>
                            </li>
                        ";

                    } elseif (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']['rol'] === 'admin') {
                        echo "
                            <li class='menu-user'>
                                <a href=''>". $_SESSION['inicioSesion']['nombre'] ."</a>
                                <ul class='submenu'>
                                    <li><a href='".URL_BASE."'>Perfil</a></li>
                                    <li><a href='".URL_BASE."admin/mostrarUsuarios'>Mostrar Usuarios</a></li>
                                    <li><a href='".URL_BASE."admin/mostrarCategorias'>Mostrar Categorias</a></li>
                                    <li><a href='".URL_BASE."admin/mostrarProductos'>Mostrar Productos</a></li>
                                    <li><a href='".URL_BASE."usuario/formularioRegistro'>Crear Usuario</a></li>
                                    <li><a href='".URL_BASE."admin/crearCategoria'>Crear Categoria</a></li>
                                    <li><a href='".URL_BASE."admin/crearProducto'>Crear Producto</a></li>
                                    <li><a href='".URL_BASE."usuario/cerrarSesion'>Cerrar Sesion</a></li>
                                </ul>
                            </li>
                        ";
                    } else {
                        echo "
                            <li><a href='".URL_BASE."usuario/formularioRegistro'>Crear Cuenta</a></li>
                            <li><a href='".URL_BASE."usuario/formularioLogin'>Iniciar Sesion</a></li>
                        ";
                    }
                ?>
            </ul>
        </nav>
    </header>
