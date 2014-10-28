<?php

/**
 * This is the model class for table "informe".
 *
 * The followings are the available columns in table 'informe':
 * @property integer $id
 * @property integer $id_campana
 * @property string $tipo
 * @property string $informe
 * @property string $nombre_archivo
 * @property integer $orden
 *
 * The followings are the available model relations:
 * @property Campana $idCampana
 */
class Informe extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'informe';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_campana, orden', 'numerical', 'integerOnly'=>true),
			array('tipo, nombre_archivo', 'length', 'max'=>255),
			array('informe', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_campana, tipo, informe, nombre_archivo, orden', 'safe', 'on'=>'search'),
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
			'idCampana' => array(self::BELONGS_TO, 'Campana', 'id_campana'),
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
			'tipo' => 'Tipo',
			'informe' => 'Informe',
			'nombre_archivo' => 'Nombre Archivo',
			'orden' => 'Orden',
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
		$criteria->compare('tipo',$this->tipo,true);
		$criteria->compare('informe',$this->informe,true);
		$criteria->compare('nombre_archivo',$this->nombre_archivo,true);
		$criteria->compare('orden',$this->orden);

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
	 * @return Informe the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
