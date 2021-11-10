<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            
                <li><a class="btn btn-outline-info" role="button" href="/item/new" >Nuevo Producto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Marca</th>
            <th>Empresa Proveedora</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($item as $key => $m): ?>
            <tr>
                <td><img src="<?= base_url()?>/imagen/productos/<?= $m->foto ?>" width="300" height="250" > </img> </td>
                <td><?= $m->nombre ?></td>
                <td><?= $m->marca ?></td>
                <td><?= $m->proveedor ?></td>
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

