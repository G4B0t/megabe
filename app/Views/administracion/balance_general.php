<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h2><?= view("dashboard/partials/_session"); ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <div class="container">
        <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Codigo Cuenta</th>
                    <th>Nombre Cuenta</th>
                    <th>Debe</th>
                    <th>Haber </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cuentas as $key => $m): ?>
                    <tr>
                        <td><?= $m->codigo_cuenta ?></td>
                        <td><?= $m->nombre_cuenta ?></td>
                        <td><?php echo number_format(($m->debe)) ?></td>
                        <td><?php echo number_format(($m->haber)) ?></td>                        
                    </tr>
                <?php endforeach?>
                
            </tbody>
        
            </table>
            <?= $pagers->links('cuentas','paginacion') ?>  
        </div>