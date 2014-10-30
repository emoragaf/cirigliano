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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

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
							            	if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/')) {
										   		mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
									   			chmod(Yii::getPathOfAlias('webroot').'/uploads/', 0775); 
									   		}
								   			if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/visitas/')) {
								   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/visitas/');
								   				chmod(Yii::getPathOfAlias('webroot').'/uploads/visitas/', 0775);
								   			}
						   					if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/')) {
								   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/');
								   				chmod(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/', 0775);
								   			} 
						   					if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/')) {
								   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/');
								   				chmod(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/', 0775); 
								   			}  
												   
						                    $formfoto = new FormularioFotos;
						                    $foto = new Foto;
						                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
						                    $foto->path = Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/'.$mueble->id.'/';
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
					            	if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/')) {
								   		mkdir(Yii::getPathOfAlias('webroot').'/uploads/');
							   			chmod(Yii::getPathOfAlias('webroot').'/uploads/', 0775); 
							   		}
						   			if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/visitas/')) {
						   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/visitas/');
						   				chmod(Yii::getPathOfAlias('webroot').'/uploads/visitas/', 0775);
						   			}	
				   					if(!is_dir(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/')) {
						   				mkdir(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/');
						   				chmod(Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/', 0775);
						   			} 	
									   
				                    $formfoto = new FormularioFotos;
				                    $foto = new Foto;
				                    $foto->nombre = $pic->name; //it might be $img_add->name for you, filename is just what I chose to call it in my model
				                    $foto->path = Yii::getPathOfAlias('webroot').'/uploads/visitas/'.$visita->id.'/';
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
				Informe::InformePpt($visita->id);
				Informe::InformePdf($visita->id);
				if($visita->estado == 3){
					//Enviar email
					//Enviar email
					$email = Yii::app()->mandrillwrap;
					$email->mandrillKey = 'dLsiSqgctG1atlNvHqVdVg';
					$email->text = "Informe Solicitud Reparación ".$visita->punto->direccion."\nFecha Ingreso: ".date('d-m-Y',strtotime($visita->fecha_visita));
					$email->html = "<h1>Informe Solicitud Reparación ".$visita->punto->direccion."</h1><p>Fecha Ingreso: ".date('d-m-Y',strtotime($visita->fecha_visita))."</p>";
					$email->subject = "Informe Solicitud Reparación";
					$email->fromName = "emoraga";
					$email->fromEmail = "emoraga@hbl.cl";
					$email->to = array(
			            array(
			                'email' => 'o0eversor0o@gmail.com',
			                'name' => 'Eduardo Moraga',
			                'type' => 'to'
			            ),
			            array(
			                'email' => 'e.moraga@yahoo.com',
			                'name' => 'Eduardo Moraga',
			                'type' => 'to'
			            ),
			            array(
			                'email' => 'e.moraga@live.cl',
			                'name' => 'Eduardo Moraga',
			                'type' => 'to'
			            ),
			        );
			        $content = base64_encode(file_get_contents(Yii::getPathOfAlias('webroot')."/uploads/informes/".$visita->punto_id."/".$visita->id.".pdf"));
			        $email->tags = array('informe-MovistarMantencion','prueba');
					$email->attachments = array(array('type'=>'application/pdf','name'=>'Informe Solicitud '.$visita->punto->direccion.' '.date('d-m-Y',strtotime($visita->fecha_visita)),'content'=>$content));
					$email->images = array();
					$email->sendEmail();
					//$visita->estado = 4;
					
					$visita->save();
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Formulario'])) {
			$model->attributes=$_POST['Formulario'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
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