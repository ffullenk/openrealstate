<?php
$this->pageTitle=Yii::app()->name . ' - '.Yii::t('common','Login');
$this->breadcrumbs=array(
	Yii::t('common','Login')
);
?>

<h1><?php echo Yii::t('common', 'Login'); ?></h1>

<p><?php echo Yii::t('common', 'Already used our services? Please fill out the following form with your login credentials'); ?>:</p>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>false,
	/*'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),*/
)); ?>

	<p class="note"><?php echo Yii::t('common', 'Fields with <span class="required">*</span> are required.'); ?></p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe'); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row">
		<?php if(param('useUserads')): ?> <?php echo CHtml::link(tt("Join now"), 'register'); ?> | <?php endif; ?> <?php echo CHtml::link(tt("Forgot password?"), 'recover'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('common', 'Login')); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<?php $this->widget('ext.eauth.EAuthWidget', array('action' => 'site/login')); ?>
