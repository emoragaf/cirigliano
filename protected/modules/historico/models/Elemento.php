<?php

/**
 * This is the model class for table "elemento".
 *
 * The followings are the available columns in table 'elemento':
 * @property integer $id
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property CampanaElemento[] $campanaElementos
 * @property DetalleIngresoElemento[] $detalleIngresoElementos
 * @property FotoElemento[] $fotoElementos
 * @property FotoVisita[] $fotoVisitas
 * @property PuntoElemento[] $puntoElementos
 * @property VisitaElemento[] $visitaElementos
 * @property Visita[] $visitas
 */
class Elemento extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'elemento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descripcion', 'safe', 'on'=>'search'),
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
			'campanaElementos' => array(self::HAS_MANY, 'CampanaElemento', 'id_elemento'),
			'detalleIngresoElementos' => array(self::HAS_MANY, 'DetalleIngresoElemento', 'id_elemento'),
			'fotoElementos' => array(self::HAS_MANY, 'FotoElemento', 'id_elemento'),
			'fotoVisitas' => array(self::HAS_MANY, 'FotoVisita', 'id_elemento'),
			'puntoElementos' => array(self::HAS_MANY, 'PuntoElemento', 'id_elemento'),
			'visitaElementos' => array(self::HAS_MANY, 'VisitaElemento', 'id_elemento'),
			'visitas' => array(self::MANY_MANY, 'Visita', 'checklist_elemento(id_elemento, id_visita)'),
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
	 * @return Elemento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
