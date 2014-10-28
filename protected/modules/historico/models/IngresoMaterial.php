<?php

/**
 * This is the model class for table "ingreso_material".
 *
 * The followings are the available columns in table 'ingreso_material':
 * @property integer $id
 * @property integer $id_campana
 * @property integer $numero_guia
 * @property string $fecha
 * @property string $observaciones
 * @property integer $id_proveedor
 *
 * The followings are the available model relations:
 * @property DetalleIngresoMaterial[] $detalleIngresoMaterials
 * @property Proveedor $idProveedor
 * @property Campana $idCampana
 */
class IngresoMaterial extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ingreso_material';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_campana, numero_guia, id_proveedor', 'numerical', 'integerOnly'=>true),
			array('fecha, observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_campana, numero_guia, fecha, observaciones, id_proveedor', 'safe', 'on'=>'search'),
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
			'detalleIngresoMaterials' => array(self::HAS_MANY, 'DetalleIngresoMaterial', 'id_ingreso_material'),
			'idProveedor' => array(self::BELONGS_TO, 'Proveedor', 'id_proveedor'),
			'idCampana' => array(self::BELONGS_TO, 'Campana', 'id_campana'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_campana' => 'Id Campana',
			'numero_guia' => 'Numero Guia',
			'fecha' => 'Fecha',
			'observaciones' => 'Observaciones',
			'id_proveedor' => 'Id Proveedor',
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
		$criteria->compare('id_campana',$this->id_campana);
		$criteria->compare('numero_guia',$this->numero_guia);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('id_proveedor',$this->id_proveedor);

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
	 * @return IngresoMaterial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
