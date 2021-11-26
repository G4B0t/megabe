<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            

            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->
    <div class="row">
          <form action="/item_almacen" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                    <input type="text" name="filtro" class="form-control" id="filtro" placeholder="Producto" required>
                </div>
                <div class="col-md-3 form-group "> 
                    <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    <a href="/productos" class="btn btn-info" type="submit" name="submit">Ver Todo</a>
                </div>
            </div>
          </form>
        </div>

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Item</th>
            <th>Codigo</th>
            <th>Stock Total</th>
            <th>Stock en Almacen</th>
            <th>Almacen</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($item_almacen as $key => $m): ?>
            <tr>
                <td><?= $m->nombre ?></td>
                <td><?= $m->codigo ?></td>
                <td><?= $m->total ?></td>
                <td><?= $m->stock?></td>
                <td><?= $m->direccion ?></td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('item_almacen','paginacion') ?>

