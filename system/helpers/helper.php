<?php

function check($value)
{
	echo"<pre>";
	print_r($value);
	exit();
}

function formatDate($date)
{
      return date('F j, Y, g:i A',strtotime($date));
}
 
function TimeAgo ($oldTime, $newTime, $type) 
{
    $timeCalc = strtotime($newTime) - strtotime($oldTime);

    if ($timeCalc >= (60*60*24*30*12*2)){
    $timeCalc = intval($timeCalc/60/60/24/30/12) . " years ago";
    }else if ($timeCalc >= (60*60*24*30*12)){
        $timeCalc = intval($timeCalc/60/60/24/30/12) . " year ago";
    }else if ($timeCalc >= (60*60*24*30*2)){
        $timeCalc = intval($timeCalc/60/60/24/30) . " months ago";
    }else if ($timeCalc >= (60*60*24*30)){
        $timeCalc = intval($timeCalc/60/60/24/30) . " month ago";
    }else if ($timeCalc >= (60*60*24*2)){
        $timeCalc = intval($timeCalc/60/60/24) . " days ago";
    }else if ($timeCalc >= (60*60*24)){
        $timeCalc = " Yesterday";
    }else if ($timeCalc >= (60*60*2)){
        $timeCalc = intval($timeCalc/60/60) . " hours ago";
    }else if ($timeCalc >= (60*60)){
        $timeCalc = intval($timeCalc/60/60) . " hour ago";
    }else if ($timeCalc >= 60*2){
        $timeCalc = intval($timeCalc/60) . " minutes ago";
    }else if ($timeCalc >= 60){
        $timeCalc = intval($timeCalc/60) . " minute ago";
    }else if ($timeCalc > 5){
        $timeCalc .= " seconds ago";
    }else if ($timeCalc >= 0){
        
        if ($type==='Online') {
            $timeCalc ='Online';
        }else if ($type==='Message') {
            $timeCalc ='Just Now';
        }
    }


   return $timeCalc;
}

function linkCSS($cssPath)
{
	$url=BASEURL."/".$cssPath;
	echo '<link rel="stylesheet" type="text/css" href="'.$url.'">';
}

function linkJS($jsPath)
{
	$url=BASEURL."/".$jsPath;
	echo "<script type='text/javascript' src='".$url."'></script>";
}

function IpAddress()
{
    $ipaddress = '';
    
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';


    //return '134567';
   return $ipaddress;

}

function password_method($password)
{
	$uppercase = preg_match('@[A-Z]@',$password);
    $lowercase = preg_match('@[a-z]@',$password);
    $number    = preg_match('@[0-9]@',$password);

    if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) 
    {
            return false;
    }
    else
    {
    	return true;
    }
}

function MsgDisplay($status,$msg,$type=NULL,$url=NULL)
{
	if ($status==='success' && !empty($url)) 
	{
		echo json_encode([
			'success'=>'success',
			'message'=>$msg,
			'url'=>$url,
			
		]);
	}
	else if ($status==='success' && empty($url)) 
	{
		echo json_encode([
			'success'=>'success',
			'message'=>$msg,
	    ]);
	}
    else if ($status==='error') 
	{
		echo json_encode([
			'error'=>'error',
			'message'=>$msg,
	    ]);
	}
    else if ($status==='securityVerification' && !empty($url)) 
    {
        echo json_encode([
            'securityVerification'=>'securityVerification',
            'message'=>$msg,
            'url'=>$url,
            
        ]);
    }
    else if ($status==='refersh') 
    {
        echo json_encode([
            'success'=>'success',
            'message'=>$msg,
            'signout'=>1,
        ]);
    }
    else if ($status==='signout') 
    {
        echo json_encode([
            'success'=>'success',
            'signout'=>1,
        ]);
    }
    else if ($status==='country_change') 
    {
        echo json_encode([
            'dialog'=>'success',
            'title' => 'Country Change',
            'message'=>'<center><b>Country Change Successfully....!</b></center>',
            'activty_type' => '',
        ]);
    }
    else if ($status==='email_type_change') 
    {
        echo json_encode([
            'dialog'=>'success',
            'title' => 'Email Privacy Change',
            'message'=>'<center><b>Email Privacy Change Successfully....!</b></center>',
            'activty_type' => '',
        ]);
    }
    else if ($status==='email_type_error') 
    {
        echo json_encode([
            'dialog'=>'error',
            'title' => 'Email Privacy Change Error',
            'message'=>'<center><b>Something Was Wrong Please Try Again....!</b></center>',
            'activty_type' => '',
        ]);
    }
    else if ($status==='account_type_change') 
    {
        echo json_encode([
            'dialog'=>'success',
            'title' => 'Account Privacy Change',
            'message'=>'<center><b>Account Privacy Change Successfully....!</b></center>',
            'activty_type' => '',
        ]);
    }
    else if ($status==='account_type_error') 
    {
        echo json_encode([
            'dialog'=>'error',
            'title' => 'Account Privacy Change Error',
            'message'=>'<center><b>Something Was Wrong Please Try Again....!</b></center>',
            'activty_type' => '',
        ]);
    }
    else if($status==='friend_request')
    {
        echo json_encode([
            'success'=>'success',
            'type'=>$msg,
        ]);
    }
}

function MsgDialog($dialog,$title,$message,$activty_type=NULL)
{
    echo json_encode([
        'dialog'=>$dialog,
        'title' => $title,
        'message'=>$message,
        'activty_type'=>$activty_type,
    ]);
}

function encryption($action, $string)
{
    $key = 'm$B=7&%4t#6F^M!JU7Xu?7';
    $ciphering = 'AES-256-CBC';
    $iv = '1234567891011121';

    if ($action == 'encrypt') {
        return openssl_encrypt($string, $ciphering, $key, 0, $iv);
    } elseif ($action == 'decrypt') {
        if ($string === null) {
            // Handle the case where $string is null
            return false;
        }
        return openssl_decrypt($string, $ciphering, $key, 0, $iv);
    }

    return false;
}


function resize_image($file,$type)
{

    if (file_exists($file)) 
    {
        if($type=='png')
        {
            $original_image=imagecreatefrompng($file);
        }
        else if($type=='jpeg' OR $type=='JPG' OR $type=='jpg')
        {
            $original_image=imagecreatefromjpeg($file);
        }
        else if($type=='gif')
        {
            $original_image=imagecreatefromgif($file);
        }
        //Resolution
        $original_width=imagesx($original_image);
        $original_height=imagesy($original_image);

        $new_width=1030;
        $new_height=430;

        if ($original_image) 
        {
            $new_image=imagecreatetruecolor($new_width, $new_height);

           imagecopyresampled($new_image, $original_image,0,0,0,0,$new_width,$new_height,$original_width,$original_height);

           imagejpeg($new_image,$file,90);

        }

    }
 }

 function countryName_to_code( $name ){

    $countryList = array(
    'Afghanistan' => 'AF',
    'Aland Islands' => 'AX',
    'Albania' => 'AL',
    'Algeria' => 'DZ',
    'American Samoa' => 'AS',
    'Andorra' => 'AD',
    'Angola' => 'AO',
    'Anguilla' => 'AI',
    'Antartica' => 'AQ',
    'Antigua and Barbuda' => 'AG',
    'Argentina' => 'AR',
    'Armenia' => 'AM',
    'Aruba' => 'AW',
    'Ashmore and Cartier Island' => 'AU',
    'Australia' => 'AU',
    'Austria' => 'AT',
    'Azerbaijan' => 'AZ',
    'Bahamas the' => 'BS',
    'Bahrain' => 'BH',
    'Bangladesh' => 'BD',
    'Barbados' => 'BB',
    'Belarus' => 'BY',
    'Belgium' => 'BE',
    'Belize' => 'BZ',
    'Benin' => 'BJ',
    'Bermuda' => 'BM',
    'Bhutan' => 'BT',
    'Bolivia' => 'BO',
    'Bosnia and Herzegovina' => 'BA',
    'Botswana' => 'BW',
    'Bouvet Island (Bouvetoya)' => 'BV',
    'Brazil' => 'BR',
    'British Indian Ocean Territory (Chagos Archipelago)' => 'IO',
    'Virgin Islands' => 'VG',
    'Brunei' => 'BN',
    'Bulgaria' => 'BG',
    'Burkina Faso' => 'BF',
    'Burma'  => 'MM',
    'Burundi' => 'BI',
    'Cambodia' => 'KH',
    'Cameroon' => 'CM',
    'Canada' => 'CA',
    'Cape Verde' => 'CV',
    'Cayman Islands' => 'KY',
    'Central African Republic' => 'CF',
    'Chad' => 'TD',
    'Chile' => 'CL',
    'China' => 'CN',
    'Christmas Island' => 'CX',
    'Clipperton Island' => 'CP',
    'Cocos (Keeling) Islands' => 'CC',
    'Colombia' => 'CO',
    'Comoros' => 'KM',
    'Congo, Democratic Republic of the' => 'CD',
    'Congo, Republic of the' => 'CG',
    'Cook Islands' => 'CK',
    'Costa Rica' => 'CR',
    'Cote d Ivoire' => 'CI',
    'Croatia' => 'HR',
    'Cuba' => 'CU',
    'Cyprus' => 'CY',
    'Czeck Republic' => 'CZ',
    'Denmark' => 'DK',
    'Djibouti' => 'DJ',
    'Dominica' => 'DM',
    'Dominican Republic' => 'DO',
    'Ecuador' => 'EC',
    'Egypt' => 'EG',
    'El Salvador' => 'SV',
    'Equatorial Guinea' => 'GQ',
    'Eritrea' => 'ER',
    'Estonia' => 'EE',
    'Ethiopia' => 'ET',
    'Faroe Islands' => 'FO',
    'Falkland Islands (Islas Malvinas)' => 'FK',
    'Fiji the Fiji Islands' => 'FJ',
    'Finland' => 'FI',
    'France' => 'FR',
    'French Guiana' => 'GF',
    'French Polynesia' => 'PF',
    'Juan de Nova Island' => 'TF',
    'Gabon' => 'GA',
    'Gambia the' => 'GM',
    'Georgia' => 'GE',
    'Germany' => 'DE',
    'Ghana' => 'GH',
    'Gibraltar' => 'GI',
    'Greece' => 'GR',
    'Greenland' => 'GL',
    'Grenada' => 'GD',
    'Guadeloupe' => 'GP',
    'Guam' => 'GU',
    'Guatemala' => 'GT',
    'Guernsey' => 'GG',
    'Guinea' => 'GN',
    'Guinea-Bissau' => 'GW',
    'Guyana' => 'GY',
    'Haiti' => 'HT',
    'Heard Island and McDonald Islands' => 'HM',
    'Holy See (Vatican City)' => 'VA',
    'Honduras' => 'HN',
    'Hong Kong' => 'HK',
    'Hungary' => 'HU',
    'Iceland' => 'IS',
    'India' => 'IN',
    'Indonesia' => 'ID',
    'Iran' => 'IR',
    'Iraq' => 'IQ',
    'Ireland, Northern' => 'IE',
    'Isle of Man' => 'IM',
    'Israel' => 'IL',
    'Italy' => 'IT',
    'Howland Island', 'UM',
    'Jamaica' => 'JM',
    'Japan' => 'JP',
    'Jarvis Island','UM',
    'Jersey' => 'JE',
    'Jordan' => 'JO',
    'Kazakhstan' => 'KZ',
    'Kenya' => 'KE',
    'Kiribati' => 'KI',
    'Korea, North' => 'KP',
    'Korea, South' => 'KR',
    'Kuwait' => 'KW',
    'Kyrgyzstan' => 'KG',
    'Laos' => 'LA',
    'Latvia' => 'LV',
    'Lebanon' => 'LB',
    'Lesotho' => 'LS',
    'Liberia' => 'LR',
    'Libya' => 'LY',
    'Liechtenstein' => 'LI',
    'Lithuania' => 'LT',
    'Luxembourg' => 'LU',
    'Macau' => 'MO',
    'Macedonia, Former Yugoslav Republic of' => 'MK',
    'Madagascar' => 'MG',
    'Malawi' => 'MW',
    'Malaysia' => 'MY',
    'Maldives' => 'MV',
    'Mali' => 'ML',
    'Malta' => 'MT',
    'Marshall Islands' => 'MH',
    'Martinique' => 'MQ',
    'Mauritania' => 'MR',
    'Mauritius' => 'MU',
    'Mayotte' => 'YT',
    'Mexico' => 'MX',
    'Micronesia, Federated States of' => 'FM',
    'Moldova' => 'MD',
    'Monaco' => 'MC',
    'Mongolia' => 'MN',
    'Montenegro' => 'ME',
    'Montserrat' => 'MS',
    'Morocco' => 'MA',
    'Mozambique' => 'MZ',
    'Myanmar' => 'MM',
    'Namibia' => 'NA',
    'Nauru' => 'NR',
    'Nepal' => 'NP',
    'Netherlands Antilles' => 'AN',
    'Netherlands the' => 'NL',
    'New Caledonia' => 'NC',
    'New Zealand' => 'NZ',
    'Nicaragua' => 'NI',
    'Niger' => 'NE',
    'Nigeria' => 'NG',
    'Niue' => 'NU',
    'Norfolk Island' => 'NF',
    'Northern Mariana Islands' => 'MP',
    'Norway' => 'NO',
    'Oman' => 'OM',
    'Pakistan' => 'PK',
    'Palau' => 'PW',
    'Gaza Strip' => 'PS',
    'Panama' => 'PA',
    'Papua New Guinea' => 'PG',
    'Paraguay' => 'PY',
    'Peru' => 'PE',
    'Philippines' => 'PH',
    'Pitcaim Islands' => 'PN',
    'Poland' => 'PL',
    'Portugal' => 'PT',
    'Puerto Rico' => 'PR',
    'Qatar' => 'QA',
    'Reunion' => 'RE',
    'Romainia' => 'RO',
    'Russia' => 'RU',
    'Rwanda' => 'RW',
    'Saint Barthelemy' => 'BL',
    'Saint Helena' => 'SH',
    'Saint Kitts and Nevis' => 'KN',
    'Saint Lucia' => 'LC',
    'Saint Martin' => 'MF',
    'Saint Pierre and Miquelon' => 'PM',
    'Saint Vincent and the Grenadines' => 'VC',
    'Samoa' => 'WS',
    'San Marino' => 'SM',
    'Sao Tome and Principe' => 'ST',
    'Saudi Arabia' => 'SA',
    'Senegal' => 'SN',
    'Serbia' => 'RS',
    'Seychelles' => 'SC',
    'Sierra Leone' => 'SL',
    'Singapore' => 'SG',
    'Slovakia' => 'SK',
    'Slovenia' => 'SI',
    'Solomon Islands' => 'SB',
    'Somalia' => 'SO',
    'South Africa' => 'ZA',
    'South Georgia and South Sandwich Islands' => 'GS',
    'Spain' => 'ES',
    'Sri Lanka' => 'LK',
    'Sudan' => 'SD',
    'Suriname' => 'SR',
    'Svalbard' => 'SJ',
    'Swaziland' => 'SZ',
    'Sweden' => 'SE',
    'Switzerland' => 'CH',
    'Syria' => 'SY',
    'Taiwan' => 'TW',
    'Tajikistan' => 'TJ',
    'Tanzania' => 'TZ',
    'Thailand' => 'TH',
    'Timor-Leste' => 'TL',
    'Toga' => 'TG',
    'Tokelau' => 'TK',
    'Tonga' => 'TO',
    'Trinidad' => 'TT',
    'Tunisia' => 'TN',
    'Turkey' => 'TR',
    'Turkmenistan' => 'TM',
    'Turks and Caicos Islands' => 'TC',
    'Tuvalu' => 'TV',
    'Uganda' => 'UG',
    'Ukraine' => 'UA',
    'United Arab Emirates' => 'AE',
    'United Kingdom' => 'GB',
    'USA' => 'US',
    'United States Minor Outlying Islands' => 'UM',
    'United States Virgin Islands' => 'VI',
    'Uruguay' => 'UY',
    'Uzbekistan' => 'UZ',
    'Vanuatu' => 'VU',
    'Venezuela' => 'VE',
    'Vietnam' => 'VN',
    'Wallis and Futuna' => 'WF',
    'Western Sahara' => 'EH',
    'Yemen' => 'YE',
    'Zambia' => 'ZM',
    'Zimbabwe' => 'ZW',

    /*'Johnston Atoll' => 'NULL',
    'Europa Island' => 'NULL',
    'Man, Isle of' => 'NULL',
    'Midway Islands' => 'NULL',
    'Scotland' => 'NULL',
    'Spratly Islands' => 'NULL',
    'Wales' => 'NULL',
    'West Bank' => 'NULL',
    'Yugoslavia' => 'NULL',*/
    );


    if(!isset($countryList[$name])) 
    {
        return $name;
    }
    else
    {
        return $countryList[$name];
    }
}


function Pagination_admin($total_row,$function_name)
 {
    $url=explode('/',$_SERVER['REQUEST_URI']);
    if(is_array($url))
    {
        $val=(int)end($url);
        if(is_int($val))
        {
             $page=$val;
        }
    }


    $obj=new admin;
    $page_number       =(isset($page) AND !empty($page)) ? $page:0;
    $par_page_records  =10;
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

    if($function_name=='getAllUsers')
    {
        $pageUrl=BASEURL."/admin/allUsers/";
    }
    else if($function_name=='getAllPostReport')
    {
        $pageUrl=BASEURL."/admin/allPostReport/";
    }
    else if($function_name=='getAllAccountReport')
    {
        $pageUrl=BASEURL."/admin/allAccountReport/";
    }
    else if($function_name=='getAccountVerification')
    {
        $pageUrl=BASEURL."/admin/accountVerification/";
    }
    
    echo $obj->$function_name(($limit),$par_page_records);

    $pagination.="<br><br>";
    $half=floor($pagination_buttons/2);

    if ($page_number < $pagination_buttons AND ($last_page==$pagination_buttons OR $last_page > $pagination_buttons)) 
    {
        for ($i=1; $i <= $pagination_buttons; $i++) 
        { 
            if ($i==$page_number) 
            {
                $pagination.='<li class="active"><a href="'.$pageUrl.$i.'">'.$i.'<span class="sr-only">(Current)</span></a></li>';
            }
            else
            {
                $pagination.='<li><a href="'.$pageUrl.$i.'">'.$i.'</a></li>';
            }
        }

        if($last_page>$pagination_buttons) 
        {
          $pagination.='<li><a href="'.$pageUrl.($pagination_buttons+1).'">&raquo;</a></li>';
        }
    }
    else if($page_number>=$pagination_buttons AND $last_page>$pagination_buttons) 
    {
        if(($page_number+$half)>=$last_page)
        {
            $pagination.='<li><a href="'.$pageUrl.($last_page-$pagination_buttons).'">&laquo;</a></li>';
            for ($i=($last_page-$pagination_buttons)+1; $i <=$last_page; $i++) 
            { 
                if ($i==$page_number) 
                {
                    $pagination.='<li class="active"><a href="'.$page.'/'.$i.'">'.$i.'<span class="sr-only">(Current)</span></a></li>';
                }
                else
                {
                    $pagination.='<li><a href="'.$pageUrl.$i.'">'.$i.'</a></li>';
                }
            }
        }
        else if (($page_number+$half)<$last_page) 
        {
             $pagination.='<li><a href="'.$pageUrl.(($page_number-$half)-1).'">&laquo;</a></li>';

             for ($i=($page_number-$half); $i <=($page_number+$half) ; $i++) 
             { 
                if ($i==$page_number) 
                {
                    $pagination.='<li class="active"><a href="'.$page.'/'.$i.'">'.$i.'<span class="sr-only">(Current)</span></a></li>';
                }
                else
                {
                    $pagination.='<li><a href="'.$pageUrl.$i.'">'.$i.'</a></li>';
                }
             }

              $pagination.='<li><a href="'.$pageUrl.(($page_number+$half)+1).'">&raquo;</a></li>';
        }
    }
    else
    {
       if (@$page>1) 
       {
          $pagination.='<li><a href="'.$pageUrl.($page_number-1).'">&laquo;</a></li>';
       }
    }

    

    $pagination.="</nav></ul>";


    echo"
    <div class='row'>
      <div class='col-md-12 col-sm-12'>
          <center>$pagination</center>        
     </div>
    </div>"; 
           
}


function encryptDecryptChat($action, $string,$key)
{
    $output = false;
    $encryption_method = "AES-256-CBC";
    $key = hash('sha256',$key);

    if( $action == 'encrypt' )
    {
        // Generate a random string, hash it and get the first 16 character of the hashed string which will be ised as the IV
        $str = "qwertyuiopasdfghjklzxcvbnm,./;'\[]-=`!@#$%^&*()_+{}|\":?><0123456789QWERTYUIOPASDFGHJKLZXCVBNM";
        $shuffled = str_shuffle($str);
        $iv = substr(hash('sha256', $shuffled), 0, 16);

        $output = openssl_encrypt($string, $encryption_method, $key, 0, $iv);
        $output = base64_encode($output);       // Tidy up the string so that it survives the transport 100%
        $ivoutput = $iv.$output;                // Concat the IV with the encrypted message
        return $ivoutput;
    }
    else if( $action == 'decrypt' )
    {
        $iv = substr($string, 0, 16);           // Extract the IV from the encrypted string
        $string = substr($string, 16);          // The rest of the encrypted string is the message
        $output =@openssl_decrypt(base64_decode($string), $encryption_method, $key, 0, $iv);
        return $output;
    }

    return false;
}






?>