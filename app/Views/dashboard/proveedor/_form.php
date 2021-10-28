<section class="inner-page">
    <div class="container">

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="id_persona">Persona:</label>
                <div class="col-sm-10">
                <select  class="form-select"  name="id_persona" id="id_persona">
                    <?php foreach ($persona as $c): ?>
                        <option <?= $proveedor->id_persona !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->fullName ?> </option>
                    <?php endforeach?>
                </select>
                </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre_empresa" class="col-sm-2 col-form-label">Nombre Empresa:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nombre_empresa" name="nombre_empresa" value="<?=old('nombre_empresa', $proveedor->nombre_empresa)?>"/><br />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="direccion" class="col-sm-2 col-form-label">Direccion:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="direccion" name="direccion" value="<?=old('direccion', $proveedor->direccion)?>"/><br />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="contacto" class="col-sm-2 col-form-label">Contacto:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="contacto" name="contacto" value="<?=old('contacto', $proveedor->contacto)?>"/><br />
            </div>
        </div>

        
        <div class="col-sm-10">
            <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
        </div>

    </div>
</section>
