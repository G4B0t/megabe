<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
          <li><a class="btn btn-outline-dark" role="button" href="/anulacion">Volver</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->
<?= view("dashboard/partials/_form-error"); ?>
<form action="create" method="POST" enctype="multipart/form-data">
<?= view("administracion/anulacion/_form",['textButton' => 'Guardar']); ?>


      <div class="modal fade" id="cierre" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">                    
                    <div class="mb-3 row">
                        <strong>Confirmar Contraseña: </strong><input type="password" id="password" name="password" class="form-control" placeholder="contraseña">     
                    </div> 
                        <div class="modal-footer">  
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        
                            <button type="submit" name="submit" class="btn btn-primary">Confirmar</button>
                    
                        </div>
                </div>
            </div>
        </div>
      </div>
  </form>

<script>

    var detalle_modal = document.getElementById('cierre')
    detalle_modal.addEventListener('show.bs.modal', function (event1) {
    // Button that triggered the modal
    var button1 = event1.relatedTarget

    var modalTitle1 = detalle_modal.querySelector('.modal-title')

    modalTitle1.textContent = 'Confirmarcion de Anulacion'
    })
</script>     