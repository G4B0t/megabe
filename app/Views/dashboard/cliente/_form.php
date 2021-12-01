


    
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="id_persona">Persona:</label>
            <div class="col-sm-10">
                <select class="form-select" name="id_persona" id="id_persona">
                    <?php foreach ($persona as $c): ?>
                        <option <?= $cliente->id_persona !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->fullName ?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">EMAIL:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="email" name="email" value="<?=old('email', $cliente->email)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="usuario" class="col-sm-2 col-form-label">USUARIO:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="usuario" name="usuario" value="<?=old('usuario', $cliente->usuario)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="contrasena" class="col-sm-2 col-form-label">CONTRASEÑA:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="contrasena" name="contrasena" value="<?=old('contrasena', $cliente->contrasena)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nit" class="col-sm-2 col-form-label">NIT:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nit" name="nit" value="<?=old('nit', $cliente->nit)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="razon_social" class="col-sm-2 col-form-label">RAZON_SOCIAL:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="razon_social" name="razon_social" value="<?=old('razon_social', $cliente->razon_social)?>"/><br />
            </div>
        </div>

        <div class="col-sm-10">
            <input class="btn btn-secondary"action="action" onclick="window.history.go(-1); return false;" type="submit" value="Cancelar" />
            <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
        </div>

        </div>
</section>