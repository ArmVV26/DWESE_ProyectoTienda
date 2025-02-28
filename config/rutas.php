<?php

    // Importo las clases necesarias
    use Controllers\HomeController;
    use Controllers\UsuarioController;
    use Controllers\CategoriaController;
    use Controllers\ProductoController;
    use Controllers\CarritoController;
    use Controllers\PedidoController;

    // Importo la clase Router
    use Lib\Router;

    // RUTAS GENERALES
    // Defino la ruta por defecto
    Router::add('GET', '', function(){
        return (new HomeController())->index();
    });
    Router::add('GET', 'categoria/:id', function($id){
        return (new HomeController())->index($id);
    });


    // RUTAS USUARIOS
    // Ruta para registrar un usuario
    Router::add('GET', 'usuario/formularioRegistro', function(){
        return (new UsuarioController())->registrar();
    });
    Router::add('POST', 'usuario/formularioRegistro', function(){
        return (new UsuarioController())->registrar();
    });
    // Ruta para mostrar el formulario de registro exitoso
    Router::add('GET', 'usuario/registroExitoso', function(){
        return (new UsuarioController())->registrar();
    });
    Router::add('POST', 'usuario/registroExitoso', function(){
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
    Router::add('GET', 'usuario/eliminar/:id', function($id){
        return (new UsuarioController())->eliminarUsuario($id);
    });
    // Ruta para actualizar/editar un usuario
    Router::add('GET', 'usuario/actualizarUsuario/:id', function($id){
        return (new UsuarioController())->actualizarUsuario($id);
    });
    Router::add('POST', 'usuario/actualizarUsuario/:id', function($id){
        return (new UsuarioController())->actualizarUsuario($id);
    });
    // Ruta para mostrar el perfil de un usuario
    Router::add('GET', 'usuario/perfil', function(){
        return (new UsuarioController())->perfilUsuario();
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
    Router::add('GET', 'categoria/eliminar/:id', function($id){
        return (new CategoriaController())->eliminarCategoria($id);
    });

    // RUTAS PRODUCTOS
    // Ruta para crear un producto
    Router::add('GET', 'admin/crearProducto', function(){
        return (new ProductoController())->crearProducto();
    });
    Router::add('POST', 'admin/crearProducto', function(){
        return (new ProductoController())->crearProducto();
    });
    // Ruta para mostrar los productos
    Router::add('GET', 'admin/mostrarProductos', function(){
        return (new ProductoController())->mostrarProductos();
    });
    // Ruta para eliminar un producto
    Router::add('GET', 'producto/eliminar/:id', function($id){
        return (new ProductoController())->eliminarProducto($id);
    });
    // Ruta para actualizar/editar un producto
    Router::add('GET', 'admin/actualizarProducto/:id', function($id){
        return (new ProductoController())->actualizarProducto($id);
    });
    Router::add('POST', 'admin/actualizarProducto/:id', function($id){
        return (new ProductoController())->actualizarProducto($id);
    });

    // RUTAS CARRITO
    // Ruta para agregar un producto al carrito
    Router::add('GET', 'carrito/agregarProducto/:id', function($id){
        return (new CarritoController())->agregarProducto($id);
    });
    Router::add('POST', 'carrito/agregarProducto/:id', function($id){
        return (new CarritoController())->agregarProducto($id);
    });
    // Ruta para mostrar el carrito
    Router::add('GET', 'carrito/mostrarCarrito', function(){
        return (new CarritoController())->mostrarCarrito();
    });
    // Ruta para restar/eliminar un producto del carrito
    Router::add('GET', 'carrito/restarProducto/:id', function($id){
        return (new CarritoController())->restarProducto($id);
    });
    // Ruta para eliminar un producto del carrito
    Router::add('GET', 'carrito/eliminarProducto/:id', function($id){
        return (new CarritoController())->eliminarProducto($id);
    });
    // Ruta para vaciar el carrito
    Router::add('GET', 'carrito/vaciarCarrito', function(){
        return (new CarritoController())->vaciarCarrito();
    });

    // RUTAS PEDIDO
    // Ruta para formulario pedido
    Router::add('GET', 'pedido/formularioPedido', function(){
        return (new PedidoController())->formularioPedido();
    });
    Router::add('POST', 'pedido/formularioPedido', function(){
        return (new PedidoController())->formularioPedido();
    });
    // Ruta para mostrar el pedido existoso
    Router::add('GET', 'pedido/pedidoExitoso', function(){
        return (new PedidoController())->formularioPedido();
    });
    Router::add('POST', 'pedido/pedidoExitoso', function(){
        return (new PedidoController())->formualrioPedido();
    });
    // Ruta para mostrar los pedidos de un usuario
    Router::add('GET', 'pedido/mostrarPedidos', function(){
        return (new PedidoController())->obtenerPedidosUsuario();
    });
    Router::add('POST', 'pedido/mostrarPedidos', function(){
        return (new PedidoController())->obtenerPedidosUsuario();
    });
    
    // Defino la ruta por defecto
    Router::dispatch();