<?= view("dashboard/partials/_form-error"); ?>
<form action="/plan_cuenta/update/<?= $plan_cuenta->id ?>" method="POST" enctype="multipart/form-data">
<?= view("dashboard/plan_cuenta/_form",['textButton' => 'Actualizar']); ?>
</form>