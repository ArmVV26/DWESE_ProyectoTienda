<?php

    // Importo las clases necesarias
    use App\Controllers\UsuarioController;

    // Importo la clase Router
    use Lib\Router;

    // Defino la ruta por defecto
    Router::add('GET', '', function(){
        return (new UsuarioController())->registrar();
    });

    // RUTAS USUARIOS
    // Ruta para registrar un usuario
    Router::add('GET', 'usuario/formularioRegistro', function(){
        return (new UsuarioController())->registrar();
    });
    Router::add('POST', 'usuario/formularioRegistro', function(){
        return (new UsuarioController())->registrar();
    });
    // Ruta para iniciar sesión
    Router::add('GET', 'usuario/formularioLogin', function(){
        return (new UsuarioController())->login();
    });
    Router::add('POST', 'usuario/formularioLogin', function(){
        return (new UsuarioController())->login();
    });
    // Ruta para cerrar sesión
    Router::add('GET', 'usuario/cerrarSesion', function(){
        return (new UsuarioController())->cerrarSesion();
    });
    // Ruta para mostrar los usuarios
    Router::add('GET', 'admin/mostrarUsuarios', function(){
        return (new UsuarioController())->mostrarUsuarios();
    });
    // Ruta para eliminar un usuario
    Router::add('GET', 'usuario/eliminar', function(){
        return (new UsuarioController())->eliminarUsuario();
    });

    // Defino la ruta por defecto
    Router::dispatch();