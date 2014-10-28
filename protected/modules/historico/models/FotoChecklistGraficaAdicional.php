<?php

/**
 * This is the model class for table "foto_checklist_grafica_adicional".
 *
 * The followings are the available columns in table 'foto_checklist_grafica_adicional':
 * @property integer $id
 * @property integer $id_visita
 * @property integer $id_materialidad
 * @property string $soporte
 * @property integer $alto
 * @property integer $ancho
 * @property string $tipo
 * @property string $foto
 *
 * The followings are the available model relations:
 * @property Materialidad $idMaterialidad
 * @property Visita $idVisita
 */
class FotoChecklistGraficaAdicional extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'foto_checklist_grafica_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_visita, id_materialidad, alto, ancho', 'numerical', 'integerOnly'=>true),
			array('soporte, tipo', 'length', 'max'=>255),
			array('foto', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_visita, id_materialidad, soporte, alto, ancho, tipo, foto', 'safe', 'on'=>'search'),
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
			'idMaterialidad' => array(self::BELONGS_TO, 'Materialidad', 'id_materialidad'),
			'idVisita' => array(self::BELONGS_TO, 'Visita', 'id_visita'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_visita' => 'Id Visita',
			'id_materialidad' => 'Id Materialidad',
			'soporte' => 'Soporte',
			'alto' => 'Alto',
			'ancho' => 'Ancho',
			'tipo' => 'Tipo',
			'foto' => 'Foto',
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
		$criteria->compare('id_visita',$this->id_visita);
		$criteria->compare('id_materialidad',$this->id_materialidad);
		$criteria->compare('soporte',$this->soporte,true);
		$criteria->compare('alto',$this->alto);
		$criteria->compare('ancho',$this->ancho);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('foto',$this->foto,true);

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
	 * @return FotoChecklistGraficaAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
