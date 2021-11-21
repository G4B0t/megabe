<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Datos Generales de Empresa</h2>
          <h2><?= view("dashboard/partials/_session"); ?></h2>
          <ol>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


<section class="inner-page">
    <div class="container">
      <div class="mb-3 row">
            <label for="nombre_empresa" class="col-sm-2 col-form-label">Nombre Empresa:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nombre_empresa" name="nombre_empresa" value="<?=old('nombre_empresa', $generales->nombre_empresa)?>"/><br />
            </div>
      </div>

      <div class="mb-3 row">
            <label for="nit_empresa" class="col-sm-2 col-form-label">Nit Empresa:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nit_empresa" name="nit_empresa" value="<?=old('nit_empresa', $generales->nit_empresa)?>"/><br />
            </div>
      </div>

      <div class="mb-3 row">
            <label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="direccion" name="direccion" value="<?=old('direccion', $generales->direccion)?>"/><br />
            </div>
      </div>

      <div class="mb-3 row">
            <label for="contacto" class="col-sm-2 col-form-label">Contacto:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="contacto" name="contacto" value="<?=old('contacto', $generales->contacto)?>"/><br />
            </div>
      </div>

      <div class="mb-3 row">
            <label for="contacto" class="col-sm-2 col-form-label">Contacto:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="contacto" name="contacto" value="<?=old('contacto', $generales->contacto)?>"/><br />
            </div>
      </div>
    </div>
</section>