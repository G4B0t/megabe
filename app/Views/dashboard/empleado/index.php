<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $title ?></h2>
            <h4><?= view("dashboard/partials/_session"); ?></h4>
            <ol>
                <li><a class="btn btn-outline-info" role="button" href="/empleado/new" >Nuevo Empleado</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Almacen</th>
            <th>Rol</th>
            <th>Asignacion</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($empleado as $key => $m): ?>
            <tr>
                <td><?= $m->fullname ?></td>
                <td><?= $m->usuario ?></td>
                <td><?= $m->almacen ?></td>
                <td><?= $m->rol ?></td>
                <td><?= $m->caja ?></td>
                <td>
                    <form action="/empleado/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>
                    <a href="/empleado/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>
                    <?php if($m->rol == 'Cajero') { ?>
                        <a class="btn btn-outline-info" role="button" href="/cambiar_caja/<?= $m->id ?>" >Cambiar Caja</a>
                    <?php } ?>
                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('empleado','paginacion') ?>