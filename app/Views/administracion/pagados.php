<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


    <div class="row">
        <div class="col-lg-4 col-md-6">
            <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Pedido#</th>
                    <th>Id Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($pedido as $key => $m): ?>
                    <tr>
                        <td><?= $m->id ?></td>
                        <td><?= $m->id_cliente ?></td>
                        <td><?= $m->cliente_nombre ?></td>
                        <td><?= $m->fecha ?></td>
                        <td>
                            <a href="/administracion/detalle_pagados/<?= $m->id ?>" class="btn btn-primary">Detalle</a>
                        </td>
                    </tr>
                <?php endforeach?>
            </tbody>
        
            </table>
            <?= $pagers->links('pedido_venta','paginacion') ?>    
        </div>
        <div class="col-lg-1 col-md-2">
           
        </div>

        <div class="col-lg-6 col-md-9">
            <h2>DETALLE DE PEDIDO #<?= $id ?></h2>
            <table class="table table-hover" data-aos="fade-up">
                <thead>
                    <tr>
                        <th>Codigo de Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($detalle_venta as $key => $m): ?>
                        <tr>
                            <td><?= $m->item_codigo ?></td>
                            <td><?= $m->item_nombre ?></td>
                            <td><?= $m->cantidad ?></td>
                        </tr>
                    <?php endforeach?>
                    <tr>
                         <td>
                         <form id="formComprobante" action="/administracion/entrega_confirmada/<?= $id ?>" method="POST" enctype="multipart/form-data">  
                            <!-- Button trigger modal -->
                            <button type="submit" class="btn btn-success">Confirmar Entrega</button>
                         </td>
                        </form>
                    </tr>
                </tbody>
            
            </table>
            <?= $pager->links('detalle_venta','paginacion') ?>
    </div>
</div>