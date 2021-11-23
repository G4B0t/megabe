<section class="inner-page">
    <form action="/empleado/modificar_caja/<?= $empleado->id ?>" method="POST" enctype="multipart/form-data">
        <div class="container">
            
            <div class="mb-3 col-lg-4">
            
                <select class="form-select" name="roles" id="roles">
                    <?php foreach ($roles as $c): ?>
                        <option <?= $c->id_cuenta_padre !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->nombre ?> </option>
                    <?php endforeach?>
                    
                </select>
            </div> 
            <div class="mb-3 col-lg-4">
            
                <select class="form-select" name="empleados" id="empleados">
                    <?php foreach ($empleado as $c): ?>
                        <option <?= $c->id_cuenta_padre !== $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->fullName ?> </option>
                    <?php endforeach?>
                    
                </select>
            </div>    
            <div class="col-sm-10">
                    <input class="btn btn-secondary"action="action" onclick="window.history.go(-1); return false;" type="submit" value="Cancel" />  
                    <input class="btn btn-success" type="submit" name="submit" value="Asignar" />
            </div>
        </div>
    </form> 
</section>