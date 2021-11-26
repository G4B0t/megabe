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
    <form action="/adminitracion/modificar_generales" method="POST" enctype="multipart/form-data">
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
            <label for="actividad_principal" class="col-sm-2 col-form-label">Actividad Principal:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="actividad_principal" name="actividad_principal" value="<?=old('actividad_principal', $generales->actividad_principal)?>"/><br />
            </div>
      </div>
      <div class="mb-3 row">
            <label for="actividad_secundaria" class="col-sm-2 col-form-label">Actividad Secundaria:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="actividad_secundaria" name="actividad_secundaria" value="<?=old('actividad_secundaria', $generales->actividad_secundaria)?>"/><br />
            </div>
      </div>
      <div class="mb-3 row">
            <label for="leyenda" class="col-sm-2 col-form-label">Leyenda:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="leyenda" name="leyenda" value="<?=old('leyenda', $generales->leyenda)?>"/><br />
            </div>
      </div>
      <div class="mb-3 row">
            <label for="nro_autorizacion" class="col-sm-2 col-form-label">Nro Autorizacion:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nro_autorizacion" name="nro_autorizacion" value="<?=old('nro_autorizacion', $generales->nro_autorizacion)?>"/><br />
            </div>
      </div>
      <div class="mb-3 row">
                <label for="fechaLimite" class="col-sm-2 col-form-label">Fecha Limite de Emision:</label>
                <div class="col-sm-10">
                <input type="date" id="fechaLimite" name="fechaLimite" min="<?php echo $generales->gestion.'-01-01' ?>" value="<?php echo $generales->fechaLimite?>">
                </div>
      </div>
      <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto:</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="foto" onchange="readURL(this);"/>
                <img id="blah" src="<?= base_url()?>/imagen/empresa/<?= $generales->foto?>" alt="Foto Previa" /> 
            </div>
        </div>
      <div class="mb-3 row">
          <div class="col-sm-10">
              <input class="btn btn-secondary"action="action" onclick="window.history.go(-1); return false;" type="submit" value="Cancelar" />
              <input class="btn btn-success" type="submit" name="submit" value="Guardar" />
          </div>
      </div>
      
    </div>
    </form>
</section>