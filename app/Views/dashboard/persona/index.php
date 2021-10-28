<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            <li><a class="btn btn-outline-info" role="button" href="/persona/new" >Nuevo Registro</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->     

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Documento CI</th>
            <th>Direccion Particular</th>
            <th>Telefono Particular</th>
            <th>Celular Particular</th>
            <th>Residencia Actual</th>
            <th>Ocupacion</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($persona as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->nombre ?></td>
                <td><?= $m->apellido_paterno ?></td>
                <td><?= $m->apellido_materno ?></td>
                <td><?= $m->nro_ci ?></td>
                <td><?= $m->direccion_particular ?></td>
                <td><?= $m->telefono_particular ?></td>
                <td><?= $m->celular1 ?></td>
                <td><?= $m->lugar_residencia ?></td>
                <td><?= $m->ocupacion ?></td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>
<?= $pager->links('persona','paginacion') ?>



