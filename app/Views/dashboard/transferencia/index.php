<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $title ?></h2>
            <h3><?= view("dashboard/partials/_session"); ?></h3>
          <ol>
             <li><a class="btn btn-outline-info" role="button" href="/transferencia/new" >Nueva Transferencia</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->     

                

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Categoría</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($transferencia as $key => $m): ?>
            <tr>
                <td><?= $m->id_almacen_origen ?></td>
                <td><?= $m->id_almacen_destino ?></td>
                <td><?= $m->id_empleado1 ?></td>
                <td>
                    <form action="/transferencia/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger" />
                    </form>

                    <a href="/transferencia/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links() ?>