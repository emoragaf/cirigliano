<?php

/**
 * This is the model class for table "adicional".
 *
 * The followings are the available columns in table 'adicional':
 * @property integer $id
 * @property integer $mueble_presupuesto_id
 * @property string $tarifa
 * @property string $descripcion
 * @property integer $mueble_punto_id
 * @property integer $estado
 * @property string $fecha_termino
 * @property integer $foto_id
 * @property integer $cantidad
 *
 * The followings are the available model relations:
 * @property Foto $foto
 * @property MueblePunto $mueblePunto
 */
class Informe
{

	public static function InformePpt( $id= null)
	{
		if($id != null){
			$visita = Visita::model()->findByPk($id);
			$p = $visita->presupuestos;
			if($visita->tipo_visita_id == 3)
				$modelItemPresupuesto = 'TrasladoPresupuesto';
			else
				$modelItemPresupuesto = 'MueblePresupuesto';
			
			if($visita->tipo_visita_id == 3)
				$mps = $p[0]->trasladopresupuesto;
			else
				$mps = $p[0]->mueblespresupuesto;
			
			$fotos = $visita->formulario->fotos;

			$fotosActa = array();
			$fotosGeneral = array();
			$fotosOtros = array();
			$fotosMueble = array();
			$fotosAdicionales = array();
			$fotosVPreventivaAntes = array();
			$fotosVPreventivaDespues = array();

			foreach ($fotos as $foto) {
				if($foto->tipo_foto_id == 1){
					if(isset($fotosMueble[$foto->item_foto_id])){
						if(isset($fotosMueble[$foto->item_foto_id]['Antes'])){
							$fotosMueble[$foto->item_foto_id]['Antes'][] =$foto;
						}
						else
							$fotosMueble[$foto->item_foto_id]['Antes'] =array($foto);
					}
					else
						$fotosMueble[$foto->item_foto_id] = array('Antes'=>array($foto));
				}
				if($foto->tipo_foto_id == 2){
					if(isset($fotosMueble[$foto->item_foto_id])){
						if(isset($fotosMueble[$foto->item_foto_id]['Despues'])){
							$fotosMueble[$foto->item_foto_id]['Despues'][] =$foto;
						}
						else
							$fotosMueble[$foto->item_foto_id]['Despues'] =array($foto);
					}
					else
						$fotosMueble[$foto->item_foto_id] = array('Despues'=>array($foto));
				}
				if($foto->tipo_foto_id == 8){
					if(isset($fotosAdicionales[$foto->item_foto_id])){
						if(isset($fotosAdicionales[$foto->item_foto_id]['Antes'])){
							$fotosAdicionales[$foto->item_foto_id]['Antes'][] =$foto;
						}
						else
							$fotosAdicionales[$foto->item_foto_id]['Antes'] =array($foto);
					}
					else
						$fotosAdicionales[$foto->item_foto_id] = array('Antes'=>array($foto));
				}
				if($foto->tipo_foto_id == 9){
					if(isset($fotosAdicionales[$foto->item_foto_id])){
						if(isset($fotosAdicionales[$foto->item_foto_id]['Despues'])){
							$fotosAdicionales[$foto->item_foto_id]['Despues'][] =$foto;
						}
						else
							$fotosAdicionales[$foto->item_foto_id]['Despues'] =array($foto);
					}
					else
						$fotosAdicionales[$foto->item_foto_id] = array('Despues'=>array($foto));
				}
				if($foto->tipo_foto_id == 10){
					$fotosVPreventivaAntes[] =$foto;
				}
				if($foto->tipo_foto_id == 11){
					$fotosVPreventivaDespues[] =$foto;
				}
				if($foto->tipo_foto_id == 3){
					$fotosActa[] = $foto;
				}
				if($foto->tipo_foto_id == 4){
					$fotosGeneral[] = $foto;
				}
				if($foto->tipo_foto_id == 5){
					$fotosOtros[] = $foto;
				}
			}

			$MueblesPresupuesto = $mps;

			$objPHPPowerPoint = new PhpOffice\PhpPowerpoint\PhpPowerpoint();

			// Set writers
			$writers = array('PowerPoint2007' => 'pptx');

			// Set properties
			$objPHPPowerPoint->getProperties()->setCreator('Cirigliano')
			                                  ->setLastModifiedBy('Cirigliano')
			                                  ->setTitle($visita->punto->direccion.' '.$visita->fecha_visita)
			                                  ->setSubject('Informe Visita')
			                                  ->setDescription('Informe Visita')
			                                  ->setKeywords('cirigliano visita movistar mantencion');
			                                  

			// Create slide
			$currentSlide = $objPHPPowerPoint->getActiveSlide();

			// Create a shape (drawing)
			// $shape = $currentSlide->createDrawingShape();
			// $shape->setName('PHPPowerPoint logo')
			//       ->setDescription('PHPPowerPoint logo')
			//       ->setPath(Yii::getPathOfAlias('webroot').'/resources/phppowerpoint_logo.gif')
			//       ->setHeight(36)
			//       ->setOffsetX(10)
			//       ->setOffsetY(10);
			// $shape->getShadow()->setVisible(true)
			//                    ->setDirection(45)
			//                    ->setDistance(10);

			// Create a shape (text)

			$shape = $currentSlide->createDrawingShape();
						$shape->setName('Movistar')
				      ->setDescription('Logo Movistar')
				       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
				      ->setHeight(80)
				      ->setOffsetX(750)
				      ->setOffsetY(10);

	      	$shape = $currentSlide->createDrawingShape();
						$shape->setName('Cirigliano')
				      ->setDescription('Logo Cirigliano')
				      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
				      ->setHeight(60)
				      ->setOffsetX(740)
				      ->setOffsetY(650);


			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(170)
			      ->setOffsetY(70);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
			$textRun = $shape->createTextRun('Informe Solicitud de Mantencion de Muebles');
			$textRun->getFont()->setBold(true)
			                   ->setSize(22)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(120);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Folio: '.$visita->folio);
			$textRun->getFont()->setBold(false)
			                   ->setSize(16)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );
			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(140);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Punto: '.$visita->punto->direccion.' '.$visita->punto->comuna->nombre);
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(160);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Canal: '.$visita->punto->canal->nombre);
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(180);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Distribuidor: '.$visita->punto->distribuidor->nombre);
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(200);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Fecha Ingreso: '.date('d-m-Y',strtotime($visita->fecha_creacion)));
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(220);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Fecha Ejecución: '.date('d-m-Y',strtotime($visita->fecha_visita)));
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(240);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Solicitante: '.$visita->personaPunto->Nombre);
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );                  	
			
			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(300);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Notas:');
			$textRun->getFont()->setBold(true)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

        	$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(320);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun($visita->formulario->notas);
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

            //PRESUPUESTO
			$currentSlide = $objPHPPowerPoint->createSlide();

			$shape = $currentSlide->createDrawingShape();
						$shape->setName('Movistar')
				      ->setDescription('Logo Movistar')
				       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
				      ->setHeight(80)
				      ->setOffsetX(750)
				      ->setOffsetY(10);

			      	$shape = $currentSlide->createDrawingShape();
						$shape->setName('Cirigliano')
				      ->setDescription('Logo Cirigliano')
				      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
				      ->setHeight(60)
				      ->setOffsetX(740)
				      ->setOffsetY(650);


			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(70);

			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Presupuesto');
			$textRun->getFont()->setBold(true)
			                   ->setSize(20)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createTableShape(3);
			$shape->setHeight(200);
			$shape->setWidth(700);
			$shape->setOffsetX(120);
			$shape->setOffsetY(120);

			$row = $shape->createRow();
				$row->getFill()->setFillType(PhpOffice\PhpPowerpoint\Style\Fill::FILL_SOLID)
				               ->setStartColor(new PhpOffice\PhpPowerpoint\Style\Color('FFFFFFFF'));
				$cell = $row->nextCell();
				$cell->createTextRun('Item')->getFont()->setBold(true)
				                                            ->setSize(14);
                $cell->setWidth(400);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
				$cell->createTextRun('Cantidad')->getFont()->setBold(true)
				                                            ->setSize(14);
                $cell->setWidth(120);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
				$cell->createTextRun('Monto')->getFont()->setBold(true)
				                                            ->setSize(14);
				$cell->setWidth(180);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);

            if ($visita->tipo_visita_id == 3) {
            	$row = $shape->createRow();
				$row->getFill()->setFillType(PhpOffice\PhpPowerpoint\Style\Fill::FILL_SOLID)
				               ->setStartColor(new PhpOffice\PhpPowerpoint\Style\Color('FFFFFFFF'));
				$cell = $row->nextCell();
				$cell->createTextRun($p[0]->tarifaTraslado->Descripcion)->getFont()->setBold(true)
				                                            ->setSize(14);
                $cell->setWidth(400);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
				$cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
				$cell->createTextRun('1')->getFont()->setBold(true)
				                                            ->setSize(14);
                $cell->setWidth(120);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
	            $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
				$cell->createTextRun($p[0]->TTraslado)->getFont()->setBold(true)
				                                            ->setSize(14);
				$cell->setWidth(180);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
            }
            if ($visita->visita_preventiva == 1 && $p[0]->tarifa_visita_preventiva != null) {
            	$row = $shape->createRow();
				$row->getFill()->setFillType(PhpOffice\PhpPowerpoint\Style\Fill::FILL_SOLID)
				               ->setStartColor(new PhpOffice\PhpPowerpoint\Style\Color('FFFFFFFF'));
				$cell = $row->nextCell();
				$cell->createTextRun('Visita Preventiva')->getFont()->setBold(true)
				                                            ->setSize(14);
                $cell->setWidth(400);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
				$cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
				$cell->createTextRun('1')->getFont()->setBold(true)
				                                            ->setSize(14);
                $cell->setWidth(120);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
	            $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
				$cell->createTextRun($p[0]->tarifa_visita_preventiva)->getFont()->setBold(true)
				                                            ->setSize(14);
				$cell->setWidth(180);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
            }
			foreach ($mps as $accion) {
				$row = $shape->createRow();
				$row->getFill()->setFillType(PhpOffice\PhpPowerpoint\Style\Fill::FILL_SOLID)
				               ->setStartColor(new PhpOffice\PhpPowerpoint\Style\Color('FFFFFFFF'));
				$cell = $row->nextCell();
				$cell->createTextRun(strip_tags($accion->Descripcion))->getFont()->setSize(10);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
	            $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );		
				$cell->createTextRun($accion->cant_servicio)->getFont()->setSize(10);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
                $cell = $row->nextCell();
                $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
				$cell->createTextRun($accion->Tarifa)->getFont()->setSize(10);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
			}
			foreach ($p[0]->adicionales as $ad) {
				$row = $shape->createRow();
				$row->getFill()->setFillType(PhpOffice\PhpPowerpoint\Style\Fill::FILL_SOLID)
				               ->setStartColor(new PhpOffice\PhpPowerpoint\Style\Color('FFFFFFFF'));
				$cell = $row->nextCell();
				$cell->createTextRun($ad->Descripcion)->getFont()->setSize(10);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
	            $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
				$cell->createTextRun($ad->cantidad)->getFont()->setSize(10);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
                $cell = $row->nextCell();
                $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
				$cell->createTextRun($ad->tarifa)->getFont()->setSize(10);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
			}

			$row = $shape->createRow();
			$cell = $row->nextCell();
			$cell->getBorders()->getRight()->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_NONE);  
			$cell = $row->nextCell();
			$cell->createTextRun('Total:')->getFont()->setSize(10);
			$cell->getBorders()->getBottom()->setLineWidth(1)
			                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
			$cell->getBorders()->getLeft()->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_NONE);                               
            $cell = $row->nextCell();
            $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
			$cell->createTextRun($p[0]->total)->getFont()->setBold(true)
			                                            ->setSize(10);
			$cell->getBorders()->getBottom()->setLineWidth(1)
			                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
			 
            
			// ACTA
			$cant = count($fotosActa);
			if($cant == 1)
			{
				$height = 500;
				$OffsetY = 200;
				$OffsetX = 550;
			}
			else{
				$height = 250;
				$OffsetY = 200;
				$OffsetX = 400;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosActa[$i-1];
				if($i == 1 || $i%5 == 0){
					$slide = $objPHPPowerPoint->createSlide();

					$shape = $slide->createRichTextShape()
					      ->setHeight(300)
					      ->setWidth(600)
					      ->setOffsetX(170)
					      ->setOffsetY(50);
					$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
					$textRun = $shape->createTextRun('Acta');
					$textRun->getFont()->setBold(true)
					                   ->setSize(30)
					                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );
					$shape = $slide->createDrawingShape();
						$shape->setName('Movistar')
				      ->setDescription('Logo Movistar')
				       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
				      ->setHeight(80)
				      ->setOffsetX(750)
				      ->setOffsetY(10);

			      	$shape = $slide->createDrawingShape();
						$shape->setName('Cirigliano')
				      ->setDescription('Logo Cirigliano')
				      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
				      ->setHeight(60)
				      ->setOffsetX(740)
				      ->setOffsetY(650);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Acta')
				      ->setDescription('Foto Acta')
				      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Acta')
				      ->setDescription('Foto Acta')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120 + $OffsetY);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Acta')
				      ->setDescription('Foto Acta')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Acta')
				      ->setDescription('Foto Acta')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120 + $OffsetY);
				}
			}

			// General
			$cant = count($fotosGeneral);
			if($cant == 1)
			{
				$height = 500;
				$OffsetY = 200;
				$OffsetX = 550;
			}
			else{
				$height = 250;
				$OffsetY = 200;
				$OffsetX = 400;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosGeneral[$i-1];
				if($i == 1 || $i%5 == 0){
					$slide = $objPHPPowerPoint->createSlide();

					$shape = $slide->createRichTextShape()
					      ->setHeight(300)
					      ->setWidth(600)
					      ->setOffsetX(170)
					      ->setOffsetY(50);
					$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
					$textRun = $shape->createTextRun('General');
					$textRun->getFont()->setBold(true)
					                   ->setSize(30)
					                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

					$shape = $slide->createDrawingShape();
						$shape->setName('Movistar')
				      ->setDescription('Logo Movistar')
				       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
				      ->setHeight(80)
				      ->setOffsetX(750)
				      ->setOffsetY(10);

			      	$shape = $slide->createDrawingShape();
						$shape->setName('Cirigliano')
				      ->setDescription('Logo Cirigliano')
				      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
				      ->setHeight(60)
				      ->setOffsetX(740)
				      ->setOffsetY(650);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('General')
				      ->setDescription('Foto General')
				      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('General')
				      ->setDescription('Foto General')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120 + $OffsetY);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('General')
				      ->setDescription('Foto General')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('General')
				      ->setDescription('Foto General')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120 + $OffsetY);
				}
			}

			// Otros
			$cant = count($fotosOtros);
			if($cant == 1)
			{
				$height = 500;
				$OffsetY = 200;
				$OffsetX = 550;
			}
			else{
				$height = 250;
				$OffsetY = 200;
				$OffsetX = 400;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosOtros[$i-1];
				if($i == 1 || $i%5 == 0){
					$slide = $objPHPPowerPoint->createSlide();

					$shape = $slide->createRichTextShape()
					      ->setHeight(300)
					      ->setWidth(600)
					      ->setOffsetX(170)
					      ->setOffsetY(50);
					$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
					$textRun = $shape->createTextRun('Otros');
					$textRun->getFont()->setBold(true)
					                   ->setSize(30)
					                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

					$shape = $slide->createDrawingShape();
						$shape->setName('Movistar')
				      ->setDescription('Logo Movistar')
				       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
				      ->setHeight(80)
				      ->setOffsetX(750)
				      ->setOffsetY(10);

			      	$shape = $slide->createDrawingShape();
						$shape->setName('Cirigliano')
				      ->setDescription('Logo Cirigliano')
				      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
				      ->setHeight(60)
				      ->setOffsetX(740)
				      ->setOffsetY(650);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Otros')
				      ->setDescription('Foto Otros')
				      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Otros')
				      ->setDescription('Foto Otros')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120 + $OffsetY);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Otros')
				      ->setDescription('Foto Otros')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Otros')
				      ->setDescription('Foto Otros')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120 + $OffsetY);
				}
			}
			// Visita Preventiva Antes
			$cant = count($fotosVPreventivaAntes);
			if($cant == 1)
			{
				$height = 500;
				$OffsetY = 200;
				$OffsetX = 550;
			}
			else{
				$height = 250;
				$OffsetY = 200;
				$OffsetX = 400;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosVPreventivaAntes[$i-1];
				if($i == 1 || $i%5 == 0){
					$slide = $objPHPPowerPoint->createSlide();

					$shape = $slide->createRichTextShape()
					      ->setHeight(300)
					      ->setWidth(600)
					      ->setOffsetX(170)
					      ->setOffsetY(50);
					$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
					$textRun = $shape->createTextRun('Antes');
					$textRun->getFont()->setBold(true)
					                   ->setSize(30)
					                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

					$shape = $slide->createDrawingShape();
						$shape->setName('Movistar')
				      ->setDescription('Logo Movistar')
				       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
				      ->setHeight(80)
				      ->setOffsetX(750)
				      ->setOffsetY(10);

			      	$shape = $slide->createDrawingShape();
						$shape->setName('Cirigliano')
				      ->setDescription('Logo Cirigliano')
				      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
				      ->setHeight(60)
				      ->setOffsetX(740)
				      ->setOffsetY(650);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Antes')
				      ->setDescription('Visita Preventiva Antes')
				      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Antes')
				      ->setDescription('Visita Preventiva Antes')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120 + $OffsetY);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Antes')
				      ->setDescription('Visita Preventiva Antes')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Antes')
				      ->setDescription('Visita Preventiva Antes')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120 + $OffsetY);
				}
			}

			// Visita Preventiva Despues
			$cant = count($fotosVPreventivaDespues);
			if($cant == 1)
			{
				$height = 500;
				$OffsetY = 200;
				$OffsetX = 550;
			}
			else{
				$height = 250;
				$OffsetY = 200;
				$OffsetX = 400;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosVPreventivaDespues[$i-1];
				if($i == 1 || $i%5 == 0){
					$slide = $objPHPPowerPoint->createSlide();

					$shape = $slide->createRichTextShape()
					      ->setHeight(300)
					      ->setWidth(600)
					      ->setOffsetX(170)
					      ->setOffsetY(50);
					$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
					$textRun = $shape->createTextRun('Despues');
					$textRun->getFont()->setBold(true)
					                   ->setSize(30)
					                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

					$shape = $slide->createDrawingShape();
						$shape->setName('Movistar')
				      ->setDescription('Logo Movistar')
				       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
				      ->setHeight(80)
				      ->setOffsetX(750)
				      ->setOffsetY(10);

			      	$shape = $slide->createDrawingShape();
						$shape->setName('Cirigliano')
				      ->setDescription('Logo Cirigliano')
				      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
				      ->setHeight(60)
				      ->setOffsetX(740)
				      ->setOffsetY(650);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Despues')
				      ->setDescription('Visita Preventiva Despues')
				      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Despues')
				      ->setDescription('Visita Preventiva Despues')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120 + $OffsetX)
				      ->setOffsetY(120 + $OffsetY);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Despues')
				      ->setDescription('Visita Preventiva Despues')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$shape = $slide->createDrawingShape();
						$shape->setName('Despues')
				      ->setDescription('Visita Preventiva Despues')
				      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
				      ->setHeight($height)
				      ->setOffsetX(120)
				      ->setOffsetY(120 + $OffsetY);
				}
			}


			// Muebles
			
			foreach ($fotosMueble as $mueble) {
				$cantAntes = count($mueble['Antes']);
				$cantDespues = count($mueble['Despues']);
				if($cantAntes == 1)
				{
					$baseY = 120;
					$baseX = 170;
					$height = 500;
				}
				else{
					$baseY = 120;
					$baseX = 120;
					$height = 250;
					$OffsetY = 200;
					$OffsetX = 400;
				}
				for ($i=1; $i <= $cantAntes ; $i++) { 
					$foto = $mueble['Antes'][$i-1];
					if($i == 1 || $i%5 == 0){
						$mueblepresupuesto = $modelItemPresupuesto::model()->findByPk($foto->item_foto_id);
						$slide = $objPHPPowerPoint->createSlide();

						$shape = $slide->createRichTextShape()
						      ->setHeight(300)
						      ->setWidth(600)
						      ->setOffsetX(170)
						      ->setOffsetY(50);
						$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
						$textRun = $shape->createTextRun(strip_tags($mueblepresupuesto->Descripcion.' Antes'));
						$textRun->getFont()->setBold(true)
						                   ->setSize(16)
						                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

						$shape = $slide->createDrawingShape();
							$shape->setName('Movistar')
					      ->setDescription('Logo Movistar')
					       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
					      ->setHeight(80)
					      ->setOffsetX(750)
					      ->setOffsetY(10);

				      	$shape = $slide->createDrawingShape();
							$shape->setName('Cirigliano')
					      ->setDescription('Logo Cirigliano')
					      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
					      ->setHeight(60)
					      ->setOffsetX(740)
					      ->setOffsetY(650);
					}
					if($i%2 == 0 && $i%4 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY + $OffsetY);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY + $OffsetY);
					}
				}
				for ($i=1; $i <= $cantDespues ; $i++) { 
					$foto = $mueble['Despues'][$i-1];
					if($i == 1 || $i%5 == 0){
						$mueblepresupuesto = $modelItemPresupuesto::model()->findByPk($foto->item_foto_id);
						$slide = $objPHPPowerPoint->createSlide();

						$shape = $slide->createRichTextShape()
						      ->setHeight(300)
						      ->setWidth(600)
						      ->setOffsetX(170)
						      ->setOffsetY(50);
						$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
						$textRun = $shape->createTextRun(strip_tags($mueblepresupuesto->Descripcion.' Despues'));
						$textRun->getFont()->setBold(true)
						                   ->setSize(16)
						                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

						$shape = $slide->createDrawingShape();
							$shape->setName('Movistar')
					      ->setDescription('Logo Movistar')
					       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
					      ->setHeight(80)
					      ->setOffsetX(750)
					      ->setOffsetY(10);

				      	$shape = $slide->createDrawingShape();
							$shape->setName('Cirigliano')
					      ->setDescription('Logo Cirigliano')
					      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
					      ->setHeight(60)
					      ->setOffsetX(740)
					      ->setOffsetY(650);
					}
					if($i%2 == 0 && $i%4 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY + $OffsetY);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepresupuesto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY + $OffsetY);
					}
				}
			}

			// Adicionales
			
			foreach ($fotosAdicionales as $adicional) {
				$cantAntes = count($adicional['Antes']);
				$cantDespues = count($adicional['Despues']);
				if($cantAntes == 1)
				{
					$baseY = 120;
					$baseX = 170;
					$height = 500;
				}
				else{
					$baseY = 120;
					$baseX = 120;
					$height = 250;
					$OffsetY = 200;
					$OffsetX = 400;
				}
				for ($i=1; $i <= $cantAntes ; $i++) { 
					$foto = $adicional['Antes'][$i-1];
					if($i == 1 || $i%5 == 0){
						$itemAdicional = Adicional::model()->findByPk($foto->item_foto_id);
						$slide = $objPHPPowerPoint->createSlide();

						$shape = $slide->createRichTextShape()
						      ->setHeight(300)
						      ->setWidth(600)
						      ->setOffsetX(170)
						      ->setOffsetY(50);
						$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
						$textRun = $shape->createTextRun($itemAdicional->Descripcion.' Antes');
						$textRun->getFont()->setBold(true)
						                   ->setSize(16)
						                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

						$shape = $slide->createDrawingShape();
						$shape->setName('Movistar')
					      ->setDescription('Logo Movistar')
					       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
					      ->setHeight(80)
					      ->setOffsetX(750)
					      ->setOffsetY(10);

				      	$shape = $slide->createDrawingShape();
							$shape->setName('Cirigliano')
					      ->setDescription('Logo Cirigliano')
					      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
					      ->setHeight(60)
					      ->setOffsetX(740)
					      ->setOffsetY(650);
					}
					if($i%2 == 0 && $i%4 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY + $OffsetY);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY + $OffsetY);
					}
				}
				for ($i=1; $i <= $cantDespues ; $i++) { 
					$foto = $adicional['Despues'][$i-1];
					if($i == 1 || $i%5 == 0){
						$itemAdicional = Adicional::model()->findByPk($foto->item_foto_id);
						$slide = $objPHPPowerPoint->createSlide();

						$shape = $slide->createRichTextShape()
						      ->setHeight(300)
						      ->setWidth(600)
						      ->setOffsetX(170)
						      ->setOffsetY(50);
						$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
						$textRun = $shape->createTextRun($itemAdicional->Descripcion.' Despues');
						$textRun->getFont()->setBold(true)
						                   ->setSize(16)
						                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

						$shape = $slide->createDrawingShape();
							$shape->setName('Movistar')
					      ->setDescription('Logo Movistar')
					       ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg')
					      ->setHeight(80)
					      ->setOffsetX(750)
					      ->setOffsetY(10);

				      	$shape = $slide->createDrawingShape();
							$shape->setName('Cirigliano')
					      ->setDescription('Logo Cirigliano')
					      ->setPath(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png')
					      ->setHeight(60)
					      ->setOffsetX(740)
					      ->setOffsetY(650);
					}
					if($i%2 == 0 && $i%4 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY + $OffsetY);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($itemAdicional->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY + $OffsetY);
					}
				}
			}
			// Save file
			echo self::write($objPHPPowerPoint, $visita->id, $writers,$visita);
			return Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/'.$visita->id.'.pptx';
		}
		else{
			return false;
		}	
	}

	public static function InformePdf( $id = null)
	{	
		if($id != null){
			$visita = Visita::model()->findByPk($id);
			$visita = Visita::model()->findByPk($id);
			$p = $visita->presupuestos;
			if($visita->tipo_visita_id == 3)
				$modelItemPresupuesto = 'TrasladoPresupuesto';
			else
				$modelItemPresupuesto = 'MueblePresupuesto';
			
			if($visita->tipo_visita_id == 3)
				$mps = $p[0]->trasladopresupuesto;
			else
				$mps = $p[0]->mueblespresupuesto;
			
			$fotos = $visita->formulario->fotos;

			$fotosActa = array();
			$fotosGeneral = array();
			$fotosOtros = array();
			$fotosMueble = array();
			$fotosAdicionales = array();
			$fotosVPreventivaAntes = array();
			$fotosVPreventivaDespues = array();

			foreach ($fotos as $foto) {
				if($foto->tipo_foto_id == 1){
					if(isset($fotosMueble[$foto->item_foto_id])){
						if(isset($fotosMueble[$foto->item_foto_id]['Antes'])){
							$fotosMueble[$foto->item_id]['Antes'][] =$foto;
						}
						else
							$fotosMueble[$foto->item_id]['Antes'] =array($foto);
					}
					else
						$fotosMueble[$foto->item_foto_id] = array('Antes'=>array($foto));
				}
				if($foto->tipo_foto_id == 2){
					if(isset($fotosMueble[$foto->item_foto_id])){
						if(isset($fotosMueble[$foto->item_foto_id]['Despues'])){
							$fotosMueble[$foto->item_foto_id]['Despues'][] =$foto;
						}
						else
							$fotosMueble[$foto->item_foto_id]['Despues'] =array($foto);
					}
					else
						$fotosMueble[$foto->item_foto_id] = array('Despues'=>array($foto));
				}
				if($foto->tipo_foto_id == 8){
					if(isset($fotosAdicionales[$foto->item_foto_id])){
						if(isset($fotosAdicionales[$foto->item_foto_id]['Antes'])){
							$fotosAdicionales[$foto->item_foto_id]['Antes'][] =$foto;
						}
						else
							$fotosAdicionales[$foto->item_foto_id]['Antes'] =array($foto);
					}
					else
						$fotosAdicionales[$foto->item_foto_id] = array('Antes'=>array($foto));
				}
				if($foto->tipo_foto_id == 9){
					if(isset($fotosAdicionales[$foto->item_foto_id])){
						if(isset($fotosAdicionales[$foto->item_foto_id]['Despues'])){
							$fotosAdicionales[$foto->item_foto_id]['Despues'][] =$foto;
						}
						else
							$fotosAdicionales[$foto->item_foto_id]['Despues'] =array($foto);
					}
					else
						$fotosAdicionales[$foto->item_foto_id] = array('Despues'=>array($foto));
				}
				if($foto->tipo_foto_id == 10){
					$fotosVPreventivaAntes[] = $foto;
				}
				if($foto->tipo_foto_id == 11){
					$fotosVPreventivaDespues[] = $foto;
				}
				if($foto->tipo_foto_id == 3){
					$fotosActa[] = $foto;
				}
				if($foto->tipo_foto_id == 4){
					$fotosGeneral[] = $foto;
				}
				if($foto->tipo_foto_id == 5){
					$fotosOtros[] = $foto;
				}
				# code...
			}

			$MueblesPresupuesto = $mps;
			

			$pdf = Yii::createComponent("application.extensions.tcpdf.ETcPdf", 
		                            "P", "pt", "Letter", true, "UTF-8");
			$pdf->SetCreator(PDF_CREATOR);
			$pdf->SetAuthor("Cirigliano");
			$pdf->SetTitle("[Title]");
			$pdf->SetSubject("[Subject]");
			$pdf->SetKeywords("[Keywords]");
			$pdf->setPrintHeader(false);
			$pdf->setPrintFooter(false);
			$pdf->SetHeaderMargin(0);
			$pdf->SetFooterMargin(0);
			$pdf->SetMargins(20,20,20,0);
			$pdf->AddPage();
			$pdf->SetFont("dejavusans", "B", 18);
			$style = array(
			    "border" => false,
			    "padding" => 0,
			    "fgcolor" => array(0,0,0),
			    "bgcolor" => false
			);

			//$pdf->Image(Yii::app()->baseUrl."/images"."/escudo%20cia.png", ($pdf->getPageWidth()/2)-76, 2*$pdf->getPageHeight()/27, 130, 0, "PNG", "", "", true, 300);
		
			$pdf->Image(Yii::getPathOfAlias('webroot').'/images/logo_movistar.jpg', 12, 5, 100, 0, "JPG","","",true, 300);
			$pdf->Image(Yii::getPathOfAlias('webroot').'/images/logo_ciri.png', ($pdf->getPageWidth()/2)+210, 10, 80, 0, "PNG","","",true, 300);
			
			$pdf->SetFont("dejavusans", "", 19);
			$pdf->SetY(1.5*$pdf->getPageHeight()/27);
			$pdf->MultiCell(0,100,'Informe Solicitud de Mantención de Muebles ',0,"C",false);

			$pdf->SetFont("dejavusans", "", 12);
			$pdf->SetY(5*$pdf->getPageHeight()/54);
			$pdf->MultiCell(0,100,'Folio: '.$visita->folio,0,"L",false);
			$pdf->SetFont("dejavusans", "", 12);
			$pdf->SetY(6*$pdf->getPageHeight()/54);
			$pdf->MultiCell(0,100,'Punto: '.$visita->punto->direccion.' '.$visita->punto->comuna->nombre,0,"L",false);
			$pdf->SetFont("dejavusans", "", 12);
			$pdf->SetY(7*$pdf->getPageHeight()/54);
			$pdf->MultiCell(0,100,'Canal: '.$visita->punto->canal->nombre,0,"L",false);
			$pdf->SetFont("dejavusans", "", 12);
			$pdf->SetY(8*$pdf->getPageHeight()/54);
			$pdf->MultiCell(0,100,'Distribuidor: '.$visita->punto->distribuidor->nombre,0,"L",false);
			$pdf->SetFont("dejavusans", "", 12);
			$pdf->SetY(9*$pdf->getPageHeight()/54);
			$pdf->MultiCell(0,100,'Fecha Ingreso: '.date('d-m-Y',strtotime($visita->fecha_creacion)),0,"L",false);
			$pdf->SetFont("dejavusans", "", 12);
			$pdf->SetY(10*$pdf->getPageHeight()/54);
			$pdf->MultiCell(0,100,'Fecha Ejecución: '.date('d-m-Y',strtotime($visita->fecha_visita)),0,"L",false);
			$pdf->SetFont("dejavusans", "", 12);
			$pdf->SetY(11*$pdf->getPageHeight()/54);
			$pdf->MultiCell(0,100,'Solicitante: '.$visita->personaPunto->Nombre,0,"L",false);

			$pdf->SetFont("dejavusans", "", 16);
			$pdf->SetY(6.5*$pdf->getPageHeight()/27);
			$pdf->MultiCell(0,100,'Presupuesto',0,"L",false);


			$tbl = '
				<table cellspacing="0" cellpadding="1" border="1" style="font-size:12;">
				    <tr>
				        <th style="width:75%;">Item</th>
				        <th style="width:10%;text-align:right">Cantidad</th>
				        <th style="width:15%;text-align:right">Monto</th>
				    </tr>';
			if($visita->tipo_visita_id == 3){

				$tbl .='<tr><td>'.$p[0]->tarifaTraslado->Descripcion.'</td><td>1</td><td>'.$p[0]->TTraslado.'</td></tr>';
			}
			if ($visita->visita_preventiva == 1 && $p[0]->tarifa_visita_preventiva) {
					$tbl .='<tr>
			        <td style="width:75%;">Visita Preventiva</td>
			        <td style="width:10%;text-align:right">1</td>
			        <td style="width:15%;text-align:right">'.$p[0]->tarifa_visita_preventiva.'</td>
			    </tr>';
				}
			foreach ($mps as $accion) {
				$tbl .='<tr>
			        <td style="width:75%;">'.$accion->Descripcion.'</td>
			        <td style="width:10%;text-align:right">'.$accion->cant_servicio.'</td>
			        <td style="width:15%;text-align:right">'.$accion->Tarifa.'</td>
			    </tr>';
			}
			foreach ($p[0]->adicionales as $ad) {
				$tbl .='<tr>
			        <td style="width:75%;">'.$ad->Descripcion.'</td>
			        <td style="width:10%;text-align:right">'.$ad->cantidad.'</td>
			        <td style="width:15%;text-align:right">'.$ad->tarifa.'</td>
			    </tr>';
			}
			$tbl .= '<tr>
				       <td colspan="2" align="right"> Total:</td>
				       <td style="text-align:right;">'.$p[0]->total.'</td>
				    </tr>

				</table>';
			$pdf->SetY(7.5*$pdf->getPageHeight()/27);
			$pdf->writeHTML($tbl, true, false, false, false, '');


			$pdf->SetY(20*$pdf->getPageHeight()/27);
			$pdf->SetFont("dejavusans", "", 14);
			$pdf->MultiCell(0,100,"Notas:",0,"L",false);
			
			$pdf->SetY(21*$pdf->getPageHeight()/27);
			$pdf->MultiCell(0,100,$visita->formulario->notas,0,"L",false);


			// ACTA
			$cant = count($fotosActa);
			if($cant == 1)
			{
				$height = 500;
				$width = 350;
				$baseY = 120;
				$baseX = 120;
			}
			else{
				$baseY = 120;
				$baseX = 60;
				$height = 250;
				$width = 175;
				$OffsetY = 200;
				$OffsetX = 250;
			}
			/*
			Image	($file,$x = '',$y = '',$w = 0,$h = 0,$type = '',$link = '',$align = '',$resize = false,$dpi = 300,$palign = '',$ismask = false,$imgmask = false,$border = 0,$fitbox = false,$hidden = false,$fitonpage = false,$alt = false,$altimgs = array() )		


			*/

			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosActa[$i-1];
				if($i == 1 || $i%5 == 0){
					$pdf->AddPage();
					$pdf->SetFont("dejavusans", "", 18);
					$pdf->SetY(1*$pdf->getPageHeight()/27);
					$pdf->MultiCell(0,100,'Acta',0,"C",false);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
			}
			// General
			$cant = count($fotosGeneral);
			if($cant == 1)
			{
				$height = 500;
				$width = 350;
				$baseY = 120;
				$baseX = 120;
			}
			else{
				$baseY = 120;
				$baseX = 60;
				$height = 250;
				$width = 175;
				$OffsetY = 200;
				$OffsetX = 250;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosGeneral[$i-1];
				if($i == 1 || $i%5 == 0){
					$pdf->AddPage();
					$pdf->SetFont("dejavusans", "", 18);
					$pdf->SetY(1*$pdf->getPageHeight()/27);
					$pdf->MultiCell(0,100,'General',0,"C",false);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
			}

			// Otros
			$cant = count($fotosOtros);
			if($cant == 1)
			{
				$height = 500;
				$width = 350;
				$baseY = 120;
				$baseX = 120;
			}
			else{
				$baseY = 120;
				$baseX = 60;
				$height = 250;
				$width = 175;
				$OffsetY = 200;
				$OffsetX = 250;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosOtros[$i-1];
				if($i == 1 || $i%5 == 0){
					$pdf->AddPage();
					$pdf->SetFont("dejavusans", "", 18);
					$pdf->SetY(1*$pdf->getPageHeight()/27);
					$pdf->MultiCell(0,100,'Otros',0,"C",false);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
			}

			// Visita Preventiva Antes
			$cant = count($fotosVPreventivaAntes);
			if($cant == 1)
			{
				$height = 500;
				$width = 350;
				$baseY = 120;
				$baseX = 120;
			}
			else{
				$baseY = 120;
				$baseX = 60;
				$height = 250;
				$width = 175;
				$OffsetY = 200;
				$OffsetX = 250;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosVPreventivaAntes[$i-1];
				if($i == 1 || $i%5 == 0){
					$pdf->AddPage();
					$pdf->SetFont("dejavusans", "", 18);
					$pdf->SetY(1*$pdf->getPageHeight()/27);
					$pdf->MultiCell(0,100,'Antes',0,"C",false);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
			}

			// Visita Preventiva Despus
			$cant = count($fotosVPreventivaDespues);
			if($cant == 1)
			{
				$height = 500;
				$width = 350;
				$baseY = 120;
				$baseX = 120;
			}
			else{
				$baseY = 120;
				$baseX = 60;
				$height = 250;
				$width = 175;
				$OffsetY = 200;
				$OffsetX = 250;
			}
			for ($i=1; $i <= $cant ; $i++) { 
				$foto = $fotosVPreventivaDespues[$i-1];
				if($i == 1 || $i%5 == 0){
					$pdf->AddPage();
					$pdf->SetFont("dejavusans", "", 18);
					$pdf->SetY(1*$pdf->getPageHeight()/27);
					$pdf->MultiCell(0,100,'Despues',0,"C",false);
				}
				if($i%2 == 0 && $i%4 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 == 0 && $i%4 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 != 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
				if($i%2 != 0 && $i%3 == 0) {
					$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
				}
			}

			//Muebles
			foreach ($fotosMueble as $mueble) {
				$cantAntes = count($mueble['Antes']);
				$cantDespues = count($mueble['Despues']);
				if($cantAntes == 1)
				{
					$height = 500;
					$width = 350;
					$baseY = 120;
					$baseX = 120;
				}
				else{
					$baseY = 120;
					$baseX = 60;
					$height = 250;
					$width = 175;
					$OffsetY = 200;
					$OffsetX = 250;
				}
				for ($i=1; $i <= $cantAntes ; $i++) { 
					$foto = $mueble['Antes'][$i-1];
					if($i == 1 || $i%5 == 0){
						$mueblepunto = $modelItemPresupuesto::model()->findByPk($foto->item_foto_id);
						$pdf->AddPage();
						$pdf->SetFont("dejavusans", "", 14);
						$pdf->SetY(1*$pdf->getPageHeight()/27);
						//$pdf->writeHTML('<p>'.$mueblepunto->MueblePuntoDescripcion.'</p>', true, false, false, false, '');
						$pdf->MultiCell(0,100,$mueblepunto->MueblePuntoDescripcion,0,"L",false);
						$pdf->SetY(2*$pdf->getPageHeight()/27);
						$pdf->writeHTML('<p>'.$mueblepunto->ServicioDescripcion.' Antes</p>', true, false, true, false, '');
					}
					if($i%2 == 0 && $i%4 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
				}
				if($cantDespues == 1)
				{
					$height = 500;
					$width = 350;
					$baseY = 120;
					$baseX = 120;
				}
				else{
					$baseY = 120;
					$baseX = 60;
					$height = 250;
					$width = 175;
					$OffsetY = 200;
					$OffsetX = 250;
				}
				for ($i=1; $i <= $cantDespues ; $i++) { 
					$foto = $mueble['Despues'][$i-1];
					if($i == 1 || $i%5 == 0){
						$mueblepunto = $modelItemPresupuesto::model()->findByPk($foto->item_foto_id);
						$pdf->AddPage();
						$pdf->SetFont("dejavusans", "", 14);
						$pdf->SetY(1*$pdf->getPageHeight()/27);
						$pdf->MultiCell(0,100,$mueblepunto->MueblePuntoDescripcion,0,"L",false);
						//$pdf->writeHTML('<p>'.$mueblepunto->MueblePuntoDescripcion.'</p>', true, false, false, false, '');
						$pdf->SetY(2*$pdf->getPageHeight()/27);
						$pdf->writeHTML('<p>'.$mueblepunto->ServicioDescripcion.' Despues</p>', true, false, true, false, '');
						//$pdf->MultiCell(0,100,$mueblepunto->Descripcion.' Despues',0,"C",false);
					}
					if($i%2 == 0 && $i%4 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
				}
			}

			foreach ($fotosAdicionales as $mueble) {
				$cantAntes = count($mueble['Antes']);
				$cantDespues = count($mueble['Despues']);
				if($cantAntes == 1)
				{
					$height = 500;
					$width = 350;
					$baseY = 120;
					$baseX = 120;
				}
				else{
					$baseY = 120;
					$baseX = 60;
					$height = 250;
					$width = 175;
					$OffsetY = 200;
					$OffsetX = 250;
				}
				for ($i=1; $i <= $cantAntes ; $i++) { 
					$foto = $mueble['Antes'][$i-1];
					if($i == 1 || $i%5 == 0){
						$mueblepunto = Adicional::model()->findByPk($foto->item_foto_id);
						$pdf->AddPage();
						$pdf->SetFont("dejavusans", "", 14);
						$pdf->SetY(1*$pdf->getPageHeight()/27);
						$pdf->MultiCell(0,100,$mueblepunto->MueblePuntoDescripcion,0,"L",false);
						//$pdf->writeHTML('<p>'.$mueblepunto->MueblePuntoDescripcion.'</p>', true, false, false, false, '');
						$pdf->SetY(2*$pdf->getPageHeight()/27);
						$pdf->writeHTML('<p>'.$mueblepunto->ServicioDescripcion.' Antes</p>', true, false, true, false, '');
						//$pdf->MultiCell(0,100,$mueblepunto->Descripcion.' Antes',0,"C",false);
					}
					if($i%2 == 0 && $i%4 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
				}
				if($cantDespues == 1)
				{
					$height = 500;
					$width = 350;
					$baseY = 120;
					$baseX = 120;
				}
				else{
					$baseY = 120;
					$baseX = 60;
					$height = 250;
					$width = 175;
					$OffsetY = 200;
					$OffsetX = 250;
				}
				for ($i=1; $i <= $cantDespues ; $i++) { 
					$foto = $mueble['Despues'][$i-1];
					if($i == 1 || $i%5 == 0){
						$mueblepunto = Adicional::model()->findByPk($foto->item_foto_id);
						$pdf->AddPage();
						$pdf->SetFont("dejavusans", "", 14);
						$pdf->SetY(1*$pdf->getPageHeight()/27);
						$pdf->MultiCell(0,100,$mueblepunto->MueblePuntoDescripcion,0,"L",false);
						//$pdf->writeHTML('<p>'.$mueblepunto->MueblePuntoDescripcion.'</p>', true, false, false, false, '');
						$pdf->SetY(2*$pdf->getPageHeight()/27);
						$pdf->writeHTML('<p>'.$mueblepunto->ServicioDescripcion.' Despues</p>', true, false, true, false, '');
					}
					if($i%2 == 0 && $i%4 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX+$OffsetX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$pdf->Image($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension, $baseX, $baseY + $OffsetY, $width, $height, $foto->foto->extension, "", "", true, 300,'',false,false,0,true);
					}
				}
			}

			if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/')) {
			   		mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
		   			chmod(Yii::getPathOfAlias('webroot').'/uploads/', 0775); 
	   		}
   			if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/informes/')) {
   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/informes/');
   				chmod(Yii::getPathOfAlias('webroot').'/uploads/informes/', 0775);
   			}
				if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/')) {
   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/');
   				chmod(Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/', 0775);
   			} 
			$pdf->Output(Yii::getPathOfAlias('webroot')."/uploads/informes/".$visita->punto_id."/".$visita->id.".pdf", "F");
		}
		else return false;
	}

	static function write($phpPowerPoint, $filename, $writers,$visita)
	{
		$v = $visita;
		
		// Write documents
		foreach ($writers as $writer => $extension) {
			if (!is_null($extension)) {
				$xmlWriter = PhpOffice\PhpPowerpoint\IOFactory::createWriter($phpPowerPoint, $writer);
				if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/')) {
			   		mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
		   			chmod(Yii::getPathOfAlias('webroot').'/uploads/', 0775); 
		   		}
	   			if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/informes/')) {
	   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/informes/');
	   				chmod(Yii::getPathOfAlias('webroot').'/uploads/informes/', 0775);
	   			}
					if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/')) {
	   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/');
	   				chmod(Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/', 0775);
	   			} 
				$xmlWriter->save(Yii::getPathOfAlias('webroot')."/uploads/informes/".$visita->punto_id."/{$filename}.{$extension}");
			}
		}
	}
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
