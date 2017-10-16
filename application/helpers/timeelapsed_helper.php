<?php 
if (!function_exists("time_elapsed_string")) {
  function time_elapsed_string($datetime, $full = false) {
      $now = new DateTime;
      $ago = new DateTime($datetime);
      $diff = $now->diff($ago);

      $diff->w = floor($diff->d / 7);
      $diff->d -= $diff->w * 7;

      $string = array(
          'y' => lang('year'),
          'm' => lang('month'),
          'w' => lang('week'),
          'd' => lang('day'),
          'h' => lang('hour'),
          'i' => lang('minute'),
          's' => lang('second'),
      );
      foreach ($string as $k => &$v) {
          if ($diff->$k) {
              $v = $diff->$k . ' ' . $v;
          } else {
              unset($string[$k]);
          }
      }

      if (!$full) $string = array_slice($string, 0, 2);
      return $string ? implode(', ', $string) . lang('ago') : lang('asecondago');
  }
}
 ?>