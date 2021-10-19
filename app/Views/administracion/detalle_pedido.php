<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h5><?= view("dashboard/partials/_session"); ?></h5>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            <li><a class="btn btn-outline-info" role="button" href="/administracion/ver_productos/<?=$id_pedido?>" >Agregar más Productos</a></li>
            </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->
    <?= view("dashboard/partials/_form-error"); ?>
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

        <?php foreach ($detalle_venta as $key => $m): ?>
            <tr>
                <td><?= $m->item_codigo ?></td>
                <td><?= $m->item_nombre ?></td>
                <td><?= $m->cantidad ?></td>
                <td><?= $m->total ?></td>
                <td><?= $m->moneda ?> </td>
                <td>
                    <form action="/administracion/borrar_producto/<?= $m->id ?>" method="POST">
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
        <h5 class="modal-title" id="exampleModalLabel">Datos de Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="confirmForm" action="/administracion/confirmar_pedido/<?= $id_pedido ?>" method="POST" enctype="multipart/form-data">
        
        <div class="mb-3">
                <input type="checkbox" name="myCheckbox" id="clienteCB" value="1"/><span>Cliente</span>
                <select class="form-select" name="cliente" id="cliente">
                    <?php foreach ($cliente as $c): ?>
                        <option <?= $c->id !== $c->id_persona ?: "selected"?> value="<?= $c->id ?>"><?= $c->fullName ?> </option>
                    <?php endforeach?>
                </select>
                
        </div>
        <div class="mb-3 row">
            <label for="nombre" class="col-sm-2 col-form-label" >Nombre:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nombre" name="nombre" value=""/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="apellido_paterno" class="col-sm-2 col-form-label">Apellido Paterno:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="apellido_paterno" name="apellido_paterno" value=""/><br />
            </div>
        </div>
        
        <div class="mb-3 row">
            <label for="razon_social"  class="col-sm-2 col-form-label">Razon Social:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="razon_social" name="razon_social" value=""/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nro_ci"  class="col-sm-2 col-form-label">Nro CI:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nro_ci" name="nro_ci" value=""/><br />
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

    modalTitle.textContent = 'Datos de Cliente'
    })
</script>