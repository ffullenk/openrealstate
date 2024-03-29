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

class MainController extends ModuleAdminController{
	public $modelName = 'Comment';

	public function actionIndex(){
		$model = new $this->modelName;
		$model = $model->resetScope();

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionApprove($id){
		$comment=$this->loadModel($id);
		if($comment->active != Comment::STATUS_APPROVED){
			$comment->active = Comment::STATUS_APPROVED;
			$comment->update(array('status'));
		}
		$this->redirect(array('index'));
	}

	public function actionView($id){
		$this->redirect(array('index'));
	}

}
