
jQuery(document).ready(function($) {

	var chatIntervel;

	$('.model-image').on('hidden.bs.modal', function () {
	  $('.post_report').css('overflow-y', 'auto');
	});

	$('.viewChatBoxMedia').on('hidden.bs.modal', function () {
	  $('audio').trigger('pause');
		$('video').trigger('pause');
		$('.loadMedia').html('');
	});


  $('.comment_input').emojioneArea({
			pickerPosition:'top',
		});

   $('.emojiBottom').emojioneArea({
			pickerPosition:'bottom',
		});

		$("#profilePic").on("change",function(){
			$('#showName').html( $('#profilePic').val());
		});
		$("#select_image_videos").on("change",function(){
			$('#showName').html( $('#select_image_videos').val());
		});

   $(".viewVideo").on('hide.bs.modal', function(){
     $('video').trigger('pause');
   });

   $('.delete_all_notific').click(function(){
   	 $.ajax({
        method:'POST',
        url:window.location.origin+'/friendbook/post/deleteAllPedingNotif',
        data:{'url':window.location.href},
        success:function(response){
        	var response=$.parseJSON(response);

        	if(response.success)
        	{
        		$('.total_notification').html('');
        		$('.delete_all_notific').remove();
        		window.location.reload();
        	}
        	else if(response.error)
        	{
        		dailog($('#dialog'),response.title,response.message,response.activty_type);
        	}
        }
      });
   })

  $('.search_friend_profile').on('submit',function(e){
		e.preventDefault();
		var form=$(this);

		$.ajax({
			url:form.attr('action'),
			method:form.attr('method'),
			data:form.serialize(),
			success:function(response)
			{
				var response=$.parseJSON(response);
				if(response.success)
				{
					$('.error_sms').html('');
					$('.loadAjaxData').html(response.message);
				}
				else
				{
					$('.error_sms').html("<br><br><p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
				}
				
			}
	  });
	});


	let searchParams = new URLSearchParams(window.location.search);

	if(searchParams.has('user_block')==true)
	{
		dailog($('#dialog'),'Account Block','You have Block this Account Cannot View Profile first ublock then view the profile.......!','/friendbook/timeline/profile');
	}

	if(searchParams.has('postStatusFriend')==true)
	{
		dailog($('#dialog'),'View Post Error','Post Privacy is Friend And You are not the friend. So you cant view the Private Post and Friend Post. Only view Public Post.......!','/friendbook/timeline/profile');
	}

	if(searchParams.has('postStatusPrivate')==true)
	{
		dailog($('#dialog'),'View Post Error','Private Post Cant View. Only Create Post User Can View The Private Post.......!','/friendbook/timeline/profile');
	}

	if(searchParams.has('block')==true)
	{
		dailog($('#dialog'),'Account Block','User Block Your Account Cannot View Profile.......!','/friendbook/timeline/profile');
	}

	if(searchParams.has('wrong_user')==true)
	{
		dailog($('#dialog'),'Invalid User','Invalid User Profile View......!','/friendbook/timeline/profile');
	}

	$('.form').on('submit',function(e){
		e.preventDefault();
		var form=$(this);
		submitForm(form);
	 });

	$('.formProgressBar').on('submit',function(e){
		e.preventDefault();
		var form=$(this);
		ProgressBar(form);
	 });

	$('.post-image').click(function(){
		html="<img src='"+$(this).attr('src')+"' class='img-responsive' />";
		$(".model-image").modal('show');
		$('.show-image').html(html);
	});

	$('.emailConfirmation,.resend_email,.userLogin').on('submit',function(e){
		e.preventDefault();
		var form=$(this);


		$.ajax({
			url:form.attr('action'),
			method:form.attr('method'),
			data:form.serialize(),
			success:function(response){
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

					$('.msg_display').html("<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
				}
				else
				{
					$('.msg_display').html("<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
				}
			}
	    });
	 });

	$('#delete_cover_picture').click(function(){
		dailog($('#dialog'),'Delete Cover Picture','Picture Delete','');
	});

    //Cover Picture Upload Option Show And Hide
	$(".timeline-cover").mouseenter(function(){

		$("#change_image_cover").css({'display':'block',});

		$(".custom-file-upload").css({'background-color':'#231F20'});
	});


	$(".timeline-cover").mouseleave(function(){
		$("#change_image_cover").css({'display':'none'});
	});

	//Change User Cover Image
	$(".change_cover_image").on("change",function(){

	   var form=$(this);
	   var formData = new FormData($('.change_cover_image')[0]);
	   uploadFiles(form,formData);
	   
	});

	//Larg Screen Profile Image Upload Area Start

	//Profile large Screen Image to Click Upload File Option Open
	$("#profile_image").click(function () {
		profile_image=$("#profile_image_upload").click();
	});


	//Change User larg screen Profile Image
	$(".change_profile_image").on("change",function(){
	   var form=$(this);
	   var formData = new FormData($('.change_profile_image')[0]);
	  uploadFiles(form,formData);
	   
	});

	//Larg Screen Area Close

	//Small Screen Profile Image Upload Area Start

	//Profile large Small Screen Image to Click Upload File Option Open
	$("#profile_image_sm").click(function () {
		profile_image=$("#profile_image_upload_sm").click();
	});


	//Change User Small screen Profile Image
	$(".change_profile_image_sm").on("change",function(){
	   var form=$(this);
	   var formData = new FormData($('.change_profile_image_sm')[0]);
	   uploadFiles(form,formData);
	   
	});

	//Small Screen Profile Image Upload Area Close
	$(".change_data").on('change',function(){
		var $form=$(this);
		submitForm($form);
	});

	$('div#dialog').on('dialogclose', function(event) {
	     window.location.reload();
	});

	$('.delete_profile_pic').click(function(){
		delete_profile_cover("/friendbook/users/userUpdate",'delete_profile_pic');
	});

	$('.delete_cover_pic').click(function(){
		delete_profile_cover("/friendbook/users/userUpdate",'delete_cover_pic');
	});

	//Post Image click to open select option
	$(".post_image,.post_video").click(function(){
	  $(".inputimagevideo").click();
    });

    $('.stylish_player').acornMediaPlayer({
	   tooltipsOn:'true',
	 });

    var delete_id;
    var comment_id='';

    $('.delete_my_post').click(function(){
      delete_id=$(this).attr('delete_id');
      $('.show_error_myPost').text('');
    });

    $('.delete_comment_myPost').click(function(){
      comment_id=$(this).attr('delete_id');
      $('.comment_del_error').text('');
    });

  $('.yes_delete_comment').click(function(){
     $('.comment_del_error').html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");
    delete_comment(comment_id);
  });


  $('.search_user_update').on('submit',function(e){

     e.preventDefault();
     $('#msg_error').html('');
     
      $.ajax({
        url:$(this).attr('action'),
        method:$(this).attr('method'),
        data:$(this).serialize(),
        success:function(response){
        	
          response=$.parseJSON(response);
          if(response.error)
          {
          	$('#msg_error').html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");
          	$('#msg_error').html("<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
          }
          else
          {
          	$('#friend_update').html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");
          	$('#friend_update').html(response.message);
          }
        }
      });
  });

 	$('.request_btn').on('click',function(e){

 		e.preventDefault();
 		var btn=e.target;

 		var request_id=$(btn).attr('friend_request');


 		if ($(btn).hasClass('add_friend'))
 		{
 			//In this Condition send Firend Request
 		   send_request(request_id,'friend_request',$(btn));
 		}
 		else if ($(btn).hasClass('add_friend_sidbar'))
 		{

 			//In this Condition Send Friend Request with Right Sidebar
 			send_request(request_id,'friend_request_sidbar',$(btn));
 		}
 		else if ($(btn).hasClass('accept_request'))
 		{
 		   //In this Condition Accept Firend Request
 		   send_request(request_id,'accept_request',$(btn));
 		}
 		else if ($(btn).hasClass('cancle_request'))
 		{
 			//In this Condition Cancle Firend Request
 		   send_request(request_id,'cancle_request',$(btn));
 		}
 		else if ($(btn).hasClass('accept_request_profile')) 
 		{
 			//In this Condition Accept Firend Request with user profile
 			send_request(request_id,'accept_request_profile',$(btn));
 		}
 		else if ($(btn).hasClass('cancle_request_profile'))
 		{
 			//In this Condition Cancle Firend Request with user profile
 			send_request(request_id,'cancle_request_profile',$(btn));
 		}

 	});

 	  $('.my_follower').click(function(){

      $.ajax({
        method:'POST',
        url:window.location.origin+'/friendbook/friendRequest/Getfollower',
        data:{'url':window.location.href},
        success:function(response){
        	var response=$.parseJSON(response);

        	if(response.message)
        	{
        		$('#total_follower').html(response.message);
        	}
        }
      })
  });


	  $('.comment').on('submit',function(e){

	    e.preventDefault();

	    var form=$(this);
	    var id=$(this).children().children('.post_id').val()
	    var element=$(this).parent().prevAll('.all_comments_show');

	    insert_comment(form,id,element);

	  });

	  $('.report').on('submit',function(e){
	  	e.preventDefault();
	  	var msgDisplay=$('.progressMsg');
	  	$('.percentage').html('');
      $('.progress-bar').css('width','0%');

      msgDisplay.html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");

	  	var formData = new FormData($(this)[0]);

			$.ajax({
				method:$(this).attr('method'),
				url:$(this).attr('action'),
				data:formData,
				cache: false,
       contentType: false,
       processData: false,
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
	     success: function (response) {
	     	viewReportPost();
	     	var response=$.parseJSON(response);
	      if(response.error)
				{
					msgDisplay.html("<p class='alert alert-danger text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
					$('.report')[0].reset();
					$( '.report').each(function(){
					    this.reset();
					});
				}
				else if(response.success)
				{
					reportPost(event);
					msgDisplay.html("<p class='alert alert-success text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>"+response.message+"</p>");
					$('.report')[0].reset();
					
					$( '.report').each(function(){
					    this.reset();
					});
					
				}
	     }

			});
	  });

	var i=0;
	$('.block_apply').click(function(){
     var arr = [];
     $('.user_checkboxes:checked').each(function () {
     	   if($(this).val()!=null)
     	   {
     	   	arr[i++] = $(this).val();
     	   }
         
     });

     var bulk_options=$('.select_option').val();

      $.ajax({

          method:'POST',
          url:window.location.origin+'/friendbook/friendRequest/blockUnblockUser',
          data:{'user_id':arr,'bulk_options':bulk_options},
          success:function(response){
          	var response=$.parseJSON(response);
          	var url=window.location.origin+'/friendbook/timeline/blockUser';
            if (response.success) 
						{
								setTimeout(function(){
									window.location.reload();
								},1000);
								$('#msg_error').html("<p class='alert alert-success text-center alert-dismissable blockPageAlert' style='color:black'><a href='"+url+"' class='close'  style='color:black'>&times;</a>"+response.message+"</p>");
	          }
	          else if (response.error) 
						{
								setTimeout(function(){
									window.location.reload();
								},2000);
								$('#msg_error').html("<p class='alert alert-danger text-center alert-dismissable blockPageAlert' style='color:black'><a href='"+url+"' class='close'  style='color:black'>&times;</a>"+response.message+"</p>");
	          }
          }
      });

      i=0;
	});

	 $(".blockPageAlert").bind('closed.bs.alert', function(){
        alert("Alert message box has been closed.");
    });

	//User Activity Select with scrollbar and show
  var rows=10;
  var offset=0;
  var contentHeight=$('.sidebar_user_activity').height();
  var yoffset=0;
 
  
  getUserActivity($('.sidebar_user_activity'), offset, rows);
  offset += rows;

 $('.sidebar_user_activity').scroll(function(){

    yoffset=Math.round($('.sidebar_user_activity').scrollTop());

    if (yoffset>=contentHeight-500) 
    {
      getUserActivity($('.sidebar_user_activity'), offset, rows);
      offset += rows;
      contentHeight += $('.sidebar_user_activity').height();
    }

  });


  var rows=10;
  var offset=0;
  var contentHeight=6000;
  var yoffset=0;
  var page=window.location.href.split("/");
  var page2=window.location.href.split('/').pop();
  var ajaxRequestUrl;

  if(page[5]==='friendTimeline')
  {
  	ajaxRequestUrl='/friendbook/timeline/getTimelineFriendPost';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page[5]==='friendTimelineAlbum')
  {
  	ajaxRequestUrl='/friendbook/timeline/getTimelineAlbumFriend';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='viewTimeline')
  {
  	ajaxRequestUrl='/friendbook/timeline/getTimelinePost';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='timelineAlbum')
  {
  	contentHeight=$(window).height()-300;
  	ajaxRequestUrl='/friendbook/timeline/getTimelineAlbum';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='timelineVideos')
  {
  	contentHeight=$(window).height()-200;
  	ajaxRequestUrl='/friendbook/timeline/getTimelineVideos';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page[5]==='friendTimelineVideos')
  {
  	contentHeight=$(window).height()-200;
  	ajaxRequestUrl='/friendbook/timeline/getTimelineFriendVideos';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='timelineFriend')
  {
  	contentHeight=$(window).height()-300;
  	ajaxRequestUrl='/friendbook/timeline/getTimelinefriends';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page[5]==='friendTimelineFriends')
  {
  	contentHeight=$(window).height()-300;
  	ajaxRequestUrl='/friendbook/timeline/getFriendTimelinefriends';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='newsfeedFriends')
  {
  	contentHeight=$(window).height()-300;
  	ajaxRequestUrl='/friendbook/friendRequest/newsfeedFriends';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='timelineAudios')
  {
  	ajaxRequestUrl='/friendbook/timeline/getTimelinePost';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page[5]==='friendTimelineAudios')
  {
  	ajaxRequestUrl='/friendbook/timeline/getTimelineFriendAudios';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='notification')
  {
  	rows=100;
  	contentHeight=$('.scrollbarLoadData').height()-300;
  	ajaxRequestUrl='/friendbook/page/getNotification';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='newsfeed' || page2==='newsfeedAudios')
  {
  	ajaxRequestUrl='/friendbook/post/allFriendPost';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='newsfeedImages' || page2==='newsfeedVideos')
  {
  	contentHeight=$(window).height()-500;
  	ajaxRequestUrl='/friendbook/post/getNewsfeedPost';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='newsfeedNearbyPeople')
  {
  	contentHeight=$('.scrollbarLoadData').height()-300;
  	ajaxRequestUrl='/friendbook/users/getNewsfeedPeople';
  	loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
  }
  else if(page2==='messages')
  {

  	var id=$('#user_id').val();
	      stopTyping(id);


		timeoutId = setTimeout(function() {
			  chatBoxScroll();
			  clearTimeout(timeoutId);
		}, 2000);

		userSmsSeen(id);
  	chatIntervel=setInterval(function(){
			loadAjaxChatMessage(id);
			loadAjaxChatMessageList();
		},1000);

  }

  if(page2!='index' && page2!=window.location.origin+'/friendbook/' && page2!='')
  {
	  setInterval(function(){
	  	loadAjaxContent($('#onlineUsers'), offset, rows,'/friendbook/page/sidebarOnlineUser');
	  	totalSmsNotification();
	  	totalNotification();
	  	onlineUserInsert();
	  	checkAnthorDevice();
	  	totalFriends();
			totalFriendRequest();
			totalBlockUser();
	  },1000);
  }


  if(ajaxRequestUrl!='' && page2!='notification' && page2!='newsfeedNearbyPeople' && page2!='messages')
  {
  	 offset += rows;
		 $(window).scroll(function(){
		 	  $('audio').trigger('pause');
		 	  $('video').trigger('pause');
		    yoffset=Math.round($(window).scrollTop());
		    if (yoffset>=contentHeight) 
		    {
		       loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
		       offset += rows;
           if(page2==='newsfeedImages' || page2==='newsfeedVideos' || page2==='newsfeedNearbyPeople')
		       {
		       	contentHeight= contentHeight+$(window).height();
		       }
		       else
		       {
		       	contentHeight= contentHeight+5000;
		       }
		       
		    }

		  });
  }

	if(page2=='notification' || page2=='newsfeedNearbyPeople')
	{
	 offset += rows;
	 $('.scrollbarLoadData').scroll(function(){

	 	 $('audio').trigger('pause');
		 $('video').trigger('pause');

	    yoffset=Math.round($('.scrollbarLoadData').scrollTop());
	    if (yoffset>=contentHeight) 
	    {
	      loadAjaxContent($('.loadAjaxData'), offset, rows,ajaxRequestUrl);
	      offset += rows;
	      contentHeight += $('.scrollbarLoadData').height();
	      contentHeight += $('.scrollbarLoadData').height();
	    }
	  });
 }


 $('#newEmail').click(function(){
 	 var email=$('#new_email').val();

 	 if(email=='')
 	 {
 	 	 $('.msg_display').html("<p class='alert alert-danger text-center alert-dismissable'><a href='#'' class='close' data-dismiss='alert'>&times;</a>Please Enter Your New Email Address........!</p>");
 	 }
 	 else
 	 {
 	 	  $.ajax({
        url:window.location.origin+'/friendbook/users/userUpdate',
        method:'POST',
        data:{'newEmail':email},
        success:function(response){
          response=$.parseJSON(response);

          if (response.success) 
          {
          	$(eventMsg).html('<div class="alert alert-success alert-dismissable text-center"; margin:auto"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');
          }
          else if(response.error)
          {
          	$('.msg_display').html('<div class="alert alert-danger alert-dismissable text-center"; margin:auto"><a href="#" class="close" data-dismiss="alert">&times;</a><p>'+response.message+'</p></div>');
          }
        }
     });
 	 }
 });

  $('.follow, .unfollow, .unfriend').click(function(){

 	var request=null;
 	if($(this).attr('class')=='btn btn-success follow')
 	{
 		request='followUser';
 	}
 	else if($(this).attr('class')=='btn btn-success unfollow')
 	{
 		request='unfollowUser';
 	}
 	else if($(this).attr('class')=='btn btn-danger unfriend')
 	{
 		request='unfriendUser';
 	}


	 	if(request!=null)
	 	{
		 	 $.ajax({
		    method:'POST',
		    url:window.location.origin+'/friendbook/friendRequest/'+request,
		    data:{'url':window.location.href},
		    success:function(response){
		    	var response=$.parseJSON(response);
		    	if (response.dialog) 
					{
						dailog($('#dialog'),response.title,response.message,response.activty_type);
					}
					else if(response.success)
					{
						var totalFollower;

						if(request=='followUser')
						{
							totalFollower=$('#totalFollower').text();
							totalFollower++;

							if(totalFollower==-1)
							{
								totalFollower=0;
							}

							$('#totalFollower').html(totalFollower);

							$('.follow').text('Unfollow');
							$(".follow").addClass("unfollow");
							$('.follow').removeClass("follow");
						}
						else if(request=='unfollowUser')
						{
							totalFollower=$('#totalFollower').text();
							totalFollower--;

							if(totalFollower==-1)
							{
								totalFollower=0;
							}
							$('#totalFollower').html(totalFollower);

							$('.unfollow').text('Follow');
							$(".unfollow").addClass("follow");
							$('.unfollow').removeClass("unfollow");
						}
						else if(request=='unfriendUser')
						{
							$('.unfriend').text('Add Friend');
							$('.unfriend').removeClass("btn-danger");
							$(".unfriend").addClass("add_friend");
							$(".unfriend").addClass("btn-primary");
							$('.unfriend').removeClass("unfriend");
						}
					}
		    }
		  });
	 	}
  });

  var selectFile=false;

  $(".select_image_videos").on('click',function (e) {
    e.preventDefault();
    $("#select_image_videos").click();
    $('.percentageChat').html('');
    $('.progress-bar-chat').css('width','0%');

     selectFile=true;
  });


	$('.insert_sms').on('submit',function(e){
		e.preventDefault();

		clearInterval(chatIntervel);

		var form=$(this);
		$('.percentageChat').html('');
	  $('.progress-bar-chat').css('width','0%');

		var file1=form.get(0).files;

		var formData = new FormData($(form)[0]);

		if (selectFile==false) 
	  {	
	  	$.ajax({
				method:form.attr('method'),
				url:form.attr('action'),
				data:form.serialize(),
				success:function(response){
					var response=$.parseJSON(response);

					if(response.error)
					{
						$('.error_sms').html("<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
					}
					else if (response.success)
					{
						$('#chatBox_user').val('');
						$(".emojionearea-editor").html('');
						chatBoxScroll();
						setInterval(function(){$('.percentageChat').html('');$('.progress-bar-chat').css('width','0%');},2000);
					}
				}
			});	

	  }
	  else
	  {
	  	$.ajax({
				method:form.attr('method'),
				url:form.attr('action'),
				data:formData,
				xhr:function(){
		          var xhr=new XMLHttpRequest();
		          var percentage=0;
		          xhr.upload.addEventListener('progress',function(e){
		              percentage=Math.round((e.loaded/e.total)*100);
		              $('.percentageChat').html(percentage+"%");
		              $('.progress-bar-chat').css('width',percentage+"%");
		            });

		            return xhr;
		          },
				success:function(response){
					var response=$.parseJSON(response);
					if(response.error)
					{
						$('.error_sms').html("<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
					}
					else if (response.success)
					{
					 $('#chatBox_user').val('');
					 $(".emojionearea-editor").html('');
					 chatBoxScroll();
					 $("#select_image_videos").removeAttr("multiple").val("");
					 $('#showName').empty();
					  setInterval(function(){$('.percentageChat').html('');$('.progress-bar-chat').css('width','0%');},1000);
					}
				},
				cache: false,
	      contentType: false,
	      processData: false,

			});	

	  }

	  var id=$('#user_id').val();
	  chatIntervel=setInterval(function(){
			loadAjaxChatMessage(id);
			loadAjaxChatMessageList();
		 },1000);

	 });


	$('.display_user_sms_bar').on('click',function(e){ 

		clearInterval(chatIntervel);

   chatBoxScroll();

		var user_id=e.target;

    $('.percentage').html('');
    $('.progress-bar').css('width','0%');

    $('#select_files').text('Show Files').attr('select_type','select_files').css('background','black');
     
    var id=$(user_id).parentsUntil('ul').filter('a').parent().attr('user_id');

    if (id===undefined || id===null || id==='') 
    {
    	id=$(user_id).parent().attr('user_id');
    }

     

     //Sending images videos and audios
     $('#select_files').val(id);

      if (id!=undefined) 
      {
      	$('#user_id').replaceWith("<input type='hidden' value='"+id+"' name='user_id' id='user_id'>");

        $('.send_sms_user').animate({
				  scrollTop: 30000
				}, 1000);

				userSmsSeen(id);

      	chatIntervel=setInterval(function(){
					loadAjaxChatMessage(id);
					loadAjaxChatMessageList();
				 },1000);

      	
      }
  });

  $('#select_files').click(function(){
     var id=$(this).val();
     var val=$(this).attr('select_type');
     if(val=='select_files')
     {
       $(this).html('<i class="icon ion-chatboxes"></i>&nbsp;&nbsp;Show Chat').attr('select_type','show_chat').css('background','#1499C9');
     }
     else
     {
       $(this).html('<i class="ion-images"></i>&nbsp;&nbsp;Show Files').attr('select_type','select_files').css('background','black');
     }
  });

  $('.chat-room').mouseenter(function(){
  	var id=$('#user_id').val();
  	userSmsSeen(id);
  });

  //setup before functions
   var typingTimer;                //timer identifier
   var doneTypingInterval = 1000;  //time in ms, 5 seconds for example


  //on keyup, start the countdown
	$('.chatBox_user').on('keyup', function () {
	  clearTimeout(typingTimer);

	  var id=$('#user_id').val();
	  typingTimer =setTimeout(function(){stopTyping(id);},doneTypingInterval);

	  $.ajax({
				method:'POST',
        url:window.location.origin+'/friendbook/messages/userTyping',
				data:{'user_id':id,'typing':'userTyping'},
				success:function(response){
					var response=$.parseJSON(response);

					if(response.error)
					{
						$('.error_sms').html("<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
					}
					else if (response.success)
					{
						chatBoxScroll();

						setInterval(function(){$('.percentageChat').html('');$('.progress-bar-chat').css('width','0%');},2000);
					}
				}
			});

	});

	//on keydown, clear the countdown 
	$('.chatBox_user').on('keydown', function () {
	  clearTimeout(typingTimer);
	});



   $("#chatBox_user").focusout(function(){
		 	  var id=$('#user_id').val();
	      stopTyping(id);
		});

});


function deleteAllChat(event)
{
	$('.chat_del_error').html("");

	var friendID=$(event).attr('user_id');

	$('.yes_delete_allChat').click(function(){
			$.ajax({
		    method:'POST',
		    url:window.location.origin+'/friendbook/messages/deleteAllChat',
		    data:{'friendID':friendID,},
		    success:function(response){
		    	var response=$.parseJSON(response);

		    	$('.chat_del_error').html("<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
		    }
		  });
	});	
}


//user is "finished typing,"
function stopTyping(id) 
{
  $.ajax({
		method:'POST',
    url:window.location.origin+'/friendbook/messages/userTyping',
			data:{'user_id':id,'typing':'userStopTyping'},
		success:function(response){
			var response=$.parseJSON(response);

			if(response.error)
			{
				$('.error_sms').html("<p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
			}
			else if (response.success)
			{

				chatBoxScroll();
				setInterval(function(){$('.percentageChat').html('');$('.progress-bar-chat').css('width','0%');},2000);
			}
		}
	});
}



/*function chatBoxMedia(event)
{
	var Class=$(event).attr('class');
	var html;

	if(Class=='btn btn-info btn-sm chatBoxVideo')
	{
		$(".viewChatBoxMedia").css("margin-top","30px");
		html="<video  class='post-video stylish_player' controls style='height: 500px'><source src='"+$(event).val()+"' type='"+$(event).attr('value2')+"'></video>";
	}
	else if(Class=='btn btn-info btn-sm chatBoxAudio')
	{
		$(".viewChatBoxMedia").css("margin-top","200px");
		html="<audio controls style='width:100%;' class='bg-success'><source src='"+$(event).val()+"' type='"+$(event).attr('value2')+"'></audio>";
	}

	$('.loadMedia').html(html);	
	$('.viewChatBoxMedia').modal('show');
	
}*/

function emoji()
{

	  $('.comment_input').emojioneArea({
			pickerPosition:'top'
		});
}

function delete_comment_myPost(event)
{
	$('.comment_del_error').html('');
  	comment_id=$(event).attr('delete_id');

		$('.yes_delete_comment').click(function(){
				delete_comment(comment_id,event);
		});
}

function viewVideo(event) 
{
	var post_link="<a href='"+$(event).attr('post_link')+"' type='button' class='btn btn-default btn-lg btn-block ' style='background-color:black;color:white'>View Post</a>";
	var videoTag=$(event).children().children().children()[0].outerHTML;

	var video="<video  class='post-video stylish_player' controls style='height: 500px'>"+videoTag+"</video>";

	$('.checkVideo').html(video);	
  $('.videoLink').html(post_link);
	$('.viewVideo').modal('show');
}


function notifClick(event)
{
	var Class=$(event).attr('class');
	var postID=$(event).attr('post_id');
	var notifID=$(event).attr('notification_id');

	if(Class!='' && postID!='' && notifID!='')
	{
		 $.ajax({
        method:'POST',
        url:window.location.origin+'/friendbook/post/deletePendingNotif',
        data:{'class':Class,'postID':postID,'notifID':notifID},
        success:function(response){
        	var response=$.parseJSON(response);

        	if(response.success)
        	{
        		window.location.href=response.message;
        	}
        	else if(response.error)
        	{
        		dailog($('#dialog'),'Refersh Page','Something Was Problem Please Refersh Your Web .......!','');
        	}
        }
      });
	}
	else 
	{
		dailog($('#dialog'),'Refersh Page','Something Was Problem Please Refersh Your Web .......!','');
	}
}

function postSelect(event)
{
	var tagClass=$(event).children().attr('class');
	var html=$(event).children()[0].outerHTML;
	var postPath=$(event).attr('postLink');
	var post_link="<a href='"+postPath+"' type='button' class='btn btn-default btn-lg btn-block ' style='background-color:black;color:white'>View Post</a>";

	if(tagClass=='video')
	{
		var videoTag=$(html).children()[0].outerHTML;
		var video="<video  class='post-video stylish_player' controls style='height: 500px'>"+videoTag+"</video>";
	  $('.checkVideo').html(video);	
    $('.videoLink').html(post_link);
	  $('.viewVideo').modal('show');

	}
	else if(tagClass=='postImg')
	{
			$(".modal-1").modal('show');
	    $('.postData').html("<center>"+html+"</center>");
	}
}

function imageView(event) 
{
		html="<img src='"+$(event).attr('src')+"' class='img-responsive' />";
		$(".model-image").modal('show');
		$('.show-image').html("<center>"+html+"</center>");
}

function chatImageView(event) 
{
	  var img=$(event).children()[0];
		html="<img src='"+$(img).attr('src')+"' class='img-responsive' />";
		$(".model-image").modal('show');
		$('.show-image').html("<center>"+html+"</center>");
}

function viewVideos(event) 
{
	var post_link="<a href='"+$(event).attr('post_link')+"' type='button' class='btn btn-default btn-lg btn-block ' style='background-color:black;color:white;'>View Post</a>";
	var videoTag=$(event).children().children().children()[0].outerHTML;

	var video="<video  class='post-video stylish_player' controls style='height: 500px'>"+videoTag+"</video>";

	$('.checkVideo').html(video);	
  $('.videoLink').html(post_link);
	$('.viewVideo').modal('show');
}


function request_btn(event)
{
 		if ($(event).children().hasClass('add_friend'))
 		{
 			var request_id=$(event).children().attr('friend_request');
 			//In this Condition send Firend Request
 		  send_request(request_id,'friend_request',$(event).children());
 		}
}






