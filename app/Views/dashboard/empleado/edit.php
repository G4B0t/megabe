<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2><?= $title ?></h2>
            <ol>
                <li><a class="btn btn-outline-info" role="button" href="/empleado/new" >Nuevo Empleado</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    <h2><?= view("dashboard/partials/_session"); ?></h2>

<form action="/empleado/update/<?= $empleado->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/empleado/_form",['textButton' => 'Actualizar']); ?>
</form>