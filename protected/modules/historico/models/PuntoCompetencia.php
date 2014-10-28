<?php

/**
 * This is the model class for table "punto_competencia".
 *
 * The followings are the available columns in table 'punto_competencia':
 * @property integer $id
 * @property integer $id_empresa_competencia
 * @property integer $id_comuna
 * @property string $direccion
 * @property string $descripcion
 * @property double $latitud
 * @property double $longitud
 *
 * The followings are the available model relations:
 * @property EmpresaCompetencia $idEmpresaCompetencia
 * @property Comuna $idComuna
 */
class PuntoCompetencia extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'punto_competencia';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_empresa_competencia, id_comuna', 'numerical', 'integerOnly'=>true),
			array('latitud, longitud', 'numerical'),
			array('direccion, descripcion', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_empresa_competencia, id_comuna, direccion, descripcion, latitud, longitud', 'safe', 'on'=>'search'),
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
			'idEmpresaCompetencia' => array(self::BELONGS_TO, 'EmpresaCompetencia', 'id_empresa_competencia'),
			'idComuna' => array(self::BELONGS_TO, 'Comuna', 'id_comuna'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_empresa_competencia' => 'Id Empresa Competencia',
			'id_comuna' => 'Id Comuna',
			'direccion' => 'Direccion',
			'descripcion' => 'Descripcion',
			'latitud' => 'Latitud',
			'longitud' => 'Longitud',
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
		$criteria->compare('id_empresa_competencia',$this->id_empresa_competencia);
		$criteria->compare('id_comuna',$this->id_comuna);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('latitud',$this->latitud);
		$criteria->compare('longitud',$this->longitud);

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
	 * @return PuntoCompetencia the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
