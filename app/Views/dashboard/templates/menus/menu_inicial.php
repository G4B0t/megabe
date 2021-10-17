
          <li><a class="nav-link scrollto active" href="/#hero">Home</a></li>
          
          <li class="dropdown"><a href="/productos"><span>Menu</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <?php foreach ($categoria as $key => $m): ?>
                <li class="dropdown"><a href="/categorias/<?= $m->id ?>"><span><?= $m->nombre ?></span> <i class="bi bi-chevron-right"></i></a>
                  <ul>
                    <?php foreach ($subcategoria as $subcat => $c): ?>
                      <?php if($m->id == $c->id_categoria){?>
                          <li class="dropdown"><a href="/subcategorias/<?= $c->id ?>"><span><?= $c->nombre ?></span> <i class="bi bi-chevron-right"></i></a>
                          <ul>
                            <?php foreach ($marca as $key => $e): ?>
                                <?php if($c->id == $e->id_subcategoria){?>
                                  <li><a href="/marcas/<?= $e->id ?>"><?= $e->nombre ?></a></li>
                                <?php } ?>
                            <?php endforeach?>
                          </ul>
                      <?php } ?>
                    <?php endforeach?>
                  </ul>
              <?php endforeach?>
            </ul>
          </li>
          <li><a class="nav-link scrollto" href="/#about">About</a></li>
          <li><a class="nav-link scrollto " href="/#portfolio">Categorias</a></li>
          


