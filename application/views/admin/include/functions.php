<?php

function Pagination_admin($page,$total_row,$function_name)
 {
     global $all_users;
     
    if (isset($all_users)) 
    {
        $obj=$all_users;
    }

    $page_number       =(isset($_GET['page']) AND !empty($_GET['page'])) ? $_GET['page']:0;
    $par_page_records  =5;
    $row               =$total_row;
    $last_page         =ceil($row/$par_page_records);
    $pagination        ='<nav><ul class="pagination pagination-sm">';
    $limit             =($page_number>1) ? ($page_number * $par_page_records)-$par_page_records : 0;

    if ($row>115) 
    {
        $pagination_buttons =11;
    }
    else
    {
        $pagination_buttons =$last_page;
    }

    if ($page_number<1){

        $page_number=1;
    }
    else if ($page_number>$last_page){
        $page_number=$last_page;
    }

    //Call a function to content display
    //echo $limit."<br>".$par_page_records;
   
    
    if ($page=='all_users.php') 
    {
         $obj->$function_name(($limit),$par_page_records,'All_users');
    }
    else if ($page=='all_block_users.php') 
    {
         $obj->$function_name(($limit),$par_page_records,'Block_user');
    }
    else if ($page=='users_email_not_confirm.php') 
    {
         $obj->$function_name(($limit),$par_page_records,'Email_not_confirm');
    }
    else if ($page=='all_moderator.php') 
    {
         $obj->$function_name(($limit),$par_page_records,'Moderator');
    }
    else if ($page=='all_admin.php') 
    {
         $obj->$function_name(($limit),$par_page_records,'Admin');
    }
    else if ($page=='website_owner.php') 
    {
         $obj->$function_name(($limit),$par_page_records,'website_owner');
    }
    else
    {
         $obj->$function_name(($limit),$par_page_records,$db);
    }


    echo "<br><br>";
    $half=floor($pagination_buttons/2);

    if ($page_number < $pagination_buttons AND ($last_page==$pagination_buttons OR $last_page > $pagination_buttons)) 
    {
        for ($i=1; $i <= $pagination_buttons; $i++) 
        { 
            if ($i==$page_number) 
            {
                $pagination.='<li class="active"><a href="'.$page.'?page='.$i.'">'.$i.'<span class="sr-only">(Current)</span></a></li>';
            }
            else
            {
                $pagination.='<li><a href="'.$page.'?page='.$i.'">'.$i.'</a></li>';
            }
        }

        if($last_page>$pagination_buttons) 
        {
          $pagination.='<li><a href="'.$page.'?page='.($pagination_buttons+1).'">&raquo;</a></li>';
        }
    }
    else if($page_number>=$pagination_buttons AND $last_page>$pagination_buttons) 
    {
        if(($page_number+$half)>=$last_page)
        {
            $pagination.='<li><a href="'.$page.'?page='.($last_page-$pagination_buttons).'">&laquo;</a></li>';
            for ($i=($last_page-$pagination_buttons)+1; $i <=$last_page; $i++) 
            { 
                if ($i==$page_number) 
                {
                    $pagination.='<li class="active"><a href="'.$page.'?page='.$i.'">'.$i.'<span class="sr-only">(Current)</span></a></li>';
                }
                else
                {
                    $pagination.='<li><a href="'.$page.'?page='.$i.'">'.$i.'</a></li>';
                }
            }
        }
        else if (($page_number+$half)<$last_page) 
        {
             $pagination.='<li><a href="'.$page.'?page='.(($page_number-$half)-1).'">&laquo;</a></li>';

             for ($i=($page_number-$half); $i <=($page_number+$half) ; $i++) 
             { 
                if ($i==$page_number) 
                {
                    $pagination.='<li class="active"><a href="'.$page.'?page='.$i.'">'.$i.'<span class="sr-only">(Current)</span></a></li>';
                }
                else
                {
                    $pagination.='<li><a href="'.$page.'?page='.$i.'">'.$i.'</a></li>';
                }
             }

              $pagination.='<li><a href="'.$page.'?page='.(($page_number+$half)+1).'">&raquo;</a></li>';
        }
    }
    else
    {
       if (@$_GET['page']>1) 
       {
          $pagination.='<li><a href="'.$page.'?page='.($page_number-1).'">&laquo;</a></li>';
       }
    }

    

    $pagination.="</nav></ul>";

    if ($page=='timeline-album.php') 
    {
         echo "<center>".$pagination."</center>";
    }
    else
    {
        echo"
        <div class='row'>
          <div class='col-md-12 col-sm-12'>
              <center>$pagination</center>        
         </div>
        </div>"; 
    }         
}

?>