<?= view("dashboard/partials/_form-error"); ?>
<form action="/item/update/<?= $item->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/item/_form",['textButton' => 'Actualizar']); ?>
</form>