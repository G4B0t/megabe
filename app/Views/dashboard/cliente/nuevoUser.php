<?= view("dashboard/partials/_form-error"); ?>
<form action="/cliente/crear" method="POST" enctype="multipart/form-data">
<?= view("dashboard/cliente/_usuarioNuevo",['textButton' => 'Guardar']); ?>
</form>