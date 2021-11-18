
    
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="id_subcategoria">Subcategoria:</label>
            <div class="col-sm-10">
                <select class="form-select" name="id_subcategoria" id="id_subcategoria">
                    <?php foreach ($subcategoria as $c): ?>
                        <option <?= $marca->id_subcategoria !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre ?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nombre" name="nombre" value="<?=old('nombre', $marca->nombre)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-2 col-form-label">Descripcion:</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="descripcion" id="descripcion"><?=old('descripcion', $marca->descripcion)?></textarea><br />
            </div>
        </div>
       
        <div class="col-sm-10">
            <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
        </div>
    </div>
</section>
