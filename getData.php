<?php
require_once("TrajectoryCalculator.php");

if (php_sapi_name() == 'cli') {
    $args = $_SERVER['argv'];
    if (count($args) != 5) {
        echo "Exactly 4 arguments required: birthweight and gestationalAge_weeks, gestationalAge_days and sex". "\r\n";
        exit;
    }    
    $birthweight = $args[1];
    $gestationalAge_weeks = $args[2];
    $gestationalAge_days = $args[3];
    $sex = $args[4];
} else {    
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {    
      //echo "xmlhttprequest" . "\r\n";    
    } else {
        echo "I'm sorry Dave, I'm afraid I can't do that." . "\r\n";
        exit;
    }
    parse_str($_SERVER['QUERY_STRING'], $args);  
    if (count($args) != 4) {
        echo "Exactly 4 arguments required: birthweight and gestationalAge_weeks, gestationalAge_days and sex". "\r\n";
        exit;
    }
    $birthweight = $args['birthweight']*1;
    $gestationalAge_weeks = $args['gestationalAge_weeks']*1;
    $gestationalAge_days = $args['gestationalAge_days']*1;
    $sex = $args['sex'];
    
    //can do the adding of unique visitor
    
    //getUniqueVisitorCount($_SERVER['REMOTE_ADDR']);
    
}

$trajectoryCalculator = new TrajectoryCalculator($birthweight, $gestationalAge_weeks, $gestationalAge_days, $sex);

/*
printOut("BirthWeight: " . $birthweight);
printOut("Gestational age: " . $gestationalAge_weeks . " + " . $gestationalAge_days);
printOut("Sex: " . $sex);
printOut("Total days: " . $trajectoryCalculator->totalDays);
printOut("Birth Percentile: " .  $trajectoryCalculator->birthPercentile);
printOut("GA21: " . $trajectoryCalculator->ga21);
printOut("WT21: " . $trajectoryCalculator->wt21);
printOut("Factor: " . $trajectoryCalculator->factor);

printOut("");
printOut("Total number of points to draw: " . count($trajectoryCalculator->chartData, COUNT_RECURSIVE));
echo json_encode($trajectoryCalculator->chartData, JSON_PRETTY_PRINT);
*/

//print_r($trajectoryCalculator->chartData['Fenton']['P3']);
//print_r($trajectoryCalculator->chartData['Fenton']['P3']);
$chartData = array();
$chartData['cols'] = array(
    array('label' => 'Gestational Age', 'type' => 'number'),
    //array('label' => 'Gestational Age', 'type' => 'string'),
    array('label' => 'Fenton 3rd', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Fenton 10th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Fenton 50th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Fenton 90th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Fenton 97th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Trajectory 3rd', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Trajectory 10th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Trajectory 50th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Trajectory 90th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Trajectory 97th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'WHO 3rd', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'WHO 10th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'WHO 50th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'WHO 90th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'WHO 97th', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Infant Hypothetical', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Infant Hypothetical l_SD', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true)),
    array('label' => 'Infant Hypothetical h_SD', 'type' => 'number'),
    array('type' => 'string', 'role' => 'tooltip', 'p' => array('html' => true))
);
$chartData['rows'] = array();
// min index is 158, max is 328
for ($i=164; $i <= 308; $i++)
{
    $temp = array();
    //$temp[] = array('v' => $i); // This is if we want axis to be in GA days
    $temp[] = array('v' => ($i/7)); // This is if we want axis to be in GA weeks
    //$temp[] = array('v' => (floor($i/7)) . '+' . ($i%7)); // This is if we want axis to be in GA weeks+days
    
    // Now we need to check if index $i has a value for each array and if so
    // set that value to the temp array. if not, set it to ''
    if (isset($trajectoryCalculator->chartData['Fenton']['P3'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Fenton']['P3'][$i]);
        $temp[] = array('v' => '<center><b>Reference Fenton 3rd</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Fenton']['P3'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Fenton']['P10'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Fenton']['P10'][$i]);
        $temp[] = array('v' => '<center><b>Reference Fenton 10th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Fenton']['P10'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Fenton']['P50'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Fenton']['P50'][$i]);
        $temp[] = array('v' => '<center><b>Reference Fenton 50th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Fenton']['P50'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Fenton']['P90'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Fenton']['P90'][$i]);
        $temp[] = array('v' => '<center><b>Reference Fenton 90th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Fenton']['P90'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Fenton']['P97'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Fenton']['P97'][$i]);
        $temp[] = array('v' => '<center><b>Reference Fenton 97th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Fenton']['P97'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Trajectory']['P3'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Trajectory']['P3'][$i]);
        $temp[] = array('v' => '<center><b>Reference Trajectory 3rd</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Trajectory']['P3'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Trajectory']['P10'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Trajectory']['P10'][$i]);
        $temp[] = array('v' => '<center><b>Reference Trajectory 10th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Trajectory']['P10'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Trajectory']['P50'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Trajectory']['P50'][$i]);
        $temp[] = array('v' => '<center><b>Reference Trajectory 50th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Trajectory']['P50'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['Trajectory']['P90'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Trajectory']['P90'][$i]);
        $temp[] = array('v' => '<center><b>Reference Trajectory 90th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Trajectory']['P90'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }    
    if (isset($trajectoryCalculator->chartData['Trajectory']['P97'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['Trajectory']['P97'][$i]);
        $temp[] = array('v' => '<center><b>Reference Trajectory 97th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['Trajectory']['P97'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['WHO']['P3'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['WHO']['P3'][$i]);
        $temp[] = array('v' => '<center><b>Reference WHO 3rd</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['WHO']['P3'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['WHO']['P10'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['WHO']['P10'][$i]);
        $temp[] = array('v' => '<center><b>Reference WHO 10th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['WHO']['P10'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }    
    if (isset($trajectoryCalculator->chartData['WHO']['P50'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['WHO']['P50'][$i]);
        $temp[] = array('v' => '<center><b>Reference WHO 50th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['WHO']['P50'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['WHO']['P90'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['WHO']['P90'][$i]);
        $temp[] = array('v' => '<center><b>Reference WHO 90th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['WHO']['P90'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['WHO']['P97'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['WHO']['P97'][$i]);
        $temp[] = array('v' => '<center><b>Reference WHO 97th</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['WHO']['P97'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['InfantHypothetical']['weight'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['InfantHypothetical']['weight'][$i]);
        $temp[] = array('v' => '<center><b>Target Trajectory</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['InfantHypothetical']['weight'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['InfantHypothetical']['weight_mhSD'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['InfantHypothetical']['weight_mhSD'][$i]);
        $temp[] = array('v' => '<center><b>Target Trajectory Lower Limit</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['InfantHypothetical']['weight_mhSD'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    if (isset($trajectoryCalculator->chartData['InfantHypothetical']['weight_phSD'][$i])) {
        $temp[] = array('v' => $trajectoryCalculator->chartData['InfantHypothetical']['weight_phSD'][$i]);
        $temp[] = array('v' => '<center><b>Target Trajectory Upper Limit</b><br />GA: <b>' . (floor($i/7)) . ' + ' . ($i%7) . '/7 weeks' . '</b><br />Weight: <b>' . round($trajectoryCalculator->chartData['InfantHypothetical']['weight_phSD'][$i], 0) . 'g</b></center>');
    } else {
        $temp[] = array('v' => '');
        $temp[] = array('v' => '');
    }
    
    
    
    $chartData['rows'][] = array('c' => $temp);
}

// set up header; first two prevent IE from caching queries
header('Cache-Control: no-cache, must-revalidate');
header('Content-type: application/json');

echo json_encode($chartData);


?>