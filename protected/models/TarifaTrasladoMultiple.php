<?php

/**
 * This is the model class for table "tarifa_traslado_multiple".
 *
 * The followings are the available columns in table 'tarifa_traslado_multiple':
 * @property integer $id
 * @property integer $id_presupuesto
 * @property double $distancia
 * @property integer $tarifa_traslado
 * @property integer $tipo_tarifa_traslado
 */
class TarifaTrasladoMultiple extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tarifa_traslado_multiple';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_presupuesto, distancia, tarifa_traslado, tipo_tarifa_traslado', 'required'),
			array('id_presupuesto, tarifa_traslado, tipo_tarifa_traslado', 'numerical', 'integerOnly'=>true),
			array('distancia', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_presupuesto, distancia, tarifa_traslado, tipo_tarifa_traslado', 'safe', 'on'=>'search'),
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
			'tarifaTraslado'=>array(self::BELONGS_TO,'TarifaTraslado','tarifa_traslado'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_presupuesto' => 'Id Presupuesto',
			'distancia' => 'Distancia',
			'tarifa_traslado' => 'Tarifa Traslado',
			'tipo_tarifa_traslado' => 'Tipo Tarifa Traslado',
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
		$criteria->compare('id_presupuesto',$this->id_presupuesto);
		$criteria->compare('distancia',$this->distancia);
		$criteria->compare('tarifa_traslado',$this->tarifa_traslado);
		$criteria->compare('tipo_tarifa_traslado',$this->tipo_tarifa_traslado);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getTTraslado(){
		if($this->tarifaTraslado && $this->tipo_tarifa_traslado){
			switch ($this->tipo_tarifa_traslado) {
				case '1':
					return $this->tarifaTraslado->tarifa_a;
					break;
				case '2':
					return $this->tarifaTraslado->tarifa_b;
					break;
				case '3':
					return $this->tarifaTraslado->tarifa_c;
					break;
				case '4':
					return $this->tarifaTraslado->tarifa_d;
					break;
				case '5':
					return $this->tarifaTraslado->tarifa_a2!=null?$this->tarifaTraslado->tarifa_a2:$this->tarifaTraslado->tarifa_a;
					break;
				case '6':
				    return $this->tarifaTraslado->tarifa_b2!=null?$this->tarifaTraslado->tarifa_b2:$this->tarifaTraslado->tarifa_b;
					break;
				case '7':
				    return $this->tarifaTraslado->tarifa_c2!=null?$this->tarifaTraslado->tarifa_c2:$this->tarifaTraslado->tarifa_c;
					break;
				case '8':
				    return $this->tarifaTraslado->tarifa_d2!=null?$this->tarifaTraslado->tarifa_d2:$this->tarifaTraslado->tarifa_d;
					break;
				default:
					return null;
					break;
			}
		}
		return 'Tarifa No asignada';
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TarifaTrasladoMultiple the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
