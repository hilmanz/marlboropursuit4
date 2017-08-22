<?php

class messageHelper {
	
	
	function __construct($apps){
	global $logger,$CONFIG;
	$this->logger = $logger;
	$this->apps = $apps;
	if($this->apps->isUserOnline())  {
			if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);
	}
	else $this->uid = 0;
	$this->dbshema = "marlborohunt";
	$this->action_id = '20,21,23,24,25,26,27,28,30,45';
	}
	
	
	function getMessage(){
	
		$type = $this->action_id; // type log action
		$sql =  "
		(
		SELECT  my.id,my.fromid,my.recipientid,my.fromwho,my.datetime,my.n_status, sm.name,  sm.last_name, 1 type
		FROM my_message my
		LEFT JOIN social_member sm ON sm.id = my.recipientid		
		WHERE my.recipientid = {$this->uid} AND my.n_status = 0
		)
		UNION
		(
		SELECT log.id, '' fromid, '' recipientid, '' fromwho,log.date_time datetime, log.n_status, '' name, '' last_name,0 type FROM tbl_activity_log AS log WHERE log.user_id = {$this->uid} 
		AND action_id IN ({$type}) AND log.n_status = 0
		)
		ORDER BY datetime DESC
		";
		// pr($sql);
		$this->logger->log($sql);
		$qData = $this->apps->fetch($sql,1);
		
		if($qData) {
		
			return $qData;
		
		}
		
		return false;
		
	}
	function seeMessage(){
		$qData = $this->getMessage();
		$arrid = false;
		if(!$qData) return false;
		foreach($qData as $val){
		
			$arrid[$val['id']] = $val['id'];
		}
		
		if(!$arrid) return false;
		$strid = implode(',',$arrid);
		
		$sql = "UPDATE my_message SET n_status = 1 WHERE id IN ({$strid}) ";
		$qData = $this->apps->query($sql);
		
		$sqlLog = "UPDATE tbl_activity_log SET n_status = 1 WHERE id IN ({$strid}) ";
		$qDataLog = $this->apps->query($sqlLog);
		
	}
	
	function seeMessageByid(){
		// $qData = $this->getMessage();
		
		$id = $this->apps->_p('id');
		$type = $this->apps->_p('type');
		
		if (!isset($id)) return false;
		if (!isset($type)) return false;
		
		$getSession = @$_SESSION['statusinbox'];
		if (!$getSession) return false;	
		if ($getSession){
			
			if ($getSession ==1) $n_status = 1; // read inbox
			if ($getSession ==2) $n_status = 0;
			if ($getSession ==3) $n_status = 2; // read trash
		}else{
			$n_status = 1;
		}
		
		if ($type==1){
			$sql = "UPDATE my_message SET n_status = {$n_status} WHERE id = {$id} ";
			// pr($sql);
			$qData = $this->apps->query($sql);
		}
		
		if ($type==0){
			$sqlLog = "UPDATE tbl_activity_log SET n_status = {$n_status} WHERE id = {$id} ";
			// pr($sqlLog);
			$qDataLog = $this->apps->query($sqlLog);
		}
		return true;
		
		exit;
	}
	
	function deleteMessage(){
		
		$data = $_POST;
		if (!isset($data['id'])) return false;
		if (!isset($data['type'])) return false;
		
		foreach ($data['id'] as $key => $value){
			if (intval($key) <=4){
				$res[intval($value)] = $data['type'][intval($key)];
			}
		}
		
		if (!isset($res)) return false;
		
		foreach ($res as $key => $value){
			
			if ($value == 1){
				$message[] = $key;
			}
			if ($value == 0){
				$log[] = $key;
			}
		}
		
		$getSession = @$_SESSION['statusinbox'];
			
		if ($getSession){
			
			if ($getSession ==1) $n_status = 2; // move to trash
			if ($getSession ==2) $n_status = 0;
			if ($getSession ==3) $n_status = 3; // delete from trash
		}else{
			$n_status = 0;
		}
		
		if (isset($message)){
		
			$strid = implode(',',$message);
			$sql = "UPDATE my_message SET n_status = {$n_status} WHERE id IN ({$strid}) ";
			// pr($sql);
			$qData = $this->apps->query($sql);
		}
		
		if (isset($log)){
		
			$strid = implode(',',$log);
			
			$sqlLog = "UPDATE tbl_activity_log SET n_status = {$n_status} WHERE id IN ({$strid}) ";
			// pr($sqlLog);
			$qDataLog = $this->apps->query($sqlLog);
		}
		
		return true;
	}
	
	function readMessage(){
		
		$id = intval($this->apps->_request('id'));
		if($id==0) return false;
		$sql =  "
		SELECT msg.*,sm.name , sm.last_name 
		FROM my_message msg
		LEFT JOIN social_member sm ON sm.id = msg.userid		
		WHERE recepientid = {$this->uid} AND id={$id} LIMIT 1 ";
		$qData = $this->apps->fetch($sql);
		
		if($qData) {
				
			return $qData;
		
		}
		
		return false;
	}
	
	function createMessage($recipientid=0,$msg=null){
		$datatime = date("Y-m-d H:i:s");
		if($recipientid==0) return false;
		if($msg==null)return false;
		$sql ="
			INSERT INTO my_message (fromid, recipientid, fromwho, message, datetime, n_status)
			VALUES ({$this->uid}, {$recipientid}, 1, '{$msg}', '{$datatime}', 0)
			";
		$this->apps->query($sql);
			
		if($this->apps->getLastInsertId()>0) return true;
		
		return false;
	
	}
	
	
	
}