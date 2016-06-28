<?php
$this->breadcrumbs=array(
	'Chats'=>array('index'),
	'Manage',
);

$this->menu=array(
array('label'=>'List Chat','url'=>array('index')),
array('label'=>'Create Chat','url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('chat-grid', {
data: $(this).serialize()
});
return false;
});
");
?>

<h1>Manage Chats</h1>

<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('booster.widgets.TbGridView',array(
'id'=>'chat-grid',
'dataProvider'=>$model->search(),
'filter'=>$model,
'columns'=>array(
		'id_chat',
		'descripcion',
		'id',
		'archivo',
		 array( 
                   'name'=>'imagen', 
                   'type'  => 'image', 
                   'value'=>Yii::app()->request->baseUrl.'/protected/imagenes/chat/'.$model->imagen, 
                   'htmlOptions'=>array('style'=>'width: 200px; height: 200px'), 
               ), 
array(
'class'=>'booster.widgets.TbButtonColumn',
),
),
)); ?>
