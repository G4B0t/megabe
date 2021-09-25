
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="id_subcategoria">Subcategoría</label>
            <div class="col-sm-10">
                <select class="form-select" name="id_subcategoria" id="id_subcategoria">
                    <?php foreach ($subcategoria as $c): ?>
                        <option <?= $item->id_subcategoria !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre ?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="nombre" name="nombre" value="<?=old('nombre', $item->nombre)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-2 col-form-label">Descripcion</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="descripcion" id="descripcion"><?=old('descripcion', $item->descripcion)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="codigo" class="col-sm-2 col-form-label">Codigo</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="codigo" id="codigo"><?=old('codigo', $item->codigo)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="fecha_expiracion" class="col-sm-2 col-form-label">Fecha de Expiracion</label>
            <div class="col-sm-10">
                <input class="form-control" type="date" id="fecha_expiracion" name="fecha_expiracion"  min="today()" <?=old('codigo', $item->codigo)?>>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stock</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="stock" id="stock"><?=old('stock', $item->stock)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="precio_unitario" class="col-sm-2 col-form-label">Precio Unitario</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="precio_unitario" id="precio_unitario"><?=old('precio_unitario', $item->precio_unitario)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="marca" class="col-sm-2 col-form-label">Marca</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="marca" id="marca"><?=old('marca', $item->marca)?></textarea><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="foto"/>
            </div>
        </div>

        <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
