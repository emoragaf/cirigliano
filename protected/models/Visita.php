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
	private $estados = array(0=>'Solicitada',1=>'Espera Aprobación Presupuesto',2=>'Presupuesto Rechazado',3=>'En Ejecución',4=>'Terminada',99=>'Cancelada');
	
	
	public $punto_direccion;
	public $punto_region_id;
	public $punto_comuna_id;
	public $punto_distribuidor_id;
	public $punto_canal_id;
	public $fecha_creacion_inicio;
    public $fecha_creacion_final;
    public $fecha_visita_inicio;
    public $fecha_visita_final;
    public $mueble_punto;

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
			array('folio', 'length', 'max'=>255),
			array('fecha_creacion', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha_creacion,fecha_creacion_final ,fecha_creacion_inicio ,fecha_visita_final ,fecha_visita_inicio ,punto_direccion, punto_canal_id,punto_distribuidor_id, punto_comuna_id, punto_canal_id, punto_region_id, fecha_visita, punto_id, tipo_visita_id, persona_punto_id, estado', 'safe', 'on'=>'search'),
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
			'mueblespresupuesto' => array(self::HAS_MANY, 'MueblePresupuesto', 'visita_id'),
			'informe' => array(self::HAS_ONE, 'Formulario', 'visita_id'),
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
	public function getEstadosByTipo($tipo)
	{
		return $this->estadosbyTipo;
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
			'persona_punto_id' => 'Solicitante',
			'estado' => 'Estado',
			'punto_direccion'=>'Dirección',
			'punto_canal_id'=>'Canal',
			'punto_distribuidor_id'=>'Distribuidor',
			'punto_region_id'=>'Region',
			'punto_comuna_id'=>'Comuna',
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
		$criteria->compare('folio',$this->folio,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchVisitasPunto($id)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->condition = 'punto_id = '.$id;
		$criteria->together= true;
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_visita',$this->fecha_visita,true);
		$criteria->compare('persona_punto_id',$this->persona_punto_id);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('folio',$this->folio,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRelationsPendientes()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('punto'=>array('select'=>'punto.direccion,punto.region_id,punto.comuna_id,punto.distribuidor_id,punto.canal_id'));
		$criteria->together= true;
		$criteria->condition = 't.estado < 3';
		if((isset($this->fecha_creacion_inicio) && trim($this->fecha_creacion_inicio) != "") && (isset($this->fecha_creacion_final) && trim($this->fecha_creacion_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_creacion', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_creacion_final)).'');
        if((isset($this->fecha_visita_inicio) && trim($this->fecha_visita_inicio) != "") && (isset($this->fecha_visita_final) && trim($this->fecha_visita_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_visita', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_visita_final)).'');
		$criteria->compare('punto.direccion',$this->punto_direccion,true);
		$criteria->compare('punto.region_id',$this->punto_id,true);
		$criteria->compare('punto.comuna_id',$this->punto_id,true);
		$criteria->compare('punto.distribuidor_id',$this->punto_id,true);
		$criteria->compare('punto.canal_id',$this->punto_canal_id,true);
		$criteria->compare('t.folio',$this->folio,true);
		$criteria->compare('t.persona_punto_id',$this->persona_punto_id);
		$criteria->compare('t.estado',$this->estado);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRelations($params = array())
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($params)){
			if(isset($params['tipo'])){
				if($params['tipo'] == 1)
				{
					$criteria->condition = 't.tipo_visita_id = 1 OR t.tipo_visita_id = 2';
				}
				else
				$criteria->condition = 't.tipo_visita_id ='.$params['tipo'];
			}
		}


		$criteria->with = array('punto'=>array('select'=>'punto.direccion,punto.region_id,punto.comuna_id,punto.distribuidor_id,punto.canal_id'));
		$criteria->together= true;
		if((isset($this->fecha_creacion_inicio) && trim($this->fecha_creacion_inicio) != "") && (isset($this->fecha_creacion_final) && trim($this->fecha_creacion_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_creacion', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_creacion_final)).'');
        if((isset($this->fecha_visita_inicio) && trim($this->fecha_visita_inicio) != "") && (isset($this->fecha_visita_final) && trim($this->fecha_visita_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_visita', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_visita_final)).'');
		$criteria->compare('punto.direccion',$this->punto_direccion,true);
		$criteria->compare('punto.region_id',$this->punto_id,true);
		$criteria->compare('punto.comuna_id',$this->punto_id,true);
		$criteria->compare('punto.distribuidor_id',$this->punto_id,true);
		$criteria->compare('punto.canal_id',$this->punto_canal_id,true);
		$criteria->compare('t.folio',$this->folio,true);
		$criteria->compare('t.persona_punto_id',$this->persona_punto_id);
		$criteria->compare('t.estado',$this->estado);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRelationsActivos()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('punto'=>array('select'=>'punto.direccion,punto.region_id,punto.comuna_id,punto.distribuidor_id,punto.canal_id'));
		$criteria->together= true;
		$criteria->condition = 't.estado > 3';
		if((isset($this->fecha_creacion_inicio) && trim($this->fecha_creacion_inicio) != "") && (isset($this->fecha_creacion_final) && trim($this->fecha_creacion_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_creacion', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_creacion_final)).'');
        if((isset($this->fecha_visita_inicio) && trim($this->fecha_visita_inicio) != "") && (isset($this->fecha_visita_final) && trim($this->fecha_visita_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_visita', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_visita_final)).'');
		$criteria->compare('punto.direccion',$this->punto_direccion,true);
		$criteria->compare('punto.region_id',$this->punto_id,true);
		$criteria->compare('punto.comuna_id',$this->punto_id,true);
		$criteria->compare('punto.distribuidor_id',$this->punto_id,true);
		$criteria->compare('punto.canal_id',$this->punto_canal_id,true);
		$criteria->compare('t.folio',$this->folio,true);
		$criteria->compare('t.persona_punto_id',$this->persona_punto_id);
		$criteria->compare('t.estado',$this->estado);
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
