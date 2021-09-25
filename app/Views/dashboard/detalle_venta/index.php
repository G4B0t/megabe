<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            <li><a class="btn btn-outline-info" role="button" href="/productos" >Agregar más Productos</a></li>
            </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

<p><?= view("dashboard/partials/_session"); ?></p>

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Producto</th>
            <th>Codigo</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Moneda</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($detalle_venta as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->item_nombre ?></td>
                <td><?= $m->item_codigo ?></td>
                <td><?= $m->cantidad ?></td>
                <td><?= $m->total ?></td>
                <td><?= $m->moneda ?> </td>
                <td>
                    <form action="/detalle_venta/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>
                </td>
            </tr>
        <?php endforeach?>

        <tr>
            <td>Total: <span><?= $total ?></span></td>
            <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalle_modal" data-bs-id="<?=$id_pedido?>" >Confirmar Pedido</button>
            </td>
        </tr>

    </tbody>
</table>

<?= $pager->links('detalle_venta','paginacion') ?>



<div class="modal fade" id="detalle_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos de Factura</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="confirmForm" action="detalle_venta/confirmar_pedido_cliente/<?= $id_pedido ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="cliente" class="col-form-label">Cliente:</label>
                <input type="text" class="form-control" id="cliente" value="<?=$cliente['nombre_cliente']?>" readonly>
            </div>
            <div class="mb-3">
                <label for="razon_social" class="col-form-label">Razon Social:</label>
                <input type="input" class="form-control" id="razon_social" name="razon_social" value="<?=$cliente['razon_social']?>">
            </div>
            <div class="mb-3">
                <label for="nit" class="col-form-label">NIT:</label>
                <input type="input" class="form-control" id="nit" name="nit" value="<?= $cliente['nit']?>">
            </div>
            </div>
            <div class="modal-footer">  
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            
                <button type="submit" name="submit" class="btn btn-primary">Confirmar</button>
        
            </div>
        </form>
    </div>
  </div>
</div>

<script>
    var detalle_modal = document.getElementById('detalle_modal')
    detalle_modal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
   
    var recipient = button.getAttribute('data-bs-id')

    var modalTitle = detalle_modal.querySelector('.modal-title')

    modalTitle.textContent = 'Datos para Factura del Pedido #' + recipient
    })
</script>