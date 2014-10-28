<?php $neto = 0; ?>
<div class="row">
    <div style=" height:200px; overflow:auto;  ">
        <table class="table table-condensed table-bordered table-striped">
            <tr>
                <th>Folio</th>
                <th>Punto</th>
                <th>Fecha</th>
                <th>Mueble</th>
                <th>Elemento</th>
                <th>Cantidad</th>
                <th>Valor Unitario</th>
                <th>Total</th>
            </tr>
            <?php foreach ($presupuestos as $presupuesto): ?>
                <?php foreach ($presupuesto->mueblespresupuesto as $mueblepresupuesto): ?>
                    <tr>
                        <td><?php echo $mueblepresupuesto->presupuesto->visita->folio ?></td>
                        <td><?php echo $mueblepresupuesto->presupuesto->visita->punto->Descripcion ?></td>
                        <td><?php echo date('d-m-Y',strtotime($mueblepresupuesto->presupuesto->visita->fecha_visita)); ?></td>
                        <td><?php echo $mueblepresupuesto->mueblepunto->Descripcion; ?></td>
                        <td><?php echo $mueblepresupuesto->servicio->descripcion; ?></td>
                        <td><?php echo $mueblepresupuesto->cant_servicio; ?></td>
                        <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$mueblepresupuesto->tarifa_servicio); ?></td>
                        <td><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$mueblepresupuesto->cant_servicio*$mueblepresupuesto->tarifa_servicio); ?></td>
                    </tr>
                    <?php $neto += $mueblepresupuesto->cant_servicio*$mueblepresupuesto->tarifa_servicio;?>
                <?php endforeach ?>
            <?php endforeach ?>
        </table>
    </div>
</div>
<br>
<div class="row well">
        <p><b>Neto: </b><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$neto); ?></p>
        <p><b>Iva: </b><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$neto*0.19); ?></p>
        <p><b>Total: </b><?php echo Yii::app()->numberFormatter->format('###,###,###,###',$neto*1.19); ?></p>
</div>
