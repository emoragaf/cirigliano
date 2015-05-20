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
			array('region_id, canal_id, subcanal_id,distribuidor_id, comuna_id', 'numerical', 'integerOnly'=>true),
			array('direccion,codigo, descripcion', 'length', 'max'=>255),
			array('lat, lon', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, direccion, lat, lon, region_id, canal_id, comuna_id, distribuidor_id, destino_traslado_id, codigo, descripcion', 'safe', 'on'=>'search'),
		);
	}
	public function getDireccionDescripcion(){
		if($this->distribuidor)
			return $this->distribuidor->nombre.' '.$this->direccion;
		else
			return $this->direccion;
	}
	public function getDescripcionComuna(){
		$desc = $this->direccion;

		if($this->distribuidor)
			$desc = $this->distribuidor->nombre.' '.$desc;
		if($this->comuna)
			$desc .= ', '.$this->comuna->nombre;
		if($this->region)
			$desc .=$this->region->id==13?', RM':', '.$this->region->nombre;
		
		return $desc;
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
			'subcanal' => array(self::BELONGS_TO, 'Subcanal', 'subcanal_id'),
			'distribuidor' => array(self::BELONGS_TO, 'Distribuidor', 'distribuidor_id'),
			'region' => array(self::BELONGS_TO, 'Region', 'region_id'),
			'comuna' => array(self::BELONGS_TO, 'Comuna', 'comuna_id'),
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
			'direccion' => 'Dirección',
			'lat' => 'Lat',
			'lon' => 'Lon',
			'region_id' => 'Region',
			'comuna_id' => 'Comuna',
			'canal_id' => 'Canal',
			'subcanal_id' => 'Subcanal',
			'distribuidor_id'=>'Distribuidor',
			'codigo' =>'Cód. Franquiciado',
			'descripcion'=>'Descripción',

		);
	}

	public function getDireccion(){
		if ($this->descripcion) {
			return $this->direccion.' '.$this->descripcion;
		}
		else
			return $this->direccion;
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
		$criteria->addCondition('visible = 1');
		$criteria->compare('id',$this->id);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('codigo',$this->codigo,true);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('lon',$this->lon,true);
		$criteria->compare('region_id',$this->region_id);
		$criteria->compare('comuna_id',$this->comuna_id);
		$criteria->compare('canal_id',$this->canal_id);
		$criteria->compare('subcanal_id',$this->subcanal_id);
		$criteria->compare('distribuidor_id',$this->distribuidor_id);

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
