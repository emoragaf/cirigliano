<?php

/**
 * This is the model class for table "formulario_fotos".
 *
 * The followings are the available columns in table 'formulario_fotos':
 * @property integer $id
 * @property integer $formulario_id
 * @property integer $item_foto_id
 * @property integer $foto_id
 * @property integer $tipo_foto
 */
class FormularioFotos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'formulario_fotos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('formulario_id, foto_id, tipo_foto_id', 'required'),
			array('formulario_id, item_foto_id, foto_id, tipo_foto', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, formulario_id, item_foto_id, foto_id, tipo_foto_id', 'safe', 'on'=>'search'),
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
			'foto' => array(self::HAS_ONE, 'Foto', 'foto_id'),
			'formulario' => array(self::BELONGS_TO, 'Formuario', 'formulario_id'),
			'tipo' => array(self::BELONGS_TO, 'TipoFoto', 'tipo_foto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'formulario_id' => 'Formulario',
			'item_foto_id' => 'Item Foto',
			'foto_id' => 'Foto',
			'tipo_foto' => 'Tipo Foto',
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
		$criteria->compare('formulario_id',$this->formulario_id);
		$criteria->compare('item_foto_id',$this->item_foto_id);
		$criteria->compare('foto_id',$this->foto_id);
		$criteria->compare('tipo_foto',$this->tipo_foto);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FormularioFotos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
