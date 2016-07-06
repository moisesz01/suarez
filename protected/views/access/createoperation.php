<?php


$this->menu=array(
array('label'=>'Listar Tareas', 'url'=>array('indextask')),


);
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
'id'=>'access-form',
'enableClientValidation'=>true,
'clientOptions'=>array(
	'validateOnSubmit'=>true,
),
)); 

?>

<h1 style="font-size: 18px;">
<b>Asignar Operaciones a Tarea <?php echo $parent; ?></b>
</h1>



<p class="note">Los campos con <span class="required">*</span> son requeridos.</p>

<?php echo $form->errorSummary($model); ?>
<?php echo $message; ?>
<div class="row">
	<?php echo $form->labelEx($model,'operacion'); ?>
	<?php echo $form->textField($model,'operacion',array('id'=>'operacion')); ?>
	<?php echo $form->error($model,'operacion'); ?>
</div>


<div class="row">
  <?php echo $form->labelEx($model,'descripcion'); ?>
  <?php echo $form->textArea($model,'descripcion',array('id'=>'descripcion')); ?>
  <?php echo $form->error($model,'descripcion'); ?>
</div>

<div class="row buttons">
	
	
	


  <?php 
                            echo CHtml::ajaxSubmitButton('Asingar',Yii::app()->createUrl('/Access/AssingAndCreateOperation',
                            	array("parent"=>$parent)),
                                    array(
                                       'type'=>'POST',
                                       "dataType" => "json",  
                                    //   'data'=>array('parent'=>$parent, 
                                                    
                                       //             ),
                                        'success' => 'js:function(data) { 
                                                if(data.result==="error"){
                                                    $("#errores").show();
                                                    $("#errores").html(data.msg);
                                                    alert("El Nombre de la operacion "+ data.hijo +" ya esta siendo usado.");
                                                }
                                                if(data.result==="success"){
                                                  $("#operacion").val("");   
                                                  $("#descripcion").val(""); 
                                                  
                                                  var tds = "<tr id="+data.hijo+">";
                                                  tds += "<td>"+data.hijo+"</td>";
                      							  tds += "<td>"+data.des+"</td>";
                      							  tds += "</tr>";
                      							  $("#grilla").append(tds);

                                                  
                                                }
                                             

                                                }',
                                               
                                        ),

                                    array('class'=>'boton', 'size'=>'200'))?>


                                    <?php echo CHtml::link('Finalizar' ,array('access/ViewTarea','name'=>$parent), array('class'=>'boton')); ?>

</div>









    <table id="grilla" class="grilla">
          <thead>
                <tr>
                    <th class="esquinaizq">Nombre</th>
                    <th  class="esquinader">Descripcion</th>
                   
                    
                    
                </tr>
            </thead>
            <tbody>
               
            </tbody>                
        </table> 



<?php $this->endWidget(); ?>


</div><!-- form -->



