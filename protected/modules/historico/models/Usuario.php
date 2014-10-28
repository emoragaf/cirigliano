<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property integer $id_perfil
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $usuario
 * @property string $contrasena
 * @property string $email
 * @property string $celular
 *
 * The followings are the available model relations:
 * @property EnvioEmail[] $envioEmails
 * @property Supervisor[] $supervisors
 * @property Supervisor[] $supervisors1
 * @property Perfil $idPerfil
 * @property UsuarioPunto[] $usuarioPuntos
 * @property Solicitante[] $solicitantes
 * @property Solicitud[] $solicituds
 * @property Transporte[] $transportes
 * @property Alarma[] $alarmas
 * @property Acceso[] $accesos
 * @property Reparacion[] $reparacions
 */
class Usuario extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_perfil', 'numerical', 'integerOnly'=>true),
			array('nombre, apellido_paterno, apellido_materno, usuario, email', 'length', 'max'=>255),
			array('contrasena', 'length', 'max'=>32),
			array('celular', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_perfil, nombre, apellido_paterno, apellido_materno, usuario, contrasena, email, celular', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'envioEmails' => array(self::HAS_MANY, 'EnvioEmail', 'id_usuario'),
			'supervisors' => array(self::HAS_MANY, 'Supervisor', 'id_merchand'),
			'supervisors1' => array(self::HAS_MANY, 'Supervisor', 'id_supervisor'),
			'idPerfil' => array(self::BELONGS_TO, 'Perfil', 'id_perfil'),
			'usuarioPuntos' => array(self::HAS_MANY, 'UsuarioPunto', 'id_usuario'),
			'solicitantes' => array(self::HAS_MANY, 'Solicitante', 'id_usuario'),
			'solicituds' => array(self::HAS_MANY, 'Solicitud', 'id_usuario'),
			'transportes' => array(self::HAS_MANY, 'Transporte', 'id_usuario'),
			'alarmas' => array(self::HAS_MANY, 'Alarma', 'id_usuario'),
			'accesos' => array(self::HAS_MANY, 'Acceso', 'id_usuario'),
			'reparacions' => array(self::HAS_MANY, 'Reparacion', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_perfil' => 'Id Perfil',
			'nombre' => 'Nombre',
			'apellido_paterno' => 'Apellido Paterno',
			'apellido_materno' => 'Apellido Materno',
			'usuario' => 'Usuario',
			'contrasena' => 'Contrasena',
			'email' => 'Email',
			'celular' => 'Celular',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_perfil',$this->id_perfil);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('apellido_paterno',$this->apellido_paterno,true);
		$criteria->compare('apellido_materno',$this->apellido_materno,true);
		$criteria->compare('usuario',$this->usuario,true);
		$criteria->compare('contrasena',$this->contrasena,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('celular',$this->celular,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your MyActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
