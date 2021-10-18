                
                
<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><li><a class="btn btn-outline-info" role="button" href="/cliente/new" >Nuevo Cliente</a></li></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->
                



<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Usuario</th>
            <th>Nit</th>
            <th>Razon Social</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($cliente as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->cliente ?></td>
                <td><?= $m->usuario ?></td>
                <td><?= $m->nit ?></td>
                <td><?= $m->razon_social ?></td>
                <td>
                    <form action="/cliente/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>

                    <a href="/cliente/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('cliente','paginacion') ?>