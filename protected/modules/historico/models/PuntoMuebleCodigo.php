<?php

/**
 * This is the model class for table "punto_mueble_codigo".
 *
 * The followings are the available columns in table 'punto_mueble_codigo':
 * @property integer $id
 * @property integer $id_punto
 * @property integer $id_mueble
 * @property string $codigo
 * @property string $fecha_ingreso
 * @property string $fecha_retiro
 * @property double $latitud
 * @property double $longitud
 *
 * The followings are the available model relations:
 * @property FotoPuntoMuebleCodigo[] $fotoPuntoMuebleCodigos
 * @property Mueble $idMueble
 * @property Punto $idPunto
 */
class PuntoMuebleCodigo extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'punto_mueble_codigo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_punto, id_mueble', 'numerical', 'integerOnly'=>true),
			array('latitud, longitud', 'numerical'),
			array('codigo', 'length', 'max'=>255),
			array('fecha_ingreso, fecha_retiro', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_punto, id_mueble, codigo, fecha_ingreso, fecha_retiro, latitud, longitud', 'safe', 'on'=>'search'),
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
			'fotoPuntoMuebleCodigos' => array(self::HAS_MANY, 'FotoPuntoMuebleCodigo', 'id_punto_mueble_codigo'),
			'idMueble' => array(self::BELONGS_TO, 'Mueble', 'id_mueble'),
			'idPunto' => array(self::BELONGS_TO, 'Punto', 'id_punto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_punto' => 'Id Punto',
			'id_mueble' => 'Id Mueble',
			'codigo' => 'Codigo',
			'fecha_ingreso' => 'Fecha Ingreso',
			'fecha_retiro' => 'Fecha Retiro',
			'latitud' => 'Latitud',
			'longitud' => 'Longitud',
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
		$criteria->compare('id_punto',$this->id_punto);
		$criteria->compare('id_mueble',$this->id_mueble);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('fecha_ingreso',$this->fecha_ingreso,true);
		$criteria->compare('fecha_retiro',$this->fecha_retiro,true);
		$criteria->compare('latitud',$this->latitud);
		$criteria->compare('longitud',$this->longitud);

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
	 * @return PuntoMuebleCodigo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
