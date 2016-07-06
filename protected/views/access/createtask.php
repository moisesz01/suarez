<?php


$this->menu=array(
	array('label'=>'Listar Tarea', 'url'=>array('indextask')),
	array('label'=>'Gestión de Roles', 'url'=>array('index')),

);
?>

<div class="form">

<?php 

$form=$this->beginWidget('booster.widgets.TbActiveForm',array(
	'id'=>'access-form',
	'enableAjaxValidation'=>false,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); 

?>




<h1 class="titulo">Crear Tarea</h1>


	<p class="note">Los Campos con <span class="required">*</span> son requeridos.</p>
 
	<?php echo $form->errorSummary($model); ?>
	<?php echo $message; ?>

	<?php echo $form->textFieldGroup($model,'tarea',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	<?php echo $form->textFieldGroup($model,'descripcion',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	

	<div class="row buttons">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Aceptar',
		)); ?>
		
	</div>



<?php $this->endWidget(); ?>


</div><!-- form -->



