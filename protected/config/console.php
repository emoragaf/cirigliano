<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Vitalis',
    'timeZone' => 'America/Santiago',
    'language'=>'es', // Este es el lenguaje en el que querés que muestre las cosas
    'sourceLanguage'=>'en', 
    // preloading 'log' component
    'preload'=>array(
        'log',
        'bootstrap'
    ),
    'aliases' => array(
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change this if necessary
    ),
    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.user.models.*',
        'application.modules.user.components.*',
        'application.extensions.phpass.*',
        'bootstrap.helpers.TbHtml',
        'bootstrap.helpers.TbArray',
        'bootstrap.behaviors.TbWidget',
    ),

    'modules'=>array(
        'auth'=>array(
          'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
          'userClass' => 'User', // the name of the user model class.
          'userIdColumn' => 'id', // the name of the user id column.
          'userNameColumn' => 'username', // the name of the user name column.
          'defaultLayout' => 'application.views.layouts.main', // the layout used by the module.
          'viewDir' => null, // the path to view files to use with this module.
        ),
        'user'=>array(
            # encrypting method (php hash function)
            'hash' => 'md5',
 
            # send activation email
            'sendActivationMail' => false,
 
            # allow access for non-activated users
            'loginNotActiv' => false,
 
            # activate user on registration (only sendActivationMail = false)
            'activeAfterRegister' => true,
 
            # automatically login from registration
            'autoLogin' => true,
 
            # registration path
            'registrationUrl' => array('/user/registration'),
 
            # recovery password path
            'recoveryUrl' => array('/user/recovery'),
 
            # login form path
            'loginUrl' => array('/user/login'),
 
            # page after login
            'returnUrl' => array('/user/profile'),
 
            # page after logout
            'returnLogoutUrl' => array('/user/login'),
        ),
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
            'generatorPaths'=>array(
            'bootstrap.gii',
            ),
        ),

    ),

    // application components
    'components'=>array(
        'authManager' => array(
            'class' => 'auth.components.CachedDbAuthManager',
            'cachingDuration' => 3600,
            'behaviors' => array(
                'auth' => array(
                    'class' => 'auth.components.AuthBehavior',
                ),
            ),
        ),
        'hasher'=>array (
            'class'=>'Phpass',
            'hashPortable'=>false,
            'hashCostLog2'=>10,
        ),
        'user'=>array(
            'class' => 'auth.components.AuthWebUser',
            'loginUrl' => array('/user/login'),
            'admins' => array('admin'), // users with full access
            'allowAutoLogin'=>true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',   
        ),
        'bitly' => array(
            'class' => 'application.extensions.bitly.VGBitly',
            'login' => 'o_41ov1usisp', // login name
            'apiKey' => 'R_d1d9a49e9a814f598426f686959e57b2', // apikey 
            'format' => 'json', // default format of the response this can be either xml, json (some callbacks support txt as well)
        ),
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=vitalis',
            'emulatePrepare' => true,
            'username' => 'vitalis',
            'password' => 'vitalisdev',
            'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
        ),
        'errorHandler'=>array(
            // use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params'=>array(
        'companyName' => 'Exefire',
        'adminEmail'=>'webmaster@exefire.com',
    ),
);