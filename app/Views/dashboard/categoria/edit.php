<?= view("dashboard/partials/_form-error"); ?>
<form action="/categoria/update/<?= $categoria->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/categoria/_form",['textButton' => 'Actualizar']); ?>
</form>