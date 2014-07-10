<?php

/**
 * This is the model class for table "adicional".
 *
 * The followings are the available columns in table 'adicional':
 * @property integer $id
 * @property integer $mueble_presupuesto_id
 * @property string $tarifa
 * @property string $descripcion
 * @property integer $mueble_punto_id
 * @property integer $estado
 * @property string $fecha_termino
 * @property integer $foto_id
 */
class Adicional extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, mueble_presupuesto_id, mueble_punto_id, foto_id', 'required'),
			array('id, mueble_presupuesto_id, mueble_punto_id, estado, foto_id', 'numerical', 'integerOnly'=>true),
			array('tarifa, descripcion', 'length', 'max'=>45),
			array('fecha_termino', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mueble_presupuesto_id, tarifa, descripcion, mueble_punto_id, estado, fecha_termino, foto_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'mueble_presupuesto_id' => 'Mueble Presupuesto',
			'tarifa' => 'Tarifa',
			'descripcion' => 'Descripcion',
			'mueble_punto_id' => 'Mueble Punto',
			'estado' => 'Estado',
			'fecha_termino' => 'Fecha Termino',
			'foto_id' => 'Foto',
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
		$criteria->compare('mueble_presupuesto_id',$this->mueble_presupuesto_id);
		$criteria->compare('tarifa',$this->tarifa,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('mueble_punto_id',$this->mueble_punto_id);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha_termino',$this->fecha_termino,true);
		$criteria->compare('foto_id',$this->foto_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Adicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
