<?php

/**
 * This is the model class for table "elemento_log".
 *
 * The followings are the available columns in table 'elemento_log':
 * @property integer $id
 * @property integer $elemento_mueble_id
 * @property string $fecha
 * @property integer $destino_id
 * @property integer $tipo_accion
 * @property integer $user_id
 */
class ElementoLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'elemento_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('elemento_mueble_id, fecha, destino_id, tipo_accion, user_id', 'required'),
			array('elemento_mueble_id, destino_id, tipo_accion, user_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, elemento_mueble_id, fecha, destino_id, tipo_accion, user_id', 'safe', 'on'=>'search'),
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
			'elemento_mueble_id' => 'Elemento Mueble',
			'fecha' => 'Fecha',
			'destino_id' => 'Destino',
			'tipo_accion' => 'Tipo Accion',
			'user_id' => 'User',
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
		$criteria->compare('elemento_mueble_id',$this->elemento_mueble_id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('destino_id',$this->destino_id);
		$criteria->compare('tipo_accion',$this->tipo_accion);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ElementoLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
