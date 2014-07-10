<?php

/**
 * This is the model class for table "punto".
 *
 * The followings are the available columns in table 'punto':
 * @property integer $id
 * @property string $direccion
 * @property string $lat
 * @property string $lon
 * @property integer $region_id
 * @property integer $canal_id
 *
 * The followings are the available model relations:
 * @property MueblePunto[] $mueblePuntos
 * @property NotificarPersona[] $notificarPersonas
 * @property PersonaPunto[] $personaPuntos
 * @property Canal $canal
 * @property Region $region
 * @property Visita[] $visitas
 */
class Punto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'punto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('region_id, canal_id', 'numerical', 'integerOnly'=>true),
			array('direccion', 'length', 'max'=>45),
			array('lat, lon', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, direccion, lat, lon, region_id, canal_id', 'safe', 'on'=>'search'),
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
			'mueblePuntos' => array(self::HAS_MANY, 'MueblePunto', 'punto_id'),
			'notificarPersonas' => array(self::HAS_MANY, 'NotificarPersona', 'punto_id'),
			'personaPuntos' => array(self::HAS_MANY, 'PersonaPunto', 'punto_id'),
			'canal' => array(self::BELONGS_TO, 'Canal', 'canal_id'),
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
			'visitas' => array(self::HAS_MANY, 'Visita', 'punto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'direccion' => 'Direccion',
			'lat' => 'Lat',
			'lon' => 'Lon',
			'region_id' => 'Region',
			'canal_id' => 'Canal',
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
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('lon',$this->lon,true);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('canal_id',$this->canal_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Punto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
