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

class MainController extends ModuleUserController{
	public $modelName = 'Menu';

	public function actions() {
		return array(
			'captcha' => array(
				'class' => 'MathCCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	public function actionIndex(){
		if(Yii::app()->user->getState("isAdmin")){
			$this->redirect(array('/menumanager/backend/main/admin'));
			return;
		}
		$this->redirect(array('/site/index'));
	}

	public function actionView($id){
		$model = $this->loadModel($id);
		if($model){
			if(Yii::app()->request->getParam('is_ajax')){
				$this->renderPartial('/view', array('model' => $model), false, true);
			}else{
				$this->render('/view', array('model' => $model));
			}
		} else {
			Yii::app()->user->setFlash('error', 'Страница не найдена.');
			$this->redirect(array('/site/index'));
		}
	}
}