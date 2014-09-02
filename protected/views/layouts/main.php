<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />-->
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	<!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/stylesheets/skeleton.css" />-->
	
	<?php Yii::app()->bootstrap->register(); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css"/>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>


<div id="wrap">
  <header id="navbar">
	<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	    'brandLabel' => CHtml::encode(Yii::app()->name),
	    'display'=>TbHtml::NAVBAR_DISPLAY_STATICTOP,
	    'collapse' => true, // default is static to top
	    'fluid'=>true,
	    'items' => array(
	        array(
	            'class' => 'bootstrap.widgets.TbNav',
	            'items' => array(
	            	array('label'=>'Visitas', 'url' =>array('/Visita'),'items'=>array(
	                	array('label' => 'Incidencias', 'url' =>array('/Visita/indexTipo/1')),
	                	array('label' => 'Traslados', 'url' =>array('/Visita/indexTipo/3')),
	                	array('label' => 'Excelencia', 'url' =>array('/Visita/indexTipo/4')),
	                	array('label' => 'Meson Terminal', 'url' =>array('/Visita/indexTipo/5')),
	                	array('label' => 'Racks', 'url' =>array('/Visita/indexTipo/6')),
	                	)),
	                array('label' => 'Puntos', 'url' =>array('/Punto/admin')),
	                array('label' => 'Rutas', 'url' =>array('/Ruta')),
	                array('label'=>'Administracion','items'=>array(
	                	array('label' => 'Distribuidores', 'url' =>array('/Distribuidor/admin')),
	                	array('label' => 'Canales', 'url' =>array('/Canal/admin')),
	                	//array('label' => 'Regiones', 'url' =>array('/Region/admin')),
	                	array('label' => 'Comunas', 'url' =>array('/Comuna/admin')),
	                	array('label' => 'Muebles', 'url' =>array('/Mueble/admin')),
	                	array('label' => 'Tarifas Muebles', 'url' =>array('/ServicioMueble/admin')),
	                	)),
	                array('label'=>'Cerrar Sesión ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
	                //array('label' => '', 'url' => '#'),
	                //array('label' => 'Link', 'url' => '#'),
	            ),
	        ),
	    ),
	)); ?>
	</header>

	<div class="container-fluid" id="page">
	
		<div class="row-fluid">
			<?php echo $content; ?>	
		</div>

	</div>
</div>
<footer class="footer" style="text-align: center;">
	Copyright &copy; <?php echo date('Y'); ?> by Exefire.com<br/>
	All Rights Reserved.<br/>
	<?php echo Yii::powered(); ?>
</footer><!-- footer -->		

</body>
</html>
