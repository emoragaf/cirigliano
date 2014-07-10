<?php

/**
 * This is the model class for table "visita".
 *
 * The followings are the available columns in table 'visita':
 * @property integer $id
 * @property string $fecha_creacion
 * @property string $fecha_visita
 * @property integer $punto_id
 * @property integer $tipo_visita_id
 * @property integer $persona_punto_id
 * @property integer $estado
 *
 * The followings are the available model relations:
 * @property Presupuesto[] $presupuestos
 * @property Punto $punto
 * @property TipoVisita $tipoVisita
 * @property PersonaPunto $personaPunto
 */
class Visita extends CActiveRecord
{
	private $estados = array('Solicitada','Espera Aprobación Presupuesto','En Ejecución','Terminada','Cancelada');
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
			array('punto_id, tipo_visita_id, persona_punto_id', 'required'),
			array('id, punto_id, tipo_visita_id, persona_punto_id, estado', 'numerical', 'integerOnly'=>true),
			array('fecha_visita', 'length', 'max'=>45),
			array('fecha_creacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha_creacion, fecha_visita, punto_id, tipo_visita_id, persona_punto_id, estado', 'safe', 'on'=>'search'),
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
			'presupuestos' => array(self::HAS_MANY, 'Presupuesto', 'visita_id'),
			'punto' => array(self::BELONGS_TO, 'Punto', 'punto_id'),
			'tipoVisita' => array(self::BELONGS_TO, 'TipoVisita', 'tipo_visita_id'),
			'personaPunto' => array(self::BELONGS_TO, 'PersonaPunto', 'persona_punto_id'),
		);
	}

	public function getnombreEstado()
	{
		
		if(array_key_exists($this->estado, $this->estados)){
			return $this->estados[$this->estado];
		}
		else
			return '';
	}
	public function getEstados()
	{
		return $this->estados;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha_creacion' => 'Fecha Creacion',
			'fecha_visita' => 'Fecha Visita',
			'punto_id' => 'Punto',
			'tipo_visita_id' => 'Tipo Visita',
			'persona_punto_id' => 'Persona Punto',
			'estado' => 'Estado',
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
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_visita',$this->fecha_visita,true);
		$criteria->compare('punto_id',$this->punto_id);
		$criteria->compare('tipo_visita_id',$this->tipo_visita_id);
		$criteria->compare('persona_punto_id',$this->persona_punto_id);
		$criteria->compare('estado',$this->estado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Visita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
