<?php

/**
 * This is the model class for table "campo_formulario".
 *
 * The followings are the available columns in table 'campo_formulario':
 * @property integer $id
 * @property string $nombre
 * @property integer $tipo_visita_id
 * @property string $tipo_campo
 */
class CampoFormulario extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'campo_formulario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, tipo_visita_id', 'required'),
			array('tipo_visita_id, tipo_campo_id', 'numerical', 'integerOnly'=>true),
			array('nombre, entidad', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, tipo_visita_id, tipo_campo_id', 'safe', 'on'=>'search'),
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
			'formulario' => array(self::BELONGS_TO, 'Formuario', 'formulario_id'),
			'tipo' => array(self::BELONGS_TO, 'TipoCampo', 'tipo_campo_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
			'tipo_visita_id' => 'Tipo Visita',
			'tipo_campo' => 'Tipo Campo',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('tipo_visita_id',$this->tipo_visita_id);
		$criteria->compare('tipo_campo_id',$this->tipo_campo_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CampoFormulario the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
