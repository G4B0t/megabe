
<?= view("dashboard/partials/_form-error"); ?>
<form action="create" method="POST" enctype="multipart/form-data">
<?= view("dashboard/cliente/_form",['textButton' => 'Guardar']); ?>
</form>