<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $title ?></h2>
            <h4><?= view("dashboard/partials/_session"); ?></h4>
            <ol>
            <li><a class="btn btn-outline-info" role="button" href="/empleado_rol/new" >Agregar Nuevo Rol a Empleado</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


<table class="table table-hover" data-aos="fade-up" data-toggle="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Roles</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($empleado_rol as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->fullname ?></td>
                <td><?= $m->usuario ?></td>
                <td><?= $m->rol ?></td>
                <td>
                    <form action="/empleado_rol/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar Rol" class="btn btn-outline-danger"/>
                    </form>
                    <a href="/empleado_rol/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar Rol</a>
                   
                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('empleado','paginacion') ?>