<section class="inner-page">
    <div class="container">

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="id_almacen">*ALMACEN: </label>
            <div class="col-sm-10">
                <select class="form-select" name="id_almacen" id="id_almacen">
                    <?php foreach ($almacen as $c): ?>
                        <option <?= $empleado->id_almacen !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?=  $c->direccion ?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="rol">*ROL: </label>
            <div class="col-sm-10">
                <select class="form-select" name="rol" id="rol">
                    <?php foreach ($rol as $c): ?>
                        <option <?= $c->id ?: "selected"?> value="<?= $c->id ?>"><?=  $c->nombre ?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />

    </div>
</section>