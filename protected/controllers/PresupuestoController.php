<?php

class PresupuestoController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
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
		$visita = Visita::model()->findByPk($id);
		$model=new Presupuesto;
		$model->visita_id = $id;
		$model->user_id = yii::App()->user->getId();
		$model->estado = 0;
		$model->fecha_creacion = date('Y-m-d');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$muebles= MueblePunto::model()->findAll(array('condition'=>'t.punto_id=:id','params'=>array(':id'=>$visita->id)));
		if (isset($_POST['Presupuesto']) && isset($_POST['Mueble']) ) {
			$model->attributes=$_POST['Presupuesto'];
			$model->total = 0;
			$model->save();
			$mueblesPunto = $_POST['Mueble'];
			$flag = true;
			foreach ($mueblesPunto as $key => $servicios) {
				foreach ($servicios as $servicio) {
					$mp = new mueblePresupuesto;
					$mp->mueble_punto_id = $key;
					$mp->servicio_mueble_id = $servicio;
					$mp->presupuesto_id = $model->id;
					$s = ServicioMueble::model()->findByPk($servicio);
					$model->total += $s->tarifa;
					$model->save();
					if(!$mp->save())
						$flag = false;
				}
			}

			if ($flag) {
				$visita->estado = 1;
				$visita->save();
				$this->redirect(array('visita/view','id'=>$model->visita_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'muebles'=>$muebles,
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

		if (isset($_POST['Presupuesto'])) {
			$model->attributes=$_POST['Presupuesto'];
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
		$dataProvider=new CActiveDataProvider('Presupuesto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Presupuesto('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Presupuesto'])) {
			$model->attributes=$_GET['Presupuesto'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Presupuesto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Presupuesto::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Presupuesto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='presupuesto-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}