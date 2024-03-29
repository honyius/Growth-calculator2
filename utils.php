<?php

require_once 'normdistcalc/f_cumulative_normal_dist.php';
require_once 'normdistcalc/ndist_tabulated.php';

function printOut($x, $onCLI=true, $onWeb=true) {
    //echo php_sapi_name();
    if (php_sapi_name() == 'cli' && $onCLI) {
        echo $x . "\r\n";
    }
    else if ($onWeb){
        echo $x . "<br />\n";
    }
}
function printOutWeb($x) {
    if (php_sapi_name() == 'cli') {
        return;
    }
    else {
        echo $x . "<br />\n";
    }
}

function cumnormdist($x)
{
  $b1 =  0.319381530;
  $b2 = -0.356563782;
  $b3 =  1.781477937;
  $b4 = -1.821255978;
  $b5 =  1.330274429;
  $p  =  0.2316419;
  $c  =  0.39894228;

  if($x >= 0.0) {
      $t = 1.0 / ( 1.0 + $p * $x );
      return (1.0 - $c * exp( -$x * $x / 2.0 ) * $t *
      ( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
  }
  else {
      $t = 1.0 / ( 1.0 - $p * $x );
      return ( $c * exp( -$x * $x / 2.0 ) * $t *
      ( $t *( $t * ( $t * ( $t * $b5 + $b4 ) + $b3 ) + $b2 ) + $b1 ));
    }
}


?>