<?php

/**
 * This is the model class for table "mueble_punto".
 *
 * The followings are the available columns in table 'mueble_punto':
 * @property integer $id
 * @property integer $mueble_id
 * @property integer $punto_id
 * @property string $codigo
 *
 * The followings are the available model relations:
 * @property Adicional[] $adicionals
 * @property Mueble $mueble
 * @property Punto $punto
 * @property ServicioMueble[] $servicioMuebles
 */
class MueblePunto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mueble_punto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mueble_id, punto_id, codigo', 'required'),
			array('mueble_id, punto_id', 'numerical', 'integerOnly'=>true),
			array('codigo', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mueble_id, punto_id, codigo', 'safe', 'on'=>'search'),
		);
	}

	public function getDescripcion(){
		return $this->mueble->descripcion.' '.$this->codigo;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'adicionals' => array(self::HAS_MANY, 'Adicional', 'mueble_punto_id'),
			'mueble' => array(self::BELONGS_TO, 'Mueble', 'mueble_id'),
			'punto' => array(self::BELONGS_TO, 'Punto', 'punto_id'),
			'servicioMuebles' => array(self::HAS_MANY, 'ServicioMueble', array('mueble_id'=>'mueble_id')),
		);
	}
	public function getNombreMueble(){
		return isset($this->mueble) ? $this->mueble->descripcion.' '.$this->codigo : null;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mueble_id' => 'Mueble',
			'punto_id' => 'Punto',
			'codigo' => 'Codigo',
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
		$criteria->compare('mueble_id',$this->mueble_id);
		$criteria->compare('punto_id',$this->punto_id);
		$criteria->compare('codigo',$this->codigo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MueblePunto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
