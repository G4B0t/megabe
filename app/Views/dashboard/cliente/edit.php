<?= view("dashboard/partials/_form-error"); ?>
<form action="/cliente/update/<?= $cliente->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/cliente/_form",['textButton' => 'Actualizar']); ?>
</form>