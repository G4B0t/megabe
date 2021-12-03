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

    <div class="container">
    <div class="row">
          <form action="/administracion/filtrar_item" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                    <input type="text" name="filtro" class="form-control" id="filtro" placeholder="Producto" required>
                </div>
                <div class="col-md-3 form-group "> 
                    <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    <a href="/item" class="btn btn-info" type="submit" name="submit">Ver Todo</a>
                </div>
            </div>
          </form>
    </div>

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
                    <a href="/item/<?= $m->id ?>" class="btn btn-outline-success">Kardex</a>


                </td>
                
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('item','paginacion') ?>

</div>
