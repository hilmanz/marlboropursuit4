<?php
class event extends App{
	
	
	function beforeFilter(){
		
		$this->contentHelper = $this->useHelper('contentHelper');
		$this->activityHelper = $this->useHelper('activityHelper');
		$this->userHelper = $this->useHelper('userHelper');
		$this->newsHelper = $this->useHelper('newsHelper');
		$this->searchHelper = $this->useHelper('searchHelper');
		global $LOCALE,$CONFIG;
		$this->assign('basedomain', $CONFIG['BASE_DOMAIN']);
		$this->assign('assets_domain', $CONFIG['ASSETS_DOMAIN_WEB']);
		
		$this->assign('locale', $LOCALE[1]);
	}
	
	function main(){
		
			return $this->past();
		
	}
	
	
	function past(){
		
		
		$this->View->assign('popup_game',$this->setWidgets('popup_game'));
		
		// $this->View->assign('event_past_detail',$this->setWidgets('event_past_detail'));
		
		if ($this->_g('id')){
			$this->log('read article',"event_{$this->_g('id')}");
			$detailevent = $this->getGallery(0, 4, 2, $this->_g('id'));
		}else{
			$detailevent = $this->getGallery();
		}
		
		// $detailevent = $this->getGallery();
		
		// pr($detailevent);
		foreach ($detailevent as $value){
			if($value['gallery']){
				
				foreach ($value['gallery'] as $data){
					// pr($data);
					if ($data['typealbum']==2){
						$photo[] = $data['id'];
						
					}
					
					if ($data['typealbum']==3){
						$video[] = $data['id'];
					}
				}
			}else{
				
				$photo = array();
				$video = array();
			}
		}
		
		if (count($photo)) $photo = true;
		else $photo = false;
		if (count($video)) $video = true;
		else $video = false;
		// pr($photo);
		// pr($video);
		// pr($detailevent);
		$this->View->assign("detailevent",$detailevent);
		$this->View->assign("photo",$photo);
		$this->View->assign("video",$video);
		
		$this->View->assign('event_past_list',$this->setWidgets('event_past_list'));
		
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/past-event.html');
	
	}
	function upcoming(){
		
		$this->View->assign('event_upcoming_list',$this->setWidgets('event_upcoming_list'));
		$this->View->assign('event_upcoming_detail',$this->setWidgets('event_upcoming_detail'));
		return $this->View->toString(TEMPLATE_DOMAIN_WEB .'apps/upcoming-event.html');

	}
	
	function ajax(){
		$type = $this->_g('type');
		
		
		if($type == 'foto'){
			
			$varFoto = $this->newsHelper->pastEvent();
			if($varFoto){
				print json_encode(array('status'=>TRUE,'hasil'=>$varFoto));
			}	
		}
		
		if($type == 'video'){
			$varVid = $this->newsHelper->getVideo();
			if($varVid){
				print json_encode(array('status' =>TRUE, 'hasil' => $varVid));
			}
		}
		
		if ($this->_p('getPhoto')){
		
			$start = $this->_p('start');
			$end = $this->_p('end');
			$type = $this->_p('type');
			$id = $this->_p('id');
			
			$detailevent = $this->getGallery($start, $end, $type, $id);
			// pr($detailevent);
			if ($detailevent){
				print json_encode(array('status' =>true, 'rec' => $detailevent));
			}else{
				print json_encode(array('status' =>false));
			}
		}
		
		if ($this->_p('getVideo')){
		
			$start = $this->_p('start');
			$end = $this->_p('end');
			$type = $this->_p('type');
			$id = $this->_p('id');
			
			$detailevent = $this->getGallery($start, $end, $type, $id);
			// echo 'ada';
			// pr($detailevent);
			if ($detailevent){
				print json_encode(array('status' =>true, 'rec' => $detailevent));
			}else{
				print json_encode(array('status' =>false));
			}
		}
		exit; 
	}
	
	function ajaxgallery()
	{
		$start = $this->_p('start');
		$end = $this->_p('end');
		$type = $this->_p('type');
		$id = $this->_p('id');
		$detailevent = $this->getGallery($start, $end, $type,$id);
		// pr($detailevent);
		if ($detailevent){
			print json_encode(array('status' =>true, 'rec' => $detailevent));
		}else{
			print json_encode(array('status' =>false));
		}
		
		exit;
		
	}
	
	function getGallery($start=0, $limit=4, $type=2, $id=false)
	{
		
		$id = $id;
		$detailevent = $this->newsHelper->pastEvent(false, false, $id);
		
		
		if ($detailevent){
			$detailevent[0]['total'] = count($detailevent[0]['gallery']);
			// pr($detailevent);
			
			
				
				if ($detailevent[0]['gallery']){
					
					if ($type == 2){
						// pr($detailevent[0]['gallery']);
						foreach ($detailevent[0]['gallery'] as $key => $value){
							if ($value['typealbum'] == 2){
								// $detailevent[0]['gallery'][$key] = $value;
								$detailevent[0]['myGalery'][$key] = $value;
							}
							
						}
					}else{
						foreach ($detailevent[0]['gallery'] as $key => $value){
							if ($value['typealbum'] == 3){
								$detailevent[0]['myGalery'][$key] = $value;
							}
							
						}
					}
					
					// pr($detailevent[0]);
					if ($detailevent[0]['total'] > 5){
					
						foreach ($detailevent[0]['myGalery'] as $key => $value){
							
							$detailevent[0]['gallery_sort'][] = $value;
						}
						
						// pr($detailevent[0]['gallery_sort']);
						// echo $start.'<br>';
						// echo $limit;
						// exit;
						for($i = $start; $i<=$limit; $i++){
							if (isset($detailevent[0]['gallery_sort'][$i])){
								$detailevent[0]['gallery_paging'][] = $detailevent[0]['gallery_sort'][$i];
							}
							
						}
						
						// pr($detailevent[0]['gallery_paging']);exit;
						foreach ($detailevent[0]['gallery_paging'] as $key => $value){
							
							list($dateFormat, $timeFormat) = explode(' ',$value['created_date']);
							list($year, $month, $date) = explode('-',$dateFormat);
							
							$detailevent[0]['gallery_paging'][$key]['date'] = $date.'/'.$month.'/'.$year;
						}
						// pr($detailevent[0]['gallery_paging']);
					}else{
						
						
						foreach ($detailevent[0]['myGalery'] as $key => $value){
							
							$detailevent[0]['gallery_sort'][] = $value;
						}
						
						for($i = $start; $i<=$limit; $i++){
							if (isset($detailevent[0]['gallery_sort'][$i])){
								$detailevent[0]['gallery_paging'][] = $detailevent[0]['gallery_sort'][$i];
							}
							
						}
						
						
						foreach ($detailevent[0]['gallery_paging'] as $key => $value){
							
							list($dateFormat, $timeFormat) = explode(' ',$value['created_date']);
							list($year, $month, $date) = explode('-',$dateFormat);
							
							$detailevent[0]['gallery_paging'][$key]['date'] = $date.'/'.$month.'/'.$year;
						}
					}
				}
				
			return $detailevent;
		}
		
		return false;
		
	}
	
}
?>