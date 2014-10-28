<?php

/**
 * This is the model class for table "detalle_ingreso_elemento".
 *
 * The followings are the available columns in table 'detalle_ingreso_elemento':
 * @property integer $id
 * @property integer $id_ingreso_elemento
 * @property integer $id_elemento
 * @property integer $cantidad
 *
 * The followings are the available model relations:
 * @property Elemento $idElemento
 * @property IngresoElemento $idIngresoElemento
 */
class DetalleIngresoElemento extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_ingreso_elemento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ingreso_elemento, id_elemento, cantidad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_ingreso_elemento, id_elemento, cantidad', 'safe', 'on'=>'search'),
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
			'idElemento' => array(self::BELONGS_TO, 'Elemento', 'id_elemento'),
			'idIngresoElemento' => array(self::BELONGS_TO, 'IngresoElemento', 'id_ingreso_elemento'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_ingreso_elemento' => 'Id Ingreso Elemento',
			'id_elemento' => 'Id Elemento',
			'cantidad' => 'Cantidad',
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
		$criteria->compare('id_ingreso_elemento',$this->id_ingreso_elemento);
		$criteria->compare('id_elemento',$this->id_elemento);
		$criteria->compare('cantidad',$this->cantidad);

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
	 * @return DetalleIngresoElemento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
