<?php

class DefaultController extends Controller
{
	public function filters() {
     return array( 
        //it's important to add site/error, so an unpermitted user will get the error.
        array('auth.filters.AuthFilter'),
            );
        }
	public function actionIndex()
	{
		$this->render('index');
	}
	public function actionPunto()
	{
		$this->render('indexPunto');
	}
	public function actionexcel()
	{
		$this->render('excel');
	}
	public function actionexcel2()
	{
		$this->render('excel12');
	}
}