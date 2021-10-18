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
    
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">
            <label for="nombre" class="col-sm-2 col-form-label" >Nombre:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nombre" name="nombre" value="<?=old('nombre', $persona->nombre)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="apellido_paterno" class="col-sm-2 col-form-label">Apellido Paterno:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="apellido_paterno" name="apellido_paterno" value="<?=old('apellido_paterno', $persona->apellido_paterno)?>"/><br />
            </div>
        </div>
        
        <div class="mb-3 row">
            <label for="apellido_materno"  class="col-sm-2 col-form-label">Apellido Materno:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="apellido_materno" name="apellido_materno" value="<?=old('apellido_materno', $persona->apellido_materno)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nro_ci"  class="col-sm-2 col-form-label">Documento CI:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nro_ci" name="nro_ci" value="<?=old('nro_ci', $persona->nro_ci)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="direccion_particular"  class="col-sm-2 col-form-label">Direccion Particular:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="direccion_particular" id="direccion_particular"><?=old('direccion_particular', $persona->direccion_particular)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="direccion_trabajo"  class="col-sm-2 col-form-label">Direccion de Trabajo:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="direccion_trabajo" id="direccion_trabajo"><?=old('direccion_trabajo', $persona->direccion_trabajo)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="telefono_particular"  class="col-sm-2 col-form-label">Telefono personal:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="telefono_particular" name="telefono_particular" value="<?=old('telefono_particular', $persona->telefono_particular)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="telefono_trabajo"  class="col-sm-2 col-form-label">Telefono de Trabajo:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="telefono_trabajo" name="telefono_trabajo" value="<?=old('telefono_trabajo', $persona->telefono_trabajo)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="zona_vivienda"  class="col-sm-2 col-form-label">Barrio:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="zona_vivienda" id="zona_vivienda"><?=old('zona_vivienda', $persona->zona_vivienda)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="latitud_vivienda"  class="col-sm-2 col-form-label">Latitud:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="latitud_vivienda" name="latitud_vivienda" value="<?=old('latitud_vivienda', $persona->latitud_vivienda)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="longitud_vivienda"  class="col-sm-2 col-form-label">Longitud:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="longitud_vivienda" name="longitud_vivienda" value="<?=old('longitud_vivienda', $persona->longitud_vivienda)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="celular1"  class="col-sm-2 col-form-label">Celular:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="celular1" name="celular1" value="<?=old('celular1', $persona->celular1)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="celular2"  class="col-sm-2 col-form-label">Celular alternativo:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="celular2" name="celular2" value="<?=old('celular2', $persona->celular2)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="lugar_residencia" class="col-sm-2 col-form-label">Donde reside actualmente:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="lugar_residencia" name="lugar_residencia" value="<?=old('lugar_residencia', $persona->lugar_residencia)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="ocupacion" class="col-sm-2 col-form-label">Ocupacion:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="ocupacion" name="ocupacion" value="<?=old('ocupacion', $persona->ocupacion)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">  
            <label for="foto" class="col-sm-2 col-form-label">Foto:</label>
            <div class="col-sm-10">
                <input type="file" name="foto" class="form-control"/>
            </div>
        </div>

        <div class="col-sm-10">
            <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
        </div>
    </div>
</section>