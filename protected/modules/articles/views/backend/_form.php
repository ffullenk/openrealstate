<div class="form">

    <?php $form=$this->beginWidget('CustomForm', array(
        'id'=>$this->modelName.'-form',
        'enableAjaxValidation'=>false,
    )); ?>

	<p class="note"><?php Yii::t('common', 'Fields with <span class="required">*</span> are required.');?></p>

	<?php echo $form->errorSummary($model); ?>

    <?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'page_title',
            'type' => 'string',
    	));
    ?>
    <br/>
	
    <?php
    $this->widget('application.modules.lang.components.langFieldWidget', array(
    		'model' => $model,
    		'field' => 'page_body',
            'type' => 'text-editor'
    	));
    ?>
	
    <div class="clear"></div>
    <br>

	<div class="rowold buttons">
        <?php $this->widget('bootstrap.widgets.BootButton',
                    array('buttonType'=>'submit',
                        'type'=>'primary',
                        'icon'=>'ok white',
                        'label'=> $model->isNewRecord ? tc('Add') : tc('Save'),
                    )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->