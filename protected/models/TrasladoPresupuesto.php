<?php

/**
 * This is the model class for table "traslado_presupuesto".
 *
 * The followings are the available columns in table 'traslado_presupuesto':
 * @property integer $id
 * @property integer $presupuesto_id
 * @property integer $mueble_punto
 * @property integer $distancia
 */
class TrasladoPresupuesto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'traslado_presupuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('presupuesto_id, mueble_punto, distancia', 'required'),
			array('presupuesto_id, mueble_punto, distancia', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, presupuesto_id, mueble_punto, distancia', 'safe', 'on'=>'search'),
		);
	}
	public function getTarifa(){
		return $this->tarifa_instalacion;
	}
	public function getcant_servicio(){
		return 1;
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'mueblePunto'=>array(self::BELONGS_TO,'MueblePunto','mueble_punto'),
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
			'mueble_punto' => 'Mueble Punto',
			'distancia' => 'Distancia',
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
		$criteria->compare('mueble_punto',$this->mueble_punto);
		$criteria->compare('distancia',$this->distancia);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TrasladoPresupuesto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
