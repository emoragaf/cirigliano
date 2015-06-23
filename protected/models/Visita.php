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
	private $estados = array(0=>'Solicitada',1=>'Espera Aprobación Presupuesto',2=>'Presupuesto Rechazado',3=>'En Ejecución',4=>'Terminada',5=>'Espera Informe',99=>'Cancelada');

	public $punto_destino;
	public $punto_codigo;
	public $punto_direccion;
	public $punto_descripcion;
	public $punto_region_id;
	public $punto_comuna_id;
	public $punto_distribuidor_id;
	public $punto_canal_id;
	public $punto_subcanal_id;
	public $fecha_creacion_inicio;
    public $fecha_creacion_final;
    public $fecha_visita_inicio;
    public $fecha_visita_final;
    public $mueble_punto;
    public $muebles_traslado;

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
			array('destino_traslado_id', 'required','on'=>'traslado'),
			array('punto_id, tipo_visita_id, persona_punto_id', 'required'),
			array('id, punto_id, tipo_visita_id, persona_punto_id, destino_traslado_id, estado, visita_preventiva, codigo,mimagen', 'numerical', 'integerOnly'=>true),
			array('fecha_visita', 'length', 'max'=>45),
			array('folio', 'length', 'max'=>255),
			array('fecha_creacion,muebles_traslado', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha_creacion,fecha_creacion_final ,fecha_creacion_inicio ,fecha_visita_final ,fecha_visita_inicio ,punto_direccion, punto_canal_id,punto_distribuidor_id, punto_comuna_id,punto_codigo, punto_subcanal_id, punto_region_id, fecha_visita, punto_id, tipo_visita_id, persona_punto_id, estado', 'safe', 'on'=>'search'),
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
			'formulario' => array(self::HAS_ONE, 'Formulario', 'visita_id'),
			'informe' => array(self::HAS_ONE, 'Formulario', 'visita_id'),
			'destino' => array(self::BELONGS_TO,'Punto','destino_traslado_id'),
		);
	}

	public static function convertModelToArray($models) {
			if (is_array($models))
					$arrayMode = TRUE;
			else {
					$models = array($models);
					$arrayMode = FALSE;
			}

			$result = array();
			foreach ($models as $model) {
					$attributes = $model->getAttributes();
					$relations = array();
					foreach ($model->relations() as $key => $related) {
							if ($model->hasRelated($key)) {
									$relations[$key] = self::convertModelToArray($model->$key);
							}
					}
					$all = array_merge($attributes, $relations);

					if ($arrayMode)
							array_push($result, $all);
					else
							$result = $all;
			}
			return $result;
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
			'punto_direccion'=>$this->tipo_visita_id == 3 ? 'Origen':'Dirección',
			'punto_canal_id'=>'Canal',
			'punto_subcanal_id'=>'Subcanal',
			'punto_distribuidor_id'=>'Distribuidor',
			'punto_region_id'=>'Region',
			'punto_comuna_id'=>'Comuna',
			'punto_destino'=>'Destino',
			'muebles_traslado'=>'Muebles Traslado',
			'destino_traslado_id'=>'Destino',
			'punto_codigo'=>'Código Punto',
			'codigo'=>'Id Check',
		);
	}
	public function saveWH(){
		$presupuestos = $this->presupuestos;

		foreach ($presupuestos as $presupuesto) {
			if($this->visita_preventiva){
				$whvisita = new WhVisita;

					$whvisita->folio = $this->folio;
					$whvisita->tipo_visita = $this->tipo_visita_id;
					$whvisita->direccion_punto = $this->punto->direccion;
					$whvisita->region = $this->punto->region_id;
					$whvisita->region = $this->punto->comuna_id;
					$whvisita->fecha_creacion = $this->fecha_creacion;
					$whvisita->fecha_visita = $this->fecha_visita;
					$whvisita->visita_preventiva = $this->visita_preventiva;
					$whvisita->canal = $this->punto->canal_id;
					$whvisita->distribuidor = $this->punto->distribuidor_id;
					$whvisita->notas = $this->formulario->notas;
					$whvisita->persona_punto = $this->persona_punto_id;
					$whvisita->user_autoriza = $this->id_autoriza;
					$whvisita->punto_id = $this->punto_id;
					$whvisita->vista_id = $this->id;

					$whvisita->descripcion_item = 'Visita Preventiva';
					$whvisita->monto_item = $presupuesto->tarifa_visita_preventiva;
					$whvisita->mueble = null;
					$whvisita->codigo_mueble = null;
					$whvisita->mueble_punto_id = null;
					$whvisita->cantidad_item = 1;

					$whvisita->save();
			}
			if($presupuesto->adicionales)
				foreach ($presupuesto->adicionales as $adicional) {
					$whvisita = new WhVisita;

					$whvisita->folio = $this->folio;
					$whvisita->tipo_visita = $this->tipo_visita_id;
					$whvisita->direccion_punto = $this->punto->direccion;
					$whvisita->region = $this->punto->region_id;
					$whvisita->region = $this->punto->comuna_id;
					$whvisita->fecha_creacion = $this->fecha_creacion;
					$whvisita->fecha_visita = $this->fecha_visita;
					$whvisita->visita_preventiva = $this->visita_preventiva;
					$whvisita->canal = $this->punto->canal_id;
					$whvisita->distribuidor = $this->punto->distribuidor_id;
					$whvisita->notas = $this->formulario->notas;
					$whvisita->persona_punto = $this->persona_punto_id;
					$whvisita->user_autoriza = $this->id_autoriza;
					$whvisita->punto_id = $this->punto_id;
					$whvisita->vista_id = $this->id;

					$whvisita->descripcion_item = $adicional->descripcion;
					$whvisita->monto_item = $adicional->tarifa;
					$whvisita->mueble = $adicional->mueblePunto && $adicional->mueblePunto->mueble? $adicional->mueblePunto->mueble->id:null;
					$whvisita->codigo_mueble = $adicional->mueblePunto? $adicional->mueblePunto->codigo:null;
					$whvisita->mueble_punto_id = $adicional->mueble_punto_id;
					$whvisita->cantidad_item = $adicional->cantidad;

					$whvisita->save();
				}
			if($presupuesto->mueblespresupuesto)
				foreach ($presupuesto->mueblespresupuesto as $mp) {
					$whvisita = new WhVisita;

					$whvisita->folio = $this->folio;
					$whvisita->tipo_visita = $this->tipo_visita_id;
					$whvisita->direccion_punto = $this->punto->direccion;
					$whvisita->region = $this->punto->region_id;
					$whvisita->region = $this->punto->comuna_id;
					$whvisita->fecha_creacion = $this->fecha_creacion;
					$whvisita->fecha_visita = $this->fecha_visita;
					$whvisita->visita_preventiva = $this->visita_preventiva;
					$whvisita->canal = $this->punto->canal_id;
					$whvisita->distribuidor = $this->punto->distribuidor_id;
					$whvisita->notas = $this->formulario->notas;
					$whvisita->persona_punto = $this->persona_punto_id;
					$whvisita->user_autoriza = $this->id_autoriza;
					$whvisita->punto_id = $this->punto_id;
					$whvisita->vista_id = $this->id;

					$whvisita->descripcion_item = $mp->servicio->descripcion;
					$whvisita->monto_item = $mp->tarifa_servicio;
					$whvisita->mueble = $mp->mueblepunto->mueble->id;
					$whvisita->codigo_mueble = $mp->mueblepunto->codigo;
					$whvisita->mueble_punto_id = $mp->mueble_punto_id;
					$whvisita->cantidad_item = $mp->cant_servicio;

					$whvisita->save();
				}
			if($presupuesto->trasladopresupuesto)
				foreach ($presupuesto->trasladopresupuesto as $tp) {
					if($tp->tarifa_instalacion){
						$whvisita = new WhVisita;

						$whvisita->folio = $this->folio;
						$whvisita->tipo_visita = $this->tipo_visita_id;
						$whvisita->direccion_punto = $this->punto->direccion;
						$whvisita->region = $this->punto->region_id;
						$whvisita->region = $this->punto->comuna_id;
						$whvisita->fecha_creacion = $this->fecha_creacion;
						$whvisita->fecha_visita = $this->fecha_visita;
						$whvisita->visita_preventiva = $this->visita_preventiva;
						$whvisita->canal = $this->punto->canal_id;
						$whvisita->distribuidor = $this->punto->distribuidor_id;
						$whvisita->notas = $this->formulario->notas;
						$whvisita->persona_punto = $this->persona_punto_id;
						$whvisita->user_autoriza = $this->id_autoriza;
						$whvisita->punto_id = $this->punto_id;
						$whvisita->vista_id = $this->id;

						$whvisita->descripcion_item = 'Instalación '.$tp->mueblePunto->mueble->descripcion;
						$whvisita->monto_item = $tp->tarifa_instalacion;
						$whvisita->mueble = $tp->mueblePunto && $tp->mueblePunto->mueble? $tp->mueblePunto->mueble->id:null;
						$whvisita->codigo_mueble = $tp->mueblePunto? $tp->mueblePunto->codigo:null;
						$whvisita->mueble_punto_id = $tp->mueble_punto;
						$whvisita->cantidad_item = 1;

						$whvisita->save();
					}
					if($tp->tarifa_desinstalacion){
						$whvisita = new WhVisita;

						$whvisita->folio = $this->folio;
						$whvisita->tipo_visita = $this->tipo_visita_id;
						$whvisita->direccion_punto = $this->punto->direccion;
						$whvisita->region = $this->punto->region_id;
						$whvisita->region = $this->punto->comuna_id;
						$whvisita->fecha_creacion = $this->fecha_creacion;
						$whvisita->fecha_visita = $this->fecha_visita;
						$whvisita->visita_preventiva = $this->visita_preventiva;
						$whvisita->canal = $this->punto->canal_id;
						$whvisita->distribuidor = $this->punto->distribuidor_id;
						$whvisita->notas = $this->formulario->notas;
						$whvisita->persona_punto = $this->persona_punto_id;
						$whvisita->user_autoriza = $this->id_autoriza;
						$whvisita->punto_id = $this->punto_id;
						$whvisita->vista_id = $this->id;

						$whvisita->descripcion_item = 'Desinstalación '.$tp->mueblePunto->mueble->descripcion;
						$whvisita->monto_item = $tp->tarifa_desinstalacion;
						$whvisita->mueble = $tp->mueblePunto && $tp->mueblePunto->mueble? $tp->mueblePunto->mueble->id:null;
						$whvisita->codigo_mueble = $tp->mueblePunto? $tp->mueblePunto->codigo:null;
						$whvisita->mueble_punto_id = $tp->mueble_punto;
						$whvisita->cantidad_item = 1;

						$whvisita->save();

					}
				}
			if($presupuesto->tarifasTraslado)
				foreach ($presupuesto->tarifasTraslado as $tt) {

					//echo </td>
					$whvisita = new WhVisita;

					$whvisita->folio = $this->folio;
					$whvisita->tipo_visita = $this->tipo_visita_id;
					$whvisita->direccion_punto = $this->punto->direccion;
					$whvisita->region = $this->punto->region_id;
					$whvisita->region = $this->punto->comuna_id;
					$whvisita->fecha_creacion = $this->fecha_creacion;
					$whvisita->fecha_visita = $this->fecha_visita;
					$whvisita->visita_preventiva = $this->visita_preventiva;
					$whvisita->canal = $this->punto->canal_id;
					$whvisita->distribuidor = $this->punto->distribuidor_id;
					$whvisita->notas = $this->formulario->notas;
					$whvisita->persona_punto = $this->persona_punto_id;
					$whvisita->user_autoriza = $this->id_autoriza;
					$whvisita->punto_id = $this->punto_id;
					$whvisita->vista_id = $this->id;

					$whvisita->descripcion_item = 'Tarifa Traslado '.$tt->tarifaTraslado->desde.' '.$tt->tarifaTraslado->hasta;
					$whvisita->destino_traslado = $this->destino_traslado_id;
					$whvisita->monto_item = $tt->TTraslado;
					$whvisita->mueble = null;
					$whvisita->codigo_mueble = null;
					$whvisita->mueble_punto_id = null;
					$whvisita->cantidad_item = 1;

					$whvisita->save();
				}
			if($presupuesto->manosobra)
				foreach ($presupuesto->manosobra as $mo) {
					$whvisita = new WhVisita;

					$whvisita->folio = $this->folio;
					$whvisita->tipo_visita = $this->tipo_visita_id;
					$whvisita->direccion_punto = $this->punto->direccion;
					$whvisita->region = $this->punto->region_id;
					$whvisita->region = $this->punto->comuna_id;
					$whvisita->fecha_creacion = $this->fecha_creacion;
					$whvisita->fecha_visita = $this->fecha_visita;
					$whvisita->visita_preventiva = $this->visita_preventiva;
					$whvisita->canal = $this->punto->canal_id;
					$whvisita->distribuidor = $this->punto->distribuidor_id;
					$whvisita->notas = $this->formulario->notas;
					$whvisita->persona_punto = $this->persona_punto_id;
					$whvisita->user_autoriza = $this->id_autoriza;
					$whvisita->punto_id = $this->punto_id;
					$whvisita->vista_id = $this->id;

					$whvisita->descripcion_item = $mo->Descripcion;
					$whvisita->monto_item = $mo->Tarifa;
					$whvisita->mueble = $mo->mueblepunto && $mo->mueblepunto->mueble ? $mo->mueblepunto->mueble->id:null;
					$whvisita->codigo_mueble = $mo->mueblepunto? $mo->mueblepunto->codigo: null;
					$whvisita->mueble_punto_id = $mo->mueble_punto_id;
					$whvisita->cantidad_item = 1;

					$whvisita->save();
				}
		}
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
		$criteria->compare('tipo_visita_id',$this->tipo_visita_id);
		$criteria->compare('folio',$this->folio,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRelationsPendientes()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('punto'=>array('select'=>'punto.direccion,punto.region_id,punto.comuna_id,punto.distribuidor_id,punto.canal_id,punto.subcanal_id'));
		$criteria->together= true;
		$criteria->condition = 't.estado < 3';
		if((isset($this->fecha_creacion_inicio) && trim($this->fecha_creacion_inicio) != "") && (isset($this->fecha_creacion_final) && trim($this->fecha_creacion_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_creacion', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_creacion_final)).'');
        if((isset($this->fecha_visita_inicio) && trim($this->fecha_visita_inicio) != "") && (isset($this->fecha_visita_final) && trim($this->fecha_visita_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_visita', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_visita_final)).'');
		$criteria->compare('punto.direccion',$this->punto_direccion,true);
		$criteria->compare('punto.descripcion',$this->punto_descripcion,true);
		$criteria->compare('punto.codigo',$this->punto_codigo,true);
		$criteria->compare('punto.region_id',$this->punto_region_id,true);
		$criteria->compare('punto.comuna_id',$this->punto_comuna_id,true);
		$criteria->compare('punto.distribuidor_id',$this->punto_distribuidor_id,true);
		$criteria->compare('punto.canal_id',$this->punto_canal_id,true);
		$criteria->compare('punto.subcanal_id',$this->punto_subcanal_id);
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


		$criteria->with = array('punto'=>array('select'=>'punto.direccion,punto.region_id,punto.comuna_id,punto.distribuidor_id,punto.canal_id,punto.subcanal_id'));
		$criteria->together= true;
		if((isset($this->fecha_creacion_inicio) && trim($this->fecha_creacion_inicio) != "") && (isset($this->fecha_creacion_final) && trim($this->fecha_creacion_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_creacion', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_creacion_final)).'');
        if((isset($this->fecha_visita_inicio) && trim($this->fecha_visita_inicio) != "") && (isset($this->fecha_visita_final) && trim($this->fecha_visita_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_visita', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_visita_final)).'');
		$criteria->compare('punto.direccion',$this->punto_direccion,true);
		$criteria->compare('punto.codigo',$this->punto_codigo,true);
		$criteria->compare('punto.direccion',$this->punto_destino,true);
		$criteria->compare('punto.descripcion',$this->punto_descripcion,true);

		$criteria->compare('punto.region_id',$this->punto_region_id);
		$criteria->compare('punto.comuna_id',$this->punto_comuna_id);
		$criteria->compare('punto.distribuidor_id',$this->punto_distribuidor_id);
		$criteria->compare('punto.canal_id',$this->punto_canal_id);
		$criteria->compare('punto.subcanal_id',$this->punto_subcanal_id);
		$criteria->compare('t.folio',$this->folio,true);
		$criteria->compare('t.persona_punto_id',$this->persona_punto_id);
		$criteria->compare('t.estado',$this->estado);
		$criteria->order = 't.id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchRelationsActivos()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('punto'=>array('select'=>'punto.direccion,punto.region_id,punto.comuna_id,punto.distribuidor_id,punto.canal_id,punto.subcanal_id'));
		$criteria->together= true;
		$criteria->condition = 't.estado > 3';
		if((isset($this->fecha_creacion_inicio) && trim($this->fecha_creacion_inicio) != "") && (isset($this->fecha_creacion_final) && trim($this->fecha_creacion_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_creacion', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_creacion_final)).'');
        if((isset($this->fecha_visita_inicio) && trim($this->fecha_visita_inicio) != "") && (isset($this->fecha_visita_final) && trim($this->fecha_visita_final) != ""))
                        $criteria->addBetweenCondition('t.fecha_visita', ''.date('Y-m-d',strtotime($this->fecha_creacion_inicio)).'', ''.date('Y-m-d',strtotime($this->fecha_visita_final)).'');
		$criteria->compare('punto.direccion',$this->punto_direccion,true);
		$criteria->compare('punto.descripcion',$this->punto_descripcion,true);

		$criteria->compare('punto.codigo',$this->punto_codigo,true);
		$criteria->compare('punto.region_id',$this->punto_region_id,true);
		$criteria->compare('punto.comuna_id',$this->punto_comuna_id,true);
		$criteria->compare('punto.distribuidor_id',$this->punto_distribuidor_id,true);
		$criteria->compare('punto.canal_id',$this->punto_canal_id,true);
		$criteria->compare('punto.subcanal_id',$this->punto_subcanal_id);
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
