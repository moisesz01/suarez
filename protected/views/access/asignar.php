<?php 
  function to_s($item) { return $item->getName();  }	
?>
<?php


$this->menu=array(
	array('label'=>'Listar Rol', 'url'=>array('index')),
	

);
?>

<script type="text/javascript">

var n =0;
</script>

<div class="form">



<h1 style="font-size: 18px;">
<b>Asignar permisos al rol <span id='role'><?php echo $parent;?></span></b>
</h1>


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'access-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

  
	<p class="note">Todos los Campos con <span class="required">*</span> son requeridos.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div id="contenedor">

	<div class="row">
		 
		 <?php echo $form->labelEx($model,'[0]tarea'); ?>
	     <?php echo $form->dropDownList($model,'[0]tarea',array_map('to_s', Yii::app()->authManager->getTasks()),array('empty'=>'Seleccione Tarea','id'=>'combo1','class'=>'target')); ?>
	     <?php echo $form->error($model,'[0]tarea'); ?>


		  

 	</div>


	 


	 
   
   </div>


	


	<script>




	$("#contenedor").on("change",".target",function(){

		n=0;
		$("div .filas").remove();

		var opcionSeleccionada = $(this);			 
		var idcategoria = opcionSeleccionada.val();

		var roles = document.getElementById('role').innerHTML;
		

		var divPadre = document.createElement('div');
		divPadre.class="filas";

		var contenedor = document.getElementById("contenedor");
		
		 
		 
		
		
		  var action = '<?php echo CController::createUrl('/Access/obtener');?>';

		 
		$('#reportarerror').html("");

		$.getJSON(action, {parent:idcategoria , role:roles}, function(listaJson) {
			



	 
			
			$.each(listaJson, function(key,value) {
				
				 

				//	alert(value);
				 agregarcheck(value);

				// contenedor.appendChild(divs);

				 //alert(key);
				
			});
				 	
				 	 	 
		
		}).error(function(e){ $('#reportarerror').html(e.responseText); });		
	});



function agregarcheck(key){

	var checkbox = document.createElement('input');
	checkbox.type = 'checkbox';
	checkbox.name = 'Access['+n+'][operacion]';
	

	var search = key.search("true");

	if(search !=-1){
		checkbox.checked = true;
		key = key.replace("true","");
		checkbox.disabled=true;
	}else{
		
		checkbox.checked = false;
		key = key.replace("false","");
	} 

	checkbox.value = key.trim();


	

	var label = document.createElement('label')
	label.appendChild(document.createTextNode(key));
	
	var hijo = $("<div class='filas'>"+key+" </div>");

	var hijo = $("<div/>");
	hijo.addClass("filas");

	hijo.append(label);
	hijo.append(checkbox);

	

	$("#contenedor").append(hijo);

	 n++;


	
 
	}
</script>

 

<div style="clear: both;"></div>

	<div class="row buttons">
		 <?php 
                            echo CHtml::ajaxSubmitButton('Asignar',Yii::app()->createUrl('/Access/AssingOperation',
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
													for (var i=0; i<data.hijo.length; i++)
  													{
  											      var tds = "<tr id="+data.hijo+">";
                                                  tds += "<td>"+data.hijo[i]+"</td>";
                      							  
                      							  tds += "</tr>";
                      							  $("#grilla").append(tds);
  													}


                                                    alert(data.message);
                                                }
                                                if(data.result==="success"){
                                                  

                                                  
                                                  
                                                  for (var i=0; i<data.hijo.length; i++)
  													{
  											      var tds = "<tr id="+data.hijo+">";
                                                  tds += "<td>"+data.hijo[i]+"</td>";
                      							  
                      							  tds += "</tr>";
                      							  $("#grilla").append(tds);
  													}

                                                

                                                  
                                                }
                                             

                                                }',
                                               
                                        ),

                                    array('class'=>'btn btn-primary colYellow', 'size'=>'200'))?>

                                     <?php echo CHtml::link('Finalizar' ,array('Access/ViewRol','name'=>$parent), array('class'=>'btn btn-warning')); ?>

	</div>

<?php $this->endWidget(); ?>

 <table id="grilla" class="grilla">
          <thead>
                <tr>
                    <th class="esquinaizq">Nombre</th>
                    
                   
                    
                    
                </tr>
            </thead>
            <tbody>
              
            </tbody>                
        </table> 


</div><!-- form -->