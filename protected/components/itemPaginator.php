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

class itemPaginator extends CLinkPager {
    public $htmlOption = array();

	public function init(){
		$this->cssFile = Yii::app()->request->baseUrl.'/css/pager.css';
		parent::init();
	}

    protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? self::CSS_HIDDEN_PAGE : self::CSS_SELECTED_PAGE);
			if ($hidden)
				return '<li class="'.$class.'">'.CHtml::link($label, 'javascript: void(0);', $this->htmlOption).'</li>';
			else
				return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page), $this->htmlOption).'</li>';
	}
}