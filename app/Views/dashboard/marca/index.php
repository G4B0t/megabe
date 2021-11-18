<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            
                <li><a class="btn btn-outline-info" role="button" href="/marca/new" >Nueva Marca</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Subcategoria</th>
            <th>Descripcion</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($marca as $key => $m): ?>
            <tr>
                <td><?= $m->nombre ?></td>
                <td><?= $m->subcategoria ?></td>
                <td><?= $m->descripcion ?></td>
                <td>
                    <form action="/marca/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>

                    <a href="/marca/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('marca','paginacion') ?>

