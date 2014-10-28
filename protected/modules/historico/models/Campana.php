<?php

/**
 * This is the model class for table "campana".
 *
 * The followings are the available columns in table 'campana':
 * @property integer $id
 * @property string $descripcion
 * @property string $fecha_inicio
 * @property string $fecha_termino
 * @property integer $id_tipo_campana
 * @property boolean $activa
 * @property integer $id_prioridad
 * @property boolean $alertado
 *
 * The followings are the available model relations:
 * @property CampanaElemento[] $campanaElementos
 * @property CampanaMaterial[] $campanaMaterials
 * @property CampanaTecnologia[] $campanaTecnologias
 * @property IngresoElemento[] $ingresoElementos
 * @property IngresoMaterial[] $ingresoMaterials
 * @property Informe[] $informes
 * @property Planificacion[] $planificacions
 * @property Adjunto[] $adjuntos
 * @property Solicitante[] $solicitantes
 * @property Visita[] $visitas
 * @property Pregunta[] $preguntas
 * @property TipoCampana $idTipoCampana
 * @property Prioridad $idPrioridad
 */
class Campana extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'campana';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_tipo_campana, id_prioridad', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>255),
			array('fecha_inicio, fecha_termino, activa, alertado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descripcion, fecha_inicio, fecha_termino, id_tipo_campana, activa, id_prioridad, alertado', 'safe', 'on'=>'search'),
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
			'campanaElementos' => array(self::HAS_MANY, 'CampanaElemento', 'id_campana'),
			'campanaMaterials' => array(self::HAS_MANY, 'CampanaMaterial', 'id_campana'),
			'campanaTecnologias' => array(self::HAS_MANY, 'CampanaTecnologia', 'id_campana'),
			'ingresoElementos' => array(self::HAS_MANY, 'IngresoElemento', 'id_campana'),
			'ingresoMaterials' => array(self::HAS_MANY, 'IngresoMaterial', 'id_campana'),
			'informes' => array(self::HAS_MANY, 'Informe', 'id_campana'),
			'planificacions' => array(self::HAS_MANY, 'Planificacion', 'id_campana'),
			'adjuntos' => array(self::HAS_MANY, 'Adjunto', 'id_campana'),
			'solicitantes' => array(self::HAS_MANY, 'Solicitante', 'id_campana'),
			'visitas' => array(self::HAS_MANY, 'Visita', 'id_campana'),
			'preguntas' => array(self::HAS_MANY, 'Pregunta', 'id_campana'),
			'idTipoCampana' => array(self::BELONGS_TO, 'TipoCampana', 'id_tipo_campana'),
			'idPrioridad' => array(self::BELONGS_TO, 'Prioridad', 'id_prioridad'),
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
			'fecha_inicio' => 'Fecha Inicio',
			'fecha_termino' => 'Fecha Termino',
			'id_tipo_campana' => 'Id Tipo Campana',
			'activa' => 'Activa',
			'id_prioridad' => 'Id Prioridad',
			'alertado' => 'Alertado',
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
		$criteria->compare('fecha_inicio',$this->fecha_inicio,true);
		$criteria->compare('fecha_termino',$this->fecha_termino,true);
		$criteria->compare('id_tipo_campana',$this->id_tipo_campana);
		$criteria->compare('activa',$this->activa);
		$criteria->compare('id_prioridad',$this->id_prioridad);
		$criteria->compare('alertado',$this->alertado);

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
	 * @return Campana the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
