
 <!-- ======= Hero Section ======= -->
 <section id="hero">
    <div class="hero-container" data-aos="fade-up" data-aos-delay="150">
      <h2><?= view("dashboard/partials/_session"); ?></h2>
      <h1>Buen Precio, Calidad y Atencion.</h1>
      <h2>Somos un equipo lleno de ingenieros talentosos</h2>
      <div class="d-flex">
        <a href="#about" class="btn-get-started scrollto">Empecemos</a>
        <a href="https://www.youtube.com/watch?v=TvuZwGHAEMM" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>Mirar Video</span></a>
      </div>
    </div>
  </section><!-- End Hero -->


 <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row justify-content-end">
          <div class="col-lg-11">
            <div class="row justify-content-end">

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box">
                  <i class="bi bi-emoji-smile"></i>
                  <span data-purecounter-start="0" data-purecounter-end="125" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Happy Clients</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box">
                  <i class="bi bi-journal-richtext"></i>
                  <span data-purecounter-start="0" data-purecounter-end="85" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Projects</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box">
                  <i class="bi bi-clock"></i>
                  <span data-purecounter-start="0" data-purecounter-end="35" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Years of experience</p>
                </div>
              </div>

              <div class="col-lg-3 col-md-5 col-6 d-md-flex align-items-md-stretch">
                <div class="count-box">
                  <i class="bi bi-award"></i>
                  <span data-purecounter-start="0" data-purecounter-end="48" data-purecounter-duration="1" class="purecounter"></span>
                  <p>Awards</p>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-lg-6 video-box align-self-baseline" data-aos="zoom-in" data-aos-delay="100">
            <img src="<?= base_url()?>/img/about.jpg" class="img-fluid" alt="">
            <a href="https://www.youtube.com/watch?v=TvuZwGHAEMM" class="glightbox play-btn mb-4"></a>
          </div>

          <div class="col-lg-6 pt-3 pt-lg-0 content">
            <h3>Somos los mejores en venta de articulos.</h3>
            <p class="fst-italic">
             Ubicado en Tarija, Santa Cruz y Cochabamba.
            </p>
            <ul>
              <li><i class="bx bx-check-double"></i> Compromiso.</li>
              <li><i class="bx bx-check-double"></i> Calidad de Atencion.</li>
              <li><i class="bx bx-check-double"></i> Productos de Calidad.</li>
            </ul>
            <p>
              Empresa Comercial dedicada a la venta de articulos no percederos
            </p>
          </div>

        </div>

      </div>
    </section><!-- End About Section -->

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
    

    </main><!-- End #main -->

    
