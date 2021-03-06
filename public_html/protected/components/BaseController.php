<?php

class BaseController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = 'main';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu = array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs = array();
	/**
	 * Description in meta tag
	 */
	public $description = '';
	/**
	 * Keywords in meta tag
	 */
	public $keywords = '';

	/**
	 * @var array
	 */
	protected $asideBlocks = array();

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if ($error = Yii::app()->errorHandler->error)
		{
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
            }
			else {
				$this->render('error', $error);
            }
		}
	}

	public function actionLang($lang) {
		Yii::app()->user->setLang($lang);
		$this->redirect(Yii::app()->request->urlReferrer);
	}

	public function init()
	{
		$result = parent::init();
        $app = Yii::app();
		$app->language = Yii::app()->user->getLang();
        $app->name = Yii::t('app', 'Transfer of the WoW characters');

		return $result;
	}

	/**
	 * @param string $block
	 */
	public function addAsideBlockToColumn2($block) {
		$this->asideBlocks[] = $block;
	}

	/**
	 * @return boolean
	 */
	public function isEmptyServiceParams() {
		$username = Config::getInstance()->getServiceUsername();
		$accessToken = Config::getInstance()->getAccessToken();
		return  empty($username) || empty($accessToken);
	}

    public function registerCssAndJs()
    {
        $cs = Yii::app()->clientScript;
        $cs->coreScriptPosition = CClientScript::POS_END;

        $requareJsDir = Yii::getPathOfAlias('application.vendor.requirejs.requirejs');
        $requareJsUrl = Yii::app()->assetManager->publish($requareJsDir . '/require.js');
        $cs->registerScriptFile($requareJsUrl, CClientScript::POS_END);
    }
}