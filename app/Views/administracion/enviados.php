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

    <?= view("dashboard/partials/_session"); ?>

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Transferencia#</th>
                    <th>Enviado por</th>
                    <th>Fecha de Envio</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($transferencia as $key => $m): ?>
                    <tr>
                        <td><?= $m->id ?></td>
                        <td><?= $m->empleado_nombre1 ?></td>
                        <td><?= $m->fecha_envio ?></td>
                        <td>
                            <a href="/administracion/detalle_transferencias/<?= $m->id ?>" class="btn btn-primary">Detalle</a>
                        </td>
                    </tr>
                <?php endforeach?>
            </tbody>
        
            </table>
            <?= $pagers->links('transferencia','paginacion') ?>    
        </div>
        <div class="col-lg-1 col-md-2">
           
        </div>

        <div class="col-lg-6 col-md-9">
            <h2>DETALLE DE ENVIO #<?= $id ?></h2>
            <table class="table table-hover" data-aos="fade-up">
                <thead>
                    <tr>
                        <th>Codigo de Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($detalle_transferencia as $key => $m): ?>
                        <tr>
                            <td><?= $m->item_codigo ?></td>
                            <td><?= $m->item_nombre ?></td>
                            <td><?= $m->cantidad ?></td>
                        </tr>
                    <?php endforeach?>
                </tbody>
            
            </table>
            <?= $pager->links('detalle_transferencia','paginacion') ?>
    </div>
</div>