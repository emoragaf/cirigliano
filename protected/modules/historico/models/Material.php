<?php

/**
 * This is the model class for table "material".
 *
 * The followings are the available columns in table 'material':
 * @property integer $id
 * @property string $descripcion
 *
 * The followings are the available model relations:
 * @property CampanaMaterial[] $campanaMaterials
 * @property DetalleIngresoMaterial[] $detalleIngresoMaterials
 * @property Visita[] $visitas
 * @property FotoVisita[] $fotoVisitas
 * @property PuntoMaterial[] $puntoMaterials
 * @property VisitaMaterial[] $visitaMaterials
 */
class Material extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'material';
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
			'campanaMaterials' => array(self::HAS_MANY, 'CampanaMaterial', 'id_material'),
			'detalleIngresoMaterials' => array(self::HAS_MANY, 'DetalleIngresoMaterial', 'id_material'),
			'visitas' => array(self::MANY_MANY, 'Visita', 'checklist_material(id_material, id_visita)'),
			'fotoVisitas' => array(self::HAS_MANY, 'FotoVisita', 'id_material'),
			'puntoMaterials' => array(self::HAS_MANY, 'PuntoMaterial', 'id_material'),
			'visitaMaterials' => array(self::HAS_MANY, 'VisitaMaterial', 'id_material'),
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
	 * @return Material the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
