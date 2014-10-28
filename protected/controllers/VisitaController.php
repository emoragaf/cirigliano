<?php

class VisitaController extends Controller
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
				'actions'=>array('index','view','indexTipo','create','update','crear','createTraslado','UpdateMueblesPunto','AddNewPersonaPunto'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','AceptarPresupuesto','RechazarPresupuesto'),
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
		$model = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new Visita;
		$model->punto_id = $id;
		$model->fecha_creacion = date('Y-m-d');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Visita'])) {
			$model->attributes=$_POST['Visita'];
			$model->fecha_visita = date('Y-m-d',strtotime($model->fecha_visita));
			if ($model->save()) {
				$model->folio = 'R'.sprintf('%07d',$model->id);
				$model->save();
				if($model->tipo_visita_id != 3)
					$this->redirect(array('Presupuesto/Create','id'=>$model->id));
				if($model->tipo_visita_id == 3)
					$this->redirect(array('View','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	public function actionUpdateMueblesPunto($id){
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$muebles= MueblePunto::model()->findAll(array('condition'=>'t.punto_id=:id','params'=>array(':id'=>$id)));
        $this->renderPartial('/visita/_formPresupuesto', array('muebles'=>$muebles,'id'=>$id),false,true);

	}
	public function actionUpdateMueblesPuntoTraslado($id){
		Yii::app()->clientScript->scriptMap['jquery.js'] = false;
		$muebles= MueblePunto::model()->findAll(array('condition'=>'t.punto_id=:id','params'=>array(':id'=>$id)));
        $this->renderPartial('/visita/_formPresupuestoTraslado', array('muebles'=>$muebles,'id'=>$id),false,true);

	}
	public function actionAddNewPersonaPunto($id)
	{
        $model=new PersonaPunto('addnew');
        $model->punto_id = $id;
        $persona = new Persona;
        $alert='';
        if(isset($_POST['PersonaPunto']) || isset($_POST['Persona'])){
        	$alert = 'Seleccione o ingrese Solicitante';
        }
        if(isset($_POST['Persona']) &&  ( ($_POST['Persona']['nombre'] == '' && $_POST['Persona']['email'] != '') || ($_POST['Persona']['nombre'] != '' && $_POST['Persona']['email'] == '') ) ){
        	$alert = 'Faltan datos para Nuevo Solicitante';
        	$persona->attributes=$_POST['Persona'];
        }
 		if(isset($_POST['PersonaPunto']) && $_POST['PersonaPunto']['persona_id'] != '')
        {
            $model->attributes=$_POST['PersonaPunto'];
        	$check = PersonaPunto::model()->find(array('condition'=>'persona_id ='.$model->persona_id.' AND punto_id ='.$model->punto_id));
            if(!$check){
	            if($model->save())
	            {
	                if (Yii::app()->request->isAjaxRequest)
	                {
	                	//echo CHtml::tag('li',array(),CHtml::tag('a',array('href'=>'javascript:void(0)',CHtml::tag('label',array('class'=>'checkbox'),CHtml::tag('input',array('type'=>'checkbox', 'value'=>$model->id),CHtml::encode($model->codigo),true),true),true),true),true);
	                    echo CJSON::encode(array(
	                        'status'=>'success', 
	                        'div'=>'<option value="'.$model->id.'">'.$model->persona->nombre.'</option>',
	                        ));
	                    exit;               
	                }
	            }
            }
            else{
				echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>'',
                        ));
            	exit;   
            }
        }
        if(isset($_POST['Persona']) && $_POST['Persona']['nombre'] != '' && $_POST['Persona']['email'] != '')
        {
            $persona->attributes=$_POST['Persona'];
            if($persona->save())
            {
            	$model->persona_id = $persona->id;
            	$model->save();
                if (Yii::app()->request->isAjaxRequest)
                {
                	//echo CHtml::tag('li',array(),CHtml::tag('a',array('href'=>'javascript:void(0)',CHtml::tag('label',array('class'=>'checkbox'),CHtml::tag('input',array('type'=>'checkbox', 'value'=>$model->id),CHtml::encode($model->codigo),true),true),true),true),true);
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        'div'=>'<option value="'.$model->id.'">'.$model->persona->nombre.'</option>',
                        ));
                    exit;               
                }
                else
                    $this->redirect(array('/Punto/view','id'=>$model->punto_id));
            }
        }
        if (Yii::app()->request->isAjaxRequest)
        {
            echo CJSON::encode(array(
                'status'=>'failure', 
                'div'=>$this->renderPartial('/visita/_formNewPersona', array('model'=>$model,'persona'=>$persona,'alert'=>$alert), true)));
            exit;               
        }
        else
            $this->render('create',array('model'=>$model,));
    }

	public function actionCrear($id)
	{
		$model=new Visita;
		$model->punto_id = $id;
		$model->fecha_creacion = date('Y-m-d');
		$muebles= MueblePunto::model()->findAll(array('condition'=>'t.punto_id=:id','params'=>array(':id'=>$id)));

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Visita'])) {
			$model->attributes=$_POST['Visita'];
			$model->fecha_visita = date('Y-m-d',strtotime($model->fecha_visita));

			$p=new Presupuesto;
			
			$p->user_id = yii::App()->user->getId();
			$p->estado = 0;
			$p->fecha_creacion = date('c');

			if ($model->save()) {
				$p->visita_id = $model->id;
				$p->save();

				$model->folio = 'R'.sprintf('%07d',$model->id);
				$model->save();
				if (isset($_POST['selectMueblePunto'])) {
					$ids=$_POST['selectMueblePunto'];
					$p->total = 0;
					$p->save();

					$adicionales = $_POST['Adicional'];
					foreach ($adicionales as $key => $m) {

						foreach ($m as $value) {
							if($value['descripcion'] != '' && $value['tarifa'] != ''){
								$adicional = new Adicional;
								$adicional->presupuesto_id = $p->id;
								$adicional->mueble_punto_id = $key;
								$adicional->descripcion = $value['descripcion'];
								$adicional->tarifa = $value['tarifa'];
								$adicional->save();		
							}
						}
					}

					$mueblesPunto = $_POST['Mueble'];
					$flag = false;
					foreach ($mueblesPunto as $key => $servicios) {
						if(in_array($key, $ids)){
							foreach ($servicios as $servicio => $cant) {
								if($cant > 0){
									$mp = new mueblePresupuesto;
									$mp->mueble_punto_id = $key;
									$mp->servicio_mueble_id = $servicio;
									$mp->presupuesto_id = $p->id;
									$mp->cant_servicio = $cant;
									$s = ServicioMueble::model()->findByPk($servicio);
									if($cant <= $s->cant_b){
										$p->total += $s->tarifa*$cant;
										$mp->tarifa_servicio =$s->tarifa;
									}
									if($cant > $s->cant_b && $cant <= $s->cant_c){
										$p->total += $s->tarifa_b*$cant;
										$mp->tarifa_servicio =$s->tarifa_b;
									}
									if($cant > $s->cant_c){
										$p->total += $s->tarifa_c*$cant;
										$mp->tarifa_servicio =$s->tarifa_c;
									}
									$p->save();
									$model->save();
									if($mp->save())
										$flag = true;
									else{
										$p->delete();
										$flag = false;
										//print_r($mp->getErrors());
									}
								}
							}
						}
					}
					if ($flag) {
						$model->estado = 1;
						$model->save();

						$this->redirect(array('Formulario/Create','id'=>$model->id));
						//$this->redirect(array('visita/view','id'=>$model->visita_id));
					}
				}
				$this->redirect(array('visita/view','id'=>$model->id));
			}		
		}

		$this->render('crear',array(
			'model'=>$model,
			'muebles'=>$muebles,
			'id'=>$id,
		));
	}

	public function actionCreateTraslado($id)
	{
		$model=new Visita('traslado');
		$model->punto_id = $id;
		$model->fecha_creacion = date('Y-m-d');
		$model->tipo_visita_id =3;
		$muebles= MueblePunto::model()->findAll(array('condition'=>'t.punto_id=:id','params'=>array(':id'=>$id)));
		$p=new Presupuesto('traslado');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Visita'])) {
			$p->attributes=$_POST['Presupuesto'];
			$model->attributes=$_POST['Visita'];
			$model->fecha_visita = date('Y-m-d',strtotime($model->fecha_visita));
			//$model->destino_traslado_id = $_POST['destino'];

			
			$p->user_id = yii::App()->user->getId();
			$p->estado = 0;
			$p->fecha_creacion = date('c');

			if ($model->save()) {
				$p->visita_id = $model->id;
				$tarifa = TarifaTraslado::model()->findByPk($p->tarifa_traslado);
				switch ($p->tipo_tarifa_traslado) {
					case '1':
						$p->total = $tarifa->tarifa_a;
						break;
					case '2':
					    $p->total = $tarifa->tarifa_b;
						break;
					case '3':
					    $p->total = $tarifa->tarifa_c;
						break;
					case '4':
					    $p->total = $tarifa->tarifa_d;
						break;
				}
				$p->save();
				$model->folio = 'T'.sprintf('%07d',$model->id);
				$model->save();

				$mueblesPunto = $_POST['Mueble'];
				if($mueblesPunto){
					foreach ($mueblesPunto as $key => $mueble) {
						$mp = MueblePunto::model()->findByPk($key);
						$tarifaInstalacion = TarifaInstalacion::model()->find(array('condition'=>'mueble_id ='.$mp->mueble_id));
						$p->total += $tarifaInstalacion->tarifa_a;
						$p->save();
						$traslado = new TrasladoPresupuesto;
						$traslado->presupuesto_id = $p->id;
						$traslado->mueble_punto = $key;
						$traslado->distancia = $tarifa->distancia;
						$traslado->tarifa_instalacion = $tarifaInstalacion->tarifa_a;
						$traslado->save();
					}
				}
				$model->estado = 1;
				$model->save();

				$this->redirect(array('View','id'=>$model->id));
			}
		}

		$this->render('createTraslado',array(
			'model'=>$model,
			'muebles'=>$muebles,
			'id'=>$id,
			'presupuesto'=>$p,
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

		if (isset($_POST['Visita'])) {
			$model->attributes=$_POST['Visita'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionAceptarPresupuesto($id)
	{
		$model=$this->loadModel($id);

		if($model->estado ==  1 && $model->formulario){
			//Enviar email
			$model->estado = 4;
		}
		else{
			$model->estado = 3;
		}

		if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
		}
	}

	public function actionRechazarPresupuesto($id)
	{
		$model=$this->loadModel($id);
		$model->estado = 2;
		if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
		}
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
		$this->layout='//layouts/column1';
		$model=new Visita('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Visita'])) {
			$model->attributes=$_GET['Visita'];
			$activos->attributes=$_GET['Visita'];
		}
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function actionIndexTipo($id)
	{
		$this->layout='//layouts/column1';
		$model=new Visita('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Visita'])) {
			$model->attributes=$_GET['Visita'];
			if($_GET['Visita']['punto_comuna_id'] == 0)
				$model->punto_comuna_id = null;
			if($_GET['Visita']['punto_distribuidor_id'] == 0)
				$model->punto_distribuidor_id = null;
		}
		$this->render('indexTipo',array(
			'model'=>$model,
			'tipo'=>$id,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Visita('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Visita'])) {
			$model->attributes=$_GET['Visita'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Visita the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Visita::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Visita $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='visita-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}