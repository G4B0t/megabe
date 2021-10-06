<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
                <li><a class="btn btn-outline-info" role="button" href="/plan_cuenta/new" >Nuevo Plan Cuenta</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<?= view("dashboard/partials/_session"); ?>


<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id Plan de Cuenta</th>
            <th>Codigo de Cuenta</th>
            <th>Nombre de Cuenta</th>
            <th>Tipo de Cuenta</th>
            <th>Cuenta Padre</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($plan_cuenta as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->codigo_cuenta ?></td>
                <td><?= $m->nombre_cuenta ?></td>
                <td><?= $m->tipo_cuenta ?></td>
                <td><?= $m->id_cuenta_padre ?></td>
                <td>
                    <form action="/plan_cuenta/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>

                    <a href="/plan_cuenta/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>

<?= $pager->links('plan_cuenta','paginacion') ?>

