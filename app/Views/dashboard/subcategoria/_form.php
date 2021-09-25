

            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

        
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">
            <label for="id_categoria" class="col-sm-2 col-form-label">Categoría</label>
            <div class="col-sm-10">
            <select class="form-select" name="id_categoria" id="id_categoria">
                 <?php foreach ($categoria as $c): ?>
                    <option <?= $subcategoria->id_categoria !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre ?> </option>
                <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="nombre">Nombre</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nombre" name="nombre" value="<?=old('nombre', $subcategoria->nombre)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label"for="descripcion">Descripcion</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="descripcion" id="descripcion"><?=old('descripcion', $subcategoria->descripcion)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto:</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="foto" onchange="readURL(this);"/>
                <img id="blah" src="<?= base_url()?>/imagen/subcategorias/<?= $subcategoria->foto?>" alt="Foto Previa" />    
            </div>
        </div>

            <div class="col-sm-10">
                <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
            </div>
    </div>
</section>
