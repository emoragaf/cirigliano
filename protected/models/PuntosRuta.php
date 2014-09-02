<?php

/**
 * This is the model class for table "puntos_ruta".
 *
 * The followings are the available columns in table 'puntos_ruta':
 * @property string $id
 * @property integer $id_punto
 * @property integer $estado
 * @property string $fecha_visita
 * @property integer $semana
 * @property string $fecha_asignacion_visita
 * @property string $created_at
 */
class PuntosRuta extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'puntos_ruta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_punto, visita_id ,ruta_id,estado, semana', 'numerical', 'integerOnly'=>true),
			array('fecha_visita, fecha_asignacion_visita, created_at', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_punto, estado, fecha_visita, semana, fecha_asignacion_visita, created_at', 'safe', 'on'=>'search'),
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
			'punto' => array(self::BELONGS_TO, 'Punto', 'id_punto'),
			'ruta' => array(self::BELONGS_TO, 'Ruta', 'ruta_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_punto' => 'Id Punto',
			'estado' => 'Estado',
			'fecha_visita' => 'Fecha Visita',
			'semana' => 'Semana',
			'fecha_asignacion_visita' => 'Fecha Asignacion Visita',
			'created_at' => 'Created At',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('id_punto',$this->id_punto);
		$criteria->compare('estado',$this->estado);
		$criteria->compare('fecha_visita',$this->fecha_visita,true);
		$criteria->compare('semana',$this->semana);
		$criteria->compare('fecha_asignacion_visita',$this->fecha_asignacion_visita,true);
		$criteria->compare('created_at',$this->created_at,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PuntosRuta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
