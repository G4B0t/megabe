<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="/productos">Ver Productos</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->
    
<?= view("dashboard/partials/_form-error"); ?>
<form action="/user/actualizar/<?= $cliente->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/user/_formEditar",['textButton' => 'Actualizar']); ?>
</form>