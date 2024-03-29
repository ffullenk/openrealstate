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

class UserAds extends Apartment {
	
	public function search() {

		$criteria = new CDbCriteria;
		$tmp = 'title_'.Yii::app()->language;

		$criteria->compare('id', $this->id);
		$criteria->compare($tmp, $this->$tmp, true);
        $criteria->compare('city_id', $this->city_id);
		$criteria->addCondition('owner_id = '.Yii::app()->user->id);

		if($this->active === '0' || $this->active){
			$criteria->addCondition('active = :active');
			$criteria->params[':active'] = $this->active;
		}

		if($this->owner_active === '0' || $this->owner_active){
			$criteria->addCondition('owner_active = :active');
			$criteria->params[':active'] = $this->owner_active;
		}

		if($this->type){
			$criteria->addCondition('type = :type');
			$criteria->params[':type'] = $this->type;
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array('defaultOrder'=>'id DESC'),
			'pagination'=>array(
				'pageSize'=>param('userPaginationPageSize', 20),
			),
		));
	}

	public static function returnStatusHtml($data, $tableId, $onclick = 0, $ignore = 0){
		if($ignore && $data->id == $ignore){
			return '';
		}

		$name = tc('Inactive');
		if ($data->active == Apartment::STATUS_MODERATION) {
			$name = tc('Awaiting moderation');
		}
		elseif ($data->active == Apartment::STATUS_ACTIVE) {
			$name = tc('Active');
		}
		return '<div align="center">'.$name.'</div>';

	}

	public static function returnStatusOwnerActiveHtml($data, $tableId, $onclick = 0, $ignore = 0){
		if($ignore && $data->id == $ignore){
			return '';
		}
		$url = Yii::app()->controller->createUrl("activate", array("id" => $data->id, 'action' => ($data->owner_active==1?'deactivate':'activate') ));
		$img = CHtml::image(
					Yii::app()->request->baseUrl.'/images/'.($data->owner_active?'':'in').'active.png',
					Yii::t('common', $data->owner_active?'Inactive':'Active'),
					array('title' => Yii::t('common', $data->owner_active?'Deactivate':'Activate'))
				);
		$options = array();
		if($onclick){
			$options = array(
				'onclick' => 'ajaxSetStatus(this, "'.$tableId.'"); return false;',
			);
		}
		return '<div align="center">'.CHtml::link($img,$url, $options).'</div>';
	}

	public function beforeSave(){
		if(!$this->isNewRecord && $this->owner_id != Yii::app()->user->id){
			throw404();
		}
		return parent::beforeSave();
	}
}