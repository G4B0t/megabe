<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
            <ol>
                <li><a class="btn btn-outline-info" role="button" href="/comprobante/new" >Nuevo Comprobante</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <h2><?= view("dashboard/partials/_session"); ?></h2>

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Subcategoría</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($comprobante as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->beneficiario ?></td>
                <td><?= $m->glosa ?></td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('item','paginacion') ?>