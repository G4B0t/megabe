<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <?= view("dashboard/partials/_session"); ?>

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($pedido_venta as $key => $m): ?>
                    <tr>
                        <td><?= $m->id ?></td>
                        <td><?= $m->fecha ?></td>
                        <td><?= $m->estado_ref ?></td>
                        <td>
                            <a href="/pedido_venta/mostrando/<?= $m->id ?>" class="btn btn-primary">Ver</a>
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
            <table class="table table-hover" data-aos="fade-up">
                <thead>
                    <tr>
                        <th>Codigo de Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($detalle_venta as $key => $m): ?>
                        <tr>

                            <td><?= $m->item_codigo ?></td>
                            <td><?= $m->item_nombre ?></td>
                            <td><?= $m->cantidad ?></td>
                            <td><?= $m->precio_unitario ?></td>
                            <td><?= $m->total ?></td>

                        </tr>
                        <?php endforeach?>
                </tbody>
            
            </table>
            <?= $pager->links('detalle_venta','paginacion') ?>
    </div>
</div>



