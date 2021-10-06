<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <?= view("dashboard/partials/_session"); ?>

    <div class="row">
        <div class="col-lg-4 col-md-6">
            <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Transferencia#</th>
                    <th>Enviado por</th>
                    <th>Fecha de Envio</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($transferencia as $key => $m): ?>
                    <tr>
                        <td><?= $m->id ?></td>
                        <td><?= $m->empleado_nombre1 ?></td>
                        <td><?= $m->fecha_envio ?></td>
                        <td>
                            <a href="/administracion/detalles_recepcion/<?= $m->id ?>" class="btn btn-primary">Detalle</a>
                        </td>
                    </tr>
                <?php endforeach?>
            </tbody>
        
            </table>
            <?= $pagers->links('transferencia','paginacion') ?>    
        </div>
        <div class="col-lg-1 col-md-2">
           
        </div>

        <div class="col-lg-6 col-md-9">
            <h2>DETALLE DE RECEPCION #<?= $id ?></h2>
            <table class="table table-hover" data-aos="fade-up">
                <thead>
                    <tr>
                        <th>Codigo de Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($detalle_transferencia as $key => $m): ?>
                        <tr>
                            <td><?= $m->item_codigo ?></td>
                            <td><?= $m->item_nombre ?></td>
                            <td><?= $m->cantidad ?></td>
                        </tr>
                        
                    <?php endforeach?>
                    <tr>
                         <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalle_modal" data-bs-id="<?= $id_empleado2 ?>">Confirmar</button>
                         </td>
                    </tr>

                </tbody>
            
            </table>
            <?= $pager->links('detalle_transferencia','paginacion') ?>
    </div>
</div>

  
<div class="modal fade" id="detalle_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Que Cantidad desea agarrar</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form id="confirmForm" action="/administracion/recepcion_confirmada/<?= $id ?>" method="POST" enctype="multipart/form-data">
            
            <div class="mb-3 row">
                <strong>Seguro que quiere confirmar la recepcion? </strong>     
            </div>        
            <div class="modal-footer">  
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <input id="transferencia_id" name="transferencia_id" type="hidden" value="">
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
   
    var id_transferencia = button.getAttribute('data-bs-id')

    var modalTitle = detalle_modal.querySelector('.modal-title')

    modalTitle.textContent = 'Confirmacion de Transferencia #'+ id_transferencia

    var transferencia = document.getElementById('transferencia_id')
    transferencia.setAttribute("value",id_transferencia)
    })
</script>