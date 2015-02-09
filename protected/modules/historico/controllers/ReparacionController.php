<?php

class ReparacionController extends Controller
{
	public function filters() {
     return array( 
        //it's important to add site/error, so an unpermitted user will get the error.
        array('auth.filters.AuthFilter'),
            );
        }
	public function actionIndex()
	{
		$model =  new Reparacion('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Reparacion'])) {
			$model->attributes=$_GET['Reparacion'];
		}
		$this->render('index',array('model'=>$model));
	}

	public function actionView($id)
	{
		$model = Reparacion::model()->findByPk($id);
		$this->render('view',array('model'=>$model));
	}
	public function actionPoblarComunas()
	{
		$comunas = Comuna::model()->findAll();

		foreach ($comunas as $c) {
			$id = $c->id;
			$nombre = $c->nombre;
			$region = $c->idProvincia->id_region;
			
			$connection=Yii::app()->db;  
			$command=$connection->createCommand('insert into comuna (id, nombre, region_id) VALUES (:id,:nombre,:region)');
			$command->bindParam(":id",$id,PDO::PARAM_INT);
			$command->bindParam(":nombre",$nombre,PDO::PARAM_STR);
			$command->bindParam(":region",$region,PDO::PARAM_INT);
			// replace the placeholder ":email" with the actual email value
			$command->execute();

		}
		echo 'Completado';
	}

	public function actionPoblarMuebles()
	{
		$muebles = Mueble::model()->findAll();

		foreach ($muebles as $c) {
			$nombre = $c->descripcion;
			$id = $c->id;
			$connection=Yii::app()->db;  
			$command=$connection->createCommand('insert into mueble (id,descripcion) VALUES (:id,:nombre)');
			$command->bindParam(":nombre",$nombre,PDO::PARAM_STR);
			$command->bindParam(":id",$id,PDO::PARAM_INT);
			// replace the placeholder ":email" with the actual email value
			$command->execute();

		}
		echo 'Completado';
	}

	public function actionPoblarElementosMuebles()
	{
		$muebles = PrecioReparacion::model()->findAll(array('condition'=>'activo is true'));

		foreach ($muebles as $c) {
			$id = $c->id;
			$nombre = $c->descripcion.' <i>'.$c->caracteristica.'</i>';
			$mueble = $c->id_mueble;
			$tarifa1 = $c->mano_de_obra_rango_1;
			$tarifa2 = $c->mano_de_obra_rango_2;
			$tarifa3 = $c->mano_de_obra_rango_3;
			
			$connection=Yii::app()->db;  
			$command=$connection->createCommand('insert into servicio_mueble (id,descripcion, mueble_id,tarifa ,tarifa_b, tarifa_c) VALUES (:id,:nombre,:mueble,:tarifa1,:tarifa2,:tarifa3)');
			$command->bindParam(":id",$id,PDO::PARAM_INT);
			$command->bindParam(":nombre",$nombre,PDO::PARAM_STR);
			$command->bindParam(":mueble",$mueble,PDO::PARAM_INT);
			$command->bindParam(":tarifa1",$tarifa1,PDO::PARAM_INT);
			$command->bindParam(":tarifa2",$tarifa2,PDO::PARAM_INT);
			$command->bindParam(":tarifa3",$tarifa3,PDO::PARAM_INT);
			// replace the placeholder ":email" with the actual email value
			$command->execute();

		}
		echo 'Completado';
	}


	public function actionPoblarTarifasTraslados()
	{
		$tarifas = PrecioTransporte::model()->findAll();

		foreach ($tarifas as $c) {
			$id = $c->id;
			$desde = $c->origen;
			$hasta = $c->destino;
			$distancia = $c->distancia;
			$tarifa1 = $c->valor1;
			$tarifa2 = $c->valor2;
			$tarifa3 = $c->valor3;
			$tarifa4 = $c->valor4;
			$activo = $c->activo == 't'? 1: 0;
			
			$connection=Yii::app()->db;  
			$command=$connection->createCommand('insert into tarifa_traslado (id,desde,hasta, distancia,tarifa_a ,tarifa_b, tarifa_c, tarifa_d,activo) VALUES (:id,:desde,:hasta,:distancia,:tarifa1,:tarifa2,:tarifa3,:tarifa4,:activo)');
			$command->bindParam(":id",$id,PDO::PARAM_INT);
			$command->bindParam(":desde",$desde,PDO::PARAM_STR);
			$command->bindParam(":hasta",$hasta,PDO::PARAM_STR);
			$command->bindParam(":distancia",$distancia,PDO::PARAM_INT);
			$command->bindParam(":tarifa1",$tarifa1,PDO::PARAM_INT);
			$command->bindParam(":tarifa2",$tarifa2,PDO::PARAM_INT);
			$command->bindParam(":tarifa3",$tarifa3,PDO::PARAM_INT);
			$command->bindParam(":tarifa4",$tarifa4,PDO::PARAM_INT);
			$command->bindParam(":activo",$activo,PDO::PARAM_INT);
			// replace the placeholder ":email" with the actual email value
			$command->execute();

		}
		echo 'Completado';
	}

	public function actionPoblarTarifasInstalacion()
	{
		$tarifas = PrecioInstalacion::model()->findAll();

		foreach ($tarifas as $c) {
			$id = $c->id;
			$mueble = $c->id_mueble;
			$valor = $c->valor;
			$activo = $c->activo == 't'? 1: 0;
			
			$connection=Yii::app()->db;  
			$command=$connection->createCommand('insert into tarifa_instalacion (id,mueble_id,tarifa_a, activo) VALUES (:id,:mueble,:valor,:activo)');
			$command->bindParam(":id",$id,PDO::PARAM_INT);
			$command->bindParam(":mueble",$mueble,PDO::PARAM_STR);
			$command->bindParam(":valor",$valor,PDO::PARAM_INT);
			$command->bindParam(":activo",$activo,PDO::PARAM_INT);
			// replace the placeholder ":email" with the actual email value
			$command->execute();

		}
		echo 'Completado';
	}

	public function actionPoblarPuntos()
	{
		$puntos = Punto::model()->findAll();

		foreach ($puntos as $p) {
			if($p->activo == 't'){
				$direccion = $p->direccion;
				$comuna = $p->id_comuna;
				$region = $p->idComuna->idProvincia->id_region;
				$distribuidor = $p->id_distribuidor;
				$canal = $p->id_canal;
				$connection=Yii::app()->db;  
				$command=$connection->createCommand('insert into punto (direccion,comuna_id, region_id, distribuidor_id,canal_id) VALUES (:direccion,:comuna,:region,:distribuidor,:canal)');
				$command->bindParam(":direccion",$direccion,PDO::PARAM_STR);
				$command->bindParam(":comuna",$comuna,PDO::PARAM_INT);
				$command->bindParam(":region",$region,PDO::PARAM_INT);
				$command->bindParam(":distribuidor",$distribuidor,PDO::PARAM_INT);
				$command->bindParam(":canal",$canal,PDO::PARAM_INT);
				// replace the placeholder ":email" with the actual email value
				$command->execute();
			}

		}
		echo 'Completado';
	}
	public function actionPoblarDistribuidores()
	{
		$dist = Distribuidor::model()->findAll();

		foreach ($dist as $d) {
			$id = $d->id;
			$nombre = $d->descripcion;
			$connection=Yii::app()->db;  
			$command=$connection->createCommand('insert into distribuidor (id, nombre) VALUES (:id, :nombre)');
			$command->bindParam(":id",$id,PDO::PARAM_INT);
			$command->bindParam(":nombre",$nombre,PDO::PARAM_STR);
			// replace the placeholder ":email" with the actual email value
			$command->execute();

		}
		echo 'Completado';
	}

	public function actionReporteElementos($year = null)
	{
		if($year){
			//$total = 0;
			//$criteria2 = new CDbCriteria();
			//$criteria2->addBetweenCondition('fecha_ejecucion','2012-12-26','2013-12-25');
			//$total2 = count(Reparacion::model()->findAll($criteria2));
			$reparaciones = array();
			for($i =1 ;$i<=12;$i++){
				if($i == 1){
					$desde = ($year-1).'-12-26';
					
				}
				else
					$desde = $year.'-'.($i-1).'-26';
				$hasta = $year.'-'.$i.'-25';

				//echo $desde.'-'.$hasta.' ';
				
				$criteria = new CDbCriteria();
				$criteria->addBetweenCondition('fecha_ejecucion',$desde,$hasta);
				$reparacionesMes[$i] = Reparacion::model()->findAll($criteria);
				//$total += $reparacionesMes[$i];
				//echo $reparacionesMes[$i];
				//echo '<br>';
			}

			//var_dump($reparacionesMes);

			
			Yii::import('application.extensions.PHPExcel',true);


			$objPHPExcel = new PHPExcel();
	    	
			$elementosMesRegion = array();
			foreach ($reparacionesMes as $mes => $reparaciones) {
				foreach ($reparaciones as $reparacion) {
					if(!isset($elementosMesRegion[$mes]))
						$elementosMesRegion[$mes] = array();
					if (isset($elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region])) {

						foreach ($reparacion->detalleReparacions as $detalle) {
							foreach ($detalle->presupuestoReparacionNormals as $pnormal) {	
								if (isset($elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion] )) {
									$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['cantidad'] += $pnormal->cantidad;
									if ($pnormal->cantidad <= 5){
										$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] += $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_1;
									}

									if ($pnormal->cantidad > 5 && $pnormal->cantidad <= 10){
										$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] += $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_2;

									}
									if ($pnormal->cantidad > 10){
										$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] += $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_3;
									}
								}
								else{
									$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion] = array('cantidad'=>$pnormal->cantidad);
									if ($pnormal->cantidad <= 5){
										$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] = $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_1;
									}

									if ($pnormal->cantidad > 5 && $pnormal->cantidad <= 10){
										$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] = $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_2;

									}
									if ($pnormal->cantidad > 10){
										$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] = $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_3;
									}
								}	
							}
						}
						
					}
					else{
						$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region]= array();
						foreach ($reparacion->detalleReparacions as $detalle) {
							foreach ($detalle->presupuestoReparacionNormals as $pnormal) {
								$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion] = array('cantidad'=>$pnormal->cantidad);
								if ($pnormal->cantidad <= 5){
									$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] = $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_1;
								}

								if ($pnormal->cantidad > 5 && $pnormal->cantidad <= 10){
									$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] = $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_2;

								}
								if ($pnormal->cantidad > 10){
									$elementosMesRegion[$mes][$reparacion->idPunto->idComuna->idProvincia->id_region][$pnormal->idPrecioReparacion->descripcion]['monto'] = $pnormal->cantidad*$pnormal->idPrecioReparacion->mano_de_obra_rango_3;
								}
							}
						}
					}
				}
			}


			





			$objPHPExcel->setActiveSheetIndex(0)
		    ->setCellValue('A1', 'Elemento')
		    ->setCellValue('B1', 'Cantidad')
		    ->setCellValue('C1', 'Monto')
		    ->setCellValue('D1', 'Mes')
		    ->setCellValue('E1', 'Region');
		    $row =2;
			foreach ($elementosMesRegion as $mes => $elementosRegion) {
				foreach ($elementosRegion as $regionId => $elementos) {
					$objPHPExcel->setActiveSheetIndex(0);
					$region = Region::model()->findByPk($regionId);
					foreach ($elementos as $key => $value) {
						$objPHPExcel->setActiveSheetIndex(0)
						->setCellValueByColumnAndRow(0, $row, $key)
						->setCellValueByColumnAndRow(1, $row, $value['cantidad'])
						->setCellValueByColumnAndRow(2, $row, $value['monto'])
						->setCellValueByColumnAndRow(3, $row, $mes)
						->setCellValueByColumnAndRow(4, $row, $region->nombre);
						
						$row +=1;
					}
				}
			}

			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		    header('Content-Disposition: attachment;filename="Reparaciones Elementos '.$year.'.xlsx"');
		    header('Cache-Control: max-age=0');
		    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		    $objWriter->save('php://output');
		    exit;
		}
	}



	public function actionPoblarCanales()
	{
		$canales = Canal::model()->findAll();

		foreach ($canales as $c) {
			$id = $c->id;
			$nombre = $c->descripcion;
			$connection=Yii::app()->db;  
			$command=$connection->createCommand('insert into canal (id, nombre) VALUES (:id,:nombre)');
			$command->bindParam(":id",$id,PDO::PARAM_INT);
			$command->bindParam(":nombre",$nombre,PDO::PARAM_STR);
			// replace the placeholder ":email" with the actual email value
			$command->execute();

		}
		echo 'Completado';
	}
}