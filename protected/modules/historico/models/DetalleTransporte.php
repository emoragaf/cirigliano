<?php

/**
 * This is the model class for table "detalle_transporte".
 *
 * The followings are the available columns in table 'detalle_transporte':
 * @property integer $id
 * @property integer $id_transporte
 * @property integer $id_mueble
 * @property integer $cantidad
 * @property string $observaciones
 * @property integer $id_punto_destino
 *
 * The followings are the available model relations:
 * @property Transporte $idTransporte
 * @property Mueble $idMueble
 * @property Punto $idPuntoDestino
 * @property PresupuestoTransporte[] $presupuestoTransportes
 * @property RutaTransporte[] $rutaTransportes
 * @property RutaTransporteDos[] $rutaTransporteDoses
 * @property RutaInstalacion[] $rutaInstalacions
 * @property RutaTransporteUno[] $rutaTransporteUnos
 */
class DetalleTransporte extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalle_transporte';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_transporte, id_mueble, cantidad, id_punto_destino', 'numerical', 'integerOnly'=>true),
			array('observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_transporte, id_mueble, cantidad, observaciones, id_punto_destino', 'safe', 'on'=>'search'),
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
			'idTransporte' => array(self::BELONGS_TO, 'Transporte', 'id_transporte'),
			'idMueble' => array(self::BELONGS_TO, 'Mueble', 'id_mueble'),
			'idPuntoDestino' => array(self::BELONGS_TO, 'Punto', 'id_punto_destino'),
			'presupuestoTransportes' => array(self::HAS_MANY, 'PresupuestoTransporte', 'id_detalle_transporte'),
			'rutaTransportes' => array(self::HAS_MANY, 'RutaTransporte', 'id_detalle_transporte'),
			'rutaTransporteDoses' => array(self::HAS_MANY, 'RutaTransporteDos', 'id_detalle_transporte'),
			'rutaInstalacions' => array(self::HAS_MANY, 'RutaInstalacion', 'id_detalle_transporte'),
			'rutaTransporteUnos' => array(self::HAS_MANY, 'RutaTransporteUno', 'id_detalle_transporte'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_transporte' => 'Id Transporte',
			'id_mueble' => 'Id Mueble',
			'cantidad' => 'Cantidad',
			'observaciones' => 'Observaciones',
			'id_punto_destino' => 'Id Punto Destino',
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
		$criteria->compare('id_transporte',$this->id_transporte);
		$criteria->compare('id_mueble',$this->id_mueble);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('id_punto_destino',$this->id_punto_destino);

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
	 * @return DetalleTransporte the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
