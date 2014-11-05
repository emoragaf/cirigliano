<?php

class PuntoController extends Controller
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
				'actions'=>array('index','view','create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','PoblarPersonaPunto'),
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
		$muebles=new CActiveDataProvider('MueblePunto', array(
		            'criteria'=>array(
		                'condition'=>'t.punto_id=:id',
		                'params'=>array(':id'=>$id),
		            ),
		));
		$visitas=new Visita('search');
		$visitas->unsetAttributes();  // clear any default values
		if (isset($_GET['Visita'])) {
			$visitas->attributes=$_GET['Visita'];
		}
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'muebles'=>$muebles,
			'visitas'=>$visitas,
		));
	}

	public function actionPoblarPersonaPunto()
	{
		$puntos = Punto::model()->findAll();

		foreach ($puntos as $key => $value) {
			$pp = new PersonaPunto;
			$pp->punto_id = $value->id;
			$pp->persona_id = 1;
			$pp->save();
		}
		echo 'Completado';
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Punto;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Punto'])) {
			$model->attributes=$_POST['Punto'];
			if ($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
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

		if (isset($_POST['Punto'])) {
			$model->attributes=$_POST['Punto'];
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Punto('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Punto'])) {
			$model->attributes=$_GET['Punto'];
			if($_GET['Punto']['comuna_id'] == 0)
				$model->comuna_id = null;
			if($_GET['Punto']['distribuidor_id'] == 0)
				$model->distribuidor_id = null;
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionIndex()
	{
		$model=new Punto('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Punto'])) {
			$model->attributes=$_GET['Punto'];
			if($_GET['Punto']['comuna_id'] == 0)
				$model->comuna_id = null;
			if($_GET['Punto']['distribuidor_id'] == 0)
				$model->distribuidor_id = null;
		}

		$this->render('adminNewVisita',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Punto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Punto::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Punto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='punto-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}