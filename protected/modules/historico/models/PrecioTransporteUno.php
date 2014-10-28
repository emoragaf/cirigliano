<?php

/**
 * This is the model class for table "precio_transporte_uno".
 *
 * The followings are the available columns in table 'precio_transporte_uno':
 * @property integer $id
 * @property integer $id_mueble
 * @property integer $id_canal
 * @property string $origen
 * @property string $destino
 * @property integer $distancia
 * @property integer $valor
 *
 * The followings are the available model relations:
 * @property Canal $idCanal
 * @property Mueble $idMueble
 * @property RutaTransporteUno[] $rutaTransporteUnos
 */
class PrecioTransporteUno extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'precio_transporte_uno';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_mueble, id_canal, distancia, valor', 'numerical', 'integerOnly'=>true),
			array('origen, destino', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_mueble, id_canal, origen, destino, distancia, valor', 'safe', 'on'=>'search'),
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
			'idCanal' => array(self::BELONGS_TO, 'Canal', 'id_canal'),
			'idMueble' => array(self::BELONGS_TO, 'Mueble', 'id_mueble'),
			'rutaTransporteUnos' => array(self::HAS_MANY, 'RutaTransporteUno', 'id_precio_transporte_uno'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_mueble' => 'Id Mueble',
			'id_canal' => 'Id Canal',
			'origen' => 'Origen',
			'destino' => 'Destino',
			'distancia' => 'Distancia',
			'valor' => 'Valor',
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
		$criteria->compare('id_mueble',$this->id_mueble);
		$criteria->compare('id_canal',$this->id_canal);
		$criteria->compare('origen',$this->origen,true);
		$criteria->compare('destino',$this->destino,true);
		$criteria->compare('distancia',$this->distancia);
		$criteria->compare('valor',$this->valor);

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
	 * @return PrecioTransporteUno the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
