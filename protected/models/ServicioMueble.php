<?php

/**
 * This is the model class for table "servicio_mueble".
 *
 * The followings are the available columns in table 'servicio_mueble':
 * @property integer $id
 * @property string $tarifa
 * @property string $descripcion
 * @property integer $mueble_punto_id
 *
 * The followings are the available model relations:
 * @property Accion[] $accions
 * @property MueblePunto $mueblePunto
 */
class ServicioMueble extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'servicio_mueble';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, tarifa, tarifa_b, tarifa_c, cant_b, cant_c,mueble_id', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tarifa, descripcion, mueble_id', 'safe', 'on'=>'search'),
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
			'accions' => array(self::HAS_MANY, 'Accion', 'servicio_mueble_id'),
			'mueble' => array(self::BELONGS_TO, 'Mueble', 'mueble_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tarifa' => 'Tarifa 1',
			'descripcion' => 'Descripcion',
			'mueble_id' => 'Mueble',
			'tarifa_b'=> 'Tarifa 2',
			'tarifa_c'=> 'Tarifa 3',
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
		$criteria->compare('tarifa',$this->tarifa,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('mueble_id',$this->mueble_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServicioMueble the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
