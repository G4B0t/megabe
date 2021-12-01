<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <ol>
            
                <li><a class="btn btn-outline-info" role="button" href="/almacen/new" >Nuevo Almacen</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <h2><?= view("dashboard/partials/_session"); ?></h2>

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($almacen as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->direccion ?></td>
                <td><?= $m->telefono ?></td>
                <td><?= $m->latitud ?></td>
                <td><?= $m->longitud ?></td>
                <td>
                    <form action="/almacen/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar"  class="btn btn-outline-danger"/>
                    </form>

                    <a href="/almacen/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>

                </td>
            </tr>
        <?php endforeach?>

    </tbody>
</table>

<?= $pager->links('almacen','paginacion') ?>