<main id="main">
      <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            </ol>
        </div>
      </div>
      <p> <hr> <p>
    </section><!-- End Breadcrumbs -->
   

<!-- ======= Listado Section ======= -->

    <section id="team" class="team section-bg">
      <div class="container" data-aos="fade-up">
        <div class="section-title"> 
            <h2>Listado</h2>
            <p>Productos</p>
        </div>

        <div class="row">
          <form action="/Home/filtrado" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                    <input type="text" name="filtro" class="form-control" id="filtro" placeholder="Producto" required>
                </div>
                <div class="col-md-3 form-group "> 
                    <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    <a href="/productos" class="btn btn-info" type="submit" name="submit">Ver Todo</a>
                </div>
            </div>
          </form>
        </div>

        <br></br>
                        
        <div class="row">
            <?php foreach ($item as $key => $m): ?>
            <div class="col-lg-4 col-md-6">
                <div class="member" data-aos="fade-up" data-aos-delay="150">
                <div class="pic"><img src="<?= base_url()?>/imagen/productos/<?= $m->foto?>" class="img-fluid" alt="" width="600" height="600"></div>
                    <div class="member-info">
                        <h4><?= $m->nombre ?></h4>
                            <span><?= $m->descripcion ?></span>
                            <div class="social">
                                <a href="<?= base_url()?>/detalle/<?= $m->id?>"><img  alt="" src="<?= base_url()?>/img/carrito.png" width="20" height="20"></a>
                            </div>
                    </div>
                </div>
            </div>
            <?php endforeach?>
        </div>
      </div>
    </section><!-- End Listado Section -->


