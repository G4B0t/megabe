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
  
  <!-- ======= Portfolio Details Section ======= -->
  <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper-container">
              <div class="swiper-wrapper align-items-center">

                    <div class="swiper-slide" style="text-align:center" >
                        <img src="<?= base_url()?>/imagen/productos/<?= $item->foto ?>" alt="">
                    </div>

              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Informacion del Producto</h3>
              <ul>
                <li><strong>Producto</strong>: <?= $item->nombre?></li>
                <li><strong>Stock</strong>: <?= $item->stock?></li>
                <li><strong>Precio</strong>: <?php echo number_format($item->precio_unitario) ?></li>
                <li>
                    <form action="/detalle_venta/carrito/<?= $item->id ?>" method="POST" enctype="multipart/form-data">
                    <strong>Cantidad </strong>:<input type="number" id="cantidad" name="cantidad" step="1" class="form-control" placeholder="0" min="1" max="<?= $item->stock?>">   
                </li>
                <li><button class="btn btn-success" type="submit" name="submit">Agregar a Carrito</button></li>
                    </form>
              </ul>
            </div>
            <div class="portfolio-description">
              <h2>Descripcion del Producto</h2>
                <p><?= $item->descripcion ?></p>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

  </main><!-- End #main -->