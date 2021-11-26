<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h5><?= view("dashboard/partials/_session"); ?></h5>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="/item_almacen">Item Almacen</a></li>
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
                <a type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#cierre" data-bs-id="contraseña">Confirmar</a>
            </form>
            </td>
           
        </tr>

    </tbody>
</table>

<?= $pager->links('detalle_compra','paginacion') ?>

<div class="modal fade" id="cierre" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Confirmacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="confirmForm2" action="/administracion/confirmar_compra/<?= $id_pedido ?>"  method="POST" enctype="multipart/form-data">
                    
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