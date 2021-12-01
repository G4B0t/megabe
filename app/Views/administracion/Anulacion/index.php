

<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h2><?= view("dashboard/partials/_session"); ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="/anulacion/new">Nueva Anulacion de Factura</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->



    <div class="container">

    <div class="row">
          <form action="/administracion/filtrado_anulacion" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                    <input type="text" name="filtro" class="form-control" id="filtro" placeholder="Producto" required>
                </div>
                <div class="col-md-3 form-group "> 
                    <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    <a href="/anulacion" class="btn btn-info" type="submit" name="submit">Ver Todo</a>
                </div>
            </div>
          </form>
    </div>
        <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Nro Factura</th>
                    <th>Beneficiario</th>
                    <th>Motivo</th>
                    <th>Monto </th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($anulacion as $key => $m): ?>
                    <tr>
                        <td><?= $m->id_factura ?></td>
                        <td><?= $m->beneficiario ?></td>
                        <td><?= $m->motivo ?></td>
                        <td><?= $m->total ?></td>
                        <td><?= $m->fecha ?></td>                
                    </tr>
                <?php endforeach?>
                
            </tbody>
        
            </table>
            <?= $pager->links('anulacion','paginacion') ?>  
        </div>
            