<?php
/* @var $this UsuariosController */
/* @var $dataProvider CActiveDataProvider */
 

$this->menu=array(
	array('label'=>'Crear un Rol', 'url'=>array('createrol')),
	array('label'=>'Tareas', 'url'=>array('indextask')),
	

);
?>
<div class="row">
	<h1 class="titulo">Roles</h1>	
</div>


<?php
$i=1;
if(!Yii::app()->user->CheckAccess('root')){
    unset($roles['root']);           
}

foreach ($roles as $r ) {


	?>


<div style=" width: 250px;  float: left;" class="persona">
			<?php 
		
			echo '<b>'.$r->NAME.'</b>';
			
			echo "<br>";

			 echo CHtml::link(CHtml::encode('Ver Detalle'), array('ViewRol', 'name'=>$r->name)); 
			
                          ?>
                         </div>
<div style="width: 8px; float: left; height: 5px;"></div>
 <?php
 if($i==3){ $i=0;
 ?><div class="espacio"></div>
     <?php
 }
    $i++; 
	}

	

	



	?>

 


