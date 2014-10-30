<?php

/**
 * This is the model class for table "notificar_persona".
 *
 * The followings are the available columns in table 'notificar_persona':
 * @property integer $id
 * @property integer $punto_id
 * @property integer $persona_punto_id
 *
 * The followings are the available model relations:
 * @property Punto $punto
 * @property PersonaPunto $personaPunto
 */
class NotificarPersona extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'notificar_persona';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('punto_id, persona_id', 'required'),
			array('id, punto_id, persona_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, punto_id, persona_id', 'safe', 'on'=>'search'),
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
			'punto' => array(self::BELONGS_TO, 'Punto', 'punto_id'),
			'persona' => array(self::BELONGS_TO, 'Persona', 'persona_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'punto_id' => 'Punto',
			'persona_punto_id' => 'Persona Punto',
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
		$criteria->compare('punto_id',$this->punto_id);
		$criteria->compare('persona_punto_id',$this->persona_punto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NotificarPersona the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
