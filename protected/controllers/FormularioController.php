<?php

class FormularioController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters() {
     return array(
        //it's important to add site/error, so an unpermitted user will get the error.
        array('auth.filters.AuthFilter'),
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
				'actions'=>array('create','update'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		set_time_limit(0);
		$root = Yii::getPathOfAlias('webroot').'/../files/cirigliano';
		$visita = Visita::model()->findByPK($id);
		$campos = CampoFormulario::model()->findAll(array('condition'=>'tipo_visita_id ='.$visita->tipo_visita_id));
		$presupuesto =$visita->presupuestos[0];
		$Muebles = $presupuesto->mueblespresupuesto;
		$Adicional = $presupuesto->adicionales;
		$traslados = $presupuesto->trasladopresupuesto;
		$TrasladoPresupuesto = $traslados;
		$MueblePresupuesto = $Muebles;
		//$MueblesPresupuesto = array();
		/*foreach ($Muebles as $key => $value) {
			$MueblesPresupuesto[$value->mueble_punto_id]= $value->mueblepunto;
			# code...
		}*/
		$model=new Formulario;
		$model->visita_id = $visita->id;
		if ($visita->tipo_visita_id == 3) {
				$model->notas = $presupuesto->nota;
		}

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if (isset($_POST['Formulario'])) {
			$model->attributes=$_POST['Formulario'];
			$model->created_at = date('c');
			if($model->estado = 3)
				$model->estado = 4;
			if ($model->save()) {
				foreach ($campos as $campo) {
					$campo->entidad = str_replace('[', '', $campo->entidad);
					$campo->entidad = str_replace(']', '', $campo->entidad);
					if (strpos($campo->entidad,'n:') !== false) {
					    $foo = explode(':', $campo->entidad);
					    foreach ($$foo[1] as $mueble) {
				    		$nombre = $campo->nombre;
					    	if(strpos($nombre,'%n') !== false){
					    		$id = str_replace('%n', '', $nombre);
					    		$fieldname = 'Foto'.str_replace(' ', '', $id).$mueble->id;
					    		if($campo->tipo->nombre == 'FotoMultiple' || $campo->tipo->nombre == 'FotoSimple'){
					    			$images = CUploadedFile::getInstancesByName($fieldname);
				    				if (isset($images) && count($images) > 0) {
							            // go through each uploaded image
							            foreach ($images as $image => $pic) {
							            	if(!is_dir($root.'/uploads/')) {
										   		mkdir($root.'/uploads/');
									   			chmod($root.'/uploads/', 0775);
									   		}
								   			if(!is_dir($root.'/uploads/visitas/')) {
								   				mkdir($root.'/uploads/visitas/');
								   				chmod($root.'/uploads/visitas/', 0775);
								   			}
						   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
								   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
								   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
								   			}
						   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/')) {
								   				mkdir($root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/');
								   				chmod($root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/', 0775);
								   			}

						                    $formfoto = new FormularioFotos;
						                    $foto = new Foto;
						                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
						                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/';
						                    $foto->extension = $pic->extensionName;
						                    if($foto->save()){
						                    	$tipo = TipoFoto::model()->find(array('condition'=>'nombre ="'.str_replace(' ', '', $id).'" AND model ="'.$foo[1].'"'));

						                    	$formfoto->formulario_id = $model->id;
						                    	$formfoto->foto_id = $foto->id;
						                    	$formfoto->item_foto_id = $mueble->id;
						                    	$formfoto->tipo_foto_id = $tipo->id;
						                    	$formfoto->save();
							                	$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
						                    }
						                    else{
					                    		print_r($foto->errors);
						                    }

								        }
								    }
					    		}
					    	}
					    }
					}
					else {
						$fieldname = str_replace(' ', '', $campo->nombre);
						if((strcmp($campo->nombre,'Acta')=== 0 || strcmp($campo->nombre,'General')=== 0 || strcmp($campo->nombre,'Otros')=== 0) && $campo->tipo->nombre == 'FotoMultiple'){
							$images = CUploadedFile::getInstancesByName($fieldname);
							if (isset($images)) {
					            // go through each uploaded image
					            foreach ($images as $image => $pic) {
					            	if(!is_dir($root.'/uploads/')) {
								   		mkdir($root.'/uploads/');
							   			chmod($root.'/uploads/', 0775);
							   		}
						   			if(!is_dir($root.'/uploads/visitas/')) {
						   				mkdir($root.'/uploads/visitas/');
						   				chmod($root.'/uploads/visitas/', 0775);
						   			}
				   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
						   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
						   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
						   			}

				                    $formfoto = new FormularioFotos;
				                    $foto = new Foto;
				                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
				                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/';
				                    $foto->extension = $pic->extensionName;
				                    if($foto->save()){
				                    	$tipo = TipoFoto::model()->find(array('condition'=>'nombre ="'.str_replace(' ', '', $fieldname).'"'));
				                    	if($tipo){
					                    	$formfoto->formulario_id = $model->id;
					                    	$formfoto->foto_id = $foto->id;
					                    	$formfoto->item_foto_id = $visita->id;
					                    	$formfoto->tipo_foto_id = $tipo->id;
					                    	if($formfoto->save()){
						                		$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
					                    	}
					                    	else{
					                    		print_r($formfoto->errors);
					                    	}

				                    	}
				                    	else{
				                    	print_r($tipo->errors);
				                    	}
				                    }
				                    else{
				                    	print_r($foto->errors);
				                    }
					        	}
							}
						}
					}
				}
				if($visita->visita_preventiva == 1){
					$imagesAntes = CUploadedFile::getInstancesByName('VPreventivaAntes');
    				if (isset($imagesAntes) && count($imagesAntes) > 0) {
			            // go through each uploaded image
			            foreach ($imagesAntes as $image => $pic) {
			            	if(!is_dir($root.'/uploads/')) {
						   		mkdir($root.'/uploads/');
					   			chmod($root.'/uploads/', 0775);
					   		}
				   			if(!is_dir($root.'/uploads/visitas/')) {
				   				mkdir($root.'/uploads/visitas/');
				   				chmod($root.'/uploads/visitas/', 0775);
				   			}
		   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
				   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
				   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
				   			}


		                    $formfoto = new FormularioFotos;
		                    $foto = new Foto;
		                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
		                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/';
		                    $foto->extension = $pic->extensionName;
		                    if($foto->save()){
		                    	$formfoto->formulario_id = $model->id;
		                    	$formfoto->foto_id = $foto->id;
		                    	$formfoto->item_foto_id = null;
		                    	$formfoto->tipo_foto_id = 10;
		                    	$formfoto->save();
			                	$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
		                    }
		                    else{
	                    		print_r($foto->errors);
		                    }

				        }
				    }
				    $imagesDespues = CUploadedFile::getInstancesByName('VPreventivaDespues');
    				if (isset($imagesDespues) && count($imagesDespues) > 0) {
			            // go through each uploaded image
			            foreach ($imagesDespues as $image => $pic) {
			            	if(!is_dir($root.'/uploads/')) {
						   		mkdir($root.'/uploads/');
					   			chmod($root.'/uploads/', 0775);
					   		}
				   			if(!is_dir($root.'/uploads/visitas/')) {
				   				mkdir($root.'/uploads/visitas/');
				   				chmod($root.'/uploads/visitas/', 0775);
				   			}
		   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
				   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
				   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
				   			}


		                    $formfoto = new FormularioFotos;
		                    $foto = new Foto;
		                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
		                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/';
		                    $foto->extension = $pic->extensionName;
		                    if($foto->save()){
		                    	$formfoto->formulario_id = $model->id;
		                    	$formfoto->foto_id = $foto->id;
		                    	$formfoto->item_foto_id = null;
		                    	$formfoto->tipo_foto_id = 11;
		                    	$formfoto->save();
			                	$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
		                    }
		                    else{
	                    		print_r($foto->errors);
		                    }

				        }
				    }
				}
				Informe::InformePpt($visita->id);
				Informe::InformePdf($visita->id);
				if ($visita->estado == 1) {
					//Enviar email
					if($visita->tipo_visita_id == 3){

						$html = "<h1>Presupuesto Solicitud Traslado ".$visita->punto->direccion."</h1>";
						$html .="<p>Folio: ".$visita->folio."</p>";
						$html .="<p>Fecha Ingreso: ".date('d-m-Y',strtotime($visita->fecha_visita))."</p>";
						$html .= $visita->destino!=null?"<p>Dirección Destino ".$visita->destino->direccion."</p>":"";
						$html .= $visita->destino->comuna!=null?"<p>Comuna Destino ".$visita->destino->comuna->nombre."</p>":"";
						$html .= $visita->destino->comuna!=null&&$visita->destino->comuna->region!=null?"<p>Region Destino ".$visita->destino->comuna->region->nombre."</p>":"";
						$html .= $visita->punto!=null?"<p>Dirección Origen ".$visita->punto->direccion."</p>":"";
						$html .=$visita->punto->comuna!=null?"<p>Comuna Origen: ".$visita->punto->comuna->nombre."</p>":"";
						$html .=($visita->punto->comuna!=null&&$visita->punto->comuna->region!=null)?"<p>Region Origen: ".$visita->punto->comuna->region->nombre."</p>":"";
						$html .=$visita->punto->canal!=null?"<p>Canal: ".$visita->punto->canal->nombre."</p>":"";
						$html .=$visita->punto->distribuidor!=null?"<p>Distribuidor: ".$visita->punto->distribuidor->nombre."</p>":"";
						$html .="<br><p>PARA ACEPTAR EL PRESUPUESTO HAGA CLICK EN EL SIGUIENTE ENLACE:</p><a href='".Yii::app()->createAbsoluteUrl("Visita/AceptarPresupuesto",array("id"=>$visita->id))."'>Aceptar Presupuesto</a>";
						$html .="<br><p>PARA VER MAS DETALLES:</p><a href='".Yii::app()->createAbsoluteUrl("Visita/view",array("id"=>$visita->id))."'>Detalles Visita</a>";

					}
					else{
						$html = "<h1>Presupuesto Solicitud Reparación ".$visita->punto->direccion."</h1>";
						$html .="<p>Folio: ".$visita->folio."</p>";
						$html .="<p>Fecha Ingreso: ".date('d-m-Y',strtotime($visita->fecha_visita))."</p>";
						$html .=$visita->punto->comuna!=null?"<p>Comuna: ".$visita->punto->comuna->nombre."</p>":"";
						$html .=$visita->punto->comuna!=null&&$visita->punto->comuna->region!=null?"<p>Region: ".$visita->punto->comuna->region->nombre."</p>":"";
						$html .=$visita->punto->canal!=null?"<p>Canal: ".$visita->punto->canal->nombre."</p>":"";
						$html .=$visita->punto->distribuidor!=null?"<p>Distribuidor: ".$visita->punto->distribuidor->nombre."</p>":"";
						$html .="<br><p>PARA ACEPTAR EL PRESUPUESTO HAGA CLICK EN EL SIGUIENTE ENLACE:</p><a href='".Yii::app()->createAbsoluteUrl("Visita/AceptarPresupuesto",array("id"=>$visita->id))."'>Aceptar Presupuesto</a>";
						$html .="<br><p>PARA VER MAS DETALLES:</p><a href='".Yii::app()->createAbsoluteUrl("Visita/view",array("id"=>$visita->id))."'>Detalles Visita</a>";
					}

					$recipients = array();
					$query = '(global =1';
					if ($visita->punto->canal_id) {
						$query .= $visita->punto->canal_id.') AND tipo_notificacion = 1';
					}
					else {
						$query .=') AND tipo_notificacion = 1';
					}
					if($visita->tipo_visita_id == 3){
						if ($visita->punto->canal_id!=7) {
							$notificar = NotificarPersona::model()->findAll(array('condition'=>$query));
							foreach ($notificar as $n) {
								$recipients[]= array('email'=>$n->persona->email,'name'=>$n->persona->nombre,'type'=>'to');
							}
						}
						else{
							$notificar = NotificarPersona::model()->findAll(array('condition'=>$query));
							foreach ($notificar as $n) {
								$recipients[]= array('email'=>$n->persona->email,'name'=>$n->persona->nombre,'type'=>'to');
							}
						}
					}
					else{
						$notificar = NotificarPersona::model()->findAll(array('condition'=>$query));
						foreach ($notificar as $n) {
							$recipients[]= array('email'=>$n->persona->email,'name'=>$n->persona->nombre,'type'=>'to');
						}
					}

					$email = Yii::app()->mandrillwrap;
					$email->mandrillKey = 'dLsiSqgctG1atlNvHqVdVg';
					$email->text = "Presupuesto Solicitud Reparación ".$visita->punto->direccion."\nFecha Ingreso: ".date('d-m-Y',strtotime($visita->fecha_visita));
					$email->html = $html;
					$email->subject = "Presupuesto Solicitud Reparación ".$visita->folio;
					$email->fromName = "Cirigliano TradeSensor";
					$email->fromEmail = "noreply@tradesensor.cl";
					$email->to = $recipients;
			        //$content = base64_encode(file_get_contents($root."/uploads/informes/".$visita->punto_id."/".$visita->id.".pdf"));
			        $email->tags = array('presupuesto-MovistarMantencion','produccion');
					//$email->attachments = array(array('type'=>'application/pdf','name'=>'Informe Solicitud '.$visita->punto->direccion.' '.date('d-m-Y',strtotime($visita->fecha_visita)),'content'=>$content));
					$email->images = array();
					$email->sendEmail();
				}
				if($visita->estado == 5){
					//Enviar email
					$html = "<h1>Informe Solicitud ".$visita->punto->direccion."</h1>";
					$html .="<p>Folio: ".$visita->folio."</p>";
					$html .="<p>Fecha Ingreso: ".date('d-m-Y',strtotime($visita->fecha_visita))."</p>";
					$html .=$visita->punto->comuna!=null?"<p>Comuna: ".$visita->punto->comuna->nombre."</p>":"";
					$html .=$visita->punto->comuna!=null&&$visita->punto->comuna->region!=null?"<p>Region: ".$visita->punto->comuna->region->nombre."</p>":"";
					$html .=$visita->punto->canal!=null?"<p>Canal: ".$visita->punto->canal->nombre."</p>":"";
					$html .=$visita->punto->distribuidor!=null?"<p>Distribuidor: ".$visita->punto->distribuidor->nombre."</p>":"";
					$recipients = array();
					if($visita->tipo_visita_id == 3){
						if ($visita->punto->canal_id!=7) {
							$notificar = NotificarPersona::model()->findAll(array('condition'=>'(global =1 OR canal_id ='.$visita->punto->canal_id.') AND tipo_notificacion = 2'));
							foreach ($notificar as $n) {
								$recipients[]= array('email'=>$n->persona->email,'name'=>$n->persona->nombre,'type'=>'to');
							}
						}
						else{
							if ($visita->destino->canal_id!=7) {
								$notificar = NotificarPersona::model()->findAll(array('condition'=>'(global =1 OR canal_id ='.$visita->destino->canal_id.') AND tipo_notificacion = 2'));
								foreach ($notificar as $n) {
									$recipients[]= array('email'=>$n->persona->email,'name'=>$n->persona->nombre,'type'=>'to');
								}
							}
						}
					}
					else{
						$notificar = NotificarPersona::model()->findAll(array('condition'=>'(global =1 OR canal_id ='.$visita->punto->canal_id.') AND tipo_notificacion = 2'));
						foreach ($notificar as $n) {
							$recipients[]= array('email'=>$n->persona->email,'name'=>$n->persona->nombre,'type'=>'to');
						}
					}

					$email = Yii::app()->mandrillwrap;
					$email->mandrillKey = 'dLsiSqgctG1atlNvHqVdVg';
					$email->text = "Informe Solicitud Reparación ".$visita->punto->direccion."\nFecha Ingreso: ".date('d-m-Y',strtotime($visita->fecha_visita));
					$email->html = $html;
					$email->subject = "Informe Solicitud Reparación ".$visita->folio;
					$email->fromName = "Cirigliano TradeSensor";
					$email->fromEmail = "noreply@tradesensor.cl";
					$email->to = $recipients;
			        $content = base64_encode(file_get_contents($root."/uploads/informes/".$visita->punto_id."/".$visita->id.".pdf"));
			        $email->tags = array('informe-MovistarMantencion','produccion');
					$email->attachments = array(array('type'=>'application/pdf','name'=>'Informe Solicitud '.$visita->punto->direccion.' '.date('d-m-Y',strtotime($visita->fecha_visita)),'content'=>$content));
					$email->images = array();
					$email->sendEmail();

					$visita->estado = 4;
					//$visita->id_autoriza = Yii::app()->user->getId();

					$visita->save();
				}
				if(isset(Yii::app()->session['TrasladoIV'])){
					Yii::app()->session['TarifaIV'] = true;
					$this->redirect(array('Visita/CreateTraslado','id'=>Yii::app()->session['TrasladoIV']['destino']));
				}
				$this->redirect(array('Visita/view','id'=>$visita->id));
			}

		}

		$this->render('create',array(
			'model'=>$model,
			'visita'=>$visita,
			'campos'=>$campos,
			'presupuesto'=>$presupuesto,
			'MueblePresupuesto'=>$MueblePresupuesto,
			'TrasladoPresupuesto'=>$TrasladoPresupuesto,
			'Adicional'=>$Adicional,

		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		set_time_limit(0);
		$root = Yii::getPathOfAlias('webroot').'/../files/cirigliano';
		$model=$this->loadModel($id);
		$visita = Visita::model()->findByPK($model->visita_id);
		$fotos = $model->fotos;
		$campos = CampoFormulario::model()->findAll(array('condition'=>'tipo_visita_id ='.$visita->tipo_visita_id));
		$presupuesto =$visita->presupuestos[0];
		$Muebles = $presupuesto->mueblespresupuesto;
		$Adicional = $presupuesto->adicionales;
		$traslados = $presupuesto->trasladopresupuesto;
		$TrasladoPresupuesto = $traslados;
		$MueblePresupuesto = $Muebles;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if (isset($_POST['forDelete'])) {
			foreach ($_POST['forDelete'] as $fotoId) {
				$fotoForDelete = FormularioFotos::model()->findByPk($fotoId);
				if($fotoForDelete){
					unlink($fotoForDelete->foto->path.$fotoForDelete->foto->id.'.'.$fotoForDelete->foto->extension);
					$fotoForDelete->foto->delete();
					$fotoForDelete->delete();
				}
			}
		}
		if (isset($_POST['Formulario'])) {
			$model->attributes=$_POST['Formulario'];
			//$model->created_at = date('c');
			if ($model->save()) {
				foreach ($campos as $campo) {
					$campo->entidad = str_replace('[', '', $campo->entidad);
					$campo->entidad = str_replace(']', '', $campo->entidad);
					if (strpos($campo->entidad,'n:') !== false) {
					    $foo = explode(':', $campo->entidad);
					    foreach ($$foo[1] as $mueble) {
				    		$nombre = $campo->nombre;
					    	if(strpos($nombre,'%n') !== false){
					    		$id = str_replace('%n', '', $nombre);
					    		$fieldname = 'Foto'.str_replace(' ', '', $id).$mueble->id;
					    		if($campo->tipo->nombre == 'FotoMultiple' || $campo->tipo->nombre == 'FotoSimple'){
					    			$images = CUploadedFile::getInstancesByName($fieldname);
				    				if (isset($images) && count($images) > 0) {
							            // go through each uploaded image
							            foreach ($images as $image => $pic) {
							            	if(!is_dir($root.'/uploads/')) {
										   		mkdir($root.'/uploads/');
									   			chmod($root.'/uploads/', 0775);
									   		}
								   			if(!is_dir($root.'/uploads/visitas/')) {
								   				mkdir($root.'/uploads/visitas/');
								   				chmod($root.'/uploads/visitas/', 0775);
								   			}
						   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
								   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
								   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
								   			}
						   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/')) {
								   				mkdir($root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/');
								   				chmod($root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/', 0775);
								   			}

						                    $formfoto = new FormularioFotos;
						                    $foto = new Foto;
						                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
						                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/';
						                    $foto->extension = $pic->extensionName;
						                    if($foto->save()){
						                    	$tipo = TipoFoto::model()->find(array('condition'=>'nombre ="'.str_replace(' ', '', $id).'" AND model ="'.$foo[1].'"'));

						                    	$formfoto->formulario_id = $model->id;
						                    	$formfoto->foto_id = $foto->id;
						                    	$formfoto->item_foto_id = $mueble->id;
						                    	$formfoto->tipo_foto_id = $tipo->id;
						                    	$formfoto->save();
							                	$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
						                    }
						                    else{
					                    		print_r($foto->errors);
						                    }

								        }
								    }
					    		}
					    	}
					    }
					}
					else {
						$fieldname = str_replace(' ', '', $campo->nombre);
						if((strcmp($campo->nombre,'Acta')=== 0 || strcmp($campo->nombre,'General')=== 0 || strcmp($campo->nombre,'Otros')=== 0) && $campo->tipo->nombre == 'FotoMultiple'){
							$images = CUploadedFile::getInstancesByName($fieldname);
							if (isset($images)) {
					            // go through each uploaded image
					            foreach ($images as $image => $pic) {
					            	if(!is_dir($root.'/uploads/')) {
								   		mkdir($root.'/uploads/');
							   			chmod($root.'/uploads/', 0775);
							   		}
						   			if(!is_dir($root.'/uploads/visitas/')) {
						   				mkdir($root.'/uploads/visitas/');
						   				chmod($root.'/uploads/visitas/', 0775);
						   			}
				   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
						   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
						   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
						   			}

				                    $formfoto = new FormularioFotos;
				                    $foto = new Foto;
				                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
				                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/';
				                    $foto->extension = $pic->extensionName;
				                    if($foto->save()){
				                    	$tipo = TipoFoto::model()->find(array('condition'=>'nombre ="'.str_replace(' ', '', $fieldname).'"'));
				                    	if($tipo){
					                    	$formfoto->formulario_id = $model->id;
					                    	$formfoto->foto_id = $foto->id;
					                    	$formfoto->item_foto_id = $visita->id;
					                    	$formfoto->tipo_foto_id = $tipo->id;
					                    	if($formfoto->save()){
						                		$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
					                    	}
					                    	else{
					                    		print_r($formfoto->errors);
					                    	}

				                    	}
				                    	else{
				                    	print_r($tipo->errors);
				                    	}
				                    }
				                    else{
				                    	print_r($foto->errors);
				                    }
					        	}
							}
						}
					}
				}
				if($visita->visita_preventiva == 1){
					$imagesAntes = CUploadedFile::getInstancesByName('VPreventivaAntes');
    				if (isset($imagesAntes) && count($imagesAntes) > 0) {
			            // go through each uploaded image
			            foreach ($imagesAntes as $image => $pic) {
			            	if(!is_dir($root.'/uploads/')) {
						   		mkdir($root.'/uploads/');
					   			chmod($root.'/uploads/', 0775);
					   		}
				   			if(!is_dir($root.'/uploads/visitas/')) {
				   				mkdir($root.'/uploads/visitas/');
				   				chmod($root.'/uploads/visitas/', 0775);
				   			}
		   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
				   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
				   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
				   			}


		                    $formfoto = new FormularioFotos;
		                    $foto = new Foto;
		                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
		                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/';
		                    $foto->extension = $pic->extensionName;
		                    if($foto->save()){
		                    	$formfoto->formulario_id = $model->id;
		                    	$formfoto->foto_id = $foto->id;
		                    	$formfoto->item_foto_id = null;
		                    	$formfoto->tipo_foto_id = 10;
		                    	$formfoto->save();
			                	$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
		                    }
		                    else{
	                    		print_r($foto->errors);
		                    }

				        }
				    }
				    $imagesDespues = CUploadedFile::getInstancesByName('VPreventivaDespues');
    				if (isset($imagesDespues) && count($imagesDespues) > 0) {
			            // go through each uploaded image
			            foreach ($imagesDespues as $image => $pic) {
			            	if(!is_dir($root.'/uploads/')) {
						   		mkdir($root.'/uploads/');
					   			chmod($root.'/uploads/', 0775);
					   		}
				   			if(!is_dir($root.'/uploads/visitas/')) {
				   				mkdir($root.'/uploads/visitas/');
				   				chmod($root.'/uploads/visitas/', 0775);
				   			}
		   					if(!is_dir($root.'/uploads/visitas/'.$visita->id.'/')) {
				   				mkdir($root.'/uploads/visitas/'.$visita->id.'/');
				   				chmod($root.'/uploads/visitas/'.$visita->id.'/', 0775);
				   			}


		                    $formfoto = new FormularioFotos;
		                    $foto = new Foto;
		                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
		                    $foto->path = $root.'/uploads/visitas/'.$visita->id.'/';
		                    $foto->extension = $pic->extensionName;
		                    if($foto->save()){
		                    	$formfoto->formulario_id = $model->id;
		                    	$formfoto->foto_id = $foto->id;
		                    	$formfoto->item_foto_id = null;
		                    	$formfoto->tipo_foto_id = 11;
		                    	$formfoto->save();
			                	$pic->saveAs($foto->path.$foto->id.'.'.$foto->extension);
		                    }
		                    else{
	                    		print_r($foto->errors);
		                    }

				        }
				    }
				}
				Informe::InformePpt($visita->id);
				Informe::InformePdf($visita->id);
				$this->redirect(array('Visita/view','id'=>$visita->id));
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'visita'=>$visita,
			'campos'=>$campos,
			'presupuesto'=>$presupuesto,
			'MueblePresupuesto'=>$MueblePresupuesto,
			'TrasladoPresupuesto'=>$TrasladoPresupuesto,
			'Adicional'=>$Adicional,
			'fotos'=>$fotos,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax'])) {
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			}
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Formulario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Formulario('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Formulario'])) {
			$model->attributes=$_GET['Formulario'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Formulario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Formulario::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Formulario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='formulario-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
