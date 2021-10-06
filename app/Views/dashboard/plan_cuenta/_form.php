
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
            <label class="col-sm-2 col-form-label" for="id_subcategoria">Cuenta Padre:</label>
            <div class="col-sm-10">
                <select class="form-select" name="id_marca" id="id_marca">
                    <?php foreach ($cuenta_padre as $c): ?>
                        <option <?= $plan_cuenta->id_cuenta_padre !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre_cuenta ?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="codigo_cuenta" class="col-sm-2 col-form-label">Codigo de Cuenta:</label>
            <div class="col-sm-10">
                <input class="form-control" type="number" id="codigo_cuenta" name="codigo_cuenta" min="1" value="<?=old('codigo_cuenta', $plan_cuenta->codigo_cuenta)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre_cuenta" class="col-sm-2 col-form-label">Nombre de Cuenta:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="nombre_cuenta" id="nombre_cuenta"><?=old('nombre_cuenta', $plan_cuenta->nombre_cuenta)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="tipo_cuenta" class="col-sm-2 col-form-label">Tipo de Cuenta:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="tipo_cuenta" id="tipo_cuenta"><?=old('tipo_cuenta', $plan_cuenta->tipo_cuenta)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="grupo" class="col-sm-2 col-form-label">Grupo:</label>
            <div class="col-sm-10">
            <input class="form-control" type="input" id="grupo" name="grupo" value="<?=old('grupo', $plan_cuenta->grupo)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="debe" class="col-sm-2 col-form-label">Debe:</label>
            <div class="col-sm-10">
            <input class="form-control" type="number" id="debe" name="debe" min="1" value="<?=old('debe', $plan_cuenta->debe)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="haber" class="col-sm-2 col-form-label">Haber:</label>
            <div class="col-sm-10">
            <input class="form-control" type="number" id="haber" name="haber" min="1" value="<?=old('haber', $plan_cuenta->haber)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="saldo" class="col-sm-2 col-form-label">Saldo:</label>
            <div class="col-sm-10">
            <input class="form-control" type="number" id="saldo" name="saldo" min="1" value="<?=old('saldo', $plan_cuenta->saldo)?>"/><br /> 
            </div>
        </div>
       
        <div class="col-sm-10">
            <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
        </div>
    </div>
</section>
