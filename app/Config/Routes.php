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

$routes->post('/administracion/searchCliente', 'Administracion_1::searchCliente');
$routes->get('/administracion', 'Administracion_1::index');
$routes->post('/administracion/confirmar_pago/(:any)', 'Administracion_1::confirmar_pago/$1');
$routes->get('/administracion/mostrar_detalle/(:any)', 'Administracion_1::mostrar_detalle/$1');
$routes->get('/administracion/ver_pedidos', 'Administracion_1::listar');
$routes->get('/administracion/ver_productos/(:any)', 'Administracion_1::ver_productos/$1');
$routes->post('/administracion/confirmar_pedido/(:any)', 'Administracion_1::confirmar_pedido/$1');
$routes->post('/administracion/movimiento_caja/(:any)', 'Administracion_1::movimiento_caja/$1');
$routes->get('/administracion/armar_pedido', 'Administracion_1::armar_pedido');
$routes->get('/administracion/mostrar_carrito/(:any)', 'Administracion_1::mostrar_carrito/$1');
$routes->post('/administracion/agregar_carrito/(:any)', 'Administracion_1::agregar_carrito/$1');
$routes->post('/administracion/borrar_producto/(:any)', 'Administracion_1::borrar_producto/$1');
$routes->post('/administracion/filtrado_items_venta/(:any)', 'Administracion_1::filtrar_producto_venta/$1');

$routes->post('/administracion/confirmar_compra/(:any)', 'Administracion_2::confirmar_compra/$1');
$routes->post('/administracion/agregar_item/(:any)', 'Administracion_2::agregar_linea/$1');
$routes->get('/administracion/armar_compra', 'Administracion_2::new_compra');
$routes->get('/administracion/ver_carrito/(:any)', 'Administracion_2::mostrar_linea/$1');
$routes->get('/administracion/ver_items/(:any)', 'Administracion_2::ver_items/$1');
$routes->post('/administracion/ver_items_filtrado/(:any)', 'Administracion_2::ver_items_filtrado/$1');
$routes->post('/administracion/borrar_item/(:any)', 'Administracion_2::borrar_linea/$1');

$routes->get('/administracion/armar_transferencia', 'Administracion_3::nueva_transferencia_envio');
$routes->post('/administracion/sumar_producto/(:any)', 'Administracion_3::agregar_item_envio/$1');
$routes->get('/administracion/ver_pedido_trasferencia/(:any)', 'Administracion_3::ver_carrito_envio/$1');
$routes->get('/administracion/show_items/(:any)', 'Administracion_3::show_items/$1');
$routes->post('/administracion/show_items_filtrado/(:any)', 'Administracion_3::show_items_filtrado/$1');
$routes->post('/administracion/delete_item/(:any)', 'Administracion_3::delete_linea/$1');
$routes->post('/administracion/confirmar_transferencia/(:any)', 'Administracion_3::confirm_transferencia/$1');
$routes->get('/administracion/ver_enviados', 'Administracion_3::ver_enviados');
$routes->get('/administracion/detalle_transferencias/(:any)', 'Administracion_3::detalles_transferencias/$1');

$routes->get('/administracion/ver_recibidos', 'Administracion_3::ver_recepcion_transferencia');
$routes->get('/administracion/detalles_recepcion/(:any)', 'Administracion_3::ver_detalle_recepcion/$1');
$routes->post('/administracion/recepcion_confirmada/(:any)', 'Administracion_3::confirmar_recepcion/$1');

$routes->get('/administracion/configuracion', 'Administracion_4::configuracion');
$routes->post('/adminitracion/actualizar_usuario/(:any)', 'Administracion_4::actualizar_empleado/$1');
$routes->get('/administracion/generales', 'Administracion_4::modificar_generales');
$routes->post('/adminitracion/modificar_generales', 'Administracion_4::update_generales');
$routes->get('/administracion/items_reorden', 'Administracion_4::items_reorden');
$routes->post('/administracion/filtrar_punto_reorden', 'Administracion_4::filtrar_punto_reorden');

$routes->post('/administracion/modificar_cuentas', 'Administracion_2::update_cuentas');
$routes->get('/administracion/cuentas_generales', 'Administracion_2::cuentas_generales');
$routes->get('/administracion/nuevo_comprobante', 'Administracion_2::nuevo_comprobante');
$routes->get('/administracion/ver_comprobante/(:any)', 'Administracion_2::ver_comprobante/$1');
$routes->post('/administracion/save_comprobante/(:any)', 'Administracion_2::guardar_comprobante/$1');
$routes->post('/administracion/nuevo_detalle/(:any)', 'Administracion_2::new_detalle/$1');
$routes->post('/administracion/editar_detalle/(:any)', 'Administracion_2::edit_detalle/$1');
$routes->post('/administracion/borrar_detalle/(:any)', 'Administracion_2::delete_detalle/$1');
$routes->get('/administracion/ver_pagados', 'Administracion_2::listar');
$routes->get('/administracion/detalle_pagados/(:any)', 'Administracion_2::mostrar_detalle/$1');
$routes->post('/administracion/entrega_confirmada/(:any)', 'Administracion_2::confirmar_entrega/$1');

$routes->post('/administracion/cuadro_mando/categoria_filtrado', 'Administracion_4::cuadro_categoria_filtrado');
$routes->post('/administracion/cuadro_mando/subcategoria_filtrado', 'Administracion_4::cuadro_subcategoria_filtrado');
$routes->post('/administracion/cuadro_mando/marca_filtrado', 'Administracion_4::cuadro_marca_filtrado');
$routes->post('/administracion/cuadro_mando/item_filtrado', 'Administracion_4::cuadro_item_filtrado');

$routes->get('/administracion/cuadro_categoria', 'Administracion_4::cuadro_mando_categoria');
$routes->get('/administracion/cuadro_subcategoria/(:any)', 'Administracion_4::cuadro_mando_subcategoria/$1');
$routes->get('/administracion/cuadro_marca/(:any)', 'Administracion_4::cuadro_mando_marca/$1');
$routes->get('/administracion/cuadro_item/(:any)', 'Administracion_4::cuadro_mando_item/$1');
$routes->get('/administracion/mayorizar', 'Administracion_4::plan_cuenta_mayorizar');
$routes->post('/administracion/cierre_gestion', 'Administracion_4::cerrar_gestion');
$routes->get('/administracion/inicio_gestion', 'Administracion_4::iniciar_gestion');
$routes->post('/administracion/cambiar_gestion', 'Administracion_4::nueva_gestion');
$routes->get('/administracion/balance_general', 'Administracion_4::generar_balance_general');
$routes->post('/administracion/filtrado_anulacion', 'Anulacion::filtrado_anulacion');
$routes->post('/administracion/confirmar_anulacion', 'Anulacion::confirmar_password');

$routes->get('/imagen/(:any)/(:any)', 'Home::imagen/$1/$2',['as' =>'get_image']);
$routes->get('/contacto/(:any)', 'Home::contacto/$1',['as' => 'contacto']);

$routes->get('/login', 'User::login',['as' =>'user_login_get']);
$routes->post('/login_user', 'User::login_post',['as' =>'user_login_post']);
$routes->get('/logout', 'User::logout',['as' =>'logout_post']);

$routes->get('/cliente/(:any)/editar', 'Cliente::editar/$1');
$routes->get('/pedido_venta', 'Pedido_Venta::index');
$routes->get('/pedido_venta/mostrando/(:any)', 'Pedido_Venta::mostrando/$1');
$routes->get('/mis_pedidos', 'Pedido_Venta::index');
$routes->get('/actualizar/(:any)', 'Pedido_Venta::actualizarVigente/$1');

$routes->resource('item');
$routes->resource('item_almacen');
$routes->resource('subcategoria');
$routes->resource('categoria');
$routes->resource('almacen');
$routes->resource('cliente');
$routes->resource('empleado');
$routes->resource('plan_cuenta');
$routes->resource('proveedor');
$routes->resource('empleado_rol');
$routes->resource('marca');
$routes->resource('anulacion');

$routes->get('/empleado/asignacion/(:any)', 'Empleado::asginar/$1');
$routes->get('/cambiar_caja/(:any)', 'Empleado::modificar_caja/$1');
$routes->post('/empleado/modificar_caja/(:any)', 'Empleado::updateCaja/$1');

$routes->get('/detalle_venta/(:any)/(:any)', 'Detalle_Venta::carrito/$1/$2');
$routes->post('/detalle_venta/confirmar_pedido_cliente/(:any)', 'Detalle_Venta::confirmarPedido/$1');
$routes->post('/detalle_venta/delete/(:any)', 'Detalle_Venta::delete/$1');
$routes->post('/detalle_venta/carrito/(:any)', 'Detalle_Venta::carrito/$1');
$routes->get('/detalle_venta', 'Detalle_Venta::index');

$routes->post('/user/crear', 'User::crear');
$routes->post('/user/actualizar', 'User::actualizar');
$routes->post('/user/configuracion', 'User::configuracion');
$routes->get('/registrar_nuevo', 'User::nuevo');

$routes->get('/generar_pdf/(:any)','Administracion_1::generatePDF/$1');



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
