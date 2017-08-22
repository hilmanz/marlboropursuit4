<?php
class movefwd extends App{
	function beforeFilter(){
	
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->activityHelper = $this->useHelper('activityHelper');
		$this->userHelper = $this->useHelper('userHelper');
		$this->newsHelper = $this->useHelper('newsHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->assign('locale', $LOCALE[1]);
	}
	
	function main()
	{
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/move-fwd.html');
	}
	
	function activity()
	{
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/move-fwd-activity.html');
	}
	
	
}
?>