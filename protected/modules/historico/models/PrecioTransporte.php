<?php

/**
 * This is the model class for table "precio_transporte".
 *
 * The followings are the available columns in table 'precio_transporte':
 * @property integer $id
 * @property string $origen
 * @property string $destino
 * @property integer $distancia
 * @property integer $valor1
 * @property integer $valor2
 * @property integer $valor3
 * @property integer $valor4
 * @property boolean $activo
 *
 * The followings are the available model relations:
 * @property RutaTransporte[] $rutaTransportes
 */
class PrecioTransporte extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'precio_transporte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('distancia, valor1, valor2, valor3, valor4', 'numerical', 'integerOnly'=>true),
			array('origen, destino', 'length', 'max'=>255),
			array('activo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, origen, destino, distancia, valor1, valor2, valor3, valor4, activo', 'safe', 'on'=>'search'),
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
			'rutaTransportes' => array(self::HAS_MANY, 'RutaTransporte', 'id_precio_transporte'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'origen' => 'Origen',
			'destino' => 'Destino',
			'distancia' => 'Distancia',
			'valor1' => 'Valor1',
			'valor2' => 'Valor2',
			'valor3' => 'Valor3',
			'valor4' => 'Valor4',
			'activo' => 'Activo',
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
		$criteria->compare('origen',$this->origen,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('distancia',$this->distancia);
		$criteria->compare('valor1',$this->valor1);
		$criteria->compare('valor2',$this->valor2);
		$criteria->compare('valor3',$this->valor3);
		$criteria->compare('valor4',$this->valor4);
		$criteria->compare('activo',$this->activo);

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
	 * @return PrecioTransporte the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
