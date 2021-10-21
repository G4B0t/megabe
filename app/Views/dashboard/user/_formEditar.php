<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="/productos">Ver Productos</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


<section class="inner-page">
    <div class="container">

        <div class="mb-3 row">
            <label for="contrasena" class="col-sm-2 col-form-label">CONTRASEÑA:</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="contrasena" name="contrasena" /><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="foto" onchange="readURL(this);"/>
                <img id="blah" src="<?= base_url()?>/imagen/clientes/<?= $persona['foto']?>" alt="Foto Previa" />
            </div>
        </div>

        <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />