<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class Access extends CFormModel
{
	public $rol;
	public $tarea;
	public $operacion;
	public $email;
	public $respuesta;
	public $descripcion;
	

	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('rol, tarea, operacion, email, respuesta, descripcion', 'required'),
					);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'rol'=>'Nombre de Rol',
			'tarea'=>'Nombre de Tarea',
			'operacion'=>'Nombre de Operación',
			'email'=>'Username',
			'descripcion'=>'Descripción',
		);
	}
}