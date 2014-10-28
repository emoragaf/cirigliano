<?php

/**
 * This is the model class for table "solicitud".
 *
 * The followings are the available columns in table 'solicitud':
 * @property integer $id
 * @property string $fecha
 * @property integer $id_usuario
 * @property integer $id_punto
 * @property boolean $enviada
 *
 * The followings are the available model relations:
 * @property DetalleSolicitud[] $detalleSolicituds
 * @property Punto $idPunto
 * @property Usuario $idUsuario
 */
class Solicitud extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'solicitud';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_punto', 'numerical', 'integerOnly'=>true),
			array('fecha, enviada', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha, id_usuario, id_punto, enviada', 'safe', 'on'=>'search'),
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
			'detalleSolicituds' => array(self::HAS_MANY, 'DetalleSolicitud', 'id_solicitud'),
			'idPunto' => array(self::BELONGS_TO, 'Punto', 'id_punto'),
			'idUsuario' => array(self::BELONGS_TO, 'Usuario', 'id_usuario'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'id_usuario' => 'Id Usuario',
			'id_punto' => 'Id Punto',
			'enviada' => 'Enviada',
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
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_punto',$this->id_punto);
		$criteria->compare('enviada',$this->enviada);

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
	 * @return Solicitud the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
