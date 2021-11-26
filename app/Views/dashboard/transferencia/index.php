<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $title ?></h2>
            <h3><?= view("dashboard/partials/_session"); ?></h3>
            <ol>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->     

                

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>#</th>
            <th>Enviado por:</th>
            <th>Almacen Origen</th>
            <th>Fecha Envio</th>
            <th>Almacen Destino</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($transferencia as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->fullname ?></td>
                <td><?= $m->origen ?></td>
                <td><?= $m->fecha_envio ?></td>
                <td><?= $m->destino ?></td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('transferencia','paginacion') ?>