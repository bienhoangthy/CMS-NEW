<?php 
if (!function_exists("time_elapsed_string")) {
    function time_elapsed_string($datetime, $full = false) {
        $today = time();    
        $createdday= strtotime($datetime); 
        $datediff = abs($today - $createdday);  
        $difftext="";  
        $years = floor($datediff / (365*60*60*24));  
        $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
        $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
        $hours= floor($datediff/3600);  
        $minutes= floor($datediff/60);  
        $seconds= floor($datediff);  
        if($difftext=="")  
        {  
          if($years>1)  
           $difftext=$years." ".lang('yearsago');  
          elseif($years==1)  
           $difftext=$years." ".lang('yearsago');  
        }  
        if($difftext=="")  
        {  
           if($months>1)  
           $difftext=$months." ".lang('monthsago');  
           elseif($months==1)  
           $difftext=$months." ".lang('monthsago');  
        }   
        if($difftext=="")  
        {  
           if($days>1)  
           $difftext=$days." ".lang('daysago');  
           elseif($days==1)  
           $difftext=$days." ".lang('daysago');  
        } 
        if($difftext=="")  
        {  
           if($hours>1)  
           $difftext=$hours." ".lang('hoursago');  
           elseif($hours==1)  
           $difftext=$hours." ".lang('hoursago');  
        }   
        if($difftext=="")  
        {  
           if($minutes>1)  
           $difftext=$minutes." ".lang('minutesago');  
           elseif($minutes==1)  
           $difftext=$minutes." ".lang('minutesago');  
        }  
        if($difftext=="")  
        {  
           if($seconds>1)  
           $difftext=$seconds." ".lang('secondsago');  
           elseif($seconds==1)  
           $difftext=$seconds." ".lang('secondsago');  
        }  
        if($difftext=="")  
        {   
           $difftext=lang('asecondago');  
        } 
        return $difftext;  
    }
}
 ?>