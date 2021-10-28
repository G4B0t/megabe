<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h4><?= view("dashboard/partials/_session"); ?></h4>
            <ol>
                
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

   
<?= view("dashboard/partials/_session"); ?>
<form action="/proveedor/update/<?= $item->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/proveedor/_form",['textButton' => 'Actualizar']); ?>
</form>