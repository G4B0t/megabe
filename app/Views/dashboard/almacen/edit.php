<?= view("dashboard/partials/_form-error"); ?>
<form action="/almacen/update/<?= $almacen->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/almacen/_form",['textButton' => 'Actualizar']); ?>
</form>