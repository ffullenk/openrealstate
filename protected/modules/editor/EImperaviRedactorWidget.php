<?php

/**
 * EImperaviRedactorWidget class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @link http://code.google.com/p/yiiext/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

/**
 * EImperaviRedactorWidget adds {@link http://imperavi.ru/redactor/ imperavi redactor} as a form field widget.
 *
 * Usage:
 * <pre>
 * $this->widget('ext.yiiext.widgets.imperaviRedactor.EImperaviRedactorWidget',array(
 *     // you can either use it for model attribute
 *     'model'=>$my_model,
 *     'attribute'=>'my_field',
 *     // or just for input field
 *     'name'=>'my_input_name',
 *     // imperavi redactor {@link http://imperavi.ru/redactor/docs/ options}
 *     'options'=>array(
 *         'toolbar'=>'classic',
 *         'cssPath'=>Yii::app()->theme->baseUrl.'/css/',
 *     ),
 * ));
 * </pre>

 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.3
 * @package yiiext.widgets.imperaviRedactor
 * @link http://imperavi.ru/redactor/
 */
class EImperaviRedactorWidget extends CInputWidget {

	/**
	 * @var string URL where to look imperavi redactor assets.
	 */
	public $assetsUrl;
	/**
	 * @var string imperavi redactor script name.
	 */
	public $scriptFile;
	/**
	 * @var string imperavi redactor stylesheet.
	 */
	public $cssFile;
	/**
	 * @var array imperavi redactor {@link http://imperavi.ru/redactor/docs/ options}.
	 */
	public $options = array();

	/**
	 * Init widget.
	 */
	public function init() {
		list($this->name, $this->id) = $this->resolveNameId();

		if ($this->assetsUrl === null)
			$this->assetsUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/assets', false, -1, YII_DEBUG);

		if ($this->scriptFile === null)
			$this->scriptFile = $this->assetsUrl.'/'.(YII_DEBUG ? 'redactor.js' : 'redactor.min.js');

		if ($this->cssFile === null)
			$this->cssFile = $this->assetsUrl.'/css/editor.css';

		$this->registerClientScript();
	}

	/**
	 * Run widget.
	 */
	public function run() {
		if ($this->hasModel())
			echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
		else
			echo CHtml::textArea($this->name, $this->value, $this->htmlOptions);
	}

	/**
	 * Register CSS and Script.
	 */
	protected function registerClientScript() {
		if (!isset($this->options['path'])) {
			$this->options['path'] = rtrim($this->assetsUrl, '/\\').'/';
		}

		if (!isset($this->options['imageUpload'])) {
			$this->options['imageUpload'] = CHtml::normalizeUrl(array('/photo_upload?type=imageUpload'));
		}

		if (!isset($this->options['fileDownload'])) {
			$this->options['fileDownload'] = CHtml::normalizeUrl(array('/photo_upload?type=fileDownload&file='));
		}

		if (!isset($this->options['fileDelete'])) {
			$this->options['fileDelete'] = CHtml::normalizeUrl(array('/photo_upload?type=fileDelete&delete='));
		}

		if (!isset($this->options['fileUpload'])) {
			$this->options['fileUpload'] = CHtml::normalizeUrl(array('/photo_upload?type=fileUpload'));
		}


		if (!isset($this->options['toolbar'])) {
			$this->options['toolbar'] = 'custom';
		}

		$cs = Yii::app()->getClientScript();
		$cs->registerCssFile($this->cssFile);
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($this->scriptFile);
		$cs->registerScript(__CLASS__.'#'.$this->id, 'window.'.$this->id.' = jQuery("#'.$this->id.'").redactor('.CJavaScript::encode($this->options).');');
	}

}
