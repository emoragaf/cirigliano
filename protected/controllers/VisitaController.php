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
				'actions'=>array('index','view','indexTipo','create','update','crear'),
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
			if ($model->save()) {
				$model->folio = 'R'.sprintf('%07d',$model->id);
				$model->save();
				if($model->tipo_visita_id != 3)
					$this->redirect(array('Presupuesto/Create','id'=>$model->id));
				if($model->tipo_visita_id == 3)
					$this->redirect(array('View','id'=>$model->id));
			}
		}

		$this->render('crear',array(
			'model'=>$model,
			'muebles'=>$muebles,
		));
	}

	public function actionCreateTraslado($id)
	{
		$model=new Visita;
		$model->punto_id = $id;
		$model->fecha_creacion = date('Y-m-d');
		$model->tipo_visita_id =3;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Visita'])) {
			$model->attributes=$_POST['Visita'];
			$model->fecha_visita = date('Y-m-d',strtotime($model->fecha_visita));
			if ($model->save()) {
				$model->folio = 'T'.sprintf('%07d',$model->id);
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
		$model->estado = 3;
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
			$activos->attributes=$_GET['Visita'];
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