<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            <li><a class="btn btn-outline-info" role="button" href="/persona/new" >Nuevo Producto</a></li>
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
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Documento CI</th>
            <th>Direccion Particular</th>
            <th>Direccion Trabajo</th>
            <th>Telefono Particular</th>
            <th>Telefono Trabajo</th>
            <th>Barrio</th>
            <th>Latitud</th>
            <th>Longitud</th>
            <th>Celular Particular</th>
            <th>Celular Alternativo</th>
            <th>Residencia Actual</th>
            <th>Ocupacion</th>
            <th>Opciones</th>
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
                <td><?= $m->direccion_trabajo ?></td>
                <td><?= $m->telefono_particular ?></td>
                <td><?= $m->telefono_trabajo ?></td>
                <td><?= $m->zona_vivienda ?></td>
                <td><?= $m->latitud_vivienda ?></td>
                <td><?= $m->longitud_vivienda ?></td>
                <td><?= $m->celular1 ?></td>
                <td><?= $m->celular2 ?></td>
                <td><?= $m->lugar_residencia ?></td>
                <td><?= $m->ocupacion ?></td>
                <td>
                    <form action="/persona/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>

                    <a href="/persona/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>
<?= $pager->links('persona','paginacion') ?>



