<?php

/**
 * This is the model class for table "foto_visita".
 *
 * The followings are the available columns in table 'foto_visita':
 * @property integer $id
 * @property integer $id_visita
 * @property integer $id_tipo_foto_visita
 * @property string $tipo
 * @property string $foto
 * @property string $observaciones
 * @property integer $orden
 * @property integer $id_elemento
 * @property integer $id_material
 *
 * The followings are the available model relations:
 * @property Elemento $idElemento
 * @property Material $idMaterial
 * @property Visita $idVisita
 * @property TipoFotoVisita $idTipoFotoVisita
 * @property Linea[] $lineas
 */
class FotoVisita extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'foto_visita';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_visita, id_tipo_foto_visita, orden, id_elemento, id_material', 'numerical', 'integerOnly'=>true),
			array('tipo', 'length', 'max'=>255),
			array('foto, observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_visita, id_tipo_foto_visita, tipo, foto, observaciones, orden, id_elemento, id_material', 'safe', 'on'=>'search'),
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
			'idElemento' => array(self::BELONGS_TO, 'Elemento', 'id_elemento'),
			'idMaterial' => array(self::BELONGS_TO, 'Material', 'id_material'),
			'idVisita' => array(self::BELONGS_TO, 'Visita', 'id_visita'),
			'idTipoFotoVisita' => array(self::BELONGS_TO, 'TipoFotoVisita', 'id_tipo_foto_visita'),
			'lineas' => array(self::HAS_MANY, 'Linea', 'id_foto_visita'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_visita' => 'Id Visita',
			'id_tipo_foto_visita' => 'Id Tipo Foto Visita',
			'tipo' => 'Tipo',
			'foto' => 'Foto',
			'observaciones' => 'Observaciones',
			'orden' => 'Orden',
			'id_elemento' => 'Id Elemento',
			'id_material' => 'Id Material',
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
		$criteria->compare('id_visita',$this->id_visita);
		$criteria->compare('id_tipo_foto_visita',$this->id_tipo_foto_visita);
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('foto',$this->foto,true);
		$criteria->compare('observaciones',$this->observaciones,true);
		$criteria->compare('orden',$this->orden);
		$criteria->compare('id_elemento',$this->id_elemento);
		$criteria->compare('id_material',$this->id_material);

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
	 * @return FotoVisita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
