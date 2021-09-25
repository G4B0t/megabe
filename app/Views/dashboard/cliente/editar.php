<?= view("dashboard/partials/_form-error"); ?>
<form action="/cliente/actualizar/<?= $cliente->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/cliente/_formEditar",['textButton' => 'Actualizar']); ?>
</form>