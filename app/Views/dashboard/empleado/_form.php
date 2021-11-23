
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="id_persona">Persona: </label>
            <div class="col-sm-10">
                <select class="form-select" name="id_persona" id="id_persona">
                    <?php foreach ($persona as $c): ?>
                        <option <?= $empleado->id_persona !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?=  $c->fullName?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label"><span>*</span>EMAIL:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="email" name="email" value="<?=old('email', $empleado->email)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="usuario" class="col-sm-2 col-form-label"><span>*</span>USUARIO:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="usuario" name="usuario" value="<?=old('usuario', $empleado->usuario)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="contrasena" class="col-sm-2 col-form-label"><span>*</span>CONTRASEÑA:</label>
            <div class="col-sm-10">
                <input class="form-control" type="password" id="contrasena" name="contrasena" value="<?=old('contrasena', $empleado->contrasena)?>"/><br />
            </div>
        </div>

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
        <div class="col-sm-10">
            <input class="btn btn-secondary"action="action" onclick="window.history.go(-1); return false;" type="submit" value="Cancel" />
            <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
        </div>

    </div>
</section>
