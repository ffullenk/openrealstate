<?php
/**********************************************************************************************
*                            Open Real Estate CMS
*                              -----------------
*	version				:	1.3.3
*	copyright			:	(c) 2012 Monoray
*	website				:	http://monoray.net/
*	website				:	http://monoray.net/contact
*
* This file is part of Open Real Estate CMS
*
* Open Real Estate is free software. This work is licensed under a GNU GPL.
* http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*
* Open Real Estate is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
* Without even the implied warranty of  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
***********************************************************************************************/

class MainController extends ModuleAdminController {
	public $modelName = 'User';
	
	public function actionIndex(){
		
		$model=$this->loadModel(Yii::app()->user->id);

		if(isset($_POST[$this->modelName])){
			$model->scenario = 'changeAdminPass';

			$model->old_password = $_POST[$this->modelName]['old_password'];
			if($model->validatePassword($model->old_password)){
				$model->attributes=$_POST[$this->modelName];
				if($model->validate()){
					$model->setPassword();
					$model->save(false);
					Yii::app()->user->setFlash('success', Yii::t('module_usercpanel', 'Your password successfully changed.'));
					$this->redirect(array('index'));
				}
			} else {
				Yii::app()->user->setFlash('error', Yii::t('module_adminpass', 'Wrong admin password! Try again.'));
				$this->redirect(array('index'));
			}
		}
		$this->render('index', array('model' => $model));
	}
}