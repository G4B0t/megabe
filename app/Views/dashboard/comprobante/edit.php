
<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
            <ol>
            <li><a class="btn btn-outline-info" role="button" href="/comprobante" >Ver Comprobantes</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Codigo Cuenta</th>
            <th>Nombre de Cuenta</th>
            <th>Debe</th>
            <th>Haber</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($detalle_comprobante as $key => $m): ?>
            <tr>
                <td><?= $m->codigo_cuenta ?></td>
                <td><?= $m->nombre_cuenta ?></td>
                <td><?php echo number_format(($m->debe)) ?></td>
                <td><?php echo number_format(($m->haber)) ?></td>
            </tr>
        <?php endforeach?>
        <tr>
            <td><span> - <span></td>
            <td><span> Total <span></td>
            <td><span> <?php echo number_format(($total->debe)) ?> <span></td>
            <td><span> <?php echo number_format(($total->haber)) ?> <span></td>
        </tr>
        <tr>
            <td><span>Glosa:<span></td>
            <td><?= $comprobante->glosa ?></td>
        </tr>
        <tr>
            <td><span>Beneficiario:<span></td>
            <td><?= $comprobante->beneficiario ?></td>
        </tr>
        
    </tbody>
</table>

<?= $pager->links('detalle_comprobante','paginacion') ?>