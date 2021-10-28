
<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
            <ol>
                <li><a class="btn btn-outline-info" role="button" href="/proveedor/new" >Nuevo Proveedor</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<table class="table" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Empresa</th>
            <th>Contacto</th>
            <th>Item</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($proveedor as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->proveedor ?></td>
                <td><?= $m->nombre_empresa ?></td>
                <td><?= $m->contacto ?></td>
                <td><?= $m->item ?></td>
                <td>
                    <form action="/proveedor/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>

                    <a href="/proveedor/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>
<?= $pager->links('proveedor','paginacion') ?>
