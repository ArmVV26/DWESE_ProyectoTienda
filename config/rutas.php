<?php

    // Importo las clases necesarias
    use Controllers\HomeController;
    use Controllers\UsuarioController;
    use Controllers\CategoriaController;

    // Importo la clase Router
    use Lib\Router;

    // Defino la ruta por defecto
    Router::add('GET', '', function(){
        return (new HomeController())->index();
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
    // Ruta para actualizar/editar un usuario
    Router::add('GET', 'usuario/actualizarUsuario', function(){
        return (new UsuarioController())->actualizarUsuario();
    });
    Router::add('POST', 'usuario/actualizarUsuario', function(){
        return (new UsuarioController())->actualizarUsuario();
    });

    // RUTAS CATEGORÍAS
    // Ruta para crear una categoría
    Router::add('GET', 'admin/crearCategoria', function(){
        return (new CategoriaController())->crearCategoria();
    });
    Router::add('POST', 'admin/crearCategoria', function(){
        return (new CategoriaController())->crearCategoria();
    });
    // Ruta para mostrar las categorías
    Router::add('GET', 'admin/mostrarCategorias', function(){
        return (new CategoriaController())->mostrarCategorias();
    });
    // Ruta para eliminar una categoría
    Router::add('GET', 'categoria/eliminarCategoria', function(){
        return (new CategoriaController())->eliminarCategoria();
    });

    // Defino la ruta por defecto
    Router::dispatch();