<?php

/**
 * This is the model class for table "alarma".
 *
 * The followings are the available columns in table 'alarma':
 * @property integer $id
 * @property integer $id_usuario
 * @property integer $id_tipo_campana
 * @property boolean $email
 * @property boolean $sms
 * @property boolean $nueva
 * @property boolean $modificada
 * @property boolean $eliminada
 * @property boolean $finalizada
 *
 * The followings are the available model relations:
 * @property TipoCampana $idTipoCampana
 * @property Usuario $idUsuario
 */
class Alarma extends MyActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'alarma';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_usuario, id_tipo_campana', 'numerical', 'integerOnly'=>true),
			array('email, sms, nueva, modificada, eliminada, finalizada', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_usuario, id_tipo_campana, email, sms, nueva, modificada, eliminada, finalizada', 'safe', 'on'=>'search'),
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
			'idTipoCampana' => array(self::BELONGS_TO, 'TipoCampana', 'id_tipo_campana'),
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
			'id_usuario' => 'Id Usuario',
			'id_tipo_campana' => 'Id Tipo Campana',
			'email' => 'Email',
			'sms' => 'Sms',
			'nueva' => 'Nueva',
			'modificada' => 'Modificada',
			'eliminada' => 'Eliminada',
			'finalizada' => 'Finalizada',
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
		$criteria->compare('id_usuario',$this->id_usuario);
		$criteria->compare('id_tipo_campana',$this->id_tipo_campana);
		$criteria->compare('email',$this->email);
		$criteria->compare('sms',$this->sms);
		$criteria->compare('nueva',$this->nueva);
		$criteria->compare('modificada',$this->modificada);
		$criteria->compare('eliminada',$this->eliminada);
		$criteria->compare('finalizada',$this->finalizada);

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
	 * @return Alarma the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
