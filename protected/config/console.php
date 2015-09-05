<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Cirigliano',
    'timeZone' => 'America/Santiago',

    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
        'application.vendors.*',

    ),
    // application components
    'components'=>array(
        'db'=>array(
    			'connectionString' => 'mysql:host=localhost;dbname=cirigliano;unix_socket=/Applications/MAMP/tmp/mysql/mysql.sock',
    			'emulatePrepare' => true,
    			'username' => 'cirigliano',
    			'password' => 'ciriglianodev',
    			'charset' => 'utf8',
    			'tablePrefix' => 'tbl_',
    		),
        'mandrillwrap' => array(
    	         'class' => 'ext.mandrillwrap.mandrillwrap',
    	         //'options' => array(/.. additional curl options ../)
    	    ),
    ),
);
