<?php
class games extends App{
	function beforeFilter(){
	
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->activityHelper = $this->useHelper('activityHelper');
		$this->gamesHelper = $this->useHelper('gamesHelper');
		$this->userHelper = $this->useHelper('userHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		
		$this->assign('locale', $LOCALE[1]);
		
	}
	
	function main()
	{
	
		// $this->View->assign('games_content',$this->setWidgets('games_content'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/games_pages.html');
	}
	
	function wallbreaker(){
	
		$wallead = $this->gamesHelper->leaderboard_wallbreaker();
		$this->assign("wallead",$wallead);
	
		$this->View->assign('popup_leaderboard_wallbraker',$this->setWidgets('popup_leaderboard_wallbraker'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/wallbreaker.html');
	}
	
	function maybeninja(){
		
		$maylead = $this->gamesHelper->leaderboard_maybeninja();
		$this->assign("maylead",$maylead);
		
		$this->View->assign('popup_leaderboard_maybeninja',$this->setWidgets('popup_leaderboard_maybeninja'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/crossout.html');
	}
	
	function crossout(){
		
		$maylead = $this->gamesHelper->leaderboard_maybeninja();
		$this->assign("maylead",$maylead);
		
		$this->View->assign('popup_leaderboard_maybeninja',$this->setWidgets('popup_leaderboard_maybeninja'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/crossout.html');
	}
	
	function wordhunt(){
		
		$maylead = $this->gamesHelper->leaderboardgames(4);
		$this->assign("maylead",$maylead);
		
		$this->View->assign('popup_leaderboard_wordhunt',$this->setWidgets('popup_leaderboard_wordhunt'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/wordhunt.html');
	}
	
	 
	
	function doubtcrasher(){
		
		$maylead = $this->gamesHelper->leaderboardgames(5);
		$this->assign("maylead",$maylead);
		
		$this->View->assign('popup_leaderboard_doubtcrush',$this->setWidgets('popup_leaderboard_doubtcrush'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/doubtcrush.html');
	}
	
	function play(){
		
		$gamesplay = strip_tags($this->_request('gamesplay'));
		
		if($gamesplay=='wallbreaker'){
			$wallead = $this->gamesHelper->leaderboard_wallbreaker();
			$this->assign("wallead",$wallead);
	
			$this->View->assign('popup_leaderboard_wallbraker',$this->setWidgets('popup_leaderboard_wallbraker'));
			$this->View->assign('popup_leaderboard',$this->setWidgets('popup_leaderboard'));
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/game-play-wallbreaker.html');
		}
		
		if($gamesplay=='maybeninja'){
			$maylead = $this->gamesHelper->leaderboard_maybeninja();
			$this->assign("maylead",$maylead);
		
			$this->View->assign('popup_leaderboard_maybeninja',$this->setWidgets('popup_leaderboard_maybeninja'));
			$this->View->assign('popup_leaderboard',$this->setWidgets('popup_leaderboard'));
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/game-play-crossout.html');
		}
		if($gamesplay=='crossout'){
			$maylead = $this->gamesHelper->leaderboard_maybeninja();
			$this->assign("maylead",$maylead);
		
			$this->View->assign('popup_leaderboard_maybeninja',$this->setWidgets('popup_leaderboard_maybeninja'));
			$this->View->assign('popup_leaderboard',$this->setWidgets('popup_leaderboard'));
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/game-play-crossout.html');
		}
		
		if($gamesplay=='wordhunt'){
			$maylead = $this->gamesHelper->leaderboardgames(4);
			$this->assign("maylead",$maylead);
		
			$this->View->assign('popup_leaderboard_wordhunt',$this->setWidgets('popup_leaderboard_wordhunt'));
			$this->View->assign('popup_leaderboard',$this->setWidgets('popup_leaderboard'));
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/game-play-wordhunt.html');
		}
		
		if($gamesplay=='doubtcrasher'){
			$maylead = $this->gamesHelper->leaderboardgames(5);
			$this->assign("maylead",$maylead);
		
			$this->View->assign('popup_leaderboard_doubtcrush',$this->setWidgets('popup_leaderboard_doubtcrush'));
			$this->View->assign('popup_leaderboard',$this->setWidgets('popup_leaderboard'));
			return $this->View->toString(TEMPLATE_DOMAIN_WEB .'widgets/game-play-doubtcrush.html');
		}
	}
	
	function hiddencode()
	{
		
		if ($this->_p('hiddenCode')){
			if ($this->_p('param')){
			
				$validateCode = $this->gamesHelper->ValidateHiddenCode();
				if ($validateCode){
					print json_encode(array('status'=>true, 'rec'=>$validateCode));
				}else{
					print json_encode(array('status'=>false));
				}
			}
			
		}
		
		exit;
	}
		
	
}
?>