
<?= view("dashboard/partials/_form-error"); ?>
<form action="create" method="POST" enctype="multipart/form-data">
<?= view("dashboard/item/_form",['textButton' => 'Guardar']); ?>
</form>