<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'licensewidget',
                'cssFile'=>'jquery-ui-1.8.16.custom.css',
                'theme'=>'redmond',
                'themeUrl'=>Yii::app()->request->baseUrl.'/css/ui',
                'options'=>array(
                    'title'=>tFile::getT('module_install', 'License agreement'),
                    'autoOpen'=>$this->autoOpen ? true : false,
                    'modal'=>'true',
                    'show'=>'puff',
                    'hide'=>'slide',
                    'width'=>'80%',
                    'height'=>'auto',
                    'resizable' =>false,
                    'buttons'=>array(tFile::getT('module_install', 'Accept')=>'js:function() {
                        $("#InstallForm_agreeLicense").attr("checked", "checked");
                        $(this).dialog("close");
                    }'),
                ),
            ));
?>

<div>
    <h2><?php echo tFile::getT('module_install', 'License agreement');?></h2>
    <p>
		GNU GPL Open Real Estate CMS is distributed under generally available open license called GNU GPL version 2.
		<a href="http://www.gnu.org/licenses/old-licenses/gpl-2.0.html" rel="nofollow" target="_blank">Original license text</a>.
    </p>
    <p>
		You can distribute Open Real Estate CMS only if you save copyright in the footer of the product and  in the system code (php files).
	</p>
    <p>
		If you prefer to delete active hyperlink to our web site which is placed in the footer of the user's and admin's parts of the product, you should pay us 49$.
		For this purpose you need <a href="http://monoray.net/contact" target="_blank">send us a message</a> and name the domain for which you would like to delete the hyperlink.
	</p>
</div>

<div>
    Media content for the site is used according to the cc-by-2 License.
    Authors are:
    <ul>
	    <li>
	        <a href="http://www.flickr.com/photos/39404185@N03" target="_blank">Kavanjin Croatia Apartments</a>
        </li>
        <li>
            <a href="http://www.flickr.com/photos/9160678@N06" target="_blank">scarletgreen</a>
        </li>
        <li>
            <a href="http://www.flickr.com/photos/9160678@N06" target="_blank">Jeremy Levine Design</a>
        </li>
        <li>
            <a href="http://www.flickr.com/photos/58842866@N08" target="_blank">tommerton2010</a>
        </li>
    </ul>
</div>

<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>