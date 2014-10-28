<?php

/**
 * This is the model class for table "ruta_instalacion".
 *
 * The followings are the available columns in table 'ruta_instalacion':
 * @property integer $id
 * @property integer $id_detalle_transporte
 * @property integer $id_precio_instalacion
 * @property string $tipo
 *
 * The followings are the available model relations:
 * @property DetalleTransporte $idDetalleTransporte
 * @property PrecioInstalacion $idPrecioInstalacion
 */
class RutaInstalacion extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ruta_instalacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_detalle_transporte, id_precio_instalacion', 'numerical', 'integerOnly'=>true),
			array('tipo', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_detalle_transporte, id_precio_instalacion, tipo', 'safe', 'on'=>'search'),
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
			'idDetalleTransporte' => array(self::BELONGS_TO, 'DetalleTransporte', 'id_detalle_transporte'),
			'idPrecioInstalacion' => array(self::BELONGS_TO, 'PrecioInstalacion', 'id_precio_instalacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_detalle_transporte' => 'Id Detalle Transporte',
			'id_precio_instalacion' => 'Id Precio Instalacion',
			'tipo' => 'Tipo',
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
		$criteria->compare('id_detalle_transporte',$this->id_detalle_transporte);
		$criteria->compare('id_precio_instalacion',$this->id_precio_instalacion);
		$criteria->compare('tipo',$this->tipo,true);

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
	 * @return RutaInstalacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
