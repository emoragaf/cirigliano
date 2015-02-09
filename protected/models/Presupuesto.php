<?php

/**
 * This is the model class for table "presupuesto".
 *
 * The followings are the available columns in table 'presupuesto':
 * @property integer $id
 * @property string $total
 * @property string $nota
 * @property integer $visita_id
 * @property integer $user_id
 * @property integer $estado
 * @property string $fecha_creacion
 * @property string $fecha_respuesta
 * @property string $fecha_asignacion
 * @property string $fecha_termino
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Visita $visita
 */
class Presupuesto extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'presupuesto';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tipo_tarifa_traslado','required','on'=>'traslado'),
			array('id, visita_id, user_id, estado, tarifa_traslado, tipo_tarifa_traslado', 'numerical', 'integerOnly'=>true),
			array('total', 'length', 'max'=>45),
			array('nota, fecha_creacion, fecha_respuesta, fecha_asignacion, fecha_termino', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, total, nota, visita_id, user_id, estado, fecha_creacion, fecha_respuesta, fecha_asignacion, fecha_termino', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'visita' => array(self::BELONGS_TO, 'Visita', 'visita_id'),
			'mueblespresupuesto' => array(self::HAS_MANY, 'MueblePresupuesto', 'presupuesto_id','order'=>'servicio_mueble_id'),
			'trasladopresupuesto' => array(self::HAS_MANY, 'TrasladoPresupuesto', 'presupuesto_id'),
			'adicionales' => array(self::HAS_MANY, 'Adicional', 'presupuesto_id'),
			'tarifasTraslado'=>array(self::HAS_MANY,'TarifaTrasladoMultiple','id_presupuesto'),
			'manosobra'=>array(self::HAS_MANY,'ManoObraPresupuesto','presupuesto_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'total' => 'Total',
			'nota' => 'Nota',
			'visita_id' => 'Visita',
			'user_id' => 'User',
			'estado' => 'Estado',
			'fecha_creacion' => 'Fecha Creacion',
			'fecha_respuesta' => 'Fecha Respuesta',
			'fecha_asignacion' => 'Fecha Asignacion',
			'fecha_termino' => 'Fecha Termino',
			'tarifa_traslado'=>'Origen - Destino Traslado',
			'tipo_tarifa_traslado'=>'Nombre Proveedor',
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
		$criteria->compare('total',$this->total,true);
		$criteria->compare('nota',$this->nota,true);
		$criteria->compare('visita_id',$this->visita_id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha_creacion',$this->fecha_creacion,true);
		$criteria->compare('fecha_respuesta',$this->fecha_respuesta,true);
		$criteria->compare('fecha_asignacion',$this->fecha_asignacion,true);
		$criteria->compare('fecha_termino',$this->fecha_termino,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Presupuesto the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
