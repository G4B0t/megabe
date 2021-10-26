<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>Megabe</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

     <!-- Favicons -->
  <link href="<?= base_url()?>/img/favicon.png" rel="icon">
  <link href="<?= base_url()?>/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="<?= base_url()?>/css/googleFont.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?= base_url()?>/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/boxicons/css/boxicons.min.css" rel="stylesheet"> 
  <link href="<?= base_url()?>/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url()?>/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


  <!-- Template Main CSS File -->
  
  <link href="<?= base_url()?>/css/style.css" rel="stylesheet">

  <link href="<?= base_url()?>/css/imagenes.css" rel="stylesheet">

</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top <?= $tipo ?> ">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="/<?=$vista?>">Inicio</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar ">
        <ul>
          <?php $i = 0; foreach($rol as $key =>$m):  $i++; ?>

                   <?php if($m->nombre == 'Administrador') { ?>
                      <li><a class="nav-link scrollto active" href="/administracion/cuadro_categoria">CUADRO DE MANDO</a></li>
                      <li class="dropdown"><a href="#"><span>Menu</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                        <li class="dropdown"><a href="/item"><span>Items</span> <i class="bi bi-chevron-down"></i></a>
                          <ul>  
                            <li><a class="nav-link scrollto" href="/categoria">Categorias</a></li>
                            <li><a class="nav-link scrollto" href="/subcategoria">Subcategorias</a></li>
                            <li><a class="nav-link scrollto" href="/subcategoria">Marcas</a></li>
                          </ul>
                        </li>
                        <li class="dropdown"><a href="/persona"><span>Personas</span> <i class="bi bi-chevron-down"></i></a>
                          <ul>  
                            <li><a class="nav-link scrollto" href="/cliente">Clientes</a></li>
                            <li><a class="nav-link scrollto" href="/empleado">Empleados</a></li>
                          </ul>
                        </li>
                        <li class="dropdown"><a href="/almacen"><span>Almacen</span> <i class="bi bi-chevron-down"></i></a>
                          <ul>  
                            <li><a class="nav-link scrollto" href="/transferencia">Transferencias</a></li>
                            <li><a class="nav-link scrollto" href="/item_almacen">Item - Almacen</a></li>
                          </ul>
                        </li>
                        </ul>
                      </li>
                      <li class="dropdown"><a href="#"><span>Vendedor</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                          <li><a class="nav-link scrollto" href="/administracion/armar_pedido"><span>Armar Pedido</span></a></li>
                          <li><a class="nav-link scrollto" href="/administracion/ver_pedidos">Confirmar Pagos</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a href="#"><span>Cajero</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                          <li><a type="button" class="nav-link scrollto" data-bs-toggle="modal" data-bs-target="#caja" data-bs-id="abono">Abono a Caja</a></li>
                          <li><a type="button" class="nav-link scrollto" data-bs-toggle="modal" data-bs-target="#caja" data-bs-id="retiro">Retiro de Caja</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a href="#"><span>Almacenes</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                          <li><a class="nav-link scrollto active" href="/administracion/ver_pagados">Entregas</a></li>
                          <li><a class="nav-link scrollto" href="/administracion/armar_transferencia">Armar Envio</a></li>
                        </ul>
                      </li>
                      <li class="dropdown"><a href="#"><span>Contador</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                          <li><a class="nav-link scrollto active" href="/administracion/nuevo_comprobante">Comprobante</a></li>
                          <li><a class="nav-link scrollto" href="/administracion/mayorizar">Mayorizacion</a></li>
                          <li><a class="nav-link scrollto" href="/administracion/balance_general">Balance General</a></li>
                          <li><a class="nav-link scrollto" href="/administracion/cierre_gestion">Cierre de Gestion</a></li>
                          <li><a class="nav-link scrollto" href="/administracion/inicio_gestion">Inicio de Gestion</a></li>
                        </ul>
                      </li>
                  <?php } ?>

                  <?php if($m->nombre == "Cliente"){ ?>
                    <!-- MENU CLIENTE-->
                    <li><a class="nav-link scrollto" href="/#about">Megabe</a></li> 
                    <li><a class="nav-link scrollto" href="/mis_pedidos">Mis Pedidos</a></li>
                    <li><a class="nav-link scrollto" href="/detalle_venta">Mi Carrito</a></li>
                    <li><a class="nav-link scrollto" href="/user/configuracion">Perfil</a></li>
                  <?php } ?>

                  <?php if($m->nombre == 'Normal' || $m->nombre == 'Cliente') { ?>
                    <!-- MENU NORMAL -->
                      <li class="dropdown"><a href="/productos"><span>Menu</span> <i class="bi bi-chevron-down"></i></a>
                      <ul>
                        <?php foreach ($categoria as $key => $m): ?>
                          <li class="dropdown"><a href="/categorias/<?= $m->id ?>"><span><?= $m->nombre ?></span> <i class="bi bi-chevron-right"></i></a>
                            <ul>
                              <?php foreach ($subcategoria as $subcat => $c): ?>
                                <?php if($m->id == $c->id_categoria){?>
                                    <li class="dropdown"><a href="/subcategorias/<?= $c->id ?>"><span><?= $c->nombre ?></span> <i class="bi bi-chevron-right"></i></a>
                                    <ul>
                                      <?php foreach ($marca as $key => $e): ?>
                                          <?php if($c->id == $e->id_subcategoria){?>
                                            <li><a href="/marcas/<?= $e->id ?>"><?= $e->nombre ?></a></li>
                                          <?php } ?>
                                      <?php endforeach?>
                                    </ul>
                                <?php } ?>
                              <?php endforeach?>
                            </ul>
                        <?php endforeach?>
                      </ul>
                    </li>
                    
                    <li><a class="nav-link scrollto " href="/#portfolio">Categorias</a></li>
                  <?php } ?>
                                  
                  <?php  if(($m->nombre == "Vendedor" || $m->nombre == "Cajero") && $i<2){ ?>
                        <!-- MENU CAJERO o VENDEDOR --> 
                        <li><a class="nav-link scrollto" href="/administracion/ver_pedidos">Confirmar Pagos</a></li>
                  <?php } ?>
                    
                  <?php if($m->nombre == "Cajero"){ ?>
                    <!-- MENU CAJERO --> 
                    <li><a type="button" class="nav-link scrollto" data-bs-toggle="modal" data-bs-target="#caja" data-bs-id="abono">Abono a Caja</a></li>
                    <li><a type="button" class="nav-link scrollto" data-bs-toggle="modal" data-bs-target="#caja" data-bs-id="retiro">Retiro de Caja</a></li>
                  <?php } ?>
                    
                  <?php if($m->nombre == "Vendedor"){ ?>
                    <!-- MENU VENDEDOR --> 
                    <li><a class="nav-link scrollto" href="/administracion/armar_pedido"><span>Armar Pedido</span></a></li>
                  <?php } ?>
                    
                  <?php if($m->nombre == "Almacenes"){ ?>
                    <!-- MENU ALMACENERO --> 
                    <li><a class="nav-link scrollto active" href="/administracion/ver_pagados">Entregas</a></li>
                    <li><a class="nav-link scrollto" href="/administracion/armar_transferencia">Armar Envio</a></li>
                    <li><a class="nav-link scrollto" href="/administracion/ver_enviados">Ver Envios</a></li>
                    <li><a class="nav-link scrollto" href="/administracion/ver_recibidos">Ver Recepciones</a></li>
                      <?php if($central){?>
                        <li><a class="nav-link scrollto" href="/administracion/armar_compra">Ingresar Compra</a></li>
                      <?php } ?>
                  <?php } ?>
                    
                  <?php if ($m->nombre == "Contador"){?>
                      <!-- MENU CONTADOR -->
                      
                      <li><a class="nav-link scrollto active" href="/administracion/nuevo_comprobante">Comprobante</a></li>
                      <li><a class="nav-link scrollto" href="/administracion/mayorizar">Mayorizacion</a></li>
                      <li><a class="nav-link scrollto" href="/administracion/balance_general">Balance General</a></li>
                      <li><a class="nav-link scrollto" href="/administracion/cierre_gestion">Cierre de Gestion</a></li>
                      <li><a class="nav-link scrollto" href="/administracion/inicio_gestion">Inicio de Gestion</a></li>
                  <?php } ?>

                  
          <?php endforeach ?>
        <li><a class="nav-link scrollto" href="/<?= $log?>"><?= $log?></a></li>
        </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header>
  




