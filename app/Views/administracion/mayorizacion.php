<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="<?= route_to('contacto','Gabriel') ?>">Contacto</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Codigo de Cuenta</th>
                    <th>Nombre de Cuenta</th>
                    <th>Debe</th>
                    <th>Haber</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($plan_cuenta as $key => $m): ?>
                    <tr>
                        <td><?= $m->codigo_cuenta ?></td>
                        <td><?= $m->nombre_cuenta ?></td>
                        <td><?= $m->debe ?></td>
                        <td><?= $m->haber ?></td>
                    </tr>
                <?php endforeach?>
            </tbody>
        
            </table>
            <?= $pagers->links('plan_cuenta','paginacion') ?>