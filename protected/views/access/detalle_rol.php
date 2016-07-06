<?php
 

 

$this->menu=array(
	array('label'=>'Listar Roles', 'url'=>array('index')),
	array('label'=>'Agregar Operaciones', 'url'=>array('AssingOperation','parent'=>$padre)),
  array('label'=>'Eliminar Rol', 'url'=>'#', 'linkOptions'=>array('submit'=>array('DeleteRol','name'=>$padre),'confirm'=>'¿Esta seguro de eliminar este Rol?')),
	
	

);
?>

<h1 class="titulo">Operaciones del Rol: <?php echo $padre; ?> </h1> 




		
		  <?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
        echo "<br/>";
    }
    ?>


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
                    <td style="width: 100px;"></td>
                    <td style="width: 30px;"><?php  

                    echo CHtml::ajaxLink(
  "Eliminar",
  Yii::app()->createUrl( 'Access/RemoveChild' ),
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



	
