                <li><a class="btn btn-outline-info" role="button" href="/item/new" >Nuevo Producto</a></li>
            </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

<?= view("dashboard/partials/_session"); ?>

<table class="table table-hover" data-aos="fade-up">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Subcategoría</th>
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
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger"/>
                    </form>

                    <a href="/item/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>



    </tbody>
</table>

<?= $pager->links('item','paginacion') ?>