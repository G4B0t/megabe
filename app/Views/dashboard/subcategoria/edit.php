<?= view("dashboard/partials/_form-error"); ?>
<form action="/subcategoria/update/<?= $subcategoria->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/subcategoria/_form",['textButton' => 'Actualizar']); ?>
</form>