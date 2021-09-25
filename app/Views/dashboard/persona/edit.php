<?= view("dashboard/partials/_form-error"); ?>
<form action="/persona/update/<?= $persona->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/persona/_form",['textButton' => 'Actualizar']); ?>
</form>