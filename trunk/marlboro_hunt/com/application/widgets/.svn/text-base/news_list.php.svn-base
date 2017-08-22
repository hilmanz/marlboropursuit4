<?php
class news_list{
	
	function __construct($apps=null){
		$this->apps = $apps;	
		global $LOCALE,$CONFIG;
		$this->apps->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->apps->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		$this->apps->assign('locale',$LOCALE[$this->apps->lid]);
	}

	function main(){
	
		$newsList = $this->apps->newsHelper->newsDetail(true,true);
		// pr($newsList);
		// $newsList = false;
		if ($newsList){
			foreach ($newsList as $key => $value){
				list($dateFormat, $timeFormat) = explode(' ',$value['posted_date']);
				list($year, $month, $date) = explode('-',$dateFormat);
				$newsList[$key]['datachange'] = $date.'/'.$month.'/'.$year;
			}
		}else{
			$newsList = false;
		}
		
		
		$this->apps->assign("newsList",$newsList);
		return $this->apps->View->toString(TEMPLATE_DOMAIN_WEB ."widgets/news_list.html"); 
	
	}
}
?>