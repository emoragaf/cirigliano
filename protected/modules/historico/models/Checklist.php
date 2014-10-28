<?php

/**
 * This is the model class for table "checklist".
 *
 * The followings are the available columns in table 'checklist':
 * @property integer $id_visita
 * @property string $rut
 * @property string $nombre
 * @property string $observaciones
 * @property string $fecha_recepcion
 *
 * The followings are the available model relations:
 * @property Visita $idVisita
 */
class Checklist extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'checklist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_visita', 'numerical', 'integerOnly'=>true),
			array('rut, nombre', 'length', 'max'=>255),
			array('observaciones, fecha_recepcion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_visita, rut, nombre, observaciones, fecha_recepcion', 'safe', 'on'=>'search'),
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
			'idVisita' => array(self::BELONGS_TO, 'Visita', 'id_visita'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_visita' => 'Id Visita',
			'rut' => 'Rut',
			'nombre' => 'Nombre',
			'observaciones' => 'Observaciones',
			'fecha_recepcion' => 'Fecha Recepcion',
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

		$criteria->compare('id_visita',$this->id_visita);
		$criteria->compare('rut',$this->rut,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('fecha_recepcion',$this->fecha_recepcion,true);

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
	 * @return Checklist the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
