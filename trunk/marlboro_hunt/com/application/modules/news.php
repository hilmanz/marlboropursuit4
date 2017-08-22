<?php
class news extends App{
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
	
	function main(){
		
		$this->View->assign('popup_game',$this->setWidgets('popup_game'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/news-home.html');
		
	}
	
	function landing(){
		$this->log('surf', 'news');
		$this->View->assign('popup_game',$this->setWidgets('popup_game'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/news-landing.html');
	}
	
	function video(){
		
		$this->log('surf', 'be marlboro video');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/video-pages.html');
	}
	
	function decision(){
		// $this->log('surf', 'be marlboro video');
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/decision_pages.html');
	}
	
	function detail(){
		
		//widget list
		$this->View->assign('news_list',$this->setWidgets('news_list'));
		// widget detail
		$this->View->assign('news_detail',$this->setWidgets('news_detail'));
		
		$this->log('read article',"news_{$this->_g('id')}");
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'/apps/news.html');
	}
	
	
}
?>