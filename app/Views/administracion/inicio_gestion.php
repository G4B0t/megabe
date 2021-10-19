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
<form action="/administracion/cambiar_gestion" method="POST" enctype="multipart/form-data">
    <section class="inner-page">
        <div class="container">
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label" for="gestion">Gestión:</label>
                <div class="col-sm-10">
                    <input class="form-control" type="input" id="gestion" name="gestion" value="<?=old('gestion', $general->gestion)?>"/><br />
                </div>
            </div>

            <div class="col-sm-10">
                <input class="btn btn-success" type="submit" name="submit" value="Guardar" />
            </div>
        </div>
    </section>
</form>