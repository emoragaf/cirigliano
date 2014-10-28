<?php

class MueblePuntoController extends Controller
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
				'actions'=>array('index','view','create','update','AddNew'),
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
		$model = $this->loadModel($id);
		$servicios=new CActiveDataProvider('ServicioMueble', array(
		            'criteria'=>array(
		                'condition'=>'t.mueble_id=:id',
		                'params'=>array(':id'=>$model->mueble_id),
		            ),
		));
		$this->render('view',array(
			'model'=>$model,
			'servicios'=>$servicios,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new MueblePunto;
		$model->punto_id = $id;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['MueblePunto'])) {
			$model->attributes=$_POST['MueblePunto'];
			//$mueble = Mueble::model()->findByPk($model->mueble_id);
        	$model->codigo = uniqid($model->mueble_id);
			if ($model->save()) {
				$this->redirect(array('/Punto/view','id'=>$model->punto_id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionAddNew($id)
	{
        $model=new MueblePunto;
        $model->punto_id = $id;
 
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
 
        if(isset($_POST['MueblePunto']))
        {
            $model->attributes=$_POST['MueblePunto'];
        	$model->codigo = uniqid($model->mueble_id);
            if($model->save())
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                	//echo CHtml::tag('li',array(),CHtml::tag('a',array('href'=>'javascript:void(0)',CHtml::tag('label',array('class'=>'checkbox'),CHtml::tag('input',array('type'=>'checkbox', 'value'=>$model->id),CHtml::encode($model->codigo),true),true),true),true),true);
                    echo CJSON::encode(array(
                        'status'=>'success', 
                        //'div'=>'<li class="active"><a href ="javascript:void(0)"><label class="checkbox"><input type="checkbox" value='.$model->id.'>'.CHtml::encode($model->Descripcion).'</input></label></a></li>'
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
                'div'=>$this->renderPartial('/mueblePunto/_form', array('model'=>$model), true)));
            exit;               
        }
        else
            $this->render('create',array('model'=>$model,));
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

		if (isset($_POST['MueblePunto'])) {
			$model->attributes=$_POST['MueblePunto'];
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
		$dataProvider=new CActiveDataProvider('MueblePunto');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MueblePunto('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['MueblePunto'])) {
			$model->attributes=$_GET['MueblePunto'];
		}

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MueblePunto the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MueblePunto::model()->findByPk($id);
		if ($model===null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MueblePunto $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax']==='mueble-punto-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}