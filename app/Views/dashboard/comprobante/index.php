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

    <h2><?= view("dashboard/partials/_session"); ?></h2>

<div class="container">
    <div class="row">
          <form action="/administracion/filtrado_anulacion" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                <select class="search form-select" name="comprobante" id="comprobante" >
                    <?php foreach ($comprobante as $c): ?>
                        <option <?= $c->id ?: "selected"?> value="<?= $c->id ?>"><?= $c->id ?>: <?= $c->beneficiario?> </option>
                    <?php endforeach?>
                </select>
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
            <th>#</th>
            <th>Beneficiario</th>
            <th>Fecha</th>
            <th>Glosa</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($comprobante as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->beneficiario ?></td>
                <td><?= $m->glosa ?></td>
                <td><?= $m->fecha ?></td>
                <td><a class="btn btn-outline-info" role="button" href="/comprobante/<?= $m->id ?>/edit" >Ver Detalle de Comprobante</a></td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('comprobante','paginacion') ?>

</div>

<script>
    $('.comprobante').select2({
        placeholder: '--- Buscar Comprobante ---',
        ajax: {
          url: '<?php echo base_url('administracion/searchComprobante');?>',
          dataType: 'json',
          delay: 250,
          processResults: function(data){
            return {
              results: data
            };
          },
          cache: true
        }
      });
    
</script>