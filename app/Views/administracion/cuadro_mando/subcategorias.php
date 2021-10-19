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
                <?php foreach ($subcategoria as $key => $m): ?>
                    <tr>
                        <td>
                            <a class="btn" href="/administracion/cuadro_marca/<?= $m->id ?>" style= "background-color: <?php if($m->promedio>80){
                                            echo '#4CAF50';                                                                      
                                                } else if($m->promedio<80 && $m->promedio>50){
                                                    echo '#FFFF00';  
                                            } else if($m->promedio<50){
                                                echo '#FF0000';
                                            }?>";>Ver
                            </a>
                        </td>
                        <td><?= $m->id ?></td>
                        <td><?= $m->nombre ?></td>
                        <td><?= $m->venta_esperada ?></td>
                        <td><?= $m->cantidad ?></td>
                        <td><?php if($m->promedio >= 100){echo '100!!';}else{ echo $m->promedio;} ?></td>
                        
                    </tr>
                <?php endforeach?>
                
            </tbody>
        
            </table>
            <?= $pagers->links('subcategoria','paginacion') ?>  
    </div>