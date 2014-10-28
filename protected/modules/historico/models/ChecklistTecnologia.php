<?php

/**
 * This is the model class for table "checklist_tecnologia".
 *
 * The followings are the available columns in table 'checklist_tecnologia':
 * @property integer $id_visita
 * @property integer $id_tecnologia
 * @property integer $buenos
 * @property integer $malos
 *
 * The followings are the available model relations:
 * @property FotoChecklistTecnologia[] $fotoChecklistTecnologias
 * @property FotoChecklistTecnologia[] $fotoChecklistTecnologias1
 */
class ChecklistTecnologia extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'checklist_tecnologia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_visita, id_tecnologia, buenos, malos', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_visita, id_tecnologia, buenos, malos', 'safe', 'on'=>'search'),
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
			'fotoChecklistTecnologias' => array(self::HAS_MANY, 'FotoChecklistTecnologia', 'id_visita'),
			'fotoChecklistTecnologias1' => array(self::HAS_MANY, 'FotoChecklistTecnologia', 'id_tecnologia'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_visita' => 'Id Visita',
			'id_tecnologia' => 'Id Tecnologia',
			'buenos' => 'Buenos',
			'malos' => 'Malos',
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

		$criteria->compare('id_visita',$this->id_visita);
		$criteria->compare('id_tecnologia',$this->id_tecnologia);
		$criteria->compare('buenos',$this->buenos);
		$criteria->compare('malos',$this->malos);

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
	 * @return ChecklistTecnologia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
