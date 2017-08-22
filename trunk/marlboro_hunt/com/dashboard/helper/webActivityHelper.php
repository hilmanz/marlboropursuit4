<?php

class webActivityHelper {

	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);

		$this->dbshema = "marlborohunt";	
		$this->week = 7;
		$week = intval($this->apps->_request('week'));
		if($week!=0) $this->week = $week;
		
		$this->startdate = $this->apps->_g('startdate');
		$this->enddate = $this->apps->_g('enddate');	
		if($this->enddate=='') $this->enddate = date('Y-m-d');		
		if($this->startdate=='') $this->startdate = date('Y-m-d' ,  strtotime( '-7 day' ,strtotime($this->enddate)) );
		
		// $this->startweekcampaign = "2013-04-25";
		// pr($this->apps->_request('week'));
		
	}
	
	function top10visitedPage(){
	
		$sql = "SELECT count(*) num, action_value  FROM `tbl_activity_log` WHERE `action_id` = 6

				and action_value not like '%Send message%' and action_value not like '%DYO%' 
				and action_value not like '%Favorite%' and action_value not like '%video-kickoff%'
				and action_value not like '%video-laborday%' and action_value not like '%Faforite%'

				group by action_value
				order by num desc
				limit 10";
				// pr($sql);	 
		$qData = $this->apps->fetch($sql,1);
		return $qData;
	
	}
	
	function joinPursuitAct(){
		$sql = "SELECT count( * ) num, 'the pursuit' action_value
				FROM tbl_activity_log
				WHERE action_id = 40 ";
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		return $qData;
		
	}
	
	function gamePursuit(){
		$gamesarr[1] = "cross out";
		$gamesarr[2] = "wall breaker";
		$gamesarr[3] = "hidden code";
		$gamesarr[4] = "doubt word";
		$gamesarr[5] = "word hunt";
		$sql = "SELECT COUNT( * ) num, DATE( datetimes ) dd,gamesid
				FROM my_games WHERE datetimes >= '{$this->startdate}'
				AND datetimes <= '{$this->enddate}' 
				GROUP BY gamesid
				ORDER BY dd";
		// pr($sql);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		foreach($qData as $key => $val){
			if(array_key_exists($val['gamesid'],$gamesarr)) $qData[$key]['action_value'] = $gamesarr[$val['gamesid']];
			else  $qData[$key]['action_value'] = false;
		}
		// pr($qData);
		return $qData;
	
	}
	
	function tradePursuit(){
	
		$sql = "SELECT COUNT(*) num, DATE(datetime) dd FROM tbl_code_trade
				WHERE datetime >= '{$this->startdate}' AND datetime <= '{$this->enddate}' ";
		// pr($sql);
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		return $qData;
	
	}
	
	function redeemMerchandiseAct(){
		
		$sql = "SELECT COUNT( * ) num, DATE( redeemdate ) dd FROM my_merchandise 
				WHERE userid NOT IN ({$this->apps->getadminemail()}) ";
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		return $qData;
	
	}
	
	function thisorthatact(){
	
		$sql = "SELECT COUNT(*) num, DATE(date_time) dd FROM tbl_activity_log WHERE action_id = 6
				AND action_value LIKE '%this or%' AND DATE(date_time) >= '{$this->startdate} AND DATE(date_time) <= {$this->enddate}' ";
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		return $qData;	
	
	}
	
	function eventAct(){
		
		$sql = "SELECT COUNT(*) num, DATE(date_time) dd	FROM tbl_activity_log WHERE action_id = 2
				AND action_value LIKE '%event%' AND DATE(date_time) >= '{$this->startdate}' AND DATE(date_time) <= '{$this->enddate}' ";
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		return $qData;	
	
	}
	
	function newsAct(){
	
		$sql = "SELECT COUNT(*) num, DATE(date_time) dd	FROM tbl_activity_log WHERE action_id = 6
				AND action_value LIKE '%news%' AND DATE(date_time) >= '{$this->startdate}' AND DATE(date_time) <= '{$this->enddate}' ";
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		return $qData;
	
	}
	
	function myAccountact(){
	
		$sql = "SELECT COUNT(*) num, DATE(date_time) dd	FROM tbl_activity_log WHERE action_id = 6
				AND action_value LIKE '%account%' AND DATE(date_time) >= '{$this->startdate}' AND DATE(date_time) <= '{$this->enddate}'";
		$qData = $this->apps->fetch($sql);
		if(!$qData) return false;
		return $qData;
	
	}
	
	/* ------------------------------------ */
	
	function getsocial($struserid=null){
			if($struserid==null) return false;
			
		
			$sql ="SELECT img,id FROM social_member WHERE id IN ( {$struserid} ) ";	
	 
			$qData = $this->apps->fetch($sql,1);
		 
		
		if($qData){
			
			$arrData = false;
			
			foreach($qData as $val){
				$arrData[$val['id']] = $val;
			}	
			return $arrData;
		}
		
		return false;
	}
	
	function getPages($struserid=null){
			if($struserid==null) return false;
			
		
			$sql ="SELECT img,id FROM my_pages WHERE id IN ( {$struserid} ) ";	
			 
			$qData = $this->apps->fetch($sql,1);
	 
		
		if($qData){
			
			$arrData = false;
			
			foreach($qData as $val){
				$arrData[$val['id']] = $val;
			}	
			return $arrData;
		}
		
		return false;
	}
	
	function fixeddate($data = false,$datedayindex='dd',$valueindex='total'){
	if($data==false )return false;
	$mindate = strtotime($this->startdate);
	$maxdate = strtotime($this->enddate);
	$totaldate = ($maxdate - $mindate) / (60*60*24);
	$arrdata = false;
	// pr($data);
	foreach($data as $key => $val) {		
		$arrdata[$val[$datedayindex]] = $val[$valueindex];
	}

	// pr($mindate);
	// pr($arrdata);
	
	if(!$arrdata) return false;
		$newdata = false;
		for($i=0;$i<=$totaldate;$i++){
		// pr($totaldate);
			$dates = date("Y-m-d",$mindate);
			$val = date("Y-m-d" , strtotime("{$dates} +{$i} day"));
			// pr($val);		 	
				if(!array_key_exists($val,$arrdata)) $arrdata[$val] = 0;				
		}	
		$n = 0;
		
		ksort($arrdata);
		// pr($arrdata);
		foreach($arrdata as $key => $val){
			$newdata[$n][$datedayindex] = $key;
			$newdata[$n][$valueindex] = $val;
			$n++;
		}
		if($newdata)return $newdata;
		else return false;
	}
	
	function unserial($data)
	{
		
		$explode = unserialize($data);
		
		if ($explode) return $explode;
		return false;
	}
	
	function weeklyreport($all=false){
	$data =false;
	
	// if($all){
		// $this->startdate = '2013-07-15';
		// $this->enddate = date('Y-m-d');
	// }
	/* total login */
	// LOGIN
	$sql = "
	SELECT COUNT(*) total,DATE(date_time) dd 
	FROM `tbl_activity_log` 
	WHERE action_id = 1 
	AND user_id <> 0 	
	AND DATE(date_time) >= '{$this->startdate}' 
	AND DATE(date_time) <= '{$this->enddate}' 
	GROUP BY dd";
	$qData = $this->apps->fetch($sql,1);	
	$arrdata=false;
	if($qData){
		$newdata = $this->fixeddate($qData,'dd','total');
		if($newdata) $data['login']['total']=$newdata ;
		else $data['login']['total']=$qData ;
	}else {
			$arrdata=false;
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['login']['total']  = $newdata ;
	}
	// pr($data['login']['total']);
	// unique login
	$sql ="SELECT COUNT(*) total, dd FROM 
	(
	SELECT COUNT(*) total,user_id,DATE(date_time) 
	dd FROM `tbl_activity_log` 
	WHERE action_id = 1 AND user_id <> 0 
	AND DATE(date_time) >= '{$this->startdate}' 
	AND DATE(date_time) <= '{$this->enddate}' 
	GROUP BY dd,user_id
	) a
	GROUP BY dd";
	
	$qData = $this->apps->fetch($sql,1);	
	$arrdata=false;
	if($qData){
		// pr($qData);
		$newdata = $this->fixeddate($qData,'dd','total');
		// pr($newdata);
		if($newdata) $data['login']['unique'] = $newdata ;
		else $data['login']['unique'] = $qData;
	}else {
			$arrdata=false;
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['login']['unique']  = $newdata ;
	}
	//ALL GAMES
	//TOTAL
	$sql ="SELECT DATE(datetimes) dateday, count(*) total , gamesid
	FROM `my_games`
	WHERE DATE(datetimes) >= '{$this->startdate}' 
	AND DATE(datetimes) <= '{$this->enddate}' 
	group by dateday,gamesid";
 	
	pr($sql);
	$qData = $this->apps->fetch($sql,1);	
	$arrdata=false;
	if($qData){
		pr($qData);
		foreach($qData as $key => $val){			
			$arrdata[$val['gamesid']][] =$val;
		}
		
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dateday','total');
			// pr($newdata);
			if($newdata)$data['games'][$key]['total']  = $newdata ;
			else $data['games'][$key]['total'] = $val ;
			 
		}
		
	
	}else {
			$arrdata=false;
			$arrdata[0]['dateday'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dateday','total');
			// pr($newdata);
			if($newdata)$data['games'][0]['total']  = $newdata ;
	}
	//UNIQUE
	$sql ="SELECT COUNT(*) total, dateday,gamesid FROM (
	SELECT DATE(datetimes) dateday, count(*) total ,userid,gamesid
	FROM `my_games`
	WHERE DATE(datetimes) >= '{$this->startdate}' 
	AND DATE(datetimes) <= '{$this->enddate}' 
	group by dateday,userid,gamesid
	) a
	GROUP BY dateday,gamesid";
	
	pr($sql);
	$qData = $this->apps->fetch($sql,1);
	$arrdata=false;	
	if($qData){
		pr($qData);
		foreach($qData as $key => $val){			
			$arrdata[$val['gamesid']][] =$val;
		}
		
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dateday','total');
			// pr($newdata);
			if($newdata)$data['games'][$key]['unique']  = $newdata ;
			else $data['games'][$key]['unique'] = $val ;
			 
		}
	
	}else {
			$arrdata=false;
			$arrdata[0]['dateday'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dateday','total');
			// pr($newdata);
			if($newdata)$data['games'][0]['unique']  = $newdata ;
	}
	//THIS OR THAT
	//TOTAL
	
	/*
	$getCurrentWeek = "
	SELECT COUNT( * ) AS reports_in_week, 
	DATE_ADD(created_date , INTERVAL( 2 - DAYOFWEEK(created_date) ) 
	DAY ) start, 
	DATE_ADD(created_date , INTERVAL( 8 - DAYOFWEEK(created_date) )
	DAY ) end
	FROM marlborohunt_news_content_repo
	GROUP BY WEEK(created_date) ORDER BY  WEEK(created_date) DESC LIMIT 1";
	$resCurrentWeek = $this->apps->fetch($getCurrentWeek);
	
	list ($startdate, $startminute) = explode(' ',$resCurrentWeek['start']);
	list ($enddate, $endminute) = explode(' ',$resCurrentWeek['end']);
	
	// pr($startdate);
	*/
	
	$sql ="
	SELECT COUNT(*) total, DATE(repo.created_date) dd ,repo.typealbum, con.tags
	FROM marlborohunt_news_content_repo repo
	LEFT JOIN marlborohunt_news_content con ON repo.otherid = con.id
	WHERE  DATE(repo.created_date) >= '{$this->startdate}' 
	AND DATE(repo.created_date) <= '{$this->enddate}' 
	AND repo.content ='THIS OR THAT'
	GROUP BY  dd,repo.typealbum";
	// pr($sql);



	$qData = $this->apps->fetch($sql,1);	
	$arrdata=false;
	
	
	
	if($qData){
		// pr($qData);
		
		// $unserial = unserialize($qData[0]['tags']);
		// pr($unserial);
		// exit;
		foreach($qData as $key => $val){			
			
			
			$titleThisOrThat[$key] = unserialize($val['tags']);
			
			
			if ($val['typealbum']==2){
				$button = $titleThisOrThat[$key][0]['button'];
			}
			
			if ($val['typealbum']==3){
				$button = $titleThisOrThat[$key][1]['button'];
			}
			
			
			$arrdata[$button][] =$val;
			// $arrdata[$val['typealbum']][] =$val;
			
		}
		// pr($qData);
		// pr($titleThisOrThat);
		// pr($arrdata);
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dd','total');
			
			// foreach ($newdata as $keys => $value){
				// $newdate[$value['dd']] = $value;
			// }
			// pr($val);
			if($newdata)$data['thisorthat'][$key]['total']  = $newdata ;
			else $data['thisorthat'][$key]['total'] = $val ;
			 
		}
	 
	}else {
			$arrdata=false;
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['thisorthat'][0]['total']  = $newdata ;
	}
	// UNIQUE
	$sql ="SELECT COUNT(*) total,typealbum, dd FROM (
	SELECT COUNT(*) total, DATE(created_date) dd ,userid,typealbum
	FROM marlborohunt_news_content_repo 
	WHERE  DATE(created_date) >= '{$this->startdate}' 
	AND DATE(created_date) <= '{$this->enddate}' 
	AND content ='THIS OR THAT'
	GROUP BY  dd,typealbum,userid
		) a GROUP BY dd,typealbum";
	
	// pr($sql);
	// pr($titleThisOrThat);
	
	$qData = $this->apps->fetch($sql,1);
	$arrdata=false;	
	
	if($qData){
		foreach($qData as $key => $val){			
			// $arrdata[$val['typealbum']][] =$val;
			// $titleThisOrThat = unserialize($val['tags']);
			
			if ($val['typealbum']==2){
				$button = $titleThisOrThat[$key][0]['button'];
			}
			
			if ($val['typealbum']==3){
				$button = $titleThisOrThat[$key][1]['button'];
			}
			
			// pr($button);
			$arrdata[$button][] =$val;
		}
		
		// pr($arrdata);
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dd','total');
			// pr($newdata);
			if($newdata)$data['thisorthat'][$key]['unique']  = $newdata ;
			else $data['thisorthat'][$key]['unique'] = $val ;
			 
		}
	}else {
			$arrdata=false;
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['thisorthat'][0]['unique']  = $newdata ;
	}
	//SURFING BE MARLBORO, LEARN MORE, MSCAPE VIDEO, MSCAPE FERARI
	//TOTAL
	$sql ="	
	SELECT COUNT(*)total , action_value,DATE(date_time) dd 
	FROM tbl_activity_log 
	WHERE 
	action_value IN ('be marlboro video','learn more','mscape_video','mscape_video2') 
	AND action_id = 6
	AND DATE(date_time) >= '{$this->startdate}' 
	AND DATE(date_time) <= '{$this->enddate}' 
	GROUP BY dd , action_value
	ORDER BY dd, action_value ";
	$qData = $this->apps->fetch($sql,1);	
	$arrdata=false;
	if($qData){
		foreach($qData as $key => $val){			
			$arrdata[$val['action_value']][] =$val;
		}
		
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dd','total');
			// pr($newdata);
			if($newdata)$data['video'][$key]['total']  = $newdata ;
			else $data['video'][$key]['total'] = $val ;
			 
		}
		
	}else {
			$arrdata=false;
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['video'][0]['total']  = $newdata ;
	}
		
	//UNIQUE
	$sql ="	
	SELECT COUNT(*) total , dd,action_value 
	FROM (
	SELECT COUNT(*)total ,user_id , action_value,DATE(date_time) dd FROM tbl_activity_log 
	WHERE action_value IN ('be marlboro video','learn more','mscape_video','mscape_video2') 
	AND action_id = 6
	AND DATE(date_time) >= '{$this->startdate}' 
	AND DATE(date_time) <= '{$this->enddate}' 
	GROUP BY dd , action_value ,user_id
	)a
	GROUP BY dd , action_value
	ORDER BY dd, action_value";
	$qData = $this->apps->fetch($sql,1);
	$arrdata=false;
	if($qData){	
			foreach($qData as $key => $val){			
			$arrdata[$val['action_value']][] =$val;
		}
		
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dd','total');
			// pr($newdata);
			if($newdata)$data['video'][$key]['unique']  = $newdata ;
			else $data['video'][$key]['unique'] = $val ;
			 
		}
		
	}else {
			$arrdata=false;
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['video'][0]['unique']  = $newdata ;
	}	
	//SURFING EVENT AND NEWS
	//TOTAL
	$sql ="SELECT COUNT(*)total,
	IF(SUBSTRING(action_value,1,4)='news',SUBSTRING(action_value,1,4),SUBSTRING(action_value,1,5)) acti ,DATE(date_time) dd FROM tbl_activity_log WHERE ( action_value like 'news%' OR action_value like 'event%')  AND action_id = 2
	AND DATE(date_time) >= '{$this->startdate}' 
	AND DATE(date_time) <= '{$this->enddate}' 
	GROUP BY dd , acti
	ORDER BY dd, acti ";
	$qData = $this->apps->fetch($sql,1);	
	$arrdata=false;
	if($qData){
		foreach($qData as $key => $val){			
			$arrdata[$val['acti']][] =$val;
		}
		
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dd','total');
			// pr($newdata);
			if($newdata)$data['pages'][$key]['total']  = $newdata ;
			else $data['pages'][$key]['total'] = $val ;
			 
		}
		 
	 }else {
			
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['pages'][0]['total']  = $newdata ;
	}
		
	//UNIQUE
	$sql ="SELECT COUNT(*) total , dd,acti 
	FROM (
	SELECT COUNT(*)total,user_id,
	IF(SUBSTRING(action_value,1,4)='news',SUBSTRING(action_value,1,4),SUBSTRING(action_value,1,5)) acti ,DATE(date_time) dd FROM tbl_activity_log WHERE ( action_value like 'news%' OR action_value like 'event%')  AND action_id = 2
	AND DATE(date_time) >= '{$this->startdate}' 
	AND DATE(date_time) <= '{$this->enddate}' 
	GROUP BY dd ,user_id, acti
	)a
	GROUP BY dd , acti
	ORDER BY dd, acti ";
	 
	$qData = $this->apps->fetch($sql,1);
	$arrdata=false;	
	if($qData){
		foreach($qData as $key => $val){			
			$arrdata[$val['acti']][] =$val;
		}
		
		foreach($arrdata as $key => $val ){
			$newdata = $this->fixeddate($val,'dd','total');
			// pr($newdata);
			if($newdata)$data['pages'][$key]['unique']  = $newdata ;
			else $data['pages'][$key]['unique'] = $val ;
			 
		}
		 	
	}else {
			
			$arrdata[0]['dd'] = date('Y-m-d');
			$arrdata[0]['total'] = 0;
			
			 
			$newdata = $this->fixeddate($arrdata,'dd','total');
			// pr($newdata);
			if($newdata)$data['pages'][0]['unique']  = $newdata ;
	}
	
	return $data;
	}
	
	function thisorthatsubmission()
	{
		$sql ="
				SELECT id, created_date, expired_date, tags
				FROM marlborohunt_news_content
				WHERE title LIKE '%THIS OR THAT%'
				AND tags != ''
				AND n_status NOT
				IN ( 2 ) ";
		$qData = $this->apps->fetch($sql,1);
		// pr($sql);
		if($qData){
			
			foreach ($qData as $key => $value){
				
				list($dateformat, $time) = explode(' ', $value['created_date']); 
				
				$date[] = $dateformat;
				
				$qData[$key]['created_date'] = $dateformat;
			}
			// pr($date);
			$i = 0;
			
			$count = count($qData);
			// echo $count;
			foreach ($qData as $key => $value){
				
				if ($key < $count-1){
					
					// list ($date, $time) = explode(' ',$date['created_date']);
					
					// $qData[$key]['created_date_fix'] = $date[$key+1];
					$qData[$key]['due_date'] = $date[$key+1];
					$qData[$key]['due_date_fix'] = date('Y-m-d', strtotime($date[$key+1].' -1 day'));
				}else{
					$qData[$key]['due_date'] = date('Y-m-d');
					$qData[$key]['due_date_fix'] = date('Y-m-d');
				}
				
				
			}
			
			// pr($qData);
			foreach ($qData as $key => $value){
				
				$sql = "SELECT count( * ) total, typealbum
						FROM marlborohunt_news_content_repo
						WHERE created_date >= '{$value['created_date']}'
						AND created_date < '{$value['due_date']}'
						AND otherid = {$value['id']}
						GROUP BY typealbum ";
				// pr($sql);
				// pr($sql);AND otherid = {$value['id']}
				$res = $this->apps->fetch($sql,1);
				
				$sqlCount = "SELECT count( DISTINCT (userid) ) total, typealbum
							FROM marlborohunt_news_content_repo
							WHERE created_date >= '{$value['created_date']}'
							AND created_date < '{$value['due_date']}'
							AND otherid = {$value['id']}
							GROUP BY typealbum";
							
				$resCount = $this->apps->fetch($sqlCount,1);
				// pr($sqlCount);
				if ($res){
				
					foreach ($res as $keys => $val){
						$deserial = unserialize($value['tags']);
						$res[$keys]['eventName'] = $deserial[$keys]['button'];
						$res[$keys]['unique'] = $resCount[$keys]['total'];
					}
					
					$qData[$key]['submission'] = $res;
				}
				
				list ($year, $month, $day) = explode('-', $value['created_date']);
				$qData[$key]['change_create_date'] = $day.'-'.$month.'-'.$year;
				
				list ($year, $month, $day) = explode('-', $value['due_date_fix']);
				$qData[$key]['change_due_date'] = $day.'-'.$month.'-'.$year;
				
			}
			
			
			
			// pr($qData);
			return $qData;
			
		}
		
	}
}

?>