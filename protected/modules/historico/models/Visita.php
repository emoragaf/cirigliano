<?php

/**
 * This is the model class for table "visita".
 *
 * The followings are the available columns in table 'visita':
 * @property integer $id
 * @property integer $id_campana
 * @property integer $id_punto
 * @property string $fecha
 * @property integer $id_estado_visita
 * @property string $observaciones
 *
 * The followings are the available model relations:
 * @property Dummy[] $dummies
 * @property Checklist $checklist
 * @property Mueble[] $muebles
 * @property Tecnologia[] $tecnologias
 * @property Material[] $materials
 * @property FotoChecklistGraficaAdicional[] $fotoChecklistGraficaAdicionals
 * @property FotoVisita[] $fotoVisitas
 * @property EstadoVisita $idEstadoVisita
 * @property Punto $idPunto
 * @property Campana $idCampana
 * @property VisitaElemento[] $visitaElementos
 * @property VisitaTecnologia[] $visitaTecnologias
 * @property Elemento[] $elementos
 * @property ChecklistExhibicion[] $checklistExhibicions
 * @property VisitaMaterial[] $visitaMaterials
 */
class Visita extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'visita';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_campana, id_punto, id_estado_visita', 'numerical', 'integerOnly'=>true),
			array('fecha, observaciones', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_campana, id_punto, fecha, id_estado_visita, observaciones', 'safe', 'on'=>'search'),
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
			'dummies' => array(self::MANY_MANY, 'Dummy', 'checklist_dummy(id_visita, id_dummy)'),
			'checklist' => array(self::HAS_ONE, 'Checklist', 'id_visita'),
			'muebles' => array(self::MANY_MANY, 'Mueble', 'checklist_mueble(id_visita, id_mueble)'),
			'tecnologias' => array(self::MANY_MANY, 'Tecnologia', 'checklist_tecnologia(id_visita, id_tecnologia)'),
			'materials' => array(self::MANY_MANY, 'Material', 'checklist_material(id_visita, id_material)'),
			'fotoChecklistGraficaAdicionals' => array(self::HAS_MANY, 'FotoChecklistGraficaAdicional', 'id_visita'),
			'fotoVisitas' => array(self::HAS_MANY, 'FotoVisita', 'id_visita'),
			'idEstadoVisita' => array(self::BELONGS_TO, 'EstadoVisita', 'id_estado_visita'),
			'idPunto' => array(self::BELONGS_TO, 'Punto', 'id_punto'),
			'idCampana' => array(self::BELONGS_TO, 'Campana', 'id_campana'),
			'visitaElementos' => array(self::HAS_MANY, 'VisitaElemento', 'id_visita'),
			'visitaTecnologias' => array(self::HAS_MANY, 'VisitaTecnologia', 'id_visita'),
			'elementos' => array(self::MANY_MANY, 'Elemento', 'checklist_elemento(id_visita, id_elemento)'),
			'checklistExhibicions' => array(self::HAS_MANY, 'ChecklistExhibicion', 'id_visita'),
			'visitaMaterials' => array(self::HAS_MANY, 'VisitaMaterial', 'id_visita'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_campana' => 'Id Campana',
			'id_punto' => 'Id Punto',
			'fecha' => 'Fecha',
			'id_estado_visita' => 'Id Estado Visita',
			'observaciones' => 'Observaciones',
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
		$criteria->compare('id_campana',$this->id_campana);
		$criteria->compare('id_punto',$this->id_punto);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_estado_visita',$this->id_estado_visita);
		$criteria->compare('observaciones',$this->observaciones,true);

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
	 * @return Visita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
