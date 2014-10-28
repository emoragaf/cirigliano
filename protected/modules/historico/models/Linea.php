<?php

/**
 * This is the model class for table "linea".
 *
 * The followings are the available columns in table 'linea':
 * @property integer $id
 * @property integer $id_foto_visita
 * @property integer $x1
 * @property integer $y1
 * @property integer $x2
 * @property integer $y2
 * @property string $titulo
 * @property string $color
 * @property double $longitud
 *
 * The followings are the available model relations:
 * @property FotoVisita $idFotoVisita
 */
class Linea extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'linea';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_foto_visita, x1, y1, x2, y2', 'numerical', 'integerOnly'=>true),
			array('longitud', 'numerical'),
			array('titulo', 'length', 'max'=>255),
			array('color', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_foto_visita, x1, y1, x2, y2, titulo, color, longitud', 'safe', 'on'=>'search'),
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
			'idFotoVisita' => array(self::BELONGS_TO, 'FotoVisita', 'id_foto_visita'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_foto_visita' => 'Id Foto Visita',
			'x1' => 'X1',
			'y1' => 'Y1',
			'x2' => 'X2',
			'y2' => 'Y2',
			'titulo' => 'Titulo',
			'color' => 'Color',
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
		$criteria->compare('id_foto_visita',$this->id_foto_visita);
		$criteria->compare('x1',$this->x1);
		$criteria->compare('y1',$this->y1);
		$criteria->compare('x2',$this->x2);
		$criteria->compare('y2',$this->y2);
		$criteria->compare('titulo',$this->titulo,true);
		$criteria->compare('color',$this->color,true);
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
	 * @return Linea the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
