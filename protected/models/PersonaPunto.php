<?php

/**
 * This is the model class for table "persona_punto".
 *
 * The followings are the available columns in table 'persona_punto':
 * @property integer $id
 * @property integer $persona_id
 * @property integer $punto_id
 *
 * The followings are the available model relations:
 * @property NotificarPersona[] $notificarPersonas
 * @property Persona $persona
 * @property Punto $punto
 * @property Visita[] $visitas
 */
class PersonaPunto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'persona_punto';
	}

	/** 
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('punto_id', 'required','on'=>'addnew'),
			array('persona_id, punto_id', 'required','on'=>'default'),
			array('id, persona_id, punto_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, persona_id, punto_id', 'safe', 'on'=>'search'),
		);
	}
	public function getNombre(){
		return isset($this->persona) ? $this->persona->nombre : null;
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'notificarPersonas' => array(self::HAS_MANY, 'NotificarPersona', 'persona_punto_id'),
			'persona' => array(self::BELONGS_TO, 'Persona', 'persona_id'),
			'punto' => array(self::BELONGS_TO, 'Punto', 'punto_id'),
			'visitas' => array(self::HAS_MANY, 'Visita', 'persona_punto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'persona_id' => 'Persona',
			'punto_id' => 'Punto',
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
		$criteria->compare('persona_id',$this->persona_id);
		$criteria->compare('punto_id',$this->punto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PersonaPunto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
