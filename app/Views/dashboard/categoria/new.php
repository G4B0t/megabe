
<?= view("dashboard/partials/_form-error"); ?>
<form action="create" method="POST" enctype="multipart/form-data">
<?= view("dashboard/categoria/_form",['textButton' => 'Guardar']); ?>
</form>