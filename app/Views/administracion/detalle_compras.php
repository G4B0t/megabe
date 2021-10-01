<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h5><?= view("dashboard/partials/_session"); ?></h5>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            <li><a class="btn btn-outline-info" role="button" href="/administracion/ver_items/<?=$id_pedido?>" >Agregar más Productos</a></li>
            </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Moneda</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($detalle_compra as $key => $m): ?>
            <tr>
                <td><?= $m->item_codigo ?></td>
                <td><?= $m->item_nombre ?></td>
                <td><?= $m->cantidad ?></td>
                <td><?= $m->total ?></td>
                <td><?= $m->moneda ?> </td>
                <td>
                    <form action="/administracion/borrar_item/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>
                </td>
            </tr>
        <?php endforeach?>

        <tr>
            <td>Total: <span><?= $total ?></span></td>
            <td>
            <form id="confirmForm" action="/administracion/confirmar_compra/<?= $id_pedido ?>" method="POST" enctype="multipart/form-data">
                <!-- Button trigger modal -->
                <button type="submit" class="btn btn-primary">Confirmar</button>
            </form>
            </td>
           
        </tr>

    </tbody>
</table>

<?= $pager->links('detalle_compra','paginacion') ?>