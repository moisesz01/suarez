<?php
 

 

$this->menu=array(
	array('label'=>'Listar Tareas', 'url'=>array('IndexTask')),
	array('label'=>'Agregar Operaciones', 'url'=>array('AssingAndCreateOperation','parent'=>$padre)),
  array('label'=>'Eliminar Tarea', 'url'=>'#', 'linkOptions'=>array('submit'=>array('DeleteTask','name'=>$padre),'confirm'=>'¿Esta seguro de eliminar esta Tarea?')),
	array('label'=>'Gestión de Roles', 'url'=>array('index')),
	);
?>

<h1 class="titulo">Operaciones de la tarea: <?php echo $padre; ?></h1>

		
		


 <table id="grilla" class="grilla">
          <thead>
                <tr>
                    <th class="esquinaizq">Nombre</th>
                    <th  class="">Descripcion</th>
                    <th  class="esquinader">Eliminar</th>
                   
                    
                    
                </tr>
            </thead>
            <tbody>
<?php foreach ($hijos as $h)
	{	
?>
                
                <?php echo "<tr id=".$h->name.">"; ?>
                    <td><?php echo $h->name;?></td>
                    <td style="width: 100px;"><?php echo $h->description; ?></td>
                    <td style="width: 30px;"><?php  

                    echo CHtml::ajaxLink(
  "Eliminar",
  Yii::app()->createUrl( 'Access/RemoveAndDeleteChild' ),
  array( // ajaxOptions
    'type' => 'POST',
    'beforeSend' => "function( request )
                     {
                       // Set up any pre-sending stuff like initializing progress indicators
                     }",
    'success' => "function( data )
                  {
                    // handle return data
                    alert( data );
                    window.location.reload();
                    $(this).parent().hide();
                    
                  }",
    'data' => array( 'parent' => $padre, 'child' => $h->name )
  ),
  array( //htmlOptions
    //'href' => Yii::app()->createUrl( 'myController/ajaxRequest' ),
    'class' => 'class'
  )
);



                    ?></td>
                     
                </tr>


                <?php 
	}

?>
            </tbody>                
        </table> 



	
