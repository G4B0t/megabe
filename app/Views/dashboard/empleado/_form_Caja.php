<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $title ?></h2>
            <ol>
               
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<section class="inner-page">
    <form action="/empleado/modificar_caja/<?= $empleado->id ?>" method="POST" enctype="multipart/form-data">
        <div class="container">
            
            <div class="mb-3 col-lg-4">
            
                <select class="form-select" name="cajas" id="cajas">
                    <?php foreach ($cajas as $c): ?>
                        <option <?= $c->id_cuenta_padre !== $c->id ?: "selected"?> value="<?= $c->nombre_cuenta ?>"><?= $c->nombre_cuenta ?> </option>
                    <?php endforeach?>
                    
                </select>
            </div>   
                    
                    <input class="btn btn-success" type="submit" name="submit" value="Asignar" />

        </div>
    </form> 
</section>