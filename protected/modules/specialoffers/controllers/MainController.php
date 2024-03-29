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

	public function actionIndex(){
		Yii::app()->getModule('apartments');
		
		$criteria = new CDbCriteria;
		$criteria->condition = 'active=1 AND is_special_offer = 1';

        if(isset($_POST['is_ajax'])){
            $this->renderPartial('index', array(
                'criteria' => $criteria,
            ), false, true);
        }else{
            $this->render('index', array(
                'criteria' => $criteria,
            ));
        }
	}
}