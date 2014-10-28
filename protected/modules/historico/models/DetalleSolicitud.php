<?php

/**
 * This is the model class for table "detalle_solicitud".
 *
 * The followings are the available columns in table 'detalle_solicitud':
 * @property integer $id
 * @property integer $id_solicitud
 * @property integer $ancho
 * @property integer $alto
 * @property string $observaciones
 * @property string $orientacion
 *
 * The followings are the available model relations:
 * @property Solicitud $idSolicitud
 */
class DetalleSolicitud extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_solicitud';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_solicitud, ancho, alto', 'numerical', 'integerOnly'=>true),
			array('orientacion', 'length', 'max'=>1),
			array('observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_solicitud, ancho, alto, observaciones, orientacion', 'safe', 'on'=>'search'),
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
			'idSolicitud' => array(self::BELONGS_TO, 'Solicitud', 'id_solicitud'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_solicitud' => 'Id Solicitud',
			'ancho' => 'Ancho',
			'alto' => 'Alto',
			'observaciones' => 'Observaciones',
			'orientacion' => 'Orientacion',
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
		$criteria->compare('id_solicitud',$this->id_solicitud);
		$criteria->compare('ancho',$this->ancho);
		$criteria->compare('alto',$this->alto);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('orientacion',$this->orientacion,true);

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
	 * @return DetalleSolicitud the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
