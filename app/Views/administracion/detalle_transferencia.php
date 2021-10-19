<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            <li><a class="btn btn-outline-info" role="button" href="/administracion/show_items/<?=$id_transferencia?>" >Agregar más Productos</a></li>
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
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($detalle_transferencia as $key => $m): ?>
            <tr>
                <td><?= $m->item_codigo ?></td>
                <td><?= $m->item_nombre ?></td>
                <td><?= $m->cantidad ?></td>
                <td>
                    <form action="/administracion/delete_producto/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>
                </td>
            </tr>
        <?php endforeach?>

        <tr>
            <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalle_modal" data-bs-id="<?=$id_transferencia?>" >Confirmar Envio</button>
            </td>
        </tr>

    </tbody>
</table>

<?= $pager->links('detalle_transferencia','paginacion') ?>


<div class="modal fade" id="detalle_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Almacen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="confirmForm" action="/administracion/confirmar_transferencia/<?= $id_transferencia ?>" method="POST" enctype="multipart/form-data">
           
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="id_almacen_destino">Almacen:</label>
                <div class="col-sm-10">
                    <select class="form-select" name="id_almacen_destino" id="id_almacen_destino">
                        <?php foreach ($almacen as $c): ?>
                            <option <?= $transferencia->id_almacen_destino !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->direccion ?> </option>
                        <?php endforeach?>
                    </select>
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

    modalTitle.textContent = 'Elegir Almacen de Destino'
    })
</script>