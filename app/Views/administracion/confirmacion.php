<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h2><?= view("dashboard/partials/_session"); ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="/item_almacen">Item Almacen</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


    <div class="row">
        <div class="col-lg-4 col-md-6">
            <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>#Pedido</th>
                    <th>Id Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
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
                        <td><?php echo number_format($m->total) ?></td>
                        <td>
                            <a href="/administracion/mostrar_detalle/<?= $m->id ?>" class="btn btn-primary">Detalle</a>
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
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Stock en Almacen</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($detalle_venta as $key => $m): ?>
                        <tr>
                            <td><?= $m->item_codigo ?></td>
                            <td><?= $m->item_nombre ?></td>
                            <td><?php echo number_format($m->precio_unitario) ?></td>
                            <td><?= $m->cantidad ?></td>
                            <td><?= $m->stock_almacen ?></td>
                            <td><?php echo number_format($m->total) ?></td>
                        </tr>
                    <?php endforeach?>
                    <tr>
                         <td>Total: <span><?= $total ?></span></td>
                         <td>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#factura_modal" data-bs-id="<?=$id?>" >Confirmar Pago</button>
                         </td>
                    </tr>
                </tbody>
            
            </table>
            <?= $pager->links('detalle_venta','paginacion') ?>
    </div>
</div>

<div class="modal fade" id="factura_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos de Factura</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="confirmForm" action="/administracion/confirmar_pago/<?= $id ?>" method="POST" enctype="multipart/form-data">
                <?php foreach($rol as $key =>$m): ?>
                        <?php  if($m->nombre == 'Cajero'){ ?>
                            <div class="mb-3">
                                <input type="checkbox" name="myCheckbox" id="cajaCB" value="Caja" onClick="toggleSelect(this)"/><span>Cuenta Caja</span>
                                <select class="form-select" name="cajas" id="cajas">
                                    <option <?= $cajas->id_cuenta_padre !== $cajas->id ?: "selected"?> value="<?= $cajas->id ?>"><?= $cajas->nombre_cuenta ?> </option>
                                </select>
                            </div>
                        <?php } ?>
                <?php endforeach ?>
                <div class="mb-3">
                    <input type="checkbox" name="myCheckbox" id="bancoCB" value="Banco" onClick="toggleSelect(this)"/><span>Cuenta Banco</span>
                    <select class="form-select" name="bancos" id="bancos">
                        <?php foreach ($bancos as $c): ?>
                            <option <?= $c->id_cuenta_padre !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre_cuenta ?> </option>
                        <?php endforeach?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="respaldo" class="col-sm-4 col-form-label">Respaldo PDF:</label>
                    <div class="col-sm-10">
                        <input class="form-control" type="file" name="respaldo"/>
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
    var factura_modal = document.getElementById('factura_modal')
    factura_modal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
   
    var recipient = button.getAttribute('data-bs-id')

    var modalTitle = factura_modal.querySelector('.modal-title')

    modalTitle.textContent = 'Datos para Cuenta del Pedido #' + recipient
    })
   
    window.onload = toggleSelect() // to disable select on load if needed
    
    var isChecked = document.getElementById("cajaCB").checked;
    document.getElementById("cajas").disabled = !isChecked;
    var isChecked = document.getElementById("bancoCB").checked;
    document.getElementById("bancos").disabled = !isChecked;

    function toggleSelect(id)
    {
        var isChecked = document.getElementById("cajaCB").checked;
        document.getElementById("cajas").disabled = !isChecked;
        var isChecked = document.getElementById("bancoCB").checked;
        document.getElementById("bancos").disabled = !isChecked;
        var myCheckbox = document.getElementsByName("myCheckbox");

        Array.prototype.forEach.call(myCheckbox,function(el){
                el.checked = false;
            });
        id.checked = true;
        var isChecked = document.getElementById("cajaCB").checked;
        document.getElementById("cajas").disabled = !isChecked;
        var isChecked = document.getElementById("bancoCB").checked;
        document.getElementById("bancos").disabled = !isChecked;
    }

   
</script>

