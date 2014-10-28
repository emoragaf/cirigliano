<?php

/**
 * This is the model class for table "presupuesto_reparacion_adicional".
 *
 * The followings are the available columns in table 'presupuesto_reparacion_adicional':
 * @property integer $id
 * @property integer $id_detalle_reparacion
 * @property string $elemento
 * @property integer $cantidad
 * @property integer $material
 * @property integer $mano_de_obra
 * @property integer $transporte
 *
 * The followings are the available model relations:
 * @property FotoReparacionAdicional[] $fotoReparacionAdicionals
 * @property DetalleReparacion $idDetalleReparacion
 */
class PresupuestoReparacionAdicional extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'presupuesto_reparacion_adicional';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_detalle_reparacion, cantidad, material, mano_de_obra, transporte', 'numerical', 'integerOnly'=>true),
			array('elemento', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_detalle_reparacion, elemento, cantidad, material, mano_de_obra, transporte', 'safe', 'on'=>'search'),
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
			'fotoReparacionAdicionals' => array(self::HAS_MANY, 'FotoReparacionAdicional', 'id_presupuesto_reparacion_adicional','with'=>array('idTipoFotoReparacion'=>array('alias'=>'tipofoto')),'order'=>'tipofoto.orden ASC'),
			'idDetalleReparacion' => array(self::BELONGS_TO, 'DetalleReparacion', 'id_detalle_reparacion'),
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
			'elemento' => 'Elemento',
			'cantidad' => 'Cantidad',
			'material' => 'Material',
			'mano_de_obra' => 'Mano De Obra',
			'transporte' => 'Transporte',
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
		$criteria->compare('elemento',$this->elemento,true);
		$criteria->compare('cantidad',$this->cantidad);
		$criteria->compare('material',$this->material);
		$criteria->compare('mano_de_obra',$this->mano_de_obra);
		$criteria->compare('transporte',$this->transporte);

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
	 * @return PresupuestoReparacionAdicional the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
