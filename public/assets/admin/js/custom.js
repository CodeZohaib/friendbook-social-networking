var badge;
var remove=false;

$(function(){

	$(window).scroll(function(){
		$('audio').trigger('pause');
		$('video').trigger('pause');
	});

	$('.viewPost').scroll(function(){
		$('audio').trigger('pause');
		$('video').trigger('pause');
	});

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
				$('.searchUserData').html(response.message);
			}
			else
			{
				$('.searchUserData').html('');
				$('.error_sms').html("<br><br><p class='alert alert-danger text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>"+response.message+"</p>");
			}
			
		}
    });
  });

    $('#profileComplaintboxes').click(function(event){

        if(this.checked){
            $('.profileComplaintboxes').each(function(){
                this.checked = true;                      
            });
        }
        else{
            $('.profileComplaintboxes').each(function(){
                this.checked = false;                      
            });
        }
        
    });

	$('.submit_form').on('submit',function(e){

		e.preventDefault();

		var form=$(this);
		var Class=$(this).find('.sms_display');

		$(Class).html('<center><img src='+window.location.origin+"/friendbook/public/assets/images/ajax-loader.gif alt='Loader'></center>");
	
		Ajax_request(form,$(Class));
	});


	$('.image_style').click(function(){
		$('.img_show').attr('src',$(this).attr('src'));
	});


	$('.viewProfile').click(function(){
		var user_id=$(this).attr('user_id');
		$.ajax({
			method:'POST',
			url:window.location.origin+'/friendbook/admin/viewProfile',
			data:{user_id:user_id},
			success:function(response)
			{
				var response=$.parseJSON(response);
			     $('.all_info_user').html(response.message);
			     populateCountries("country", "state");
			}
		});
	});

	$('.view_Profile').on('hidden.bs.modal', function () {
	  $('.viewPost').css('overflow-y', 'auto');
	   $('.viewComplaint,.ProfileComplaint,.viewVerification').css('overflow-y', 'auto');
	});

	$('.imageBigView,.img_small_display').on('hidden.bs.modal', function () {
	  $('.viewComplaint,.ProfileComplaint,.viewVerification ').css('overflow-y', 'auto');
	});

	$('.ProfileComplaint,.viewComplaint').on('hidden.bs.modal', function () {
		$('.viewComplainData').html('');
		$('.ProfileComplainData').html('');

	  	setInterval(function(){
		  	if(remove==true)
			{
				var badgeRemove=$(badge).parent()[0];
				badgeRemove.remove();
				remove=false;
			}
		},1000);
	});


	$('.passwordChange').on('submit',function(e){
		e.preventDefault();
		$('.passwordError').html('');
		$.ajax({
			url:$(this).attr('action'),
		    method:$(this).attr('method'),
		    data:$(this).serialize(),
			success:function(response)
			{
				var response=$.parseJSON(response);
			    $('.passwordError').html(response.message);
			}
		});
	});


	$('.addNewAdmin').on('submit',function(e){
		e.preventDefault();
		$('.newAdminError').html('');
		$.ajax({
			url:$(this).attr('action'),
		    method:$(this).attr('method'),
		    data:$(this).serialize(),
			success:function(response)
			{
				var response=$.parseJSON(response);
			    $('.newAdminError').html(response.message);
			}
		});
	})




	function Ajax_request(form,display)
	{
		var file1=form.get(0).image;

		if (file1===undefined || file1==null || file1==='') 
		{
			$.ajax({
				url:form.attr('action'),
				method:form.attr('method'),
				data:form.serialize(),
				success:function(response)
				{
					var response=$.parseJSON(response);
					show_message(response,display);
				}
			})
		}
		else
		{
			var formData = new FormData($(form)[0]);

			$.ajax({
				method:form.attr('method'),
				url:form.attr('action'),
				data:formData,
				success:function(response){
					var response=$.parseJSON(response);
					show_message(response,display);
				},
				cache: false,
                contentType: false,
                processData: false,

			});
		}
	}

	function show_message(response,display)
	{
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

			display.html("<h5 class='alert alert-success text-center alert-dismissable'><a href='#' class='close' data-dismiss='alert'>&times;</a><p>"+response.message+"</p></h5>");
		}
		else
		{
			display.html("<h5 class='alert alert-danger text-center alert-dismissable'><a href='#' class='close' data-dismiss='alert'>&times;</a><p>"+response.message+"</p></h5>");
		}
	}

});


function copyLink(element)
{
	var link=$(element).attr('link');
    navigator.clipboard.writeText(link);
	$('.msgDisplay').html("<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>Post Link Copy.......!</p>");
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
      url:window.location.origin+'/friendbook/admin/viewLikeDislike',
      data:{'post_id':id,'type':type,'post_user_id':post_user_id},
      success:function(response){
      	var response=$.parseJSON(response);

        if(type=='view_dislike') 
        {
          $('#view_dislikes').html(response.message);
        }
        else if(type=='view_like')
        {
          $('#view_likes').html(response.message);
        }
      }
     });
}

function delete_comment_myPost(event)
{
	$('.comment_del_error').html('');
  	comment_id=$(event).attr('delete_id');

	$('.yes_delete_comment').click(function(){
		   $.ajax({
	          url:window.location.origin+'/friendbook/admin/deletePostComment',
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
	});
}


function viewUserProfile(event) 
{
   var user_id=$(event).attr('user_id');
	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/viewProfile',
		data:{user_id:user_id},
		success:function(response)
		{
			var response=$.parseJSON(response);
		     $('.all_info_user').html(response.message);
		     populateCountries("country", "state");
		}
	});
}

function submitComplaint(type)
{
	var complaintID;
	var postAdminMsg=$('#postAdminMsg').val();
	var complaintActionType=$('#complaintActionType').val();

	if(type=='postComplaint')
	{
		postID=$('#postID').val();
		data={'complaintType':type,'adminMsg':postAdminMsg,'action':complaintActionType,'postID':postID}
	}
	else if(type=='profileComplaint')
	{
		profileUserID=$('#profileUserID').val();
		data={'complaintType':type,'adminMsg':postAdminMsg,'action':complaintActionType,'profileUserID':profileUserID}
	}
	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/actionComplaint',
		data:data,
		success:function(response)
		{
			var response=$.parseJSON(response);
			if(response.success)
			{ 
			   remove=true;

			   if(type=='postComplaint')
	           {
					viewAllComplaint(postID,'postComplaint');
					
			   }
			   else if(type=='profileComplaint')
			   {
			     	viewAllComplaint(profileUserID,'profileComplaint');
			   } 

			   if(type=='postComplaint' && complaintActionType=='delete_post')
	           {
					$(badge).html("<span class='badge' style='background:#ff5e5e'>Admin Delete</span>");
					
			   }
			   else if(type=='profileUserID')
			   {
					$(badge).html("<span class='badge' style='background:#ff5e5e'>Security Verification</span>");
					
			   } 
			   
			   if(response.message=='accountBlock') 
			   {
			   	   $(badge).html("<span class='badge' style='background:#ff5e5e'>Account Block</span>");
			   	   $('.displayError').html("<p class='alert alert-success text-center alert-dismissable' style='color:black'><a href='#'' class='close' data-dismiss='alert' style='color:black'>&times;</a>User Account Block Successfully....!</p>");
			   }
			   else
			   {
			   	 $('.displayError').html(response.message);
			   }
			}

			if(response.message!='accountBlock') 
			{
				$('.displayError').html(response.message);
			}
			
		     $('#postAdminMsg').val('');
		     $('#complaintActionType').each( function() {
			        $(this).val( $(this).find("option[selected]").val() );
			    });
		}
	});

}

function imageModel(event)
{
	$('.bigImage').attr('src',$(event).attr('src'));
}

function viewAllComplaint(id,type)
{
	if(type=='postComplaint')
	{
		Data={'postID':id};
		url="viewAllPostComplaint";
	}
	else if (type=='profileComplaint') 
	{
		Data={'userID':id};
		url="viewAllAccountComplaint";
	}

	$.ajax({
      method:'POST',
      url:window.location.origin+'/friendbook/admin/'+url,
      data:Data,
      success:function(response){
      	var response=$.parseJSON(response);
      	if(response.success)
      	{
      		$('.complaintHistory').html(response.message);
      	}
      }
  });
}

function accountComplaint(event)
{
	badge=$(event).parent().next().next();
	var userId=$(event).val();

	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/viewProfileComplaint',
		data:{'userId':userId},
		success:function(response)
		{
			var response=$.parseJSON(response);
			$('.ProfileComplainData').html(response.message);
			$(".ProfileComplaint").modal('show');
		}
	});
}

function postComplaint(event)
{
	badge=$(event).parent().next().next();
	var postId=$(event).val();
	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/viewPostComplaint',
		data:{'postId':postId},
		success:function(response)
		{
			var response=$.parseJSON(response);
			$('.viewComplainData').html(response.message);
			$(".viewComplaint").modal('show');
		}
	});
}

function viewPost(event)
{
	var post_id=$(event).val();
	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/viewPost',
		data:{'post_id':post_id},
		success:function(response)
		{
			var response=$.parseJSON(response);
			$('.showPost').html(response.message);
			$(".viewPost").modal('show');
		}
	});
}


function imageView(event) 
{
	html="<img src='"+$(event).attr('src')+"' class='img-responsive' />";
	$(".img_display").modal('show');
	$('.img_show').attr('src',$(event).attr('src'));
}

function imageSmallView(event) 
{
	html="<img src='"+$(event).attr('src')+"' class='img-responsive' />";
	$(".img_small_display").modal('show');
	$('.img_small_show').attr('src',$(event).attr('src'));
}


function accountVerification(event)
{
	badge=$(event).parent().next();
	var id=$(event).val();

	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/viewAccountVerification',
		data:{'verificationId':id},
		success:function(response)
		{
			var response=$.parseJSON(response);
			$('.viewVerificationData').html(response.message);
			$(".viewVerification").modal('show');
		}
	});
}


function submitVerification() 
{
	var verificationId=$('#verificationId').val();
	var verficationAdminMsg=$('#verificationAdminMsg').val();
	var verificationActionType=$('#verificationActionType').val();

	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/actionVerification',
		data:{'verificationId':verificationId,'adminMsg':verficationAdminMsg,'actionType':verificationActionType},
		success:function(response)
		{
			var response=$.parseJSON(response);
			if(response.success)
			{ 
			   var badgeRemove=$(badge).parent()[0];
				badgeRemove.remove();

			   getModelAllVerification(verificationId);

			   if(verificationActionType=='reject')
	           {
					$(badge).html("<span class='badge' style='background:#ff5e5e'>Reject</span>");
					
			   }
			   else if(verificationActionType=='verify')
			   {
					$(badge).html("<span class='badge' style='background:#6fd96f'>Verify</span>");
					
			   }
			}

			$('.displayError').html(response.message);
			
		     $('#verificationAdminMsg').val('');
		     $('#verificationActionType').each( function() {
			        $(this).val( $(this).find("option[selected]").val() );
			    });
		}
	});
}

function getModelAllVerification(verificationId)
{
	$.ajax({
		method:'POST',
		url:window.location.origin+'/friendbook/admin/getModelAllVerification',
		data:{'verificationId':verificationId},
		success:function(response)
		{
			var response=$.parseJSON(response);
			$('.allVerification').html(response.message);
			$(".viewVerification").modal('show');
		}
	});
}

function verificationOption(event) 
{
	var option=$('#verificationActionType').val();

	if(option=='reject')
	{
		$('.verificationTextarea').html('<textarea class="textarea form-control" id="verificationAdminMsg" name="adminMsg" rows="5" col="10" placeholder="Enter Message About Reject Reason Verification Proof .....!" pattren="[A-Za-z]{550}" maxlength="550" required></textarea><br><br>');
	}
	else if(option=='verify')
	{
		$('.verificationTextarea').html('');
	}
}
