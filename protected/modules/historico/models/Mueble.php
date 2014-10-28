<?php

/**
 * This is the model class for table "mueble".
 *
 * The followings are the available columns in table 'mueble':
 * @property integer $id
 * @property string $descripcion
 * @property integer $mt_lineal
 *
 * The followings are the available model relations:
 * @property DetalleTransporte[] $detalleTransportes
 * @property Visita[] $visitas
 * @property DetalleReparacion[] $detalleReparacions
 * @property FotoSolicitudReparacion[] $fotoSolicitudReparacions
 * @property MuebleComponente[] $muebleComponentes
 * @property PrecioInstalacion[] $precioInstalacions
 * @property PrecioReparacion[] $precioReparacions
 * @property PrecioTransporteUno[] $precioTransporteUnos
 * @property PresupuestoTransporte[] $presupuestoTransportes
 * @property PuntoMueble[] $puntoMuebles
 * @property PuntoMuebleCodigo[] $puntoMuebleCodigos
 */
class Mueble extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'mueble';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mt_lineal', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descripcion, mt_lineal', 'safe', 'on'=>'search'),
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
			'detalleTransportes' => array(self::HAS_MANY, 'DetalleTransporte', 'id_mueble'),
			'visitas' => array(self::MANY_MANY, 'Visita', 'checklist_mueble(id_mueble, id_visita)'),
			'detalleReparacions' => array(self::HAS_MANY, 'DetalleReparacion', 'id_mueble'),
			'fotoSolicitudReparacions' => array(self::HAS_MANY, 'FotoSolicitudReparacion', 'id_mueble'),
			'muebleComponentes' => array(self::HAS_MANY, 'MuebleComponente', 'id_mueble'),
			'precioInstalacions' => array(self::HAS_MANY, 'PrecioInstalacion', 'id_mueble'),
			'precioReparacions' => array(self::HAS_MANY, 'PrecioReparacion', 'id_mueble'),
			'precioTransporteUnos' => array(self::HAS_MANY, 'PrecioTransporteUno', 'id_mueble'),
			'presupuestoTransportes' => array(self::HAS_MANY, 'PresupuestoTransporte', 'id_mueble'),
			'puntoMuebles' => array(self::HAS_MANY, 'PuntoMueble', 'id_mueble'),
			'puntoMuebleCodigos' => array(self::HAS_MANY, 'PuntoMuebleCodigo', 'id_mueble'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descripcion' => 'Descripcion',
			'mt_lineal' => 'Mt Lineal',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('mt_lineal',$this->mt_lineal);

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
	 * @return Mueble the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
