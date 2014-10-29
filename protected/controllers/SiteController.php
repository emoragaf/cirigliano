<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	//public $layout='//layouts/column2';
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('login','error'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array(),
				'users'=>array('admin','TestMail'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	public function actionTestMail(){
		$email = Yii::app()->mandrillwrap;
		$email->mandrillKey = 'dLsiSqgctG1atlNvHqVdVg';
		$email->text = "Prueba 2 mandrillwrap";
		$email->html = "<h1>Prueba 4 mandrillwrap</h1><p>Este es un párrafo</p>";
		$email->subject = "Prueba con registros dns";
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
                'type' => 'cc'
            ),
            array(
                'email' => 'e.moraga@live.cl',
                'name' => 'Eduardo Moraga',
                'type' => 'cc'
            ),
        );
        $email->tags = array('test','prueba');
		$email->attachments = array();
		$email->images = array();
		echo $email->sendEmail();

		//$this->redirect(Yii::app()->homeUrl);


	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$model = new Visita;
		$organizaciones = array(
				array('label' => '<table class="tabla"><tr><td>Punto 1</td><td>Canal 1</td><td>Calle 112, Comuna Ciudad</td><td><i class="icon-chevron-right"></td></tr></table>', 'url' => '#'),
				array('label' => '<table class="tabla"><tr><td>Punto 2</td><td>Canal 2</td><td>Calle 7134, Comuna Ciudad</td><td><i class="icon-chevron-right"></td></tr></table>', 'url' => '#'),
				array('label' => '<table class="tabla"><tr><td>Punto 3</td><td>Canal 3</td><td>Calle 43452, Comuna Ciudad</td><td><i class="icon-chevron-right"></td></tr></table>', 'url' => '#'),
				array('label' => '<table class="tabla"><tr><td>Punto 4</td><td>Canal 1</td><td>Calle 13123, Comuna Ciudad</td><td><i class="icon-chevron-right"></td></tr></table>', 'url' => '#'),
				array('label' => '<table class="tabla"><tr><td>Punto 5</td><td>Canal 1</td><td>Calle 98, Comuna Ciudad</td><td><i class="icon-chevron-right"></td></tr></table>', 'url' => '#'),
			);
		$this->render('index',array('model'=>$model,'organizaciones'=>$organizaciones));
	}

	public function actionGStore()
	{
		
		$this->render('gstore');
	}

	public function actionUpload()
	{
		
		echo 'uploaded';
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}