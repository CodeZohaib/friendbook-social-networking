
function submitForm(form)
{
	var footer=form.parent('.modal-body').next('.modal-footer');

	footer.html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");
	var file1=form.get(0).image;
	if (file1===undefined || file1==null || file1==='') 
	{	
		$.ajax({
		url:form.attr('action'),
		method:form.attr('method'),
		data:form.serialize(),
		success:function(response){
			show_message(response,footer);
		}

      });

	}
	else
	{
		var formData = new FormData($(form)[0]);

		$.ajax({
			method:form.attr('method'),
			url:form.attr('action'),
			data:formData,
			success:function(response){
				show_message(response,footer);
			},
			cache: false,
      contentType: false,
      processData: false,

		});
   }		
}


function show_message(response,display)
{
	var response=$.parseJSON(response);

	if (response.success) 
	{
		if (response.signout)
		{
			setTimeout(function(){
				window.location.reload();
			},2000);
		}
		else if (response.url) 
		{
			setTimeout(function(){
				window.location=response.url;
			},2000);
		}

		display.html("<p class='alert alert-success text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
	}
	else if(response.error)
	{
		display.html("<p class='alert alert-danger text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
	}
	else if(response.securityVerification)
	{
		if (response.url) 
		{
			setTimeout(function(){
				window.location=response.url;
			},2000);
		}

		display.html("<p class='alert alert-danger text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
	}
	else if (response.dialog) 
	{
		dailog($('#dialog'),response.title,response.message,response.activty_type);
	}
	else if (response.update_email) 
	{
		display.html("<p class='alert alert-success text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
	}

}

function dailog(event,title,message,activty_type)
{
	event.attr('title',title).html(message).dialog({
		minWidth: 400,
		maxWidth: 'auto',
		draggable:false,resizable:false,modal:true,
	    show:{'effect':'explode'},
	    hide:{'effect':'pulsate','duration':600},
		buttons:{'OK':function(){

			if (activty_type==='close')
			{
				$(this).dialog("close");
			}
			else
			{
				var refersh=window.location.href=activty_type;
			}
	    }
	}})
}

function uploadFiles(form,formData)
{
	$.ajax({
		type:form.attr('method'),
		url:form.attr('action'),
		data:formData,
		contentType:false,
		processData:false,
		success:function(response){
			response=$.parseJSON(response);
			if (response.dialog)
			{
				form.value="";
				$('#dialog').attr('title',response.title).html(response.message).dialog({
					minWidth: 400,
					maxWidth: 'auto',
					draggable:false,resizable:false,modal:true,
			        show:{'effect':'explode'},
			        hide:{'effect':'pulsate','duration':600},
					buttons:{'OK':function(){
			      	 $(this).dialog("close");
			      }

			  }});

			}
		}
    }); 
}

function delete_profile_cover(url,value)
{         
	$.ajax({
		url:window.location.origin+url,
		method:'Post',
    data:{data:value},
		success:function(response){
			var response=$.parseJSON(response);
			if (response.dialog) 
			{
				dailog($('#dialog'),response.title,response.message,response.activty_type);
			}
		}
	});
}

function ProgressBar(form)
{
	$('.percentage').html('');
  $('.progress-bar').css('width','0%');

  var msgDisplay=$('.progressMsg');

	msgDisplay.html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");

	var file1=form.get(0).image;
	var formData = new FormData($(form)[0]);

		$.ajax({
			method:form.attr('method'),
			url:form.attr('action'),
			data:formData,
			xhr:function(){
	          var xhr=new XMLHttpRequest();
	          var percentage=0;
	          xhr.upload.addEventListener('progress',function(e){
	              percentage=Math.round((e.loaded/e.total)*100);
	              $('.percentage').html(percentage+"%");
	              $('.progress-bar').css('width',percentage+"%");
	            });

	            return xhr;
	          },
			success:function(response){
				show_message(response,msgDisplay);
			},
			cache: false,
      contentType: false,
      processData: false,

		});	
}

function send_request(request_id,request_class,event)
{
   $.ajax({
		url:window.location.origin+'/friendbook/friendRequest/sendRequest',
		method:'Post',
		data:{request_id:request_id,request_class:request_class},
		success:function(response){
			response=$.parseJSON(response);

			  //console.log(response);
 		    if(response.error)
 		    {
 		       dailog($('#request_errors'),'Friend Request Error',response.message,'close');
 		    }
 		    else if (response.type==='Request Send')
 		    {

 		    	event.removeClass("btn btn-primary").addClass('btn btn-primary1').css('color','white');
 		    	event.text('Cancle Request');
 		    }
 		    else if (response.type==='Send Request Sidbar')
 		    {
 		    	event.text('Request Send');
 		    }
 		    else if (response.type==='Add Friend')
 		    {
 		    	event.removeClass("btn btn-primary1").addClass('btn btn-primary');
 		    	event.text(response.type);
 		    }
 		    else if (response.type==='Add Friend Sidbar')
 		    {
 		    	event.text('Add Friend');
 		    }
 		    else if (response.type==='Accept Request' || response.type==='Cancle Request') 
 		    {
 		    	event.parents('.user').remove();
 		    }
 		    else if (response.type==='Accept_request_profile') 
 		    {
 		    	event.text('Send Message');
 		    	event.removeClass("btn-success accept_request_profile").addClass('btn-primary send_message');
 		    	$('.cancle_request_profile').remove();
 		    }
 		    else if (response.type==='Request_cancle_profile') 
 		    {
 		    	event.text('Add Friend');
 		    	event.removeClass("btn-success accept_request_profile").addClass('btn-primary add_friend');
 		    	$('.accept_request_profile').remove();
 		    }
 		    else if (response.type==='invalid_user_request') 
 		    {
 		    	dailog($('#dialog'),'Friend Request','Invalid User Request','');
 		    }
 		    else if(response.type==='user_block')
 		    {
 		    	dailog($('#dialog'),'Friend Request','User Block Your Account Cannot Send Friend Request','');
 		    }
 		    else if(response.type==='already_send_friendrequest')
 		    {
 		    	dailog($('#dialog'),'Friend Request','Please Check Your Friend Request User already send friend Request.........!','');
 		    }
		}
    });
}


function update_post_like(post_user_id,id,type,element)
{
	$.ajax({
          url:window.location.origin+'/friendbook/post/postLike',
          method:'POST',
          data:{'post_id':id,'type':type,'post_user_id':post_user_id},
          success:function(response){
            response=$.parseJSON(response);
            if (response.success) 
            {
            	if (response.action==='Delete') 
	            {
						     var like_color='text-green';
								 var dislike_color='text-red';
							}
							else if (response.action==='like') 
							{
								var like_color='';
								var dislike_color='text-red';
							}
							else if (response.action==='dislike') {
								var like_color='text-green';
								var dislike_color='';
							}

            	if (response.likes==null && response.dislikes==null) 
            	{
            		likes=0;
            		dislikes=0;
            	}
            	else if (response.likes!=null && response.dislikes==null)
            	{
            		likes=response.likes;
            		dislikes=0;
            	}
            	else if (response.likes==null && response.dislikes!=null)
            	{
            		likes=0;
            		dislikes=response.dislikes;
            	}
            	else if (response.likes!=null && response.dislikes!=null)
            	{
            		likes=response.likes;
            		dislikes=response.dislikes;
            	}

               $(element).html('&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn '+like_color+'" post_id="'+id+'" u_id="'+post_user_id+'" onclick="thumbsup(this)"><i class="icon ion-thumbsup"></i> '+likes+'</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn '+dislike_color+'"  post_id="'+id+'" u_id="'+post_user_id+'" onclick="thumbsdown(this)"><i class="fa fa-thumbs-down"></i> '+dislikes+'</a> <br><button type="button" class="btn btn-info btn-xs view_like" post_id="'+id+'" u_id="'+post_user_id+'" onclick="viewlike(this)"  data-target="#all_like" data-toggle="modal">View Likes</button> <button type="button" class="btn btn-danger btn-xs view_dislike" post_id="'+id+'" u_id="'+post_user_id+'" onclick="viewdislike(this)" data-target="#all_dislike" data-toggle="modal">View Dislikes</button>');
            }
            else if(response.error)
            {
            	dailog($('#dialog'),'Post Like Error',response.message,'close');
            }
        }

      });
}


var comment_interval;

function insert_comment(form,id,comment,element_show)
{
  clearInterval(comment_interval);

  var footer=form.parent('.post-comment').prev().children('.comment_errors');

	footer.html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");

	$.ajax({
	  url: window.location.origin+'/friendbook/post/insertPostComment',
	  method:'Post',
	  data:{'post_id':id,'comment':comment},
	  success:function(response){
		response=$.parseJSON(response);

		 $(".emojionearea-editor").html('');

		if (response.error)
		{
			footer.html('<div class="alert alert-danger alert-dismissable text-center"; margin:auto"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');
			if (response.url) 
			{
				setTimeout(function(){
					window.location.reload();
				},2000);
			}
		}
		else if(response.success)
		{
			$(".emojionearea-editor").html('');
			comment_interval=setInterval(function(){comment_select(id,element_show)},1000);
		}
		else if (response.dialog) 
		{
			dailog($('#dialog'),response.title,response.message,response.activty_type);
		}
	}

  });
}

function comment_select(id,element)
{
	$.ajax({
          url:window.location.origin+'/friendbook/timeline/getComments',
          method:'POST',
          data:{'post_id':id},
          success:function(response){
            response=$.parseJSON(response);

            if (response.success) 
            {
            	$(element).html(response.message);
            }
        }
    });
}

function delete_comment(comment_id,event)
{
	$.ajax({
          url:window.location.origin+'/friendbook/post/deletePostComment',
          method:'POST',
          data:{'comment_id':comment_id},
          success:function(response){
            var response=$.parseJSON(response);

            if (response.error)
            {
              $('.comment_del_error').html('<div class="alert alert-danger alert-dismissable text-center"; margin:auto"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');
            }
            else if (response.success) 
            {
              if (response.signout)
              {
                $('.comment_del_error').html('<div class="alert alert-success alert-dismissable text-center"; margin:auto"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');
                 $(event).parent().parent().remove();
                setTimeout(function(){
                  $('.delete_comment').modal('hide');
                },1000);
              }
            }
        }
    });
}

var success=0;
function getUserActivity(container, offset, rows)
{
	$.ajax({
		method:'Post',
		url:window.location.origin+'/friendbook/timeline/getActivity',
		data:{'offset':offset,'rows':rows,'url':window.location.href},
		success:function(response){
			var response=$.parseJSON(response);
			  if(response.success)
			  {
			  	success=1;
          container.append(response.message);
			  }
			  else if(response.error)
			  {
			  	if(success==0)
			  	{
			  		container.append(response.message);
			  	} 
			  }
		}
	});
}

var check=0;
function loadAjaxContent(container, offset, rows, url)
{
	var page=window.location.href.split('/').pop();
	$.ajax({
		method:'POST',
		url:window.location.origin+url,
		data:{'offset':offset,'rows':rows,'url':window.location.href},
		success:function(response){

			  try{
          var response=$.parseJSON(response);
        } catch (err) {
        	check=1;
          container.append(response);
        }
    
				if(response.success)
			  {
			  	check=1;
          if(url=='/friendbook/page/sidebarOnlineUser')
          {
          	$('#onlineUsers').html(response.message);
          }
          else
          {
          	container.append(response.message);
          }
			  }
			  else if(response.error)
			  {
			  	if(url=='/friendbook/page/sidebarOnlineUser')
			  	{
			  		$('#onlineUsers').html(response.message);
			  	}
			  	else
			  	{
				  	if(check==0)
				  	{
				  		if(window.location.href.split('/').pop()=='notification')
				  		{
				  			$( ".delete_all_notific" ).remove();
				  		}
				  		$('.error_sms').html(response.message);
				  	} 
			  	}
			  }
		}
	});
}

var count=0;

timeout = setTimeout(function() {
	count=$( ".chat-message > li" ).length;
	clearTimeout(timeout);
}, 2000);

var i=0;

function loadAjaxChatMessage(id,type=null)
{
	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/messages/selectUserMessages',
		data:{'id':id},
		success:function(response){
			 var response=$.parseJSON(response);
				if(response.success)
			  {
			  	$('.send_sms_user').html(response.message);

			  	var check=$( ".chat-message > li" ).length;

			  	if(count!=0 && count<check)
			  	{
			  		chatBoxScroll();
						count=check;
			  	}


		  		if ($('.send_sms_user').find('.userIsTyping').length) 
		  		{
		  			$('.friendTyping').show();
		  			$('.smsTyping').html('Typing.....');
					}
					else
					{
						$('.smsTyping').html('');
						$('.friendTyping').css('display','none');
					}			
			  }
			  else if(response.error)
			  {
				  $('.send_sms_user').html('<div class="alert alert-danger alert-dismissable text-center"; margin:auto" style="margin-top:250px"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');;
			  }
		}
	});
}

function chatBoxScroll() 
{
		var length=$( ".chat-message > li" ).length * 3000;
		$('.send_sms_user').animate({
			  scrollTop: length
			}, 1000);
}

function loadAjaxChatMessageList(id)
{
	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/messages/getAllMessagesList',
		data:{'getAllMessagesList':'getAllMessagesList'},
		success:function(response){
			 var response=$.parseJSON(response);
				if(response.success)
			  {
          $('.display_user_sms_bar').html(response.message);
			  }
			  else if(response.error)
			  {
				  $('.display_user_sms_bar').html('<div class="alert alert-danger alert-dismissable text-center"; margin:auto" style="margin-top:250px"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');;
			  }
		}
	});
}

function copyLink(element)
{
	 var link=$(element).attr('link');
    navigator.clipboard.writeText(link);
    // Alert the copied text
    $('#dialog').attr('title','Post').html('Post Link Copy....!').dialog({
		minWidth: 400,
		maxWidth: 'auto',
		draggable:false,resizable:false,modal:true,
	    show:{'effect':'explode'},
	    hide:{'effect':'pulsate','duration':600},
		buttons:{'OK':function(){
				$(this).dialog('destroy');
	    }
	  }});
}

//Delete Post
var delete_id;
function delete_my_post(element)
{
	delete_id=$(element).attr('delete_id');
  $('.show_error_myPost').text('');
}

function yes_delete_post()
{
     $('.show_error_myPost').html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");
     $.ajax({
          url:window.location.origin+'/friendbook/post/postDelete',
          method:'Post',
          data:{'delete_id':delete_id},
          success:function(response){
            response=$.parseJSON(response);

            if (response.error)
            {
              $('.show_error_myPost').html('<div class="alert alert-danger alert-dismissable text-center"; margin:auto"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');
            }
            else if (response.success) 
            {
              $('.show_error_myPost').html('<div class="alert alert-success alert-dismissable text-center"; margin:auto"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');
            }

            setTimeout(function(){
							window.location.reload();
						},2000);
        }
    });
}


//Post Privicy Change
function postUpdate(element)
{
	submitForm($(element));
}

function thumbsup(event)
{
	var post_id=$(event).attr('post_id');
	var post_user_id=$(event).attr('u_id');
	var element=$(event).parent();

	update_post_like(post_user_id,post_id,'like',element);
}

function thumbsdown(event)
{
	var post_id=$(event).attr('post_id');
	var post_user_id=$(event).attr('u_id');
	var element=$(event).parent();

	if (post_id!=undefined && post_user_id!=undefined && element!=undefined) 
  {
  	update_post_like(post_user_id,post_id,'dislike',element);
  }
  else
  {
  	dailog($('#dialog'),'Error','Something was problem Please Refersh Your web Page......','');
  }

	
}

function viewlike(event)
{
	var post_id=$(event).attr('post_id');
	var post_user_id=$(event).attr('u_id');
	var element=$(event).parent();
	var type='view_like';

	if (post_id!=undefined && post_user_id!=undefined && element!=undefined) 
	{
		viewLikeDislike(post_id,type,post_user_id);
	}
	else
  {
  	dailog($('#dialog'),'Error','Something was problem Please Refersh Your web Page......','');
  }
	
}

function viewdislike(event)
{
	var post_id=$(event).attr('post_id');
	var post_user_id=$(event).attr('u_id');
	var element=$(event).parent();
	var type='view_dislike';

	if (post_id!=undefined && post_user_id!=undefined && element!=undefined) 
	{
	  viewLikeDislike(post_id,type,post_user_id);
	}
	else
  {
  	dailog($('#dialog'),'Error','Something was problem Please Refersh Your web Page......','');
  }
}

function viewLikeDislike(id,type,post_user_id)
{
	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/post/displayLikesDislikes',
      data:{'post_id':id,'type':type,'post_user_id':post_user_id},
      success:function(response){

        if(type=='view_dislike') 
        {
          $('#view_dislikes').html(response);
        }
        else if(type=='view_like')
        {
          $('#view_likes').html(response);
        }
      }
     });
}


function onlineUserInsert()
{
	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/users/onlineUserInsert',
      data:{'onlineUserInsert':'onlineUserInsert'},
     });
}

function checkAnthorDevice()
{
	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/users/checkLoginIp',
      success:function(response)
      {
      	var response=$.parseJSON(response);

				if(response.dialog)
				{
					if(response.title!=null)
					{
						dailog($('#dialog'),response.title,response.message,'/friendbook/users/sessionLogout');

						$('.ui-dialog-titlebar-close').click(function(){
							var refersh=window.location.href='/friendbook/users/sessionLogout';
						});
					}
				}
      }
    });
}


function userSmsSeen(friendID)
{
	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/messages/userSmsSeen',
      data:{'friendID':friendID},
      success:function(response)
      {
      	var response=$.parseJSON(response);
				if(response.error)
				{
					$('.error_sms').html("<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
				}
      }
    });
}



function comment_insert(e)
{
	var formdata1=$(e).parent().parent().children()[0];
	var formdata2=$(e).parent().parent().children()[1];

	var form=$(e).parent().parent();
	var comment=$(formdata1).val();
	var post_id;

	if($(formdata2).val().length>0)
	{
		post_id=$(formdata2).val();
	}
	else if ($(formdata2).val().length==0) 
	{
		formdata2=$(e).parent().parent().children()[2];
		post_id=$(formdata2).val();
	}

	var element_show=$(e).parent().parent().parent('.post-comment').prev().children().parent();

	if (formdata1!=undefined && formdata2!=undefined && form!=undefined && post_id!=undefined && element_show!=undefined) 
	{
		insert_comment(form,post_id,comment,element_show);
	}
	else
  {
  	dailog($('#dialog'),'Error','Something was problem Please Refersh Your web Page......','');
  }
}

function postImage(event)
{
	html="<img src='"+$(event).attr('src')+"' class='img-responsive' />";
		$(".model-image").modal('show');
		$('.show-image').html(html);
}

function reportPost(event)
{
	$('.percentage').html('');
	$('.progressMsg').html('');
	
  $('.progress-bar').css('width','0%');
	post_id=$(event).attr('post_id');

	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/post/getpostComplaint',
      data:{'post_id':post_id},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		$('.complaintHistory').html(response.message);
      	}
      }
    });

	$('#postInputID').html("<input type='hidden' name='post_id' value='"+post_id+"'>");
}

function viewReportPost()
{
	var post_id=$('#postInputID').children().val();

	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/post/getpostComplaint',
      data:{'post_id':post_id},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		$('.complaintHistory').html(response.message);
      	}
      }
    });
}

function reportUser(event)
{
	$('.percentage').html('');
	$('.progressMsg').html('');
	
  $('.progress-bar').css('width','0%');
	user_id=$(event).attr('user_id');
	$('.report').append("<input type='hidden' name='user_id' value='"+user_id+"'>");
}


function totalNotification()
{
	  $.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/post/getPendidnggNotif',
      data:{'allPendingNotif':'allPendingNotif'},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		if(response.message=="")
      		{
      			$('.delete_all_notific').remove();
      		}
      		
      		$('.total_notification').html(response.message);
      	}
      }
    });
}

function totalSmsNotification()
{
	  $.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/messages/getAllSmsNotification',
      data:{'totalSmsNotification':'totalSmsNotification'},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		if(response.message=="0")
      		{
      			$('.totalMessageNotification').html('');
      		}
      		else
      		{
      			$('.totalMessageNotification').html(response.message);
      		}
      		
      		
      	}
      }
    });
}

function totalFriends()
{
	  $.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/friendRequest/totalFriends',
      data:{'totalFriends':'totalFriends'},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		$('.total_friends').html(response.message);
      	}
      }
    });
}


function totalFriendRequest()
{
	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/friendRequest/totalFriendRequest',
      data:{'totalFriendRequest':'totalFriendRequest'},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		$('.total_FriendRequest').html(response.message);
      	}
      }
    });
}

function totalBlockUser()
{
	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/friendRequest/totalBlockUser',
      data:{'totalBlockUser':'totalBlockUser'},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		$('.total_BlockUser').html(response.message);
      	}
      }
    });
}



function delete_message(event)
{
	var id=$(event).attr('id');
	var user_id=$(event).attr('user_id');

	$('.messageError').html("");

	$('.deleteForMe').click(function(){
		$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/messages/deleteMessage',
      data:{'deleteType':'deleteForMe','id':id,'user_id':user_id},
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
			  {	
					$('.messageError').html("<p class='alert alert-success text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
				}
				else if(response.error)
				{
					$('.messageError').html("<p class='alert alert-danger text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
				}
      }
    });
	});


	$('.deleteForEveryone').click(function(){
		$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/messages/deleteMessage',
      data:{'deleteType':'deleteForEveryone','id':id,'user_id':user_id},
      success:function(response){
      	var response=$.parseJSON(response);
			  if(response.success)
			  {	
					$('.messageError').html("<p class='alert alert-success text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
				}
				else if(response.error)
				{
					$('.messageError').html("<p class='alert alert-danger text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
				}
      }
    });
	});
}














