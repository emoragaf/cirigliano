<?php

/**
 * This is the model class for table "tarifa_traslado_mueble".
 *
 * The followings are the available columns in table 'tarifa_traslado_mueble':
 * @property integer $id
 * @property integer $id_mueble
 * @property double $distancia_hasta
 * @property double $distancia_desde
 * @property integer $tarifa
 * @property integer $tarifa_b
 * @property integer $tarifa_c
 * @property integer $cant_b
 * @property integer $cant_c
 */
class TarifaTrasladoMueble extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tarifa_traslado_mueble';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_mueble, distancia_hasta, distancia_desde, tarifa, tarifa_b, tarifa_c, cant_b, cant_c', 'required'),
			array('id_mueble, tarifa, tarifa_b, tarifa_c, cant_b, cant_c', 'numerical', 'integerOnly'=>true),
			array('distancia_hasta, distancia_desde', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_mueble, distancia_hasta, distancia_desde, tarifa, tarifa_b, tarifa_c, cant_b, cant_c', 'safe', 'on'=>'search'),
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
			'id_mueble' => 'Id Mueble',
			'distancia_hasta' => 'Distancia Hasta',
			'distancia_desde' => 'Distancia Desde',
			'tarifa' => 'Tarifa',
			'tarifa_b' => 'Tarifa B',
			'tarifa_c' => 'Tarifa C',
			'cant_b' => 'Cant B',
			'cant_c' => 'Cant C',
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
		$criteria->compare('id_mueble',$this->id_mueble);
		$criteria->compare('distancia_hasta',$this->distancia_hasta);
		$criteria->compare('distancia_desde',$this->distancia_desde);
		$criteria->compare('tarifa',$this->tarifa);
		$criteria->compare('tarifa_b',$this->tarifa_b);
		$criteria->compare('tarifa_c',$this->tarifa_c);
		$criteria->compare('cant_b',$this->cant_b);
		$criteria->compare('cant_c',$this->cant_c);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TarifaTrasladoMueble the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
