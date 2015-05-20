<?php

/**
 * This is the model class for table "wh_visita".
 *
 * The followings are the available columns in table 'wh_visita':
 * @property integer $id
 * @property string $folio
 * @property string $tipo_visita
 * @property string $direccion_punto
 * @property string $region
 * @property string $comuna
 * @property string $fecha_creacion
 * @property string $fecha_visita
 * @property integer $visita_preventiva
 * @property string $canal
 * @property string $distribuidor
 * @property string $notas
 * @property integer $persona_punto
 * @property integer $user_autoriza
 * @property string $destino_traslado
 * @property string $estado
 * @property string $descripcion_item
 * @property integer $monto_item
 * @property string $mueble
 * @property string $codigo_mueble
 * @property integer $punto_id
 * @property integer $mueble_punto_id
 * @property integer $vista_id
 * @property integer $cantidad_item
 */
class WhVisita extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'wh_visita';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('folio, fecha_creacion, punto_id', 'required'),
			array('visita_preventiva, persona_punto, user_autoriza, monto_item, punto_id, mueble_punto_id, vista_id, cantidad_item', 'numerical', 'integerOnly'=>true),
			array('folio, tipo_visita, direccion_punto, region, comuna, canal, distribuidor, destino_traslado, estado, descripcion_item, mueble, codigo_mueble', 'length', 'max'=>255),
			array('fecha_visita, notas', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, folio, tipo_visita, direccion_punto, region, comuna, fecha_creacion, fecha_visita, visita_preventiva, canal, distribuidor, notas, persona_punto, user_autoriza, destino_traslado, estado, descripcion_item, monto_item, mueble, codigo_mueble, punto_id, mueble_punto_id, vista_id, cantidad_item', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'folio' => 'Folio',
			'tipo_visita' => 'Tipo Visita',
			'direccion_punto' => 'Direccion Punto',
			'region' => 'Region',
			'comuna' => 'Comuna',
			'fecha_creacion' => 'Fecha Creacion',
			'fecha_visita' => 'Fecha Visita',
			'visita_preventiva' => 'Visita Preventiva',
			'canal' => 'Canal',
			'distribuidor' => 'Distribuidor',
			'notas' => 'Notas',
			'persona_punto' => 'Persona Punto',
			'user_autoriza' => 'User Autoriza',
			'destino_traslado' => 'Destino Traslado',
			'estado' => 'Estado',
			'descripcion_item' => 'Descripcion Item',
			'monto_item' => 'Monto Item',
			'mueble' => 'Mueble',
			'codigo_mueble' => 'Codigo Mueble',
			'punto_id' => 'Punto',
			'mueble_punto_id' => 'Mueble Punto',
			'vista_id' => 'Vista',
			'cantidad_item' => 'Cantidad Item',
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
		$criteria->compare('folio',$this->folio,true);
		$criteria->compare('tipo_visita',$this->tipo_visita,true);
		$criteria->compare('direccion_punto',$this->direccion_punto,true);
		$criteria->compare('region',$this->region,true);
		$criteria->compare('comuna',$this->comuna,true);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_visita',$this->fecha_visita,true);
		$criteria->compare('visita_preventiva',$this->visita_preventiva);
		$criteria->compare('canal',$this->canal,true);
		$criteria->compare('distribuidor',$this->distribuidor,true);
		$criteria->compare('notas',$this->notas,true);
		$criteria->compare('persona_punto',$this->persona_punto);
		$criteria->compare('user_autoriza',$this->user_autoriza);
		$criteria->compare('destino_traslado',$this->destino_traslado,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('descripcion_item',$this->descripcion_item,true);
		$criteria->compare('monto_item',$this->monto_item);
		$criteria->compare('mueble',$this->mueble,true);
		$criteria->compare('codigo_mueble',$this->codigo_mueble,true);
		$criteria->compare('punto_id',$this->punto_id);
		$criteria->compare('mueble_punto_id',$this->mueble_punto_id);
		$criteria->compare('vista_id',$this->vista_id);
		$criteria->compare('cantidad_item',$this->cantidad_item);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return WhVisita the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
