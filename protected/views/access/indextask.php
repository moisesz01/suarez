<?php
/* @var $this UsuariosController */
/* @var $dataProvider CActiveDataProvider */

 

$this->menu=array(
	array('label'=>'Crear una Tarea', 'url'=>array('createtask')),
	array('label'=>'Gestión de Roles', 'url'=>array('index')),
	

);
?>
<div class="row">
<h1 class="titulo">Tareas</h1>	
</div>



<?php	
$i=1;
foreach ($task as $t ) { ?>
<div style=" width: 250px;  float: left;" class="persona">
			<?php 
			echo $t->name;
			
			echo "<br>";

			 echo CHtml::link(CHtml::encode('Ver Detalle'), array('ViewTarea', 'name'=>$t->name)); 
			 echo "</br>";
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

 


