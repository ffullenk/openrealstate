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

class ModuleUserController extends Controller{
	public $cityActive;

	public $layout='//layouts/inner';
	public $params = array();
	private $_model;
	public $modelName;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.'.$this->getModule($this->id)->getName().'.views');
	}

	public function beginWidget($className,$properties=array()){
		if($className == 'CustomForm'){
			$className = 'CActiveForm';
		}
		if($className == 'CustomGridView'){
			$className = 'CGridView';
		}
		return parent::beginWidget($className,$properties);
	}

	public function  widget($className,$properties=array(),$captureOutput=false){
		if($className == 'bootstrap.widgets.BootButton'){
			if(isset($properties['htmlOptions'])){
				return CHtml::submitButton($properties['label'], $properties['htmlOptions']);
			} else {
				return CHtml::submitButton($properties['label']);
			}
		}

	    return parent::widget($className,$properties,$captureOutput);
	}

	public function filters(){
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules(){
		return array(
			array(
				'allow',
				'users'=>array('*'),
			),
		);
	}

	public function init(){
		parent::init();
		$this->cityActive = SearchForm::cityInit();
	}

	public function actionView($id){
		if(Yii::app()->user->getState('isAdmin')){
			$this->redirect(array('backend/main/view', 'id' => $id));
		}
		$this->render('view',array(
			'model'=>$this->loadModel($id, 1),
		));
	}

	public function actionIndex(){
		$dataProvider=new CActiveDataProvider($this->modelName);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id = null, $resetScope = 0) {
		if($this->_model===null) {
			if($id == null){
				if(isset($_GET['id'])) {
					$model = new $this->modelName;
					if($resetScope){
						$this->_model=$model->resetScope()->findByPk($_GET['id']);
					}else{
						$this->_model=$model->findByPk($_GET['id']);
					}
				}
			}
			else{
				$model = new $this->modelName;
				if($resetScope){
					$this->_model=$model->resetScope()->findByPk($id);
				}else{
					$this->_model=$model->findByPk($id);
				}
			}

			if($this->_model===null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		return $this->_model;
	}

	public function loadModelWith($with) {
		if($this->_model===null) {
			if(isset($_GET['id'])) {
				$model = new $this->modelName;
				$this->_model = $model->with($with)->findByPk($_GET['id']); //findByPk($_GET['id']);
			}
			if($this->_model===null){
				throw new CHttpException(404,'The requested page does not exist.');
			}
		}
		return $this->_model;
	}


	protected function performAjaxValidation($model){
		if(isset($_POST['ajax']) && $_POST['ajax']===$this->modelName.'-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}