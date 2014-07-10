<?php

class m140609_212321_create_tablas_table extends CDbMigration
{
	protected $MySqlOptions = 'ENGINE=InnoDB CHARSET=utf8';
	public function safeUp()
	{
		$this->createTable('organizacion', array(
                        "id" => "pk",
                        "nombre" => "varchar(40) NOT NULL",
                        "direccion" => "varchar(255) NOT NULL DEFAULT ''",
                        "comuna" => "int",
                        "email" => "varchar(128)",
                        "descripcion" => "text",
                        "created_at" => "datetime NOT NULL",
                        "updated_at" => "datetime NOT NULL",
                        "categoria_id"=>"int",
                        "modo_compra_id"=>"int",
                        "tipo_financiamiento_id"=>"int",
                    ), $this->MySqlOptions);

		$this->createTable('telefono_organizacion', array(
                        "id" => "pk",
                        "organizacion_id"=>"int NOT NULL",
                        "telefono" => "varchar(255) NOT NULL DEFAULT ''",
                        "descripcion" => "varchar(255)",
                    ), $this->MySqlOptions);
		$this->createTable('farmaco', array(
                        "id" => "pk",
                        "nombre"=>"varchar(255) NOT NULL",
                        "presentacion" => "varchar(255)",
                        "clase_terapeutica_id" => "int",
                    ), $this->MySqlOptions);
		$this->createTable('clase_terapeutica', array(
                        "id" => "pk",
                        "nombre"=>"varchar(255) NOT NULL",
                    ), $this->MySqlOptions);

		$this->createTable('categoria_organizacion', array(
                        "id" => "pk",
                        "nombre" => "varchar(255) NOT NULL DEFAULT ''",
                        "descripcion" => "varchar(255)",
                    ), $this->MySqlOptions);

		$this->createTable('farmaco_actual_organizacion', array(
                        "id" => "pk",
                        "farmaco_id" => "int NOT NULL",
                        "organizacion_id" => "int NOT NULL",
                    ), $this->MySqlOptions);

		$this->createTable('modo_compra', array(
                        "id" => "pk",
                        "nombre" => "varchar(255) NOT NULL",
                    ), $this->MySqlOptions);
		$this->createTable('tipo_financiamiento', array(
                        "id" => "pk",
                        "nombre" => "varchar(255) NOT NULL",
                    ), $this->MySqlOptions);

		$this->createTable('farmaco_potencial_organizacion', array(
                        "id" => "pk",
                        "farmaco_id" => "int NOT NULL",
                        "organizacion_id" => "int NOT NULL",
                    ), $this->MySqlOptions);
		$this->createTable('visita', array(
                        "id" => "pk",
                        "organizacion_id" => "int NOT NULL",
                        "visitador_id" => "int NOT NULL",
                        "visitado_id" => "int NOT NULL",
                        "fecha_programada"=>"datetime NOT NULL",
                        "fecha_realizada"=>"datetime",
                        "notas"=>"text",
                    ), $this->MySqlOptions);
		$this->createTable('persona', array(
                        "id" => "pk",
                        "nombre" => "varchar(45) NOT NULL",
                        "apellido_p" => "varchar(45) NOT NULL",
                        "apellido_m" => "varchar(45) NOT NULL",
                        "fecha_nacimiento"=>"date",
                        "cargo"=>"varchar(255)",
                        "profesion"=>"varchar(255)",
                        "telefono1"=>"varchar(255)",
                        "telefono2"=>"varchar(255)",
                        "telefono3"=>"varchar(255)",
                        "email"=>"varchar(255)",
                        "twitter"=>"varchar(255)",
                        "facebook"=>"varchar(255)",
                        "hijos"=>"int",
                        "estado"=>"varchar(255)",
                        "situacion_familiar_id"=>"int",
                        "categoria_persona_id"=>"int",
                    ), $this->MySqlOptions);
		$this->createTable('situacion_familiar', array(
                        "id" => "pk",
                        "nombre" => "varchar(255) NOT NULL",
                    ), $this->MySqlOptions);
		$this->createTable('categoria_persona', array(
                        "id" => "pk",
                        "nombre" => "varchar(255) NOT NULL",
                        "descripcion" => "text",
                    ), $this->MySqlOptions);
		$this->createTable('recordatorio', array(
                        "id" => "pk",
                        "autor_id" => "int NOT NULL",
                        "destinatario_id" => "int NOT NULL",
                        "fecha_creacion" => "datetime NOT NULL",
                        "fecha_recordatorio" => "datetime NOT NULL",
                        "texto"=>"text NOT NULL",
                        "leido"=>"int DEFAULT 0",
                    ), $this->MySqlOptions);
		$this->createTable('plan_accion', array(
                        "id" => "pk",
                        "organizacion_id" => "int NOT NULL",
                        "user_id" => "int NOT NULL",
                        "fecha_desde" => "date NOT NULL",
                        "fecha_hasta" => "date NOT NULL",
                        "objetivo"=>"text NOT NULL",
                    ), $this->MySqlOptions);

		$this->addForeignKey('plan_accion_organizacion_id', 'plan_accion', 'organizacion_id', 'organizacion', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('plan_accion_user_id', 'plan_accion', 'user_id', 'tbl_users', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('presona_situacion_familiar_id', 'persona', 'situacion_familiar_id', 'situacion_familiar', 'id', 'SET NULL', 'CASCADE');
		$this->addForeignKey('categoria_persona_id', 'persona', 'categoria_persona_id', 'categoria_persona', 'id', 'SET NULL', 'CASCADE');
		$this->addForeignKey('recordatorio_autor_id', 'recordatorio', 'autor_id', 'tbl_users', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('recordatorio_destinatario_id', 'recordatorio', 'destinatario_id', 'tbl_users', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('telefono_organizacion_id', 'telefono_organizacion', 'organizacion_id', 'organizacion', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('categoria_organizacion_id', 'organizacion', 'categoria_id', 'categoria_organizacion', 'id', 'SET NULL', 'CASCADE');
		$this->addForeignKey('organizacion_modo_compra_id', 'organizacion', 'modo_compra_id', 'modo_compra', 'id', 'SET NULL', 'CASCADE');
		$this->addForeignKey('organizacion_tipo_financiamiento_id', 'organizacion', 'tipo_financiamiento_id', 'tipo_financiamiento', 'id', 'SET NULL', 'CASCADE');
		$this->addForeignKey('farmaco_potencial_organizacion_id', 'farmaco_potencial_organizacion', 'organizacion_id', 'organizacion', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('farmaco_actual_organizacion_id', 'farmaco_actual_organizacion', 'organizacion_id', 'organizacion', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('clase_terapeutica_farmaco_id', 'farmaco', 'clase_terapeutica_id', 'clase_terapeutica', 'id', 'SET NULL', 'CASCADE');
		$this->addForeignKey('farmaco_actual_farmaco_id', 'farmaco_actual_organizacion', 'farmaco_id', 'farmaco', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('farmaco_potencial_farmaco_id', 'farmaco_potencial_organizacion', 'farmaco_id', 'farmaco', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('visita_organizacion_id', 'visita', 'organizacion_id', 'organizacion', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('visita_visitado_id', 'visita', 'visitado_id', 'persona', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey('visita_visitador_id', 'visita', 'visitador_id', 'tbl_users', 'id', 'CASCADE', 'CASCADE');


                    
	}

	public function safeDown()
	{
		$this->dropTable('organizacion');
		$this->dropTable('telefono_organizacion');
		$this->dropTable('farmaco');
		$this->dropTable('clase_terapeutica');
		$this->dropTable('categoria_organizacion');
		$this->dropTable('farmaco_actual_organizacion');
		$this->dropTable('farmaco_potencial_organizacion');
		$this->dropTable('farmaco_potencial_organizacion');
		$this->dropTable('farmaco_potencial_organizacion');

		$this->dropTable('visita');
		$this->dropTable('persona');
		$this->dropTable('situacion_familiar');
		$this->dropTable('categoria_persona');
		$this->dropTable('recordatorio');
		$this->dropTable('plan_accion');



	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}