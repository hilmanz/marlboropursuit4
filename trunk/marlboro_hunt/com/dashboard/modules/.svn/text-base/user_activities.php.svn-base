<?php
class user_activities extends App{
	
	
	function beforeFilter(){
	
		$this->uActivitiesHelper = $this->useHelper("uActivitiesHelper");
		
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['DASHBOARD_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_DASHBOARD']);
				
		$this->assign('locale', $LOCALE[1]);
		$this->assign('startdate', $this->_g('startdate'));
		$this->assign('enddate', $this->_g('enddate'));
	
	}
	
	function main(){

		$numberofLogin = $this->uActivitiesHelper->numberofLogin();
		$loginHistory = $this->uActivitiesHelper->loginHistory();		
		$numberofRegistrant = $this->uActivitiesHelper->numberofRegistrant();
		$numberofExistingUser = $this->uActivitiesHelper->numberofExistingUser();
		$numberofNewUser = $this->uActivitiesHelper->numberofNewUser();
		$maleFemaleUser = $this->uActivitiesHelper->maleFemaleUser();
		$this->Paging = new Paginate();
		$mostLetterCollect = $this->uActivitiesHelper->mostLetterCollect();
		if ($mostLetterCollect){
			$start = $this->_g('st');
			$total_per_page = 20;
			$total = $mostLetterCollect['total'];
			$this->assign("paging",$this->Paging->getAdminPaging($start, $total_per_page, $total,""));	
		}
		
		
		
		// pr($numberofExistingUser);
		$this->assign("numberofLogin",$numberofLogin);
		$this->assign("loginHistory",$loginHistory);		
		$this->assign("numberofRegistrant",$numberofRegistrant);
		$this->assign("numberofExistingUser",$numberofExistingUser);
		$this->assign("numberofNewUser",$numberofNewUser);
		$this->assign("maleFemaleUser",$maleFemaleUser);
		
		$this->assign("mostLetterCollect",$mostLetterCollect['rec']);
		$this->assign("total",round(count($mostLetterCollect['rec'])/2));
		
		if ($this->_p('typeoftime')){
			$this->assign("sortby",intval($this->_p('typeoftime')));
		}else{
			$this->assign("sortby",1);
		}
		
		
		if(strip_tags($this->_g('page'))=='home') $this->log('surf','home');
		return $this->View->toString(TEMPLATE_DOMAIN_DASHBOARD .'apps/user_activities.html');
		
	}
	
	function ajax()
	{
		$loginHistory = $this->uActivitiesHelper->loginHistory();
		if ($loginHistory)print json_encode(array('data'=>$loginHistory));
		else print json_encode(array('data'=>false));
		exit;
	}
		
}
?>