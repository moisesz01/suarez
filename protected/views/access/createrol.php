<?php


$this->menu=array(
	array('label'=>'Listar Rol', 'url'=>array('index')),
	

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
<?php
Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".flash-notice").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>

<h1 class="titulo">Crear Rol</h1>	



	<p class="note">Todos los Campos con <span class="required">*</span> son requeridos.</p>
 
	<?php echo $form->errorSummary($model); ?>
        <?php if(Yii::app()->user->hasFlash('notice')):?>
        <div class="flash-notice" style=" width: 300px; height: 30px; font-weight: bold; padding: 5px;">
        <?php echo Yii::app()->user->getFlash('notice'); ?>
    </div>
<?php endif; ?>
	<div class="row">
		<?php echo $form->textFieldGroup($model,'rol',array('widgetOptions'=>array('htmlOptions'=>array('class'=>'span5')))); ?>
	</div>
	

	<div class="row buttons">
		<?php $this->widget('booster.widgets.TbButton', array(
			'buttonType'=>'submit',
			'context'=>'primary',
			'label'=>'Aceptar',
		)); ?>
		
	</div>



<?php $this->endWidget(); ?>


</div><!-- form -->



