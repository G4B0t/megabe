 <!-- ======= Hero Section ======= -->
 <section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
      <h2><?= view("dashboard/partials/_session"); ?></h2>
      
      <h1>Gestion ADMINISTRATIVA</h1>
      <h2>Bienvenido <?php echo $empleado ?></h2>
      <div class="d-flex">
        <a href="#about" class="btn-get-started scrollto">Empecemos</a>
        <a href="https://www.youtube.com/watch?v=TvuZwGHAEMM" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Mirar Video</span></a>
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
                <form id="confirmForm2" action="/administracion/cierre_gestion" method="POST" enctype="multipart/form-data">
                    
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

    <div class="modal fade" id="caja" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Datos de Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="confirmForm" action="/administracion/movimiento_caja" method="POST" enctype="multipart/form-data">
                    
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
        
  </section><!-- End Hero -->
    <?php if($rol == 'Vendedor' || $rol == 'Vendedor-Cajero'){?>
      <!-- ======= Portfolio Section ======= -->
      <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>Categorias</h2>
          </div>

          <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-12 d-flex justify-content-center">
              <ul id="portfolio-flters">
                <li data-filter="*" class="filter-active">Todas</li>
                <?php foreach ($categoria as $key => $m): ?>
                      <li data-filter=".filter-<?= $m->nombre ?>"><?= $m->nombre ?></li>    
                  <?php endforeach?>
              </ul>
            </div>
          </div>

          <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
              <?php foreach ($subcategoria as $key => $m): ?>
                  <div class="col-lg-4 col-md-6 portfolio-item filter-<?= $m->categoria ?>">
                      <img src="<?= base_url()?>/imagen/subcategorias/<?= $m->foto?>" class="img-fluid" alt="">
                      <div class="portfolio-info">
                      <h4></h4>
                      <p><?= $m->nombre ?></p>
                      <a href="<?= base_url()?>/imagen/subcategorias/<?= $m->foto?>" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="<?= $m->descripcion ?>"><i class="bx bx-plus"></i></a>
                      <a href="<?= base_url()?>/productos/<?= $m->id_categoria?>/<?= $m->id?>" class="details-link" title="PRODUCTOS"><i class="bx bx-link"></i></a>
                      </div>
                  </div>
              <?php endforeach?>
          </div>
        </div>
        
      </section><!-- End Portfolio Section -->
    <?php } ?>
  </main><!-- End #main -->

<script>
    var detalle_modal = document.getElementById('caja')
    detalle_modal.addEventListener('show.bs.modal', function (event) {
    // Button that triggered the modal
    var button = event.relatedTarget
   
    var recipient = button.getAttribute('data-bs-id')

    var modalTitle = detalle_modal.querySelector('.modal-title')

    modalTitle.textContent = 'Monto de '+ recipient

    var formAction = document.getElementById('confirmForm')
    formAction.action = "/administracion/movimiento_caja/"+recipient
    })

    var detalle_modal1 = document.getElementById('cierre')
    detalle_modal1.addEventListener('show.bs.modal', function (event1) {
    // Button that triggered the modal
    var button1 = event1.relatedTarget

    var modalTitle1 = detalle_modal1.querySelector('.modal-title')

    modalTitle1.textContent = 'Confirmarcion de Cierre de Gestion'
    })
</script>     