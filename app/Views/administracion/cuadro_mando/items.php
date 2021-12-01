

<main id="main">
      <!-- ======= Breadcrumbs ======= -->
      <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2><?= $title ?></h2>
          <h2><?= view("dashboard/partials/_session"); ?></h2>
          <ol>
            <li><input class="btn btn-outline-dark"action="action" onclick="window.history.go(-1); return false;" type="submit" value="Volver" /></li>
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->


    <div class="container">
        <div class="row">
                <form action="/administracion/cuadro_mando/item_filtrado" method="POST" role="form" enctype="multipart/form-data">

                <div class="mb-3 row">
                    <label for="start" class="col-sm-2 col-form-label">Mes inicio:</label>
                    <div class="col-sm-10">
                    <input type="month" id="start" name="start" min="<?php echo $generales->gestion.'-01' ?>" value="<?php echo $generales->gestion.'-01'?>">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="end" class="col-sm-2 col-form-label">Mes fin:</label>
                    <div class="col-sm-10">
                    <input type="month" id="end" name="end" min="<?php echo $generales->gestion.'-01' ?>" value="<?php echo $generales->gestion.'-12'?>">
                    </div>
                </div>
                    <div class="mb-3 row">
                    <div class="col-md-3 form-group "> 
                            <button class="btn btn-success" type="submit" name="submit">Filtrar</button>
                        </div>
                    </div>
                </form>
        </div>
        <table class="table table-hover" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Accion</th>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Ventas Esperadas</th>
                    <th>Ventas Realizadas</th>
                    <th>Promedio %</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($item as $key => $m): ?>
                    <tr>
                        <td>
                            <a class="btn" href="/administracion/cuadro_categoria" style= "background-color: <?php if($m->promedio>80){
                                            echo '#4CAF50';                                                                      
                                                } else if($m->promedio<80 && $m->promedio>50){
                                                    echo '#FFFF00';  
                                            } else if($m->promedio<50){
                                                echo '#FF0000';
                                            }?>";>Volver a Categoria
                            </a>
                        </td>
                        <td><?= $m->id ?></td>
                        <td><?= $m->nombre ?></td>
                        <td><?= $m->venta_esperada ?></td>
                        <td><?= $m->cantidad ?></td>
                        <td><?php if($m->promedio >= 100){echo '100!!';}else{ echo round($m->promedio);} ?></td>
                        
                    </tr>
                <?php endforeach?>
                
            </tbody>
        
            </table>
            <?= $pagers->links('item','paginacion') ?>  
        </div>
            