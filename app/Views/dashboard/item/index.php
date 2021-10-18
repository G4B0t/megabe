<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
                <li><a class="btn btn-outline-info" role="button" href="/item/new" >Nuevo Producto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <h2><?= view("dashboard/partials/_session"); ?></h2>


<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Marca</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($item as $key => $m): ?>
            <tr>
                <td><img src="<?= base_url()?>/imagen/productos/<?= $m->foto ?>" width="300" height="250" > </img> </td>
                <td><?= $m->nombre ?></td>
                <td><?= $m->marca ?></td>
                <td>
                    <form action="/item/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>

                    <a href="/item/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('item','paginacion') ?>

