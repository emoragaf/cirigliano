<div id="pedidos" data-role="page">
  <div data-role="header" data-position="fixed">
  <a href="./" data-icon="arrow-l" id="volver2">Volver</a> 
    <h1>Pedidos</h1>
  </div>
  <div data-role="content">
    <ul data-role="listview" id="lista">
    <li>
      <fieldset class="ui-grid-a">
          <div class="ui-block-a" style="width:70%;">C&oacute;d. Producto</div>
          <div class="ui-block-b" style="width:30%;">Cant.</div>
       </fieldset>
       </li>
    	<?php for($i=1;$i<=10;$i++){?>
      <li>
      <fieldset class="ui-grid-a">
          <div class="ui-block-a" style="width:70%;">
            <input type="tel" name="cod<?php echo $i; ?>" id="cod<?php echo $i; ?>" />
          </div>
          <div class="ui-block-b" style="width:30%;">
						<input type="tel" name="cant<?php echo $i; ?>" id="cant<?php echo $i; ?>" style="text-align:center;" />
          </div>
       </fieldset>
      </li>
      <?php }?>
      <fieldset class="ui-grid-a">
          <div class="ui-block-a"><a href="#" data-role="button" data-theme="a">Cancelar</a></div>
          <div class="ui-block-b"><a href="#" data-role="button" data-theme="b">Agregar al Pedido</a></div>
       </fieldset>
    </ul>
  </div>
</div>