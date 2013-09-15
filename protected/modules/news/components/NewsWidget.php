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

class NewsWidget extends CWidget {

	public $usePagination = 1;

	public function getViewPath($checkTheme=false){
		return Yii::getPathOfAlias('application.modules.news.views');
	}

	public function run() {
		$news = new News;
		$result = $news->getAllWithPagination();
		
		$this->render('widgetNews_list', array(
			'news' => $result['items'],
			'pages' => $result['pages'],
		));
	}
}