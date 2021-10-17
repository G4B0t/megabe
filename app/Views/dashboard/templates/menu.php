
          <li><a class="nav-link scrollto active" href="/#hero">Home</a></li>
          
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
          <li><a class="nav-link scrollto" href="/#about">About</a></li>
          <li><a class="nav-link scrollto " href="/#portfolio">Categorias</a></li>
          <?php foreach():?>
            <?php if()?>
              <!-- MENU CLIENTE-->
              <li><a class="nav-link scrollto" href="/mis_pedidos">Mis Pedidos</a></li>
              <li><a class="nav-link scrollto" href="/detalle_venta">Mi Carrito</a></li>
              <li><a class="nav-link scrollto" href="/configuracion/2/edit">Configuracion</a></li>
            <?php } ?>
            <?php if()?>
              <!-- MENU VENDEDOR -->                        
              <li><a class="nav-link scrollto" href="/administracion/armar_pedido"><span>Armar Pedido</span></a></li>
            <?php } ?>
              <!-- ACCION EXCEPCION VENDEDOR-CAJERO -->
              <li><a class="nav-link scrollto" href="/administracion/ver_pedidos">Confirmar Pagos</a></li>
              <!-- MENU CONTABILIDAD -->                    
              <li><a class="nav-link scrollto" href="/administracion/nuevo_comprobante">Comprobante</a></li>
              <li><a class="nav-link scrollto" href="/reportes_contabilidad">Incio de Gestion</a></li>
              <li><a class="nav-link scrollto" href="/reportes_contabilidad">Cierre de Gestion</a></li>
              <!-- MENU CAJERO -->
              <li><a type="button" class="nav-link " data-bs-toggle="modal" data-bs-target="#caja" data-bs-id="abono">Abono a Caja</a></li>
              <li><a type="button" class="nav-link " data-bs-toggle="modal" data-bs-target="#caja" data-bs-id="retiro">Retiro de Caja</a></li>
              <!-- MENU ALMACENES -->
              <li><a class="nav-link scrollto active" href="/administracion/ver_pagados">Entregas</a></li>
              <li><a class="nav-link scrollto" href="/administracion/armar_transferencia">Armar Envio</a></li>
              <li><a class="nav-link scrollto" href="/administracion/ver_enviados">Ver Envios</a></li>
              <li><a class="nav-link scrollto" href="/administracion/ver_recibidos">Ver Recepciones</a></li>
                <?php if($central){?>
                  <li><a class="nav-link scrollto" href="/administracion/armar_compra">Ingresar Compra</a></li>
                <?php } ?>

          <?php endforeach?>


