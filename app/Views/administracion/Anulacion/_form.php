
    
<section class="inner-page">
    <div class="container">
        <div class="mb-3 row">
            <label class="col-sm-2 col-form-label" for="id_factura"># Factura:</label>
            <div class="col-sm-10">
                <select class="search form-select" name="id_factura" id="id_factura">
                    <?php foreach ($factura_venta as $c): ?>
                        <option  <?= $anulacion->id_factura !== $c->id ?: "selected"?> value="<?= $c->id_pedido_venta ?>"><?=$c->id_pedido_venta?> / <?= $c->fecha_emision ?> / <?= $c->beneficiario ?> </option>
                    <?php endforeach?>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="motivo" class="col-sm-2 col-form-label">Motivo:</label>
            <div class="col-sm-10">
                <input class="form-control" type="input" id="motivo" name="motivo" value="<?=old('motivo', $anulacion->motivo)?>"/><br />
            </div>
        </div>

        <div class="col-sm-10">
            <input class="btn btn-secondary"action="action" onclick="window.history.go(-1); return false;" type="submit" value="Cancelar" />
            <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cierre" data-bs-id="contraseña"><?=$textButton?></a>
        </div>

    </div>
</section>

<script>
    $('.id_factura').select2({
        placeholder: '--- Buscar Factura ---',
        ajax: {
          url: '<?php echo base_url('anulacion/searchFactura');?>',
          dataType: 'json',
          delay: 250,
          processResults: function(data){
            return {
              results: data
            };
          },
          cache: true
        }
      });

    
</script>