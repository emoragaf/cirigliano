<?php

/**
 * This is the model class for table "presupuesto_reparacion_normal".
 *
 * The followings are the available columns in table 'presupuesto_reparacion_normal':
 * @property integer $id
 * @property integer $id_detalle_reparacion
 * @property integer $id_precio_reparacion
 * @property integer $cantidad
 *
 * The followings are the available model relations:
 * @property FotoReparacionNormal[] $fotoReparacionNormals
 * @property DetalleReparacion $idDetalleReparacion
 * @property PrecioReparacion $idPrecioReparacion
 */
class PresupuestoReparacionNormal extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'presupuesto_reparacion_normal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_detalle_reparacion, id_precio_reparacion, cantidad', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_detalle_reparacion, id_precio_reparacion, cantidad', 'safe', 'on'=>'search'),
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
			'fotoReparacionNormals' => array(self::HAS_MANY, 'FotoReparacionNormal', 'id_presupuesto_reparacion_normal','with'=>array('idTipoFotoReparacion'=>array('alias'=>'tipofoto')),'order'=>'tipofoto.orden ASC'),
			'idDetalleReparacion' => array(self::BELONGS_TO, 'DetalleReparacion', 'id_detalle_reparacion'),
			'idPrecioReparacion' => array(self::BELONGS_TO, 'PrecioReparacion', 'id_precio_reparacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_detalle_reparacion' => 'Id Detalle Reparacion',
			'id_precio_reparacion' => 'Id Precio Reparacion',
			'cantidad' => 'Cantidad',
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
		$criteria->compare('id_detalle_reparacion',$this->id_detalle_reparacion);
		$criteria->compare('id_precio_reparacion',$this->id_precio_reparacion);
		$criteria->compare('cantidad',$this->cantidad);

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
	 * @return PresupuestoReparacionNormal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
