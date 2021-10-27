
<section class="inner-page">
    <div class="container">
         <div class="mb-3 row">
            <div class="col-lg-6 col-md-8">
                    <div class="member" data-aos="fade-up" data-aos-delay="150">
                    <div class="pic"><img src="<?= base_url()?>/imagen/empleados/<?= $empleado->foto?>" class="img-fluid" alt="" width="300" height="300"></div>
                        <div class="member-info">
                            <h4><?= $empleado->fullName ?></h4>
                        </div>
                    </div>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="usuario" class="col-sm-2 col-form-label">Usuario:</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="usuario" name="usuario" value="<?=old('usuario', $empleado->usuario)?>"/><br />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email:</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" id="email" name="email"  value="<?=old('email', $empleado->email)?>" /><br />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="contrasena" class="col-sm-2 col-form-label">Contraseña:</label>
            <div class="col-sm-10">
                <input class="form-control" name="contrasena" id="contrasena" type="password" onkeyup='check();'  value="" /><br />
            </div>
        </div>
        <div class="mb-3 row">
            <label for="confirm_contrasena" class="col-sm-2 col-form-label">Confirmar Contraseña:</label>
            <div class="col-sm-10">
                <input class="form-control" name="confirm_contrasena" id="confirm_contrasena" type="password" onkeyup='check();' value="" /><br />
                <span id='message'></span>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
            <div class="col-sm-10">
                <input class="form-control" type="file" name="foto" onchange="readURL(this);"/>
            </div>
        </div>

        <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />


<script>
    var check = function() {
  if (document.getElementById('contrasena').value ==
    document.getElementById('confirm_contrasena').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Coincinden';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'No coinciden';
  }
}
</script>