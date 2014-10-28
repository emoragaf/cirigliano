<?php

class FacturacionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update'),
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
	public function actionCreate()
	{
		$model=new Canal;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['Canal'])) {
			$model->attributes=$_POST['Canal'];
			if ($model->save()) {
				$this->redirect(array('admin'));
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

		if (isset($_POST['Canal'])) {
			$model->attributes=$_POST['Canal'];
			if ($model->save()) {
				$this->redirect(array('admin'));
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
		$option = 1;
		if(date('d')>=25){
			$mes = date('m-Y',strtotime('+1 month'));
		}
		else
			$mes = date('m-Y');
		$criteria = new CDbCriteria();
		$criteriaExcelencia = new CDbCriteria();
		if(isset($_POST['adicional']) && $_POST['adicional']['descripcion'] != '' && $_POST['adicional']['monto'] != ''){
			$a = new AdicionalFacturacion;
			$a->periodo = $_POST['adicional']['periodo'];
			$a->descripcion = $_POST['adicional']['descripcion'];
			$a->monto = $_POST['adicional']['monto'];
			$a->save();
			$option = 3;
		}

		if(isset($_POST['filtros']) && $_POST['filtros']['mes'] != ''){
			$mes = $_POST['filtros']['mes'];
		}
		$adicionales = AdicionalFacturacion::model()->findAll(array('condition'=>'periodo ="'.$mes.'"'));
		$adicionalesDataProvider = new CActiveDataProvider('AdicionalFacturacion',array('criteria'=>array(
			'condition'=>'periodo ="'.$mes.'"',
			)));
		$foo = explode('-', $mes);
		$bar = array('-');
		if($foo[0] > 1){
			$bar[0] = $foo[0]-1;
			$bar[1] = $foo[1];
		}
		if($foo[0] == 1){
			$bar[0] = $foo[0]-1;
			$bar[1] = $foo[1]-1;
		}

		$desde = $bar[1].'-'.str_pad($bar[0],2,0,STR_PAD_LEFT).'-25';
		$hasta = $foo[1].'-'.str_pad($foo[0],2,0,STR_PAD_LEFT).'-25';
		
		$criteria->addCondition('visita.tipo_visita_id != 4');
		$criteriaExcelencia->addCondition('visita.tipo_visita_id = 4');

		$criteria->addBetweenCondition('visita.fecha_visita',$desde,$hasta);
		$criteriaExcelencia->addBetweenCondition('visita.fecha_visita',$desde,$hasta);


		$presupuestos = Presupuesto::model()->with('visita')->findAll($criteria);
		$presupuestosExcelencia = Presupuesto::model()->with('visita')->findAll($criteriaExcelencia);
		
		$this->render('index',array(
			'presupuestos'=>$presupuestos,
			'presupuestosExcelencia'=>$presupuestosExcelencia,
			'mes'=>$mes,
			'adicionales'=>$adicionales,
			'adicionalesDataProvider'=>$adicionalesDataProvider,
			'option'=>$option,
			'desde'=>$desde,
			'hasta'=>$hasta,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Canal('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['Canal'])) {
			$model->attributes=$_GET['Canal'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Canal the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Canal::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Canal $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='canal-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}