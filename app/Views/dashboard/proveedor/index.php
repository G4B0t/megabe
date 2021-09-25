
<a href="/item/new">Crear</a>

<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Categoría</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($item as $key => $m): ?>
            <tr>
                <td><?= $m->id ?></td>
                <td><?= $m->nombre ?></td>
                <td><?= $m->subcategoria ?></td>
                <td>
                    <form action="/item/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" />
                    </form>

                    <a href="/item/<?= $m->id ?>/edit">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links() ?>