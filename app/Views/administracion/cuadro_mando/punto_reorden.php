

<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h2><?= view("dashboard/partials/_session"); ?></h2>
          <ol>
            <li><a class="btn btn-outline-dark" role="button" href="/administracion">Volver</a></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->



    <div class="container">

    <div class="row">
          <form action="/administracion/filtrar_punto_reorden" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                    <input type="text" name="filtro" class="form-control" id="filtro" placeholder="Producto" required>
                </div>
                <div class="col-md-3 form-group "> 
                    <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                    <a href="/administracion/items_reorden" class="btn btn-info" type="submit" name="submit">Ver Todo</a>
                </div>
            </div>
          </form>
    </div>
        <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Codigo</th>
                    <th>Stock </th>
                    <th>Punto de Reorden</th>
                    <th>Indicador</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $m): ?>
                    <tr>
                        <td><?= $m->id ?></td>
                        <td><?= $m->nombre ?></td>
                        <td><?= $m->codigo ?></td>
                        <td><?= $m->stock ?></td>
                        <td><?= $m->punto_reorden ?></td>   
                        <td style= "background-color: <?php if($m->stock > $m->punto_reorden){
                                            echo '#4CAF50';                                                                      
                                                } else if($m->stock == $m->punto_reorden){
                                                    echo '#FFFF00';  
                                            } else if($m->stock < $m->punto_reorden){
                                                echo '#FF0000';
                                            }?>"> <?php if($m->stock > $m->punto_reorden){
                                                echo 'Todo en Orden';                                                                      
                                                    } else if($m->stock == $m->punto_reorden){
                                                        echo 'Cuidado!';  
                                                } else if($m->stock < $m->punto_reorden){
                                                    echo 'Necesita realizar Pedido';
                                                }?>
                        </td>                     
                    </tr>
                <?php endforeach?>
                
            </tbody>
        
            </table>
            <?= $pagers->links('item','paginacion') ?>  
        </div>
            