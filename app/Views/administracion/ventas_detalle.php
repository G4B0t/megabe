<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
            <ol>
                <a href="/administracion" class="btn btn-info" type="submit" name="submit">Volver</a>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <div class="container">
    <div class="row">
                <form action="/ventas_detalle/filtrado" method="POST" role="form" enctype="multipart/form-data">

                <div class="mb-3 row">
                    <label for="start" class="col-sm-2 col-form-label">Inicio:</label>
                    <div class="col-sm-10">
                    <input type="date" id="start" name="start" min="<?php echo $generales->gestion.'-01-01' ?>" value="<?php echo $generales->gestion.'-01-01'?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="end" class="col-sm-2 col-form-label">Fin:</label>
                    <div class="col-sm-10">
                        <input type="date" id="end" name="end" min="<?php echo $generales->gestion.'-01-01' ?>" value="<?php echo $generales->gestion.'-12-31'?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <div class="col-md-3 form-group "> 
                    
                        <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    </div>
                </div>
                </form>
    </div>
    <div class="row">
    <table class="table table-hover" data-aos="fade-up">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Codigo de Producto</th>
                <th>Cantidad</th>
                <th>total</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($detalle_venta as $key => $m): ?>
                <tr>
                    <td><?= $m->fecha ?></td>
                    <td><?= $m->nombre ?></td>
                    <td><?= $m->codigo ?></td>
                    <td><?= $m->cantidad ?></td>
                    <td><?php echo number_format(($m->total)) ?></td>
                </tr>
            <?php endforeach?>

            <tr>
                    <td> ---- </td>
                    <td>Total: </td>
                    <td> ---- </td>
                    <td> ---- </td>
                    <td><?php echo number_format(($total)) ?></td>
            </tr>

        </tbody>
    </table>

    <?= $pager->links('ventas','paginacion') ?>
    </div>
</div>