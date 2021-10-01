<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h5><?= view("dashboard/partials/_session"); ?></h5>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
        <div class="container">
        <form id="formComprobante" action="/administracion/save_comprobante/<?= $comprobante->id ?>" method="POST" enctype="multipart/form-data">  
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="glosa">GLOSA:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="input" id="glosa" name="glosa" value=""/><br />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="tipo_respaldo">TIPO DE RESPALDO:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="input" id="tipo_respaldo" name="tipo_respaldo" value=""/><br />
                </div>
            </div>
            <input type="submit" name="submit" value="Guardar" class="btn btn-outline-success"/>
        </form>
        </div>
    </section>

    <table class="table table-hover" data-aos="fade-up">
    <thead class="table-dark">
        <tr>
            <th>Codigo de Cuenta</th>
            <th>Nombre de Cuenta</th>
            <th>Debe</th>
            <th>Haber</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($detalle_comprobante as $key => $m): ?>
            <tr>
                <td> <?= $m->codigo_cuenta ?> </td>
                <td> <?= $m->nombre_cuenta ?> </td>
                <td> <?= $m->debe ?> </td>
                <td> <?= $m->haber ?> </td>
                <td>
                    <form action="/administracion/borrar_detalle/<?=$m->id_detalle?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#comprobante_modal" data-bs-id="<?= $m->id_detalle?>" data-bs-accion="editar_detalle/<?= $m->id_detalle?>" >Editar</button>                 
                </td>
            </tr>
        <?php endforeach?>
        <tr>
            <td>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#comprobante_modal" data-bs-id="" data-bs-accion="nuevo_detalle/<?= $comprobante->id ?>" >Agregar</button>
            </td> 
            <td>TOTAL </td>
            <td><?= $total->debe?></td>
            <td><?= $total->haber?></td>
        </tr>

    </tbody>
</table>
<?= $pager->links('detalle_comprobante','paginacion') ?>
        


<div class="modal fade" id="comprobante_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="confirmForm" action="" method="POST" enctype="multipart/form-data">      
            <div class="mb-3 row">
                <div class="col-sm-10">
                    <input type="checkbox" name="myCheckbox" id="partida" value="debe" onClick="toggleSelect(this)"/><span>Debe</span>
                    <input type="checkbox" name="myCheckbox" id="partida" value="haber" onClick="toggleSelect(this)"/><span>Haber</span>
                </div>
            </div>
            
            <div class="mb-3">
                <select class="form-select" name="cuentas" id="cuentas">
                    <?php foreach ($cuentas as $c): ?>
                        <option <?= $c->id_cuenta_padre !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre_cuenta ?> </option>
                    <?php endforeach?>
                </select>
            </div>

            <div class="mb-3 row">
                <strong>Monto (bs): </strong><input type="number" id="monto" name="monto" step="1" class="form-control" placeholder="1" min="1">     
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
    var detalle_modal = document.getElementById('comprobante_modal')
    detalle_modal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
   
    var recipient = button.getAttribute('data-bs-accion')
    var recipient1 = button.getAttribute('data-bs-id')

    var modalTitle = detalle_modal.querySelector('.modal-title')

    modalTitle.textContent = 'Detalle de Comprobante '+recipient1
    var formAction = document.getElementById('confirmForm')
    formAction.action = "/administracion/" + recipient
    })

    window.onload = toggleSelect() // to disable select on load if needed
    
    function toggleSelect(id)
    {
        var myCheckbox = document.getElementsByName("myCheckbox");
        Array.prototype.forEach.call(myCheckbox,function(el){
                el.checked = false;
            });
        id.checked = true;
    }
    
</script>