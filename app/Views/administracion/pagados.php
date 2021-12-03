<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


    <div class="row">
        <div class="col-lg-4 col-md-6">
            <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Pedido#</th>
                    <th>Id Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($pedido as $key => $m): ?>
                    <tr>
                        <td><?= $m->id ?></td>
                        <td><?= $m->id_cliente ?></td>
                        <td><?= $m->cliente_nombre ?></td>
                        <td><?= $m->fecha ?></td>
                        <td>
                            <a href="/administracion/detalle_pagados/<?= $m->id ?>" class="btn btn-primary">Detalle</a>
                        </td>
                    </tr>
                <?php endforeach?>
            </tbody>
        
            </table>
            <?= $pagers->links('pedido_venta','paginacion') ?>    
        </div>
        <div class="col-lg-1 col-md-2">
           
        </div>

        <div class="col-lg-6 col-md-9">
            <h2>DETALLE DE PEDIDO #<?= $id ?></h2>
            <table class="table table-hover" data-aos="fade-up">
                <thead>
                    <tr>
                        <th>Codigo de Producto</th>
                        <th>Nombre de Producto</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($detalle_venta as $key => $m): ?>
                        <tr>
                            <td><?= $m->item_codigo ?></td>
                            <td><?= $m->item_nombre ?></td>
                            <td><?= $m->cantidad ?></td>
                        </tr>
                    <?php endforeach?>
                    <tr>
                         <td>
                         <form id="formComprobante" action="/administracion/entrega_confirmada/<?= $id ?>" method="POST" enctype="multipart/form-data">  
                            <!-- Button trigger modal -->
                            <a type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#cierre" data-bs-id="contraseña">Confirmar Entrega</a>
                         </td>
                        </form>
                    </tr>
                </tbody>
            
            </table>
            <?= $pager->links('detalle_venta','paginacion') ?>
    </div>
</div>

<div class="modal fade" id="cierre" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Confirmacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="confirmForm2" action="/administracion/entrega_confirmada/<?= $id ?>"  method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3 row">
                        <strong>Confirmar Contraseña: </strong><input type="password" id="password" name="password" class="form-control" placeholder="contraseña">     
                    </div> 
                        <div class="modal-footer">  
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        
                            <button type="submit" name="submit" class="btn btn-primary">Confirmar</button>
                    
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </div>

    <script>
    var detalle_modal = document.getElementById('detalle_modal')
    detalle_modal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
   
    var recipient = button.getAttribute('data-bs-stock')
    var id_item = button.getAttribute('data-bs-id')
    var nombre_item = button.getAttribute('data-bs-nombre')

    var modalTitle = detalle_modal.querySelector('.modal-title')

    modalTitle.textContent = 'Agregar cantidades del producto: ' + nombre_item

    var input = document.getElementById('cantidad')
    input.setAttribute("max",recipient)

    var item = document.getElementById('item_id')
    item.setAttribute("value",id_item)
    })
</script>