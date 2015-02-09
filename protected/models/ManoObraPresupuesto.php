<?php

/**
 * This is the model class for table "mano_obra_presupuesto".
 *
 * The followings are the available columns in table 'mano_obra_presupuesto':
 * @property integer $id
 * @property integer $presupuesto_id
 * @property integer $tarifa_mano_obra_id
 */
class ManoObraPresupuesto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mano_obra_presupuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('presupuesto_id, tarifa_mano_obra_id', 'required'),
			array('presupuesto_id, tarifa_mano_obra_id, mueble_punto_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, presupuesto_id, tarifa_mano_obra_id', 'safe', 'on'=>'search'),
		);
	}
	public function getDescripcion(){
		if($this->mueblepunto)
			return 'Mano de Obra '.$this->mueblepunto->Descripcion;
	}
	public function getTarifa(){
		if($this->tarifa)
			return $this->tarifa->tarifa;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'mueblepunto'=>array(self::BELONGS_TO,'MueblePunto','mueble_punto_id'),
			'tarifa'=>array(self::BELONGS_TO,'TarifaManoObra','tarifa_mano_obra_id'),
			'presupuesto'=>array(self::BELONGS_TO,'Presupuesto','presupuesto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'presupuesto_id' => 'Presupuesto',
			'tarifa_mano_obra_id' => 'Tarifa Mano Obra',
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
		$criteria->compare('presupuesto_id',$this->presupuesto_id);
		$criteria->compare('tarifa_mano_obra_id',$this->tarifa_mano_obra_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ManoObraPresupuesto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
