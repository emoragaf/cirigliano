<?php

/**
 * This is the model class for table "detalle_reparacion".
 *
 * The followings are the available columns in table 'detalle_reparacion':
 * @property integer $id
 * @property integer $id_reparacion
 * @property integer $id_mueble
 * @property boolean $editable
 *
 * The followings are the available model relations:
 * @property Reparacion $idReparacion
 * @property Mueble $idMueble
 * @property PresupuestoReparacionNormal[] $presupuestoReparacionNormals
 * @property PresupuestoReparacionAdicional[] $presupuestoReparacionAdicionals
 */
class DetalleReparacion extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_reparacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_reparacion, id_mueble', 'numerical', 'integerOnly'=>true),
			array('editable', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_reparacion, id_mueble, editable', 'safe', 'on'=>'search'),
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
			'idReparacion' => array(self::BELONGS_TO, 'Reparacion', 'id_reparacion'),
			'idMueble' => array(self::BELONGS_TO, 'Mueble', 'id_mueble'),
			'presupuestoReparacionNormals' => array(self::HAS_MANY, 'PresupuestoReparacionNormal', 'id_detalle_reparacion'),
			'presupuestoReparacionAdicionals' => array(self::HAS_MANY, 'PresupuestoReparacionAdicional', 'id_detalle_reparacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_reparacion' => 'Id Reparacion',
			'id_mueble' => 'Id Mueble',
			'editable' => 'Editable',
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
		$criteria->compare('id_reparacion',$this->id_reparacion);
		$criteria->compare('id_mueble',$this->id_mueble);
		$criteria->compare('editable',$this->editable);

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
	 * @return DetalleReparacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
