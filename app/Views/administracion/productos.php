<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            
            <li><a class="btn btn-outline-dark" role="button" href="/administracion/mostrar_carrito/<?= $id_pedido?>">Ver Carrito</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <div class="row">
          <form action="/administracion/filtrado_items_venta/<?=$id_pedido?>" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                    <input type="text" name="filtro" class="form-control" id="filtro" placeholder="Producto" required>
                </div>
                <div class="col-md-3 form-group "> 
                    <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    <a href="/administracion/armar_pedido" class="btn btn-info" type="submit" name="submit">Ver Todo</a>
                </div>
            </div>
          </form>
    </div>

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Producto</th>
            <th>Codigo</th>
            <th>Descripcion</th>
            <th>Stock</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($item as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->nombre ?></td>
                <td><?= $m->codigo ?></td>
                <td><?= $m->descripcion ?></td>
                <td><?= $m->stock ?></td>
                <td>
                    
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detalle_modal" data-bs-id="<?= $m->id ?>" data-bs-nombre="<?= $m->nombre ?>" data-bs-stock="<?= $m->stock ?>">Agregar Producto</button>                   
            </td>
            </tr>
        <?php endforeach?>
    </tbody>
</table>
<?= $pager->links('item','paginacion') ?>

<div class="modal fade" id="detalle_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Que Cantidad desea agarrar de </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="confirmForm" action="/administracion/agregar_carrito/<?= $id_pedido ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3 row">
                <strong>Cantidad: </strong><input type="number" id="cantidad" name="cantidad" step="1" class="form-control" placeholder="1" min="1" max="">     
            </div>                    
            <div class="modal-footer">  
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <input id="item_id" name="item_id" type="hidden" value="">
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