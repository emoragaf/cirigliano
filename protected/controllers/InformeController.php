<?php

class InformeController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('InformePpt','InformePdf'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionInformePpt( $id= null)
	{
		if($id != null){
			$visita = Visita::model()->findByPk($id);
			$p = $visita->presupuestos;
			$mps = $p[0]->mueblespresupuesto;
			$fotos = $visita->formulario->fotos;

			$fotosActa = array();
			$fotosGeneral = array();
			$fotosOtros = array();
			$fotosMueble = array();

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

			$MueblesPresupuesto = array();
			foreach ($mps as $key => $value) {
				$MueblesPresupuesto[$value->mueble_punto_id]= $value->mueblepunto;
			}
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
			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(170)
			      ->setOffsetY(50);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
			$textRun = $shape->createTextRun('Visita Punto '.$visita->punto->direccion.' '.$visita->fecha_visita);
			$textRun->getFont()->setBold(true)
			                   ->setSize(25)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(120);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Presupuesto');
			$textRun->getFont()->setBold(true)
			                   ->setSize(20)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

			$shape = $currentSlide->createTableShape(3);
			$shape->setHeight(200);
			$shape->setWidth(700);
			$shape->setOffsetX(120);
			$shape->setOffsetY(180);

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
			foreach ($mps as $accion) {
				$row = $shape->createRow();
				$row->getFill()->setFillType(PhpOffice\PhpPowerpoint\Style\Fill::FILL_SOLID)
				               ->setStartColor(new PhpOffice\PhpPowerpoint\Style\Color('FFFFFFFF'));
				$cell = $row->nextCell();
				$cell->createTextRun($accion->servicio->mueble->descripcion.' '.$accion->mueblepunto->codigo.' '.$accion->servicio->descripcion)->getFont()->setSize(12);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
				$cell = $row->nextCell();
				$cell->createTextRun($accion->cant_servicio)->getFont()->setSize(12);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
                $cell = $row->nextCell();
				$cell->createTextRun($accion->tarifa_servicio*$accion->cant_servicio)->getFont()->setSize(12);
				$cell->getBorders()->getBottom()->setLineWidth(2)
				                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
			}

			$row = $shape->createRow();
			$cell = $row->nextCell();
			$cell->getBorders()->getRight()->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_NONE);  
			$cell = $row->nextCell();
			$cell->createTextRun('Total:')->getFont()->setSize(12);
            $cell->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_RIGHT );
			$cell->getBorders()->getBottom()->setLineWidth(1)
			                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
			$cell->getBorders()->getLeft()->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_NONE);                               
            $cell = $row->nextCell();
			$cell->createTextRun($p[0]->total)->getFont()->setBold(true)
			                                            ->setSize(12);
			$cell->getBorders()->getBottom()->setLineWidth(1)
			                                ->setLineStyle(PhpOffice\PhpPowerpoint\Style\Border::LINE_SINGLE);
			 
			$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(590);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun('Notas:');
			$textRun->getFont()->setBold(true)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );

        	$shape = $currentSlide->createRichTextShape()
			      ->setHeight(300)
			      ->setWidth(600)
			      ->setOffsetX(120)
			      ->setOffsetY(620);
			$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_LEFT );
			$textRun = $shape->createTextRun($visita->formulario->notas);
			$textRun->getFont()->setBold(false)
			                   ->setSize(14)
			                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );
            
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
						$mueblepunto = MueblePunto::model()->findByPk($foto->item_foto_id);
						$slide = $objPHPPowerPoint->createSlide();

						$shape = $slide->createRichTextShape()
						      ->setHeight(300)
						      ->setWidth(600)
						      ->setOffsetX(170)
						      ->setOffsetY(50);
						$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
						$textRun = $shape->createTextRun($mueblepunto->Descripcion.' Antes');
						$textRun->getFont()->setBold(true)
						                   ->setSize(30)
						                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );
					}
					if($i%2 == 0 && $i%4 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY + $OffsetY);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Antes')
					      ->setDescription('Foto Antes')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Antes')
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
						$mueblepunto = MueblePunto::model()->findByPk($foto->item_foto_id);
						$slide = $objPHPPowerPoint->createSlide();

						$shape = $slide->createRichTextShape()
						      ->setHeight(300)
						      ->setWidth(600)
						      ->setOffsetX(170)
						      ->setOffsetY(50);
						$shape->getActiveParagraph()->getAlignment()->setHorizontal( PhpOffice\PhpPowerpoint\Style\Alignment::HORIZONTAL_CENTER );
						$textRun = $shape->createTextRun($mueblepunto->Descripcion.' Despues');
						$textRun->getFont()->setBold(true)
						                   ->setSize(30)
						                   ->setColor( new PhpOffice\PhpPowerpoint\Style\Color( '000000' ) );
					}
					if($i%2 == 0 && $i%4 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto->id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY);
					}
					if($i%2 == 0 && $i%4 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX + $OffsetX)
					      ->setOffsetY($baseY + $OffsetY);
					}
					if($i%2 != 0 && $i%3 != 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY);
					}
					if($i%2 != 0 && $i%3 == 0) {
						$shape = $slide->createDrawingShape();
							$shape->setName($mueblepunto->Descripcion.' Despues')
					      ->setDescription('Foto Despues')
					      ->setPath($foto->foto->path.'/'.$foto->foto_id.'.'.$foto->foto->extension)
					      ->setHeight($height)
					      ->setOffsetX($baseX)
					      ->setOffsetY($baseY + $OffsetY);
					}
				}
			}
				
		
			
	
			// Save file
			echo $this->write($objPHPPowerPoint, $visita->id, $writers,$visita);
			return Yii::getPathOfAlias('webroot').'/uploads/informes/'.$visita->punto_id.'/'.$visita->id.'.pptx'
		}
		else{
			return false;
		}	
	}

	public function actionInformePdf( $params = array())
	{
		if(isset($params['multi']) && $params['multi'] == true && isset($params['ids']) && is_array($params['ids']) && !empty($params['ids'])){
			$ids = $params['ids'];
		}
		elseif(isset($params['id']) && !empty($params['id'])){
			$id = Visita::model()->findByPk($params['id']);
		}
		else return false;
	}


	function write($phpPowerPoint, $filename, $writers,$visita)
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
}