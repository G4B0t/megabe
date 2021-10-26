
            </ol>
        </div>
      </div>
    </section><!-- End Breadcrumbs -->

    
<section class="inner-page">
    <div class="container">
        
        <div class="row">
          <form action="/factura_anulacion/filtro" method="POST" role="form" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-3 form-group">
                    <input type="text" name="filtro" class="form-control" id="filtro" placeholder="CI o Nombre" required>
                </div>
                <div class="col-md-3 form-group "> 
                    <button class="btn btn-success" type="submit" name="submit">Buscar</button>
                </div>
            </div>
          </form>
        </div>

        <div class="mb-3 row">
            <label for="descripcion" class="col-sm-2 col-form-label">Motivo</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="descripcion" id="descripcion"><?=old('descripcion', $factura->descripcion)?></textarea><br />
            </div>
        </div>

        
        <input class="btn btn-success" type="submit" name="submit" value="<?=$textButton?>" />
