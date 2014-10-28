<?php

/**
 * This is the model class for table "tarifa_traslado".
 *
 * The followings are the available columns in table 'tarifa_traslado':
 * @property integer $id
 * @property integer $tarifa_a
 * @property integer $tarifa_b
 * @property integer $tarifa_c
 * @property string $desde
 * @property string $hasta
 * @property integer $distancia
 */
class TarifaTraslado extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tarifa_traslado';
	}

	public function getDescripcion()
	{
		$desc = $this->desde.' - '.$this->hasta.' Distancia: '.$this->distancia;
		return $desc;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, tarifa_a, tarifa_b, tarifa_c, desde, hasta, distancia', 'required'),
			array('id, tarifa_a, tarifa_b, tarifa_c, distancia', 'numerical', 'integerOnly'=>true),
			array('desde, hasta', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tarifa_a, tarifa_b, tarifa_c, desde, hasta, distancia', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tarifa_a' => 'Tarifa A',
			'tarifa_b' => 'Tarifa B',
			'tarifa_c' => 'Tarifa C',
			'desde' => 'Desde',
			'hasta' => 'Hasta',
			'distancia' => 'Distancia',
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
		$criteria->compare('tarifa_a',$this->tarifa_a);
		$criteria->compare('tarifa_b',$this->tarifa_b);
		$criteria->compare('tarifa_c',$this->tarifa_c);
		$criteria->compare('desde',$this->desde,true);
		$criteria->compare('hasta',$this->hasta,true);
		$criteria->compare('distancia',$this->distancia);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TarifaTraslado the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
