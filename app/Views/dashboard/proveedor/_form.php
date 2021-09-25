<label for="id_subcategoria">Categoría</label>
<select name="id_subcategoria" id="id_subcategoria">
<?php foreach ($subcategoria as $c): ?>
    <option <?= $item->id_subcategoria !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre ?> </option>
<?php endforeach?>
</select>

<label for="nombre">Nombre</label>
<input type="input" id="nombre" name="nombre" value="<?=old('nombre', $item->nombre)?>"/><br />

<label for="descripcion">Descripcion</label>
<textarea name="descripcion" id="descripcion"><?=old('descripcion', $item->descripcion)?></textarea><br />

<label for="codigo">Codigo</label>
<textarea name="codigo" id="codigo"><?=old('codigo', $item->codigo)?></textarea><br />

<label for="fecha_expiracion">Fecha de Expiracion</label>
<input type="date" id="fecha_expiracion" name="fecha_expiracion"  min="today()" <?=old('codigo', $item->codigo)?>>

<label for="stock">Stock</label>
<textarea name="stock" id="stock"><?=old('stock', $item->stock)?></textarea><br />

<label for="precio_unitario">Precio Unitario</label>
<textarea name="precio_unitario" id="precio_unitario"><?=old('precio_unitario', $item->precio_unitario)?></textarea><br />

<label for="marca">Marca</label>
<textarea name="marca" id="marca"><?=old('marca', $item->marca)?></textarea><br />

<label for="foto">Foto</label>
<input type="file" name="foto"/>


<input type="submit" name="submit" value="<?=$textButton?>" />
