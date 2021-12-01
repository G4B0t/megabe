<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Cuentas Generales de Empresa</h2>
          <h2><?= view("dashboard/partials/_session"); ?></h2>
          <ol>
          </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<section class="inner-page">
    <div class="container">
    <form action="/administracion/modificar_cuentas" method="POST" enctype="multipart/form-data">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="cuenta_ventas">Cuenta de Venta:</label>
            <div class="col-sm-10">
                <select class="form-select" name="cuenta_ventas" id="cuenta_ventas">
                    <?php foreach ($plan_cuenta as $c): ?>
                        <option <?= $generales->cuenta_ventas !== $c->codigo_cuenta ?: "selected"?> value="<?= $c->codigo_cuenta ?>"><?= $c->nombre_cuenta ?> - <?= $c->codigo_cuenta ?></option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="cuenta_compras">Cuenta de Compra:</label>
            <div class="col-sm-10">
                <select class="form-select" name="cuenta_compras" id="cuenta_compras">
                    <?php foreach ($plan_cuenta as $c): ?>
                        <option <?= $generales->cuenta_compras !== $c->codigo_cuenta ?: "selected"?> value="<?= $c->codigo_cuenta ?>"><?= $c->nombre_cuenta ?> - <?= $c->codigo_cuenta ?></option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="cuenta_bancos">Cuenta de Banco:</label>
            <div class="col-sm-10">
                <select class="form-select" name="cuenta_bancos" id="cuenta_bancos">
                    <?php foreach ($plan_cuenta as $c): ?>
                        <option <?= $generales->cuenta_bancos !== $c->codigo_cuenta ?: "selected"?> value="<?= $c->codigo_cuenta ?>"><?= $c->nombre_cuenta ?> - <?= $c->codigo_cuenta ?></option>
                    <?php endforeach?>
                </select>
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