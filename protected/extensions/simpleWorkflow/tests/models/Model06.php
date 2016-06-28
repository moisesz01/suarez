<?php
class Model06 extends SWActiveRecord {

	public static function model($className=__CLASS__){
		return parent::model($className);
	}
	public function tableName(){
		return 'item';
	}

	public function rules()
	{
		return array(
			array('status','SWValidator'),	// mandatory
		);
	}
	public function behaviors()
	{
		return array(
			'swBehavior' => array(
				'class'      		=> 'application.tests.behaviors.Custom01SWBehavior',
				'autoInsert' 		=> false,
				'defaultWorkflow' 	=> 'workflow1'
			)
		);
	}
}

?>