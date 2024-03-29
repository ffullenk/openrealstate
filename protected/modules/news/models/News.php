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

class News extends ParentModel {
	public $title;
	public $dateCreated;

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return '{{news}}';
	}

	public function rules() {
		return array(
			array('title, body', 'i18nRequired'),
			array('title', 'i18nLength', 'max' => 128),
			array($this->getI18nFieldSafe(), 'safe'),
		);
	}

    public function i18nFields(){
        return array(
            'title' => 'varchar(255) not null',
            'body' => 'text not null',
        );
    }

    public function getTitle(){
        return $this->getStrByLang('title');
    }

    public function getBody(){
        return $this->getStrByLang('body');
    }

	public function relations() {

		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => 'ID',
			'title' => tt('News title', 'news'),
			'body' => tt('News body', 'news'),
			'date_created' => tt('Creation date', 'news'),
			'dateCreated' => tt('Creation date', 'news'),
		);
	}

	public function getUrl() {
		return Yii::app()->createAbsoluteUrl('/news/main/view', array(
			'id' => $this->id,
			//'title' => $this->title,
		));
	}

	public function search() {
		$criteria = new CDbCriteria;

        $titleField = 'title_'.Yii::app()->language;
		$criteria->compare($titleField, $this->$titleField, true);
        $bodyField = 'body_'.Yii::app()->language;
		$criteria->compare($bodyField, $this->$bodyField, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort' => array(
				'defaultOrder' => 'date_created DESC',
			),
			'pagination' => array(
				'pageSize' => param('adminPaginationPageSize', 20),
			),
		));
	}

	public function behaviors(){
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'date_created',
				'updateAttribute' => 'date_updated',
			),
		);
	}
	
	protected function afterFind() {
		$dateFormat = param('newsModule_dateFormat', 0) ? param('newsModule_dateFormat') : param('dateFormat', 'd.m.Y H:i:s');
		$this->dateCreated = date($dateFormat, strtotime($this->date_created));

		return parent::afterFind();
	}

	public function getAllWithPagination($inCriteria = null){
		if($inCriteria === null){
			$criteria = new CDbCriteria;
			$criteria->order = 'date_created DESC';
		} else {
			$criteria = $inCriteria;
		}

		$pages = new CPagination($this->count($criteria));
		$pages->pageSize = param('module_news_itemsPerPage', 10);
		$pages->applyLimit($criteria);

		$dependency = new CDbCacheDependency('SELECT MAX(date_updated) FROM {{news}}');

		$items = $this->cache(param('cachingTime', 1209600), $dependency)->findAll($criteria);

		return array(
			'items' => $items,
			'pages' => $pages,
		);
	}
	
	public static function getRel($id, $lang){
		$model = self::model()->resetScope()->findByPk($id);

		$title = 'title_'.$lang;
		$model->title = $model->$title;

		return $model;
	}
}