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
				'actions'=>array('GenerarInformes','Download'),
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
	public function actionDownload($id =null,$tipo = 'pdf')
	{
		if($id){
			$visita = Visita::model()->findByPk($id);
			if($visita){
				$path = Yii::getPathOfAlias('webroot')."/uploads/informes/".$visita->punto_id."/".$visita->id.'.'.$tipo;
				if(file_exists($path))
				  {
				    return Yii::app()->getRequest()->sendFile($visita->punto->direccion.' '.$visita->fecha_visita.'.'.$tipo, @file_get_contents($path));
				  }
				else
                        throw new CHttpException(404, 'No existe el archivo buscado.');
			}
		}
	}
	
	public function actionGenerarInformes($id =null)
	{
		if($id){
			$visita = Visita::model()->findByPk($id);
			if($visita){
				Informe::InformePdf($id);
				Informe::InformePpt($id);
			}
		}
	}
	
}