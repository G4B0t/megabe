
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">    
            <label class="col-sm-2 col-form-label" for="telefono">Telefono: </label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="telefono" name="telefono" value="<?=old('telefono', $almacen->telefono)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row"> 
            <label class="col-sm-2 col-form-label" for="direccion">Direccion: </label>
            <div class="col-sm-10">
                <textarea class="form-control" rows="2" name="direccion" id="direccion"><?=old('direccion', $almacen->direccion)?></textarea><br />
            </div>
        </div>
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="latitud">Latitud:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input"  id="latitud" name="latitud" value="<?=old('latitud', $almacen->latitud)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="longitud">Longitud:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input"  id="longitud" name="longitud" value="<?=old('longitud', $almacen->longitud)?>"/><br />
            </div>
        </div>

        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="foto">Foto:</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="foto"/>
            </div>
        </div>

            <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
