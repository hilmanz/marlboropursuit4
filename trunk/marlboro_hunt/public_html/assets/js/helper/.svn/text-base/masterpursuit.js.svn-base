
			
	$(document).ready(function(){
		if(isLogin) {
			$('.listmessageinbox').hide();
			$('.contentMessageInbox').hide();
			
			$.post(basedomain+'pursuit/task', {taskmessage:true}, function(data){
				var html = "";
				var paging = "";
				var total = 0;
				
				if (data.status == true){
					
						$.each(data.rec, function(i,e){
						
							var datetimes = e.datetime.split(' ');
							var dates = datetimes[0].split('-');
						
							html += "<div class='row'>";
							html += "     <span class='date'>"+e.name+" : "+dates[2]+" / "+dates[1]+" / "+dates[0]+"</span>";
							html += "     <p>"+e.message+" ";
							if(e.type==1) html+= "<a href='javascript:void(0)' class='popup-trade-message reply-message' prop='"+e.fromid+"' desc='"+e.name+"'> reply </a>";
							html+="</p>";
							html += "  </div>";			
							
						})
				}else{
					html += locale.nomessage;
				}
				
				if(total>=5){
					
					paging += "<span class='page'>Showing</span> <span class='page-num'>11</span> <span class='page'>Of</span>";	 
					paging += "<span class='page-num'> "+data.total+" </span> <span class='page last-margin'>Message</span>";	
                    paging += "<a class='prev-Page' href='javascript:void(0)'><</a>";	
                    paging += "<a class='next-Page' href='javascript:void(0)'>></a>";
					// html+="<div class='row paging'>";
					// html+="<a class='prev' href='#'>PREV</a>";
					// html+="<a class='next' href='#'>NEXT</a>";
					// html+="</div>";
				}
				
				$(".startpageinbox").attr('total',data.total);
				$(".listmessageinbox").html(html);
				$(".pagingInboxMessage").html(paging);
			
				
			},"JSON")
			
			
		}
	})
	
	
	// $(".open-inbox").click(function(event){
	
	
	$(document).on('click', '.selectAllMessage', function (event) {
		event.preventDefault();
		
			var ele = $('.inboxtable').find('input');
			if(ele.is(':checked')){
				ele.prop('checked', false);
				$('.inboxtable').removeClass('admin_checked');
			}else{
				ele.prop('checked', true);
				$('.inboxtable').addClass('admin_checked');
			}
		
	});
	
	$(document).on('click', '.deletetAllMessage', function() {
		
		var val = [];
		var type = [];
		$(':checkbox:checked').each(function(i){
		  val[i] = $(this).val();
		  type[i] = $(this).attr('prop');
		});
		
		$.post(basedomain+'pursuit/ajax', {deletemessage:true, type:type, id:val}, function(data){
			
			if (data.status == true){
				// console.log('sukses');
				// getinboxcount();
				getmessaging();
			}else{
				console.log('gagal');
			}
			
		},"JSON")
		
	})
	
	
	  
	$(document).on('click', '.backinbox', function (event) {
		event.preventDefault();
		$('.contentMessageInbox').hide();
		$('.listinbox').show();
		
		
	});
	$(document).on('click', '.messagepreview', function (event) {
		event.preventDefault();
		
		var id = $(this).attr('idmesg');
		var type = $(this).attr('replay');
		
		$.post(basedomain+'pursuit/readmessage',{id:id, type:type},function(data){
			// console.log(data);
			getinboxcount();
		});
		
		$('.contentMessageInbox').show();
		$('.listinbox').hide();
	});
	
	$(document).on('click', '.inboxbutton', function () {
		
		$.post(basedomain+'pursuit/ajax',{setinboxstatus:true, param:'1'},function(data){
			console.log(data);
		},"JSON");
		$("#inboxcounting").trigger("click");
		$('.inboxbutton').addClass('active-inbox');
		$('.sentbutton').removeClass('active-inbox');
		$('.trashbutton').removeClass('active-inbox');
		
	});
	
	$(document).on('click', '.sentbutton', function () {
		$(this).addClass('active-inbox');
		$('.inboxbutton').removeClass('active-inbox');
		$('.trashbutton').removeClass('active-inbox');
		$.post(basedomain+'pursuit/ajax',{setinboxstatus:true, param:'2'},function(data){
			console.log(data);
		},"JSON");
		
	});
	
	$(document).on('click', '.trashbutton', function () {
		
		$.post(basedomain+'pursuit/ajax',{setinboxstatus:true, param:'3'},function(data){
			console.log(data);
		},"JSON");
		
		$("#inboxcounting").trigger("click");
		$('.trashbutton').addClass('active-inbox');
		$('.sentbutton').removeClass('active-inbox');
		$('.inboxbutton').removeClass('active-inbox');
		
	});
	
	function generateInbox(data)
	{
		var rec = data;
		var html = "";
		
		html += "<table class='inboxtable' id='alternatecolor'>";
		html += "	<thead>";
		html += "		<tr>";
		html += "			<th colspan='2'>Subject</th>";
		html += "			<th>Sender</th>";
		html += "		</tr>";
		html += "	</thead>";
		html += "	<tbody>";
		
		$.each(rec, function(i,e){
			
			html += "		<tr class='open-inbox'>";
			html += "			<td class='checklist'>";
			html += "				<form action=''>";
			if (e.type==1){html += "					<input type='checkbox' name='' value='"+e.id+"' prop='"+e.type+"'> ";}   
			html += "				</form>";
			html += "			</td>";
			html += "			<td><span class='messagepreview' prop='"+e.fromid+"' content='"+e.message+"' from='"+e.name+"' replay='"+e.type+"' idmesg='"+e.id+"'>"+e.message+"</span></td>";
			
			if (e.type==0){
			html += "			<td>MARLBORO</td>";
			}else{
			html += "			<td>"+e.name+"</td>";
			}
			
			html += "		</tr>";
			
		})
			
		html += "	</tbody>";
		html += "</table>";
		
		return html;
	}
	
	$(document).on("click","#inboxcounting",function(){
		// $.post(basedomain+'pursuit/seeMessage', function(){});
		$('.listmessageinbox').hide();
		$('.contentMessageInbox').hide();
		$('.listinbox').show();
		
		$.post(basedomain+'pursuit/ajax',{getinboxstatus:true},function(data){
			$('.'+data.classstyle).addClass('active-inbox');
		},"JSON");
		
		
		var inboxNotif = parseInt($(this).attr('prop'));
		
			$.post(basedomain+'pursuit/task', {taskmessage:true}, function(data){
				var html = "";
				var paging = "";
				var total = 0;
			
				if (data.status == true){
					html += generateInbox(data.rec);
				}else{
					html += locale.nomessage;
				}
				
				if(data.total>=5){
					var start = parseInt($(".startpageinbox").attr('page'),10)-5;
					if (start<=0){
						var last = 'lastpage';
						
					}else{
						var last = '';
					}
					
					paging += "<span class='page'>Showing</span> <span class='page-num'>5</span> <span class='page'>Of</span>";	 
					paging += "<span class='page-num'> "+data.total+" </span> <span class='page last-margin'>Message</span>";	
                    paging += "<a class='prev-Page prevInbox "+last+"' href='javascript:void(0)'><</a>";	
                    paging += "<a class='next-Page nextInbox' href='javascript:void(0)'>></a>";
				}
				
				$(".notifinbox").html("("+inboxNotif+")");
				$(".listmessageinbox").html(html);
				$(".pagingInboxMessage").html(paging);
				
			},"JSON")
			
			var lastpage = $('.startpageinbox').attr('lastpage');
			if(lastpage==1) $('.nextInbox').addClass('lastpage');
			
			$('.listmessageinbox').toggle();
		 
			$(document).on('click','#fancybox-close, #fancybox-overlay', function(){
				location.reload();
				
			});
			$("#fancybox-outer").addClass('min102');
	});
	
	
	
	
	$(document).on('click','.nextInbox',function(){
		
		var start = parseInt($(".startpageinbox").attr('page'),10)+5;
		var totalInbox = parseInt($(".startpageinbox").attr("total"));
		
		var lastpage = $('.startpageinbox').attr('lastpage');
		if(lastpage==1) $('.nextInbox').addClass('lastpage');
		
		if(start < totalInbox){
			$.post(basedomain+'pursuit/task', {taskmessage:true, start:start}, function(data){
					var html = "";
					var paging = "";
					// var total = 0;
					
					if (data.status == true){
						
						html += generateInbox(data.rec);
					
					}else{
						html += locale.nomessage;
					}
					
					var lastpage = parseInt(start)+5;
					
					if (lastpage>=totalInbox){
						var last = 'lastpage';
						$('.startpageinbox').attr('lastpage','1');
					}else{
						var last = '';
						$('.startpageinbox').attr('lastpage','0');
					}
					
					
					if(data.total>=5){
						
						var currentRecord = parseInt(start)+5;
						if (currentRecord>data.total) currentRecord = data.total;
						paging += "<span class='page'>Showing</span> <span class='page-num'>"+currentRecord+"</span> <span class='page'>Of</span>";	 
						paging += "<span class='page-num'> "+data.total+" </span> <span class='page last-margin'>Message</span>";	
						paging += "<a class='prev-Page prevInbox' href='javascript:void(0)'><</a>";	
						paging += "<a class='next-Page nextInbox "+last+"' href='javascript:void(0)'>></a>";
						// html+="<div class='row paging'>";
						// html+="<a class='prevInbox' href='javascript:void(0)'>PREV</a>";
						// html+="<a class='nextInbox "+last+"' href='javascript:void(0)'>NEXT</a>";
						// html+="</div>";
					}
				
				$(".startpageinbox").attr('page',start);
				// $(".startpageinbox").attr('total',totalInbox);
				$(".listmessageinbox").html(html);
				$(".pagingInboxMessage").html(paging);
			},"JSON")
			
		}else{
			$('.startpageinbox').attr('lastpage','1');
		}
		
		
			
	})
	
	$(document).on('click','.prevInbox',function(){
		
		var start = parseInt($(".startpageinbox").attr('page'),10)-5;
		var totalInbox = parseInt($(".startpageinbox").attr("total"));
		// var nextStart = parseInt(start+5);
		
		
		if(start>=0){
			$.post(basedomain+'pursuit/task', {taskmessage:true, start:start}, function(data){
					var html = "";
					var paging = "";
					// var total = 0;
					
					if (data.status == true){
						
						html += generateInbox(data.rec);
					}else{
						html += locale.nomessage;
					}
					
					var lastpage = parseInt(start)-5;
					
					if (lastpage<=0){
						var last = 'lastpage';
						// $('.startpageinbox').attr('lastpage','1');
					}else{
						var last = '';
						$('.startpageinbox').attr('lastpage','0');
					}
					
					if(data.total>=5){
						
						var startmsgPage = parseInt($(".startpageinbox").attr('page'));
					
						var currentRecord = parseInt(startmsgPage);
					
						paging += "<span class='page'>Showing</span> <span class='page-num'>"+currentRecord+"</span> <span class='page'>Of</span>";	 
						paging += "<span class='page-num'> "+data.total+" </span> <span class='page last-margin'>Message</span>";	
						paging += "<a class='prev-Page prevInbox "+last+"' href='javascript:void(0)'><</a>";	
						paging += "<a class='next-Page nextInbox' href='javascript:void(0)'>></a>";
						// html+="<div class='row paging'>";
						// html+="<a class='prevInbox "+last+"' href='javascript:void(0)'>PREV</a>";
						// html+="<a class=' nextInbox' href='javascript:void(0)'>NEXT</a>";
						// html+="</div>";
					}
				
				$(".startpageinbox").attr('page',start);
				// $(".startpageinbox").attr('total',totalInbox);
				$(".listmessageinbox").html(html);
				$(".pagingInboxMessage").html(paging);
			},"JSON")
		
			$('.startpageinbox').attr('lastpage','0');
			$('.nextInbox').removeClass('lastpage');
		}else{
			// $('.startpageinbox').attr('lastpage','1');
			$('.prevInbox').addClass('lastpage');
		}
		
		
	})
	
	$(document).on('click', '.messagepreview', function() {
		var detail = "";
		var getid = $(this).attr('prop');
		var from = $(this).attr('from');
		var content = $(this).attr('content');
		var replay = $(this).attr('replay');
		var subject = "-";
		var detail = generateHtmlInbox(getid, from,subject,content, replay);
		$(".contentMessageInbox").html(detail);
		$(".contentMessageInbox").show();
		
		// $('.framelistinbox').html('');
		// $('.titleinbox').html('');
		// $('.back-Action').html('');
	});
		
	function generateHtmlInbox(id,from, subject, content, replay){
		
		var html = "";
		// var rec = data;
		var replay = parseInt(replay);
		
		html += "<div class='info-sender'>";
		html += "			<div class='row'>";
		html += "				<label>From :</label>";
		if (replay==0){
		html += "				<span>MARLBORO</span>";
		}else{
		html += "				<span>"+from+"</span>";
		}
		
		html += "			</div>";
		html += "			<div class='row'>";
		html += "				<label>Subject :</label>";
		if (replay==0){
		html += "				<span>[NOTIFICATION]</span>";
		}else{
		html += "				<span>[MESSAGE]</span>";
		}
		html += "			</div>";
		html += "		</div>";
		html += "		<div class='text-message'>";
		html += content;
		html += "		</div>";
		html += "		<div class='actionInbox'>";
		html += "				<div class='back-Action fl'>";
		html += "					<a class='backinbox' href='javascript:void(0)'>Back To Inbox</a>";
		html += "				</div>";
		
		if (replay==1){
		html += "				 <div class='reply fr'>";
		html += "					<a class='replyMessage bg_red popup-trade-message reply-message' href='javascript:void(0)' prop='"+id+"' desc='"+from+"'>reply</a>";
		html += "				 </div>";
		}
		
		html += "		  </div>";
		
		return html;
	}
	
	$(document).on('click','.popup-trade-message',function(){
		
		var userID = $(this).attr('prop');
		var userName = $(this).attr('desc');
		var html = "";
		// $('.listmessageinbox').toggle();
		
		// html += "<div class='entry-popup popup-create-message'>";
        // html += "    	<h4 class='titleMessages'>Enter your message to "+userName+" below</h4>";
		// html += "        	<div class='row'>";
        // html += "			<textarea class='trademessage'></textarea>";
        // html += "			<input type='hidden' value='"+userID+"' class='tradeidUser'/>";
		// html += "            <input type='submit' value='SUBMIT' class='button btn_grey fl submittrademessage' />";
        // html += "            </div>";
        // html += "    </div>";
		
		html += "<div class='info-sender'>";
		html += "			<div class='row'>";
		html += "				<label>From :</label>";
		html += "				<span>"+userName+"</span>";
		html += "			</div>";
		html += "			<div class='row'>";
		html += "				<label>Subject :</label>";
		html += "				<span>[MESSAGE]</span>";
		html += "			</div>";
		html += "		</div>";
		html += "		<div class='row'>";
		html += "			<textarea class='trademessage'></textarea>";
		html += "		</div>";
		html += "		<div class='actionInbox'>";
		html += "			 <div class='reply fr'>";
		html += "			<input type='hidden' value='"+userID+"' class='tradeidUser'/>";
		html += "				<a class='replyMessage bg_red submittrademessage' href='javascript:void(0)'>reply</a>";
		html += "			 </div>";
		html += "	  </div>";
		// html +="tes";
		$(".replay-message").trigger("click");			
		$(".replaymessagecontent").html(html);
		$(".titlepursuit").html("Message");
	})
	
	$(document).on('click','.submittrademessage',function(){
		var idUser = $('.tradeidUser').val();
		var getMesg = $('.trademessage').val();
		
		$.post(basedomain+'pursuit/ajax', {tradeMesg:true, id:idUser, mesg:getMesg}, function(data){
			var html = "";
			var getStatus = data.status;
			if (getStatus == true){
				html += "<h1>"+locale.messagesent+"</h1>";
			}else{
				html += "<h1>"+locale.messagefail+"</h1>";
			}
			
			$(".pursuit-popup").trigger("click");			
			$(".contentpursuit").html(html);
			$(".titlepursuit").html(locale.messagetitle);
		},"JSON")
	})
	
	function hiddenpackage(){
		$(document).on('click', '.hiddenPackage', function(){
			
			var getToken = $(this).attr('token');
			$.post(basedomain+"games/hiddencode",{hiddenCode:true, param:getToken}, function(data){
				
				var html = "";
				if (data.status == true){
					//html += "<div class='popup'>";
					//html += "<div class='popupContainer popup-hidden-package' id='popup-hidden-package' style='width:400px' >";
					html += "<div class='popupContent centerText'>";
					html += "<h2>Congratulations!</h2>";
					html += "<h3>"+locale.hiddenpacktextheader+"</h3>";
					// html += "<a class='thumb-small fl'><img src='"+basedomain+"assets/content/tiles/"+data.rec.toLowerCase()+".png' /></a></h3>";
					// html += "<h3>"+data.rec+" &nbsp"+locale.hiddenpacktextfooter+"</h3>";
					// html += "<h3>you've found a hidden marlboro pack.<br />you got yourself a code for <a href='"+basedomain+"pursuit'>the pursuit.</a> <br />copy the code below and use it to<br /> redeem a letter.</h3>";
					// html += "<input type='text' value='"+data.rec+"' class='theCodes' />";
					html += "</div>";
					//html += "</div>";
					//html += "</div>";
				}else{
					html += "<h1>"+locale.failed+"</h1>";
				}
				
				
				
				
				$(".hidden-package").trigger("click");			
				$(".contenthiddenpack").html(html);
				
				
				$(document).on('click','#fancybox-close, #fancybox-overlay', function(){
					location.reload();
					
				});
				$("#fancybox-outer").addClass('min102');
				
				
			},"JSON")
			
		});
	}
	
	function mybirthday(){
		
				$.post(basedomain+"pursuit/task",{getGiftBirthday:true}, function(data){
						
						if (data.status == true){
							html = "<div id='popupBirthday' class='popupContent' style='text-align:left;' >";
							html += "<h1>Happy Birth Day To You!! <span class='white'>It is a present from us</span></h1>";
							html += "<div class='pop-birthday-left'>";
							html += "<div class='row' ><img src='"+basedomain+"assets/content/thumb_gift.jpg' width='100%' /></div>";
							html += "</div>";
							
							html += "<div class='pop-birthday-right'>";
							html += "<div class='row' ><h3>And we want to deliver this gift to you, please provide your information first:</h3></div>";
							html += "<div class='pop-birthday-right2'>";
					
							html += "<div class='row' > Name <input type='text' value='' class='birthname'   maxlength='10' /></div>";
							html += "<div class='row' > Address <input type='text' value='' class='birthdayaddress' /></div>";
							html += "<div class='row' > Barangay <input type='text' value='' class='birthbarangay' /></div>";
							html += "</div>";
							html += "<div class='pop-birthday-right2'>";
							html += "<div class='row' > Province <input type='text' value='' class='birthprovince' /></div>";
							html += "<div class='row' > City <input type='text' value='' class='birthcity' /></div>";
							html += "<div class='row' > ZipCode <input type='text' value='' class='birthzip'   maxlength='4' /></div>";
							html += "</div>";
							//html += "<div class='row' > Phone Number <input type='text' value='' class='birthdayphone' /></div>";
							//html += "<div class='row' > Email <input type='text' value='' class='birthdayemail' /></div>";
							html += "<input type='hidden' value='"+data.rec.id+"' class='hiddenid' />";
							html += "<input type='button' value='CONFIRM MAILING ADDRESS' class='button btn_grey fl getgiftbirtday' /></div>";
							html += "</div>";
							html += "</div>";
							
							
						$(".contentmybirthday").html(html);
						$(".my-birthday").trigger("click");
						}
					},"JSON");
						
						
		$(document).on('click','.getgiftbirtday',function(){
			
			var name = $('.birthname').val();
			var address = $('.birthdayaddress').val();
			var city = $('.birthcity').val();
			var barangay = $('.birthbarangay').val();
			var province = $('.birthprovince').val();
			var codezip = $('.birthzip').val();
			
			//var phone = $('.birthdayphone').val();
			//var email = $('.birthdayemail').val();
			
			
			var id = $('.hiddenid').val();
			
			
			address = address+', '+barangay+', '+city+', '+province+', '+codezip;
			$.post(basedomain+"pursuit/task",{birthdayGift:true, address:address, id:id,name:name}, function(data){
				
				var html = "";
				if (data.status == true){
					html += "<h1>Success</h1>";
				}else{
					html += "<h1>Failed</h1>";
				}
				
				$(".pursuit-popup").trigger("click");			
				//$(".contentpursuit").html(html);
				$(".titlepursuit").html(html);
			},"JSON");
		})
	}
	
	function login20th(){
	
						html = "<div class='popupContent ' style='text-align:left;' >";
						html += "<h2>Congratulations!</h2>";
						html += "<h2>This is your 20th login. You get a new letter!</h2>";
						html += "<div class='row' style='text-align:center' ><img src='"+basedomain+"assets/content/tiles/"+letter+".png' /></div>";
					
						html += "</div>";
						
				
					
						$(".contentmyaccount").html(html);
						$(".my-account-profile").trigger("click");
						$("#fancybox-outer").addClass('min10');
					
	
	}
	
	
	function getmessaging(){
		
		var startmsg = parseInt($(".startpageinbox").attr('page'),10);
		var totalInbox = parseInt($(".startpageinbox").attr("total"));
		// var nextStart = parseInt(start+5);
		// if(start < totalInbox){
		$.post(basedomain+'pursuit/task', {getinboxstatus:true}, function(data){
				console.log('masuk');	
				console.log(data);
				// if (data.status==true){
					// $('.'+data.classstyle).addClass('active-inbox');
					
				// }
				
			},"JSON")
		
		$.post(basedomain+'pursuit/task', {taskmessage:true,start:startmsg}, function(data){
				var html = "";
				var paging = "";
				var total = 0;
				
				if (data.status == true){
					html += generateInbox(data.rec);
				}else{
					html += locale.nomessage;
				}
				
				if(data.total>=5){
					
					var lastpage = $('.startpageinbox').attr('lastpage');
					//if(lastpage==1) $('.nextInbox').addClass('lastpage');
					if (lastpage==1){
						var last = 'lastpage';
					}else{
						var last = '';
					}
					
					if (startmsg ==0){
						startmsg = 5;
						var pre = 'lastpage';
					}else{
						var pre = '';
					}
					// html+="<div class='row paging'>";
					// html+="<a class='prevInbox "+pre+"' href='javascript:void(0)'>PREV</a>";
					// html+="<a class='nextInbox "+last+"' href='javascript:void(0)'>NEXT</a>";
					// html+="</div>";
					
					var startmsgPage = parseInt($(".startpageinbox").attr('page'));
					
					var currentRecord = parseInt(startmsgPage)+5;
					
					
					
					paging += "<span class='page'>Showing</span> <span class='page-num'>"+currentRecord+"</span> <span class='page'>Of</span>";	 
					paging += "<span class='page-num'> "+data.total+ "</span> <span class='page last-margin'>Message</span>";	
					paging += "<a class='prev-Page prevInbox "+pre+"' href='javascript:void(0)'><</a>";	
					paging += "<a class='next-Page nextInbox "+last+"' href='javascript:void(0)'>></a>";
					
				}
				
				
				$(".listmessageinbox").html(html);
				$(".pagingInboxMessage").html(paging);
			
				
				
			},"JSON")
			
		
			
			
		// }
	}
	
	function getFlashVersion(){
	  // ie
		try {
				try {
				  // avoid fp6 minor version lookup issues
				  // see: http://blog.deconcept.com/2006/01/11/getvariable-setvariable-crash-internet-explorer-flash-6/
					var axo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash.6');
					try { axo.AllowScriptAccess = 'always'; }
					catch(e) { return '6,0,0'; }
				} catch(e) {}
				return new ActiveXObject('ShockwaveFlash.ShockwaveFlash').GetVariable('$version').replace(/\D+/g, ',').match(/^,?(.+),?$/)[1];
				// other browsers
			} catch(e) {
				try {
					if(navigator.mimeTypes["application/x-shockwave-flash"].enabledPlugin){
						return (navigator.plugins["Shockwave Flash 2.0"] || navigator.plugins["Shockwave Flash"]).description.replace(/\D+/g, ",").match(/^,?(.+),?$/)[1];
				}
				} catch(e) {}
			}
		return '0,0,0';
	}
 
