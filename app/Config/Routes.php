<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/productos/(:any)/(:any)', 'Home::listaHome/$1/$2');
$routes->get('/productos', 'Home::listarTodo');
$routes->get('/detalle/(:any)', 'Home::detalle/$1');
$routes->get('/filtrado', 'Home::filtrado');
$routes->get('/categorias/(:any)', 'Home::menuCategoria/$1');
$routes->get('/subcategorias/(:any)', 'Home::menuSubcategoria/$1');
$routes->get('/marcas/(:any)', 'Home::menuMarca/$1');

$routes->get('/administracion', 'Administracion_1::index');
$routes->get('/administracion/confirmar_pago/(:any)', 'Administracion_1::confirmar_pago/$1');
$routes->get('/administracion/mostrar_detalle/(:any)', 'Administracion_1::mostrar_detalle/$1');
$routes->get('/administracion/ver_pedidos', 'Administracion_1::listar');
$routes->get('/administracion/ver_productos/(:any)', 'Administracion_1::ver_productos/$1');
$routes->post('/administracion/confirmar_pedido/(:any)', 'Administracion_1::confirmar_pedido/$1');
$routes->post('/administracion/movimiento_caja/(:any)', 'Administracion_1::movimiento_caja/$1');
$routes->get('/administracion/armar_pedido', 'Administracion_1::armar_pedido');
$routes->get('/administracion/mostrar_carrito/(:any)', 'Administracion_1::mostrar_carrito/$1');
$routes->post('/administracion/agregar_carrito/(:any)', 'Administracion_1::agregar_carrito/$1');
$routes->post('/administracion/borrar_producto/(:any)', 'Administracion_1::borrar_producto/$1');

$routes->post('/administracion/confirmar_compra/(:any)', 'Administracion_2::confirmar_compra/$1');
$routes->post('/administracion/agregar_item/(:any)', 'Administracion_2::agregar_linea/$1');
$routes->get('/administracion/armar_compra', 'Administracion_2::new_compra');
$routes->get('/administracion/ver_carrito/(:any)', 'Administracion_2::mostrar_linea/$1');
$routes->get('/administracion/ver_items/(:any)', 'Administracion_2::ver_items/$1');
$routes->post('/administracion/borrar_item/(:any)', 'Administracion_2::borrar_linea/$1');

$routes->get('/administracion/armar_transferencia', 'Administracion_3::nueva_transferencia_envio');
$routes->post('/administracion/sumar_item/(:any)', 'Administracion_3::agregar_item_envio/$1');
$routes->get('/administracion/ver_pedido_trasferencia/(:any)', 'Administracion_2::ver_carrito_envio/$1');
$routes->get('/administracion/show_items/(:any)', 'Administracion_2::show_items/$1');
$routes->post('/administracion/delete_item/(:any)', 'Administracion_2::delete_linea/$1');

$routes->get('/administracion/nuevo_comprobante', 'Administracion_2::comprobante');
$routes->get('/administracion/ver_comprobante/(:any)', 'Administracion_2::ver_comprobante/$1');
$routes->post('/administracion/save_comprobante/(:any)', 'Administracion_2::guardar_comprobante/$1');
$routes->post('/administracion/nuevo_detalle/(:any)', 'Administracion_2::new_detalle/$1');
$routes->post('/administracion/editar_detalle/(:any)', 'Administracion_2::edit_detalle/$1');
$routes->post('/administracion/borrar_detalle/(:any)', 'Administracion_2::delete_detalle/$1');
$routes->get('/administracion/ver_pagados', 'Administracion_2::listar');
$routes->get('/administracion/detalle_pagados/(:any)', 'Administracion_2::mostrar_detalle/$1');
$routes->post('/administracion/entrega_confirmada/(:any)', 'Administracion_2::confirmar_entrega/$1');


$routes->get('/imagen/(:any)/(:any)', 'Home::imagen/$1/$2',['as' =>'get_image']);
$routes->get('/contacto/(:any)', 'Home::contacto/$1',['as' => 'contacto']);

$routes->get('/login', 'User::login',['as' =>'user_login_get']);
$routes->post('/login_user', 'User::login_post',['as' =>'user_login_post']);
$routes->get('/logout', 'User::logout',['as' =>'logout_post']);
$routes->get('/registrar_nuevo', 'Cliente::nuevo');
$routes->get('/cliente/(:any)/editar', 'Cliente::editar/$1');

$routes->get('/mostrando/(:any)', 'Pedido_Venta::mostrando/$1');
$routes->get('/mis_pedidos', 'Pedido_Venta::index');
$routes->get('/actualizar/(:any)', 'Pedido_Venta::actualizarVigente/$1');

$routes->resource('item');
$routes->resource('subcategoria');
$routes->resource('categoria');
$routes->resource('almacen');
$routes->resource('cliente');
$routes->resource('empleado');

$routes->get('/detalle_venta/(:any)/(:any)', 'Detalle_Venta::carrito/$1/$2');
$routes->post('/detalle_venta/confirmar_pedido_cliente/(:any)', 'Detalle_Venta::confirmarPedido/$1');


$routes->post('/cliente/crear', 'Cliente::crear');
$routes->post('/cliente/actualizar', 'Cliente::actualizar');
$routes->post('/user/configuracion', 'User::configuracion');

$routes->get('/detalle_venta', 'Detalle_Venta::index');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
