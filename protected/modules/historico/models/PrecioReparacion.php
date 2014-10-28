<?php

/**
 * This is the model class for table "precio_reparacion".
 *
 * The followings are the available columns in table 'precio_reparacion':
 * @property integer $id
 * @property integer $id_mueble
 * @property string $descripcion
 * @property integer $material
 * @property integer $transporte
 * @property integer $orden
 * @property boolean $activo
 * @property integer $mano_de_obra_rango_1
 * @property integer $mano_de_obra_rango_2
 * @property integer $mano_de_obra_rango_3
 * @property integer $grupo
 * @property string $caracteristica
 * @property string $unidad_de_medida
 *
 * The followings are the available model relations:
 * @property PresupuestoReparacionNormal[] $presupuestoReparacionNormals
 * @property Mueble $idMueble
 */
class PrecioReparacion extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'precio_reparacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_mueble, material, transporte, orden, mano_de_obra_rango_1, mano_de_obra_rango_2, mano_de_obra_rango_3, grupo', 'numerical', 'integerOnly'=>true),
			array('descripcion, caracteristica, unidad_de_medida', 'length', 'max'=>255),
			array('activo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_mueble, descripcion, material, transporte, orden, activo, mano_de_obra_rango_1, mano_de_obra_rango_2, mano_de_obra_rango_3, grupo, caracteristica, unidad_de_medida', 'safe', 'on'=>'search'),
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
			'presupuestoReparacionNormals' => array(self::HAS_MANY, 'PresupuestoReparacionNormal', 'id_precio_reparacion'),
			'idMueble' => array(self::BELONGS_TO, 'Mueble', 'id_mueble'),
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
			'descripcion' => 'Descripcion',
			'material' => 'Material',
			'transporte' => 'Transporte',
			'orden' => 'Orden',
			'activo' => 'Activo',
			'mano_de_obra_rango_1' => 'Mano De Obra Rango 1',
			'mano_de_obra_rango_2' => 'Mano De Obra Rango 2',
			'mano_de_obra_rango_3' => 'Mano De Obra Rango 3',
			'grupo' => 'Grupo',
			'caracteristica' => 'Caracteristica',
			'unidad_de_medida' => 'Unidad De Medida',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('material',$this->material);
		$criteria->compare('transporte',$this->transporte);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('activo',$this->activo);
		$criteria->compare('mano_de_obra_rango_1',$this->mano_de_obra_rango_1);
		$criteria->compare('mano_de_obra_rango_2',$this->mano_de_obra_rango_2);
		$criteria->compare('mano_de_obra_rango_3',$this->mano_de_obra_rango_3);
		$criteria->compare('grupo',$this->grupo);
		$criteria->compare('caracteristica',$this->caracteristica,true);
		$criteria->compare('unidad_de_medida',$this->unidad_de_medida,true);

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
	 * @return PrecioReparacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
