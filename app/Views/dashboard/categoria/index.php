
                <li><a class="btn btn-outline-info" role="button" href="/categoria/new">Nueva Categoria</a></li>
            </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

<table class="table">
    <thead>
        <tr>
            <th>foto</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categoria as $key => $m): ?>
            <tr>
                <td><img src="<?= base_url()?>/imagen/categorias/<?= $m->foto ?>" width="300" height="250" > </img> </td>
                <td><?= $m->nombre ?></td>
                <td><?= $m->descripcion ?></td>
                <td>
                    <form action="/categoria/delete/<?= $m->id ?>" method="POST">
                        <input type="submit" name="submit" value="Borrar" class="btn btn-outline-danger" />
                    </form>

                    <a href="/categoria/<?= $m->id ?>/edit" class="btn btn-outline-warning">Editar</a>


                </td>
            </tr>
        <?php endforeach?>
        



    </tbody>
</table>

<?= $pager->links('categoria','paginacion') ?>