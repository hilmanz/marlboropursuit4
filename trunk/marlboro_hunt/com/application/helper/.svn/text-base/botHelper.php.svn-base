<?php 

class botHelper {

	function __construct($apps){
		global $logger;
		$this->logger = $logger;
		$this->apps = $apps;
		$this->uid  = 0;
		if(is_object($this->apps->user)) $this->uid = intval($this->apps->user->id);
		
		$this->dbshema = "marlborohunt";	
		
		$this->week = 7;
		$week = intval($this->apps->_request('weeks'));
		if($week!=0) $this->week = $week;
		
		$this->startweekcampaign = "2013-05-20";
		$this->datetimes = date("Y-m-d H:i:s");
		$this->multiple = 20;
		// pr($this->apps->_request('week'));
	}

	
	function get20logingift()
	{
		global $LOCALE;
		$contentHelper = $this->apps->useHelper("contentHelper");
		$checkCode = false;
		$mytoken = false;
		$gamesarrayid = array(1,2);
		$token = strip_tags($this->apps->_p('token'));
		$salt = "gameapihelper";
		// if(!$token) return false;
		/* token matching with*/
		$mytoken = sha1($this->uid.date("YmdHi")."true{".$salt."}");
	
	
		/* validation */
		if($this->uid==0) return false;		
		// if($token!=$mytoken) return false;
		
		/* check this user has got 20 login codes */
		$checkgot20logincode  = $this->checkgot20logincode();
		if($checkgot20logincode) return false;
		
		/* check this user has 20++ login  */
		$checkuserlogincount  = $this->checkuserlogincount();
		if(!$checkuserlogincount) return false;
		
		
		$checkCode = $this->checkpublicexistsinventory();
		if(!$checkCode) return false;
		
		if($checkCode['result']){
			
					/* save to inventory user if  */
					$saved = $this->savetoinventory(true,$checkCode['data']);
					if($saved){
							sleep(1);
							$contentHelper->completetask(1460);
							sleep(1);
							$this->apps->log('accompalished',$LOCALE[1]['20thloginupdate']);
							return $checkCode;
					}
			
		}else{
			
			$checkCode = false;
			/* if not found code in publicity code, create 1 code for this user */
			
			$firstcreatecode = $this->generateCode();
			if(!$firstcreatecode) return false;		
			
			$checkCode = $this->checkpublicexistsinventory();
			if(!$checkCode) return false;
				
			if($checkCode['result']){
				
					/* save to inventory user   */
			
						
					$saved = $this->savetoinventory(true,$checkCode['data']);
					
					if($saved) {
						sleep(1);
						$contentHelper->completetask(1460);
						sleep(1);
						$this->apps->log('accompalished',$LOCALE[1]['20thloginupdate']);
						return $checkCode;
					}
			
			}else return false;
		}
		
		return false;
	}
	
	function getuserfirstloginletter()
	{
		$checkCode = false;
		$mytoken = false;
		$usertype = array(0,1,2);
		$gamesarrayid = array(1,2);
		$usertypeletter[0]='onlineuserletter';
		$usertypeletter[1]='offlineuserletter';
		$usertypeletter[2]='existinguserletter';
		$token = strip_tags($this->apps->_p('token'));
		$salt = "gameapihelper";
		// if(!$token) return false;
		/* token matching with*/
		$mytoken = sha1($this->uid.date("YmdHi")."true{".$salt."}");
	
	
		/* validation */
	
		if($this->uid==0) return false;		
		// if($token!=$mytoken) return false;
		
		
		
		/* check this user */
		$checkuserexist  = $this->checkuserisexisting();
		if($checkuserexist['usertype']==2) $howmany =2 ;
		else $howmany=1;
		
		for($i=1;$i<=$howmany;$i++):
		
		if(!in_array($checkuserexist['usertype'],$usertype)) return false;	
		
		/* check this user has got existing codes */
		$checkgotfirstlogincode  = $this->checkgotfirstlogincode($usertypeletter[$checkuserexist['usertype']]);		
		if($checkgotfirstlogincode) return false;
		
		$checkCode = $this->checkpublicexistsinventory($usertypeletter[$checkuserexist['usertype']]);
		
		if(!$checkCode) return false;
	
		if($checkCode['result']){
			
					/* save to inventory user if  */
					
					$saved = $this->savetoinventory(true,$checkCode['data'],$usertypeletter[$checkuserexist['usertype']]);
					
					if($saved) {
						
						if ($i>=$howmany) {
							// $this->apps->contentHelper->completetask();
							return array('status'=>true, 'type'=>$checkuserexist['usertype']);
						}
					}
			
		}else{
		
			$checkCode = false;
			/* if not found code in publicity code, create 1 code for this user */
			
			$firstcreatecode = $this->generateCode("FIRST LOGIN LETTER USER",$usertypeletter[$checkuserexist['usertype']]);
			if(!$firstcreatecode) return false;		
				
			$checkCode = $this->checkpublicexistsinventory($usertypeletter[$checkuserexist['usertype']]);
			if(!$checkCode) return false;
				
			if($checkCode['result']){
			
					/* save to inventory user   */
			
						
					$saved = $this->savetoinventory(true,$checkCode['data'],$usertypeletter[$checkuserexist['usertype']]);
					
					if($saved){
						// echo $i.' and how many'.$howmany;
						if ($i>=$howmany) {
							// $this->apps->contentHelper->completetask();
							return array('status'=>true, 'type'=>$checkuserexist['usertype']);
						}
						// return array('status'=>true, 'type'=>$checkuserexist['usertype']);
					}
			
			}else {
			
			return false;
			}
		}
		
		endfor;
		return false;
	}
	
	
	function checkuserisexisting(){
		$sql ="SELECT usertype FROM social_member WHERE id={$this->uid} LIMIT 1";
		$qData = $this->apps->fetch($sql);
		
	
		if($qData) {
			return $qData;
		
		}
		return false;
	
	}
	
	
	function checkgot20logincode(){
		global $CONFIG;
		
		if($CONFIG['20loginevent']==false) return true;
		
		$sql ="
			SELECT COUNT(*) total FROM tbl_code_publicity public
			WHERE EXISTS 
			(SELECT * FROM tbl_code_inventory WHERE codepublicityid = public.id AND userid={$this->uid} ) 
			AND channel='games20th' 
			AND n_status = 1 
			LIMIT 1";
		
	
		$qData = $this->apps->fetch($sql);
		
		if($qData) {
		
			if($qData['total']>0) 	{
			
				return true;
			}else return false;
		
		}
		return false;
	
	
	}
	
	function checkuserlogincount(){
		// $sql ="SELECT login_count FROM social_member WHERE id={$this->uid} LIMIT 1";
		$sql ="
		SELECT COUNT(*) total FROM (
			SELECT user_id,DATE(date_time) dd FROM tbl_activity_log WHERE user_id={$this->uid} AND DATE(date_time) >= '2013-07-01' GROUP BY dd LIMIT 20
		) a
		";
		$qData = $this->apps->fetch($sql);
		
	
		if($qData) {
		
			if($qData['total']>=$this->multiple) 	{
				return true;
				// if(($qData['login_count']%$this->multiple)==0) 	return true;
			}
		
		}
		return false;
	}
	
	
	
	function savetoinventory($win=false,$code=false,$gamenames="20th",$howmany=1){
		
		if(!$win) return false;
		if(!$code) return false;
		$contentHelper = $this->apps->useHelper("contentHelper");
		/* randcode , add proba in here if want to use of fontend */
		$getMasterCodeForRandom = $this->getMasterCodeForRandom();
		$randcodeidmekans = $contentHelper->randomcodegen($getMasterCodeForRandom);
		if($randcodeidmekans!=false) $code['codeid']=$randcodeidmekans;
			
		/* userid 	codeid 	codepublicityid 	n_status 	histories */
		$date = date('Y-m-d H:i:s');
		$sql = " INSERT INTO tbl_code_inventory 
		(userid, codeid, codepublicityid, n_status, datetimes, histories) 
		VALUES ({$this->uid},{$code['codeid']},{$code['id']},0, '{$date}', ' get from login {$gamenames} ')";		
		
		$this->apps->query($sql);
		if($this->apps->getLastInsertId()){
			return true;
		}else return false;
		return false;
	}
	
	function checkgotfirstlogincode($channel='games20th'){
	
		$sql ="
			SELECT COUNT(*) total FROM tbl_code_publicity public
			WHERE EXISTS 
			(SELECT * FROM tbl_code_inventory WHERE codepublicityid = public.id AND userid={$this->uid} ) 
			AND channel='{$channel}' 
			AND n_status = 1 
			LIMIT 1";
		
	
		$qData = $this->apps->fetch($sql);
		
		if($qData) {
			if($channel=='existinguserletter') $howmany = 1;
			else $howmany = 0;
			// pr($qData);
			// pr($channel);
			// pr($howmany);
			if($qData['total']>$howmany) 	{
			
				return true;
			}else return false;
		
		}
		return false;
	
	
	}
	
	function checkpublicexistsinventory($channel='games20th'){
		
		
		$data['result'] = false;
		$data['data'] = false;
		
		$sql ="
			SELECT * FROM tbl_code_publicity public
			WHERE NOT EXISTS 
			(SELECT * FROM tbl_code_inventory WHERE codepublicityid = public.id AND userid={$this->uid} ) 
			AND channel='{$channel}' 
			AND n_status = 1 
			LIMIT 1";
		// pr($sql);
		$qData = $this->apps->fetch($sql);
		
		
		if($qData) {
				
			$data['result'] = true;
			$data['data'] = $qData;
		
		}
		return $data;
		
	
	}
	
	function generateCode($codename="20TH LOGIN CODE",$channel="games20th")
	{
	
	
		$location = $codename;
		$channel = $channel;
		$posteddate = date('Y-m-d H:i:s');
		$expireddate =date('Y-m-d H:i:s');
		$group = $channel;

		$sql = "SELECT * FROM tbl_code_detail WHERE n_status = 1 AND  codetype <> 1 ";
		$masterCode = $this->apps->fetch($sql,1);
		$datetime = date("Y-m-d H:i:s");
		$getres = false;
		

			foreach ($masterCode as $key => $value){
				$popprob = ($value['prob'] * ($value['prob'] * (rand(1,12))));
				$code[$value['id']] = $popprob;
				$data[$value['id']] = $value['codename'];
				$masterCode[$key]['popprob'] = $popprob;

			}
			$maxCode = max($code);
			$key = array_search($maxCode, $code);
			$codevalue = $data[$key];
			$letters  = "ABCDEFGHJKMNPQRSTUVWXYZ23456789";
			$maskcode = substr(str_shuffle($letters), 0, 8);
			

			$sql = "INSERT INTO tbl_code_publicity 
					(maskcode, codeid, location, channel, codevalue, datetime, grouptype, n_status, used,posted_date,expired_date)
					VALUES 
					('{$maskcode}', {$key}, '{$location}', '{$channel}', '{$codevalue}', '{$datetime}', '{$group}', 1,0,'{$posteddate}','{$expireddate}')";
			// pr($sql);
			$res = $this->apps->query($sql);
			if($this->apps->getLastInsertId()){
				$getres[$maskcode] = 1;
			}else $getres[$maskcode] = 0;
			
	
		
		if($getres){
			$success = 0;
			$failed = 0;
			foreach($getres as $key => $val){
				if($val==1) $success++;
				else $failed++;			
			}
		
			/* for log generator */
			$this->logthisgenerator($success,$failed,$datetime,$masterCode);
				
				return true;
		}
		
				
			return false;
	}
	
	
	
	function logthisgenerator($success=0,$failed=0,$datetime=null,$data=false){
	
		if($datetime==null) return false;
		if($data==false) return false;
		
		
		$data = serialize($data);
		
		$sql = " INSERT INTO tbl_code_log (success,failed,datetime,data) VALUES ({$success},{$failed},'{$datetime}','{$data}')";		
		
		$this->apps->query($sql);
		if($this->apps->getLastInsertId()){
			return true;
		}else return false;
	
	}
	
		
	function getMasterCode()
	{
		$sql = "SELECT id, codename FROM tbl_code_detail WHERE n_status = 1 ";
		$result = $this->apps->fetch($sql,1);
		if ($result){
		$data = false;
			foreach ($result as $value){
				$data[$value['id']] = $value['codename'];
				// $dataID[] = $value['id'];
				// $codeName[] = $value['codename'];
			}
	
			$this->logger->log(json_encode($data));
	
			return $data;
		}else{
			return false;
		}
	}
	
	function getMasterCodeForRandom()
	{
		global $CONFIG;
		if($CONFIG['usingelusive']) $qidcode = "";
		else $qidcode = " AND codetype = 0 ";
		
		$sql = "SELECT * FROM tbl_code_detail WHERE n_status = 1 {$qidcode} ";
		$result = $this->apps->fetch($sql,1);
		if ($result){
		
			return $result;
		}else{
			return false;
		}
	}
	
}

?>

