<?php

/**
 * This is the model class for table "foto_reparacion_normal".
 *
 * The followings are the available columns in table 'foto_reparacion_normal':
 * @property integer $id
 * @property integer $id_presupuesto_reparacion_normal
 * @property integer $id_tipo_foto_reparacion
 * @property string $tipo
 * @property string $foto
 * @property string $observaciones
 * @property integer $orden
 * @property string $thumbnail
 *
 * The followings are the available model relations:
 * @property PresupuestoReparacionNormal $idPresupuestoReparacionNormal
 * @property TipoFotoReparacion $idTipoFotoReparacion
 */
class FotoReparacionNormal extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'foto_reparacion_normal';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_presupuesto_reparacion_normal, id_tipo_foto_reparacion, orden', 'numerical', 'integerOnly'=>true),
			array('tipo', 'length', 'max'=>255),
			array('foto, observaciones, thumbnail', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_presupuesto_reparacion_normal, id_tipo_foto_reparacion, tipo, foto, observaciones, orden, thumbnail', 'safe', 'on'=>'search'),
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
			'idPresupuestoReparacionNormal' => array(self::BELONGS_TO, 'PresupuestoReparacionNormal', 'id_presupuesto_reparacion_normal'),
			'idTipoFotoReparacion' => array(self::BELONGS_TO, 'TipoFotoReparacion', 'id_tipo_foto_reparacion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_presupuesto_reparacion_normal' => 'Id Presupuesto Reparacion Normal',
			'id_tipo_foto_reparacion' => 'Id Tipo Foto Reparacion',
			'tipo' => 'Tipo',
			'foto' => 'Foto',
			'observaciones' => 'Observaciones',
			'orden' => 'Orden',
			'thumbnail' => 'Thumbnail',
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
		$criteria->compare('id_presupuesto_reparacion_normal',$this->id_presupuesto_reparacion_normal);
		$criteria->compare('id_tipo_foto_reparacion',$this->id_tipo_foto_reparacion);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('thumbnail',$this->thumbnail,true);

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
	 * @return FotoReparacionNormal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
