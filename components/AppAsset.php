<?php

namespace backoffice\components;

use backoffice\assets\AppAsset as yiiAppAsset;

/**
 * @author Sujit Verma <sujit.verma@girnarsoft.com>
 */
class AppAsset extends yiiAppAsset
{
    /**
     * Registers the CSS and JS files along with the common CSS and JS with the given view.
     * @param \yii\web\View $view the view that the asset files are to be registered with.
     */
    public function registerAssetFiles($view)
    {
	parent::registerAssetFiles($view);
	$this->css = $this->getCommonCss();
	$this->js = $this->getCommonJs();
	parent::registerAssetFiles($view);
    }
    
    public function getCommonCss()
    {
	return [
            'css/jquery_dataTable.css',
            'css/select2.min.css',
            'css/mystyle.css'
	];
    }
    public function getCommonJs()
    {
	return [
            'js/jquery_dataTable.js',
            'js/myscript.js'
	];
    }
}
