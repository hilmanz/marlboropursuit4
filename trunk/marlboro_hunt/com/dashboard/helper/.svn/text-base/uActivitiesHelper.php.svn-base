<?php

class uActivitiesHelper {

	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);

		$this->dbshema = "marlborohunt";	
		$this->dateLetterDistribution = "2013-07-01";
		$this->startdate = $this->apps->_g('startdate');
		$this->enddate = $this->apps->_g('enddate');	
		if($this->enddate=='') $this->enddate = date('Y-m-d');		
		if($this->startdate=='') $this->startdate = date('Y-m-d' ,  strtotime( '-7 day' ,strtotime($this->enddate)) );
	}
	
/* 	function fixeddate($qData=false,$datetimesformat = 'datetime'){
		if(!$qData) return false;
		
		$startdate = strip_tags($this->apps->_g('startdate'));
		$enddate = strip_tags($this->apps->_g('enddate'));
		$mindate = 0;
		$maxdate = 0;
		if($startdate){
			if(!$enddate) if($startdate)  $enddate = date("Y-m-d",strtotime($startdate. "+7 day"));
			$mindate = strtotime($startdate);
			$maxdate = strtotime($enddate);
		}
		$totaldate = ($maxdate - $mindate) / (60*60*24);
		
		
		for($i=0;$i<=$totaldate;$i++){
		// pr($totaldate);
			$dates = date("Y-m-d",$mindate);
			$val = date("Y-m-d" , strtotime("{$dates} +{$i} day"));
			// pr($val);
			foreach($qData as $key => $valve) {					
				if(array_key_exists($val,$qData[$key][$datetimesformat])) $qData[$key][$datetimesformat] = $qData[$key][$datetimesformat];
				else  $qData[$key][$datetimesformat] = 0;
			}
			
		}
		return $qData;
	} */

	function numberofLogin(){
		
		$sql = "SELECT count(*) num, DATE(date_time) datetime FROM tbl_activity_log 
				WHERE action_id = 1 
				AND DATE(date_time) >= '{$this->startdate}' 
				AND DATE(date_time) <= '{$this->enddate}'
				GROUP BY datetime 
				ORDER BY datetime ASC";
				
		// $this->apps->open(1);
		// pr($sql);
		$qData = $this->apps->fetch($sql,1);
		/* 
		if($qData) $data = $this->fixeddate($qData,'datetime');
		else $data = $qData; */
		
		return $qData;
	}
	
	function loginHistory(){
		
		/*
		$sql = "SELECT COUNT( * ) num, log.user_id, DATE(log.date_time) date_time
				FROM tbl_activity_log log
				LEFT JOIN tbl_activity_actions act ON log.action_id = act.id
				WHERE log.action_id = 1 AND date_time >= '{$this->startdate}'
				AND date_time <= '{$this->enddate}'
				GROUP BY log.user_id
				ORDER BY date_time DESC LIMIT 10";
				
				SELECT MAX(logintime) totallogintime ,dd FROM
				(
				SELECT  max(date_ts) - min(date_ts) logintime ,DATE(date_time) dd,user_id FROM `tbl_activity_log` WHERE action_id = 1
				GROUP BY dd,user_id
				 ) a
				GROUP BY dd
				
		*/
		$typeoftime = strip_tags($this->apps->_p('typeoftime'));
		$qTimes = " ROUND( MAX(logintime)/ (60*60)) num ";
		if($typeoftime=='hour') $qTimes = "  MAX(logintime)/ (60*60*24)  num  ";
		if($typeoftime=='minute')$qTimes = "ROUND( MAX(logintime)/ (60*60))  num  ";
		$sql = "
				SELECT {$qTimes} ,dd date_time FROM
				(
				SELECT  max(date_ts) - min(date_ts) logintime ,DATE(date_time) dd,user_id FROM `tbl_activity_log` 
				WHERE action_id = 1
				AND DATE(date_time) >= '{$this->startdate}'
				AND DATE(date_time) <= '{$this->enddate}'
				GROUP BY dd,user_id
				 ) a
				
				GROUP BY date_time ASC 
		";
		// pr($sql);
		// $this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		return $qData;
				
	}
	
	function numberofRegistrant(){
	
		$sql = "SELECT count( * ) num, DATE_FORMAT( register_date, '%Y-%m-%d' ) datetime, sex, YEAR(
				CURRENT_TIMESTAMP ) - YEAR( birthday ) - ( RIGHT(
				CURRENT_TIMESTAMP , 5 ) < RIGHT( birthday, 5 ) ) AS age
				FROM social_member
				GROUP BY age
				ORDER BY num ASC";
		// $this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		$data = false;
			$data['18 - 24']= 0;
			$data['25 - 29']= 0;
			$data['30 - above']= 0;
			foreach( $qData as $val ){
				if($val['age']==null ) $data['null']+= $val['num'];
				else{
				if($val['age']<=24 ) $data['18 - 24'] += $val['num']; 
				if($val['age']>=25 && $val['age']<=29 ) $data['25 - 29'] += $val['num'];
				if($val['age']>=30 ) $data['30 - above']+= $val['num'];
				}
				
			}
		
		return $data;
		
	}
	
	function numberofExistingUser(){
		
		
		$sql = "SELECT count( * ) num, DATE_FORMAT( register_date, '%Y-%m-%d' ) datetime, sex, YEAR(
				CURRENT_TIMESTAMP ) - YEAR( birthday ) - ( RIGHT(
				CURRENT_TIMESTAMP , 5 ) < RIGHT( birthday, 5 ) ) AS age
				FROM social_member WHERE id IN (
					SELECT DISTINCT (user_id) FROM tbl_activity_log WHERE `date_time` >= '{$this->dateLetterDistribution}')
				AND usertype = 2 
				AND login_count > 0
				GROUP BY age
				ORDER BY datetime ASC";
				
				
		// $this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		$data = false;
			$data['18 - 24']= 0;
			$data['25 - 29']= 0;
			$data['30 - above']= 0;
			foreach( $qData as $val ){
				if($val['age']==null ) $data['null']+= $val['num'];
				else{
				if($val['age']<=24 ) $data['18 - 24'] += $val['num']; 
				if($val['age']>=25 && $val['age']<=29 ) $data['25 - 29'] += $val['num'];
				if($val['age']>=30 ) $data['30 - above']+= $val['num'];
				}
				
			}
		
		return $data;
		
	}
	
	function numberofNewUser(){
	
		$sql = "SELECT count( * ) num, DATE_FORMAT( register_date, '%Y-%m-%d' ) datetime, sex, YEAR(
				CURRENT_TIMESTAMP ) - YEAR( birthday ) - ( RIGHT(
				CURRENT_TIMESTAMP , 5 ) < RIGHT( birthday, 5 ) ) AS age
				FROM social_member WHERE id IN (
					SELECT DISTINCT (user_id) FROM tbl_activity_log WHERE `date_time` >= '{$this->dateLetterDistribution}'
				)
				AND sex !=''
				AND usertype in (0,1)
				AND login_count > 0
				GROUP BY age
				ORDER BY datetime ASC";
		// $this->apps->open(1);
		// pr($sql);
		
		$qData = $this->apps->fetch($sql,1);
		if(!$qData) return false;
		$data = false;
			$data['18 - 24']= 0;
			$data['25 - 29']= 0;
			$data['30 - above']= 0;
			foreach( $qData as $val ){
				if($val['age']==null ) $data['null']+= $val['num'];
				else{
				if($val['age']<=24 ) $data['18 - 24'] += $val['num']; 
				if($val['age']>=25 && $val['age']<=29 ) $data['25 - 29'] += $val['num'];
				if($val['age']>=30 ) $data['30 - above']+= $val['num'];
				}
				
			}
		
		return $data;
		
	}
	
	function maleFemaleUser(){
	
		//first query//
		/* $sql = "SELECT count( * ) num, DATE( register_date  ) datetime, sex
				FROM social_member WHERE				
				sex <> '' AND sex IS NOT NULL
				GROUP BY sex	ORDER BY datetime DESC"; */
				
		//rev query
		$sql = "SELECT count( * ) num, DATE( register_date ) datetime, sex
				FROM social_member WHERE n_status = 1 AND sex <> '' 
				AND sex IS NOT NULL GROUP BY sex ORDER BY datetime ASC";
				// pr($sql);
		// $this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		// pr($qData);
		if(!$qData) return false;
		$data = false;
		$data['count'] = 0;
		$data['jumlah_female'] = false;
		$data['jumlah_male'] = false;
		$data['unknown'] = false;
		$data['jumlah'] = false;
		foreach($qData as $val){
			$data['data'][$val['datetime']] = $val['num'];
			if(strtolower($val['sex'])=="female") $data['jumlah_female']+= $val['num'];
			if(strtolower($val['sex'])=="male") $data['jumlah_male']+= $val['num'];			
			if($val['sex']!="Male"&&$val['sex']!="Female") $data['unknown']+= $val['num'];			
			
			$data['date'][$val['datetime']] = $val['datetime'];
			
			$data['jumlah']+= $val['num'];		
			
		}
		// pr($data);
		$data['count'] = count($qData);
		return $data;
	}
	
	function mostLetterCollect($start=0,$limit=20){
	
		$start = intval($this->apps->_g('st'));
	
		$sql = "SELECT COUNT( * ) num, sm.name, sm.last_name
				FROM tbl_code_inventory tci
				LEFT JOIN social_member sm ON tci.userid = sm.id
				WHERE sm.name IS NOT NULL AND sm.name <> ''				 
				AND sm.id NOT IN ({$this->apps->getadminemail()})
				GROUP BY tci.userid
				ORDER BY num DESC
				LIMIT {$start},{$limit}
				";
		// pr($sql);
		// $this->apps->open(1);
		$qData = $this->apps->fetch($sql,1);
		
		$sqlTotal = "
				SElECT COUNT(*) total FROM (
				SELECT COUNT( * ) num
				FROM tbl_code_inventory tci
				LEFT JOIN social_member sm ON tci.userid = sm.id
				WHERE sm.name IS NOT NULL AND sm.name <> ''				 
				AND sm.id NOT IN ({$this->apps->getadminemail()})
				GROUP BY tci.userid
				ORDER BY num DESC) a
				";
		// pr($sqlTotal);		
		$qDataTotal = $this->apps->fetch($sqlTotal);
		
		return array('rec'=>$qData, 'total'=>$qDataTotal['total']);
					
	}
	
	function getChartDataOf($searchData=null){
		
		if($searchData==null) return false;
		
		if(is_array($searchData)) {
			foreach($searchData as $val){
				$nuArr[] = "'{$val}'";
			}
			if($nuArr)	$searchData = implode(',',$nuArr);
			else return false;
		}
		
		$theactivity = "{$searchData}";
		
		/* get activity ID */
		$actionnamedata = $this->getactivitytype($theactivity);

		if($actionnamedata) {
			
			$activityID = implode(',',$actionnamedata['id']);
		}else $activityID = false;
			
		$sql = "SELECT count(*) total, DATE(date_time) dateformatonly  FROM tbl_activity_log WHERE action_id IN ({$activityId}) ORDER BY dateformatonly GROUP BY dateformatonly LIMIT {$start},{$limit}";

		$getChartDataOf[$searchData] = $this->apps->fetch($sql);
		
		//pr($getChartDataOf);
		exit;

	}

	function getactivitytype($dataactivity=null,$id=false){
			if($dataactivity==null)return false;
			if($id) $qAppender = " id IN ({$dataactivity}) ";
			else $qAppender = " activityName IN ({$dataactivity})  ";
			$theactivity = false;
			/* get activity  id */	
			$sql = " SELECT * FROM tbl_activity_actions WHERE {$qAppender} ";

			$qData = $this->apps->open(1);
				
			if($qData) {
				foreach($qData as $val){
					$theactivity['id'][$val['id']]=$val['id'];
					$theactivity['name'][$val['id']]=$val['activityName'];
					
				}
			}
			return $theactivity;
		}

}

?>