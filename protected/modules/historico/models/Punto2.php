<?php

/**
 * This is the model class for table "punto2".
 *
 * The followings are the available columns in table 'punto2':
 * @property integer $id
 * @property integer $id_comuna
 * @property string $direccion
 * @property string $descripcion
 * @property string $codigo
 * @property double $latitud
 * @property double $longitud
 * @property integer $id_distribuidor
 * @property integer $id_canal
 * @property integer $id_subcanal
 * @property boolean $activo
 * @property integer $id_cerrado_por
 * @property string $fecha_cierre
 * @property integer $mts_mueble
 * @property integer $mts_grafica
 *
 * The followings are the available model relations:
 * @property Comuna $idComuna
 * @property Canal $idCanal
 * @property Distribuidor $idDistribuidor
 * @property Subcanal $idSubcanal
 * @property PuntoMueble2[] $puntoMueble2s
 */
class Punto2 extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'punto2';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_comuna, id_distribuidor, id_canal, id_subcanal, id_cerrado_por, mts_mueble, mts_grafica', 'numerical', 'integerOnly'=>true),
			array('latitud, longitud', 'numerical'),
			array('direccion, descripcion', 'length', 'max'=>255),
			array('codigo', 'length', 'max'=>10),
			array('activo, fecha_cierre', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_comuna, direccion, descripcion, codigo, latitud, longitud, id_distribuidor, id_canal, id_subcanal, activo, id_cerrado_por, fecha_cierre, mts_mueble, mts_grafica', 'safe', 'on'=>'search'),
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
			'idComuna' => array(self::BELONGS_TO, 'Comuna', 'id_comuna'),
			'idCanal' => array(self::BELONGS_TO, 'Canal', 'id_canal'),
			'idDistribuidor' => array(self::BELONGS_TO, 'Distribuidor', 'id_distribuidor'),
			'idSubcanal' => array(self::BELONGS_TO, 'Subcanal', 'id_subcanal'),
			'puntoMueble2s' => array(self::HAS_MANY, 'PuntoMueble2', 'id_punto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_comuna' => 'Id Comuna',
			'direccion' => 'Direccion',
			'descripcion' => 'Descripcion',
			'codigo' => 'Codigo',
			'latitud' => 'Latitud',
			'longitud' => 'Longitud',
			'id_distribuidor' => 'Id Distribuidor',
			'id_canal' => 'Id Canal',
			'id_subcanal' => 'Id Subcanal',
			'activo' => 'Activo',
			'id_cerrado_por' => 'Id Cerrado Por',
			'fecha_cierre' => 'Fecha Cierre',
			'mts_mueble' => 'Mts Mueble',
			'mts_grafica' => 'Mts Grafica',
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
		$criteria->compare('id_comuna',$this->id_comuna);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('latitud',$this->latitud);
		$criteria->compare('longitud',$this->longitud);
		$criteria->compare('id_distribuidor',$this->id_distribuidor);
		$criteria->compare('id_canal',$this->id_canal);
		$criteria->compare('id_subcanal',$this->id_subcanal);
		$criteria->compare('activo',$this->activo);
		$criteria->compare('id_cerrado_por',$this->id_cerrado_por);
		$criteria->compare('fecha_cierre',$this->fecha_cierre,true);
		$criteria->compare('mts_mueble',$this->mts_mueble);
		$criteria->compare('mts_grafica',$this->mts_grafica);

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
	 * @return Punto2 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
