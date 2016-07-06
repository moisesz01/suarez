<?php
/*use model\usuario;*/
class AccessController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','RemoveAndDeleteChild','view','DeleteTask','DeleteRol','Secret','Remember','ViewTarea','ViewRol','RemoveChild','NewPassword'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','createrol','CreateTask',
				'AssingAndCreateOperation','AssingOperation','obtener'),
				'expression'=>'Yii::app()->user->checkAccess("admin")',
				//'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','IndexTask'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
			);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

	}


	public function actionDeleteTask($name)
	{
		$auth=Yii::app()->authManager;
		$hijos = $auth->getItemChildren($name);
		foreach ($hijos as $h) {

			$auth->removeItemChild($name,$h->name);
			$auth->removeAuthItem($h->name);

		}
		$auth->removeAuthItem($name);		
		$this->redirect(array('indextask'));

	}


	public function actionDeleteRol($name)
	{
		$existe=false;
		$auth=Yii::app()->authManager;
		$user= USUARIOS::model()->findAll();
		foreach ($user as $s) {
			if($auth->isAssigned($name,$s->id_usuario)){
				$existe = true;
			}
		}
		if(!$existe){

			$hijos = $auth->getItemChildren($name);
			foreach ($hijos as $h) {
				$auth->removeItemChild($name,$h->name);
	 		}
			$auth->removeAuthItem($name);
			$this->redirect(array('index'));

		}else{

			Yii::app()->user->setFlash('error', 
				"El Rol no se puede eliminar ya que encuentra asignadoa un Usuario"
			);
			$this->redirect(array('ViewRol','name'=>$name));
		}

	}


	public function actionRemoveChild(){

		$parent = $_POST['parent'];
		$child = $_POST['child'];
		$auth=Yii::app()->authManager;
		$auth->removeItemChild($parent,$child);
		echo "Se elimino con Exito";
		
	}


	public function actionRemoveAndDeleteChild(){

		$parent = $_POST['parent'];
		$child = $_POST['child'];
		$auth=Yii::app()->authManager;
		$auth->removeItemChild($parent,$child);
		$auth->removeAuthItem($child);
		echo "Se elimino con Exito";
			
	}


	public function actionViewTarea($name)
	{

		$auth=Yii::app()->authManager; 
		$hijos = $auth->getItemChildren($name);
		$this->render('detalle_tarea',
			array(
				'hijos'=>$hijos,
				'padre'=>$name,
			)
		);
	}


	public function actionViewRol($name)
	{

		$auth=Yii::app()->authManager; 
  		$criteria=new CDbCriteria();			
		$hijos = $auth->getItemChildren($name);
		$count = count($hijos);	
		$dataProvider = new CArrayDataProvider(
			$hijos,
			array('keyField' => 'name',
				'totalItemCount' => $count,
				'pagination'=>array(
					'pageSize' => 5
				)
			)
		);		
		$this->render('detalle_rol',
			array(
				'hijos'=>$hijos,
				'padre'=>$name,
				'dataProvider'=>$dataProvider,
			)
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{	

	}

	public function actionCreateRol()
	{		

		$message="";
		$auth=Yii::app()->authManager; 
		$model = new Access;

		if(isset($_POST['Access'])){

			$model->attributes=$_POST['Access'];

			if(!$auth->getAuthItem($model->rol)){

				$auth->createRole($model->rol);
				
				$this->redirect(
					array(
						'AssingOperation',
						'parent'=>$model->rol,
						));

			}else{
                Yii::app()->user->setFlash('notice', "El nombre del Rol ingresado ya esta siendo usado");				
				$model->rol ="";

			}
		}

		$this->render('createrol',array('model'=>$model,
			'message'=>$message,
		));


	}

	public function actionCreateTask()
	{		

		$message="";
		$auth=Yii::app()->authManager; 
		$model = new Access;

		if(isset($_POST['Access'])){

			$model->attributes=$_POST['Access'];
			$model->tarea = $model->tarea.".";
			$new_operation =  trim($model->tarea, '.');

			if(!$auth->getAuthItem($model->tarea)){

				$bizRule='return Yii::app()->user->id==$params["post"];';


				$auth->createTask($model->tarea, $model->descripcion,$bizRule);
				$auth->createOperation($new_operation, $model->descripcion,$bizRule);

				$this->redirect(
					array(
						'AssingAndCreateOperation',
						'parent'=>$model->tarea
					)
				);

			}else{

				$message="El Nombre de Tarea Ya esta siendo usado";	
				$model->tarea ="";
				$model->descripcion ="";

			}

		}


		$this->render('createtask',
			array(
				'model'=>$model,
				'message'=>$message,
			)
		);


	}


	public function actionAssingAndCreateOperation($parent)
	{	

		$message="";
		$auth=Yii::app()->authManager; 
		$model = new Access;

		if(isset($_POST['Access'])){

			$model->attributes=$_POST['Access'];

			if(!$auth->getAuthItem($model->operacion)){

				$auth->createOperation($model->operacion, $model->descripcion);
				$task = $auth->getAuthItem($parent);
				$task->addChild($model->operacion);
				exit(json_encode(array('result' => 'success','hijo'=>$model->operacion,'des'=>$model->descripcion,)));

			}else{

				$message="El Nombre de la Operacion Ya esta siendo usado";	
				$model->operacion ="";
				$model->descripcion ="";
				exit(json_encode(array('result' => 'error','hijo'=>$model->operacion,'des'=>$model->descripcion,)));

			}
		}

		$this->render('createoperation',
			array(
				'model'=>$model,
				'message'=>$message,
				'parent'=>$parent,
			)
		);

	}


	public function actionAssingOperation($parent)
	{	

		$hijos =  array();
		$des = array();
		$message="";
		$auth=Yii::app()->authManager; 
		$model = new Access;

		if(isset($_POST['Access'])){

			$items = $_POST['Access'];

			foreach ($items as $i => $item) {
				
				if(isset($_POST['Access'][$i])){

					if(isset($_POST['Access'][$i]['tarea'])) {

						$new_operation = $_POST['Access'][$i]['tarea'];	
						$new_operation =  trim($new_operation, '.');

						if($auth->getAuthItem($_POST['Access'][$i]['tarea'])) {

							if(!$auth->hasItemChild($parent,$new_operation)) {								
								$rol = $auth->getAuthItem($parent);	
								$rol->addChild($new_operation);
								array_push($hijos,$new_operation);
							}

						}else{

							$rol = $auth->getAuthItem($parent);	
							$rol->addChild($new_operation);
							array_push($hijos,$new_operation);

						} 

					}
					if(isset($_POST['Access'][$i]['operacion'])) {


						$_POST['Rol'][$i]['name']= "dgdf";
						$_POST['Rol'][$i]['taks']= "algo";


						if($auth->getAuthItem($_POST['Access'][$i]['operacion'])){

							if(!$auth->hasItemChild($parent,$_POST['Access'][$i]['operacion'])){


							$rol = $auth->getAuthItem($parent);	
							$rol->addChild($_POST['Access'][$i]['operacion']);
							array_push($hijos,$_POST['Access'][$i]['operacion']);

						}else{

							exit(json_encode(array('result' => 'error','message'=>"La Operación ".$_POST['Access'][$i]['operacion']." ya se encuentra asignada.",'hijo'=>$hijos,)));

						}


						} 




					}
					
				}


				
			}

			exit(json_encode(array('result' => 'success','hijo'=>$hijos,)));

		}


		$this->render('asignar',array('model'=>$model,
			'message'=>$message,
			'parent'=>$parent,
		));

	}










	public function actionobtener($parent, $role){
		$respuesta = array();
        $auth=Yii::app()->authManager; 
		$resp = $auth->getItemChildren($parent);

 

		foreach ($resp as $son) {
			

			if($auth->hasItemChild($role, $son->name)){

			 	$retorno = $son->name." true";
			 	array_push($respuesta,$retorno);
			 	 
			}else{

				array_push($respuesta,$son->name." false");

			}
			 
		}

	
		header("Content-type: application/json");
		echo CJSON::encode($respuesta);
	}



	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{

	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$auth=Yii::app()->authManager;
		$roles = $auth->getRoles();
		$this->render('index',array(
			'roles'=>$roles,
		));
	}


	public function actionIndexTask()
	{
		$auth=Yii::app()->authManager;
		$task = $auth->getTasks();

		$this->render('indextask',array(
			'task'=>$task,
			));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{

	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Usuarios the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{

	}

	/**
	 * Performs the AJAX validation.
	 * @param Usuarios $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='access-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
