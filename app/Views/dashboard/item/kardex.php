<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            
                <li><a class="btn btn-outline-info" role="button" href="/item/new" >Nuevo Producto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<div class="container">
    <div class="row">
                <form action="/administracion/filtrar_kardex/<?= $item->id?>" method="POST" role="form" enctype="multipart/form-data">

                <div class="mb-3 row">
                    <label for="start" class="col-sm-2 col-form-label">Finicio:</label>
                    <div class="col-sm-10">
                    <input type="month" id="start" name="start" min="2010-01" value="<?php echo $generales->gestion.'-01'?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="end" class="col-sm-2 col-form-label">Fin:</label>
                    <div class="col-sm-10">
                        <input type="month" id="end" name="end" min="<?php echo $generales->gestion.'-01' ?>" value="<?php echo $generales->gestion.'-12'?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-3 form-group "> 
                        <a href="/item" class="btn btn-info" type="submit" name="submit">Volver</a>
                        <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    </div>
                </div>
                </form>
    </div>
    <div class="row">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?= $item->nombre?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= $item->codigo?></h6>
                <p class="card-text"><?= $item->descripcion?></p>
                <h6 class="card-subtitle mb-2 text-muted">Marca: <?= $item->marca?></h6>
                <h6 class="card-subtitle mb-2 text-muted">Proveedor: <?= $item->proveedor?></h6>
            </div>
        </div>
    </div>
    <div class="row">
    <table class="table table-hover" data-aos="fade-up">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($ventas as $key => $m): ?>
                <tr>
                    <td><?= $m->fecha ?></td>
                    <td><?= $m->cantidad ?></td>
                </tr>
            <?php endforeach?>

            <tr>
                    <td>Total: </td>
                    <td><?= $total ?></td>
            </tr>

        </tbody>
    </table>

    <?= $pager->links('ventas','paginacion') ?>
    </div>
</div>
