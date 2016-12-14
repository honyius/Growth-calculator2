<?php

require_once("utils.php");
require_once("refB_Fenton.php");
require_once("refG_Fenton.php");
require_once("refB_WHO.php");
require_once("refG_WHO.php");
require_once("ref_TB.php");
require_once("ref_TG.php");
require_once("first21DaysOfLife.php");

class InfantHypotheticalCalculations
{
    function __construct($ref_Fenton, $ref_WHO, $ga21, $wt21, $wt21_mhSD, $wt21_phSD, $birthPercentile, $zscore)
    {
        $this->weightAtDay = array();
        $this->weight_mhSD_AtDay = array();
        $this->weight_phSD_AtDay = array();
        $this->WG = array();
        $this->WG_cumulative = array();
        $this->ga = $ga21 - 20;                
        
        $this->weightAtDay[$ga21] = $wt21;
        $this->weight_mhSD_AtDay[$ga21] = $wt21_mhSD;
        $this->weight_phSD_AtDay[$ga21] = $wt21_phSD;
        
        $this->WG[$ga21] = $ref_Fenton->WG[$ga21];
        $this->WG_cumulative[$ga21] = $this->WG[$ga21];
        for ($i=$ga21+1;$i < 295;$i++) {
            $this->WG[$i] = $ref_Fenton->WG[$i];
            $this->WG_cumulative[$i] = $this->WG[$i] * $this->WG_cumulative[$i-1];
        }
        
        $ga42 = 294;
        $endweightgain_begin = $this->WG_cumulative[293];
        //printOut("endweightgain_begin: " . $endweightgain_begin);
        $firstweight = $endweightgain_begin * $wt21;
        //printOut("firstweight: " . $firstweight);
        //$wt42 = pow(1+($ref_WHO->L[$ga42] * $ref_WHO->S[$ga42] * normsinv($birthPercentile)), (1/$ref_WHO->L[$ga42])) * $ref_WHO->M[$ga42] * 1000;
        $wt42 = pow(1+($ref_WHO->L[$ga42] * $ref_WHO->S[$ga42] * $zscore), (1/$ref_WHO->L[$ga42])) * $ref_WHO->M[$ga42] * 1000;
        
        $this->factor = pow( ($wt42/$wt21/$endweightgain_begin), (1/($ga42-$ga21)) );
        
        for ($i=$ga21+1;$i < 295;$i++) {
            $this->weightAtDay[$i] = $this->weightAtDay[$i-1] * $this->WG[$i-1] * $this->factor;
            $this->weight_mhSD_AtDay[$i] = $this->weight_mhSD_AtDay[$i-1] * $this->WG[$i-1] * $this->factor;
            $this->weight_phSD_AtDay[$i] = $this->weight_phSD_AtDay[$i-1] * $this->WG[$i-1] * $this->factor;
        }
        
        // Now we need to calculate the weight percentile at 42 weeks and use that in addition to the WHO reference values to calculate the hypothesis weight values.
        //$perc_wt_who = cumnormdist((pow($this->weightAtDay[294]/1000/$ref_WHO->M[294], $ref_WHO->L[294]) - 1) / ($ref_WHO->L[294] * $ref_WHO->S[294]));
        //printOut("perc_wt_who: " . $perc_wt_who);
        //exit;
        $zscore_wt42 = ((pow($this->weightAtDay[294]/1000/$ref_WHO->M[294], $ref_WHO->L[294]) - 1) / ($ref_WHO->L[294] * $ref_WHO->S[294])) ;
        $zscore_wt42_mSD = ((pow($this->weight_mhSD_AtDay[294]/1000/$ref_WHO->M[294], $ref_WHO->L[294]) - 1) / ($ref_WHO->L[294] * $ref_WHO->S[294])) ;
        $zscore_wt42_pSD = ((pow($this->weight_phSD_AtDay[294]/1000/$ref_WHO->M[294], $ref_WHO->L[294]) - 1) / ($ref_WHO->L[294] * $ref_WHO->S[294])) ;
        
        //printOut("zscore_wt42: " . $zscore_wt42);
        
        //$wt_295 = pow((1 + ($ref_WHO->L[295]*$ref_WHO->S[295] * $zscore_wt42 )), 1 /$ref_WHO->L[295] ) * $ref_WHO->M[295] * 1000;
        //printOut("wt_295: " . $wt_295);
        //exit;
        
        // from 42 weeks to 44 weeks
        for ($i=295; $i <= 308; $i++) {
            $this->weightAtDay[$i] = pow((1 + ($ref_WHO->L[$i]*$ref_WHO->S[$i] * $zscore_wt42 )), 1 /$ref_WHO->L[$i] ) * $ref_WHO->M[$i] * 1000;
            $this->weight_mhSD_AtDay[$i] = pow((1 + ($ref_WHO->L[$i]*$ref_WHO->S[$i] * $zscore_wt42_mSD )), 1 /$ref_WHO->L[$i] ) * $ref_WHO->M[$i] * 1000;
            $this->weight_phSD_AtDay[$i] = pow((1 + ($ref_WHO->L[$i]*$ref_WHO->S[$i] * $zscore_wt42_pSD )), 1 /$ref_WHO->L[$i] ) * $ref_WHO->M[$i] * 1000;
        }
        //print_r($this->weightAtDay);
        //exit;
        
    }
    
}

class TrajectoryCalculator
{
    function __construct($birthweight, $gestationalAge_weeks, $gestationalAge_days, $sex)
    {        
        $totalDays = $gestationalAge_weeks*7 + $gestationalAge_days;

        $refB_Fenton = new refB_Fenton();
        $refG_Fenton = new refG_Fenton();
        $refB_WHO = new refB_WHO();
        $refG_WHO = new refG_WHO();
        $ref_TB = new ref_TB();
        $ref_TG = new ref_TG();

        if ($sex == 'male') {    
            $ga_index = $totalDays;
            $l = $refB_Fenton->L[$ga_index];
            $m = $refB_Fenton->M[$ga_index];
            $s = $refB_Fenton->S[$ga_index];
            $zscore = (pow($birthweight/$m, $l)-1) / ($l * $s);
            $zscore3 = (pow($refB_Fenton->P3[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore10 = (pow($refB_Fenton->P10[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore50 = (pow($refB_Fenton->P50[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore90 = (pow($refB_Fenton->P90[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore97 = (pow($refB_Fenton->P97[$totalDays]/$m, $l)-1) / ($l * $s);
            $f3 = new first21DaysOfLife($refB_Fenton->P3[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f10 = new first21DaysOfLife($refB_Fenton->P10[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f50 = new first21DaysOfLife($refB_Fenton->P50[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f90 = new first21DaysOfLife($refB_Fenton->P90[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f97 = new first21DaysOfLife($refB_Fenton->P97[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
        } else if ($sex == 'female') {    
            $ga_index = $totalDays;
            $l = $refG_Fenton->L[$ga_index];
            $m = $refG_Fenton->M[$ga_index];
            $s = $refG_Fenton->S[$ga_index];
            $zscore = (pow($birthweight/$m, $l)-1) / ($l * $s);
            $zscore3 = (pow($refG_Fenton->P3[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore10 = (pow($refG_Fenton->P10[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore50 = (pow($refG_Fenton->P50[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore90 = (pow($refG_Fenton->P90[$totalDays]/$m, $l)-1) / ($l * $s);
            $zscore97 = (pow($refG_Fenton->P97[$totalDays]/$m, $l)-1) / ($l * $s);
            $f3 = new first21DaysOfLife($refG_Fenton->P3[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f10 = new first21DaysOfLife($refG_Fenton->P10[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f50 = new first21DaysOfLife($refG_Fenton->P50[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f90 = new first21DaysOfLife($refG_Fenton->P90[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
            $f97 = new first21DaysOfLife($refG_Fenton->P97[$totalDays], $gestationalAge_weeks, $gestationalAge_days);
        }

        $f = new first21DaysOfLife($birthweight, $gestationalAge_weeks, $gestationalAge_days);
                
        //print_r($f->weight_mhSD);
        //print_r($f->weight_phSD);
        //exit;

        //printOut("BirthWeight: " . $birthweight);
        //printOut("Gestational age: " . $gestationalAge_weeks . " + " . $gestationalAge_days);
        //printOut("Sex: " . $sex);
        //printOut("Total days: " . $totalDays);
        $this->totalDays = $totalDays;
        $nearestWeek = floor($totalDays/7)*7;
        
        //printOut("Index on GA for totalDays: " . $ga_index, true, false);
        //printOut("L value: " . $l);
        //printOut("M value: " . $m);
        //printOut("S value: " . $s);

        //printOut("Z-score: " .  $zscore);

        //printOut("normsdist (according to mathstats lib): " . number_format(normsdist($zscore), 9));
        //$birthPercentile = number_format(normsdist($zscore), 9);
        $birthPercentile = number_format(cumnormdist($zscore), 9);
        $birthPercentileRounded = number_format(($birthPercentile * 100), 0);
        //printOut("Birth Percentile: " .  $birthPercentile);        
        printOut($birthPercentileRounded);
        $this->birthPercentile = $birthPercentile;
        
        $birthPercentile3 = number_format(cumnormdist($zscore3), 9);
        $birthPercentile10 = number_format(cumnormdist($zscore10), 9);
        $birthPercentile50 = number_format(cumnormdist($zscore50), 9);
        $birthPercentile90 = number_format(cumnormdist($zscore90), 9);
        $birthPercentile97 = number_format(cumnormdist($zscore97), 9);

        $ga21 = $totalDays + 20;
        $wt21 = $f->weightAtDay[21];
        
        $wt21_3 = $f3->weightAtDay[21];
        $wt21_10 = $f10->weightAtDay[21];
        $wt21_50 = $f50->weightAtDay[21];
        $wt21_90 = $f90->weightAtDay[21];
        $wt21_97 = $f97->weightAtDay[21];
        //printOut("GA21: " . $ga21);
        //printOut("WT21: " . $wt21);
        $this->ga21 = $ga21;
        $this->wt21 = $wt21;
        
        $wt21_mhSD = $f->weight_mhSD[21];
        $wt21_phSD = $f->weight_phSD[21];
        
        $wt21_mhSD_3 = $f3->weight_mhSD[21];
        $wt21_phSD_3 = $f3->weight_phSD[21];
        $wt21_mhSD_10 = $f10->weight_mhSD[21];
        $wt21_phSD_10 = $f10->weight_phSD[21];
        $wt21_mhSD_50 = $f50->weight_mhSD[21];
        $wt21_phSD_50 = $f50->weight_phSD[21];
        $wt21_mhSD_90 = $f90->weight_mhSD[21];
        $wt21_phSD_90 = $f90->weight_phSD[21];
        $wt21_mhSD_97 = $f97->weight_mhSD[21];
        $wt21_phSD_97 = $f97->weight_phSD[21];
        
        //printOut("WT21 mhSD: " . $wt21_mhSD);
        //printOut("WT21 phSD: " . $wt21_phSD);
        if ($sex == 'male') {
            //$ihc = new InfantHypotheticalCalculations($refB_Fenton, $refB_WHO, $ga21, 1177.23, 1123.642406, 1230.817594, $birthPercentile, $zscore);
            $ihc = new InfantHypotheticalCalculations($refB_Fenton, $refB_WHO, $ga21, $wt21, $wt21_mhSD, $wt21_phSD, $birthPercentile, $zscore);
            $ihc3 = new InfantHypotheticalCalculations($refB_Fenton, $refB_WHO, $ga21, $wt21_3, $wt21_mhSD_3, $wt21_phSD_3, $birthPercentile3, $zscore3);
            $ihc10 = new InfantHypotheticalCalculations($refB_Fenton, $refB_WHO, $ga21, $wt21_10, $wt21_mhSD_10, $wt21_phSD_10, $birthPercentile10, $zscore10);
            $ihc50 = new InfantHypotheticalCalculations($refB_Fenton, $refB_WHO, $ga21, $wt21_50, $wt21_mhSD_50, $wt21_phSD_50, $birthPercentile50, $zscore50);
            $ihc90 = new InfantHypotheticalCalculations($refB_Fenton, $refB_WHO, $ga21, $wt21_90, $wt21_mhSD_90, $wt21_phSD_90, $birthPercentile90, $zscore90);
            $ihc97 = new InfantHypotheticalCalculations($refB_Fenton, $refB_WHO, $ga21, $wt21_97, $wt21_mhSD_97, $wt21_phSD_97, $birthPercentile97, $zscore97);
            
            
        } else if ($sex == 'female') {
            //$ihc = new InfantHypotheticalCalculations($refG_Fenton, $refG_WHO, $ga21, 1177.23, 1123.642406, 1230.817594, $birthPercentile, $zscore);
            $ihc = new InfantHypotheticalCalculations($refG_Fenton, $refG_WHO, $ga21, $wt21, $wt21_mhSD, $wt21_phSD, $birthPercentile, $zscore);
            $ihc3 = new InfantHypotheticalCalculations($refG_Fenton, $refG_WHO, $ga21, $wt21_3, $wt21_mhSD_3, $wt21_phSD_3, $birthPercentile3, $zscore3);
            $ihc10 = new InfantHypotheticalCalculations($refG_Fenton, $refG_WHO, $ga21, $wt21_10, $wt21_mhSD_10, $wt21_phSD_10, $birthPercentile10, $zscore10);
            $ihc50 = new InfantHypotheticalCalculations($refG_Fenton, $refG_WHO, $ga21, $wt21_50, $wt21_mhSD_50, $wt21_phSD_50, $birthPercentile50, $zscore50);
            $ihc90 = new InfantHypotheticalCalculations($refG_Fenton, $refG_WHO, $ga21, $wt21_90, $wt21_mhSD_90, $wt21_phSD_90, $birthPercentile90, $zscore90);
            $ihc97 = new InfantHypotheticalCalculations($refG_Fenton, $refG_WHO, $ga21, $wt21_97, $wt21_mhSD_97, $wt21_phSD_97, $birthPercentile97, $zscore97);
        }

        //print_r($ihc->weightAtDay);
        //print_r($refB_Fenton->P3);
        //exit;

        //print_r($refB_Fenton->WG_cumulative);
        //exit;

        //print_r($ihc->WG);
        //print_r($ihc->WG_cumulative);
        //print_r($ihc->weightAtDay);
        //print_r($ihc->weight_phSD_AtDay);

        //printOut("Factor: " . $ihc->factor);
        $this->factor = $ihc->factor;
        //printOut("");

        //calculateInfantHypothetical

        //exit;
        //$zscore = pow($birthweight/);

        //printOut($zscore);

        $chartData['Fenton']['P3'] = array();
        $chartData['Fenton']['P10'] = array();
        if ($sex == 'male') {
            //for ($i=158; $i <= $nearestWeek; $i++) {   // get Fenton reference data
            for ($i=158; $i <= $totalDays; $i++) {   // get Fenton reference data
                $chartData['Fenton']['P3'][$i] = $refB_Fenton->P3[$i];
                $chartData['Fenton']['P10'][$i] = $refB_Fenton->P10[$i];
                $chartData['Fenton']['P50'][$i] = $refB_Fenton->P50[$i];
                $chartData['Fenton']['P90'][$i] = $refB_Fenton->P90[$i];
                $chartData['Fenton']['P97'][$i] = $refB_Fenton->P97[$i];
            }
            
            //for ($i=$nearestWeek; $i <= 350; $i++) {   // get Trajectory reference data
            /*for ($i=$totalDays; $i <= 350; $i++) {   // get Trajectory reference data
                if (isset($ref_TB->P3[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P3'][$i] = $ref_TB->P3[$gestationalAge_weeks][$i];
                if (isset($ref_TB->P10[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P10'][$i] = $ref_TB->P10[$gestationalAge_weeks][$i];
                if (isset($ref_TB->P50[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P50'][$i] = $ref_TB->P50[$gestationalAge_weeks][$i];
                if (isset($ref_TB->P90[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P90'][$i] = $ref_TB->P90[$gestationalAge_weeks][$i];
                if (isset($ref_TB->P97[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P97'][$i] = $ref_TB->P97[$gestationalAge_weeks][$i];                    
            }*/            
            
            for ($i=294; $i <= 328 ; $i++) {   // get WHO reference data
                $chartData['WHO']['P3'][$i] = $refB_WHO->P3[$i];
                $chartData['WHO']['P10'][$i] = $refB_WHO->P10[$i];
                $chartData['WHO']['P50'][$i] = $refB_WHO->P50[$i];
                $chartData['WHO']['P90'][$i] = $refB_WHO->P90[$i];
                $chartData['WHO']['P97'][$i] = $refB_WHO->P97[$i];
            }
            
        } else if ($sex == 'female') {
            for ($i=158; $i <= $totalDays; $i++) {   // get Fenton reference data
                $chartData['Fenton']['P3'][$i] = $refG_Fenton->P3[$i];
                $chartData['Fenton']['P10'][$i] = $refG_Fenton->P10[$i];
                $chartData['Fenton']['P50'][$i] = $refG_Fenton->P50[$i];
                $chartData['Fenton']['P90'][$i] = $refG_Fenton->P90[$i];
                $chartData['Fenton']['P97'][$i] = $refG_Fenton->P97[$i];
            }
            
            /*for ($i=$nearestWeek; $i <= 350; $i++) {   // get Trajectory reference data
                if (isset($ref_TG->P3[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P3'][$i] = $ref_TG->P3[$gestationalAge_weeks][$i];
                if (isset($ref_TG->P10[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P10'][$i] = $ref_TG->P10[$gestationalAge_weeks][$i];
                if (isset($ref_TG->P50[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P50'][$i] = $ref_TG->P50[$gestationalAge_weeks][$i];
                if (isset($ref_TG->P90[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P90'][$i] = $ref_TG->P90[$gestationalAge_weeks][$i];
                if (isset($ref_TG->P97[$gestationalAge_weeks][$i]))
                    $chartData['Trajectory']['P97'][$i] = $ref_TG->P97[$gestationalAge_weeks][$i];
            }*/
            
            for ($i=294; $i <= 328 ; $i++) {   // get WHO reference data
                $chartData['WHO']['P3'][$i] = $refG_WHO->P3[$i];
                $chartData['WHO']['P10'][$i] = $refG_WHO->P10[$i];
                $chartData['WHO']['P50'][$i] = $refG_WHO->P50[$i];
                $chartData['WHO']['P90'][$i] = $refG_WHO->P90[$i];
                $chartData['WHO']['P97'][$i] = $refG_WHO->P97[$i];
            }
        }        
        /*
        for ($i=$totalDays; $i < $ga21; $i++) {   // get Trajectory reference data
                $chartData['Trajectory']['P97'][$i] = $f97->weightAtDay[$i-$totalDays+1];
            }
            for ($i=$ga21; $i < 308; $i++) {   // get Trajectory reference data
                $chartData['Trajectory']['P97'][$i] = $ihc97->weightAtDay[$i];
            }*/
        // get InfantHypotheticalCalculations data
        for ($i=$totalDays; $i < $ga21;$i++) {
            $chartData['InfantHypothetical']['weight'][$i] = $f->weightAtDay[$i-$totalDays+1];
            $chartData['InfantHypothetical']['weight_mhSD'][$i] = $f->weight_mhSD[$i-$totalDays+1];
            $chartData['InfantHypothetical']['weight_phSD'][$i] = $f->weight_phSD[$i-$totalDays+1];
            $chartData['Trajectory']['P3'][$i] = $f3->weightAtDay[$i-$totalDays+1];
            $chartData['Trajectory']['P10'][$i] = $f10->weightAtDay[$i-$totalDays+1];
            $chartData['Trajectory']['P50'][$i] = $f50->weightAtDay[$i-$totalDays+1];
            $chartData['Trajectory']['P90'][$i] = $f90->weightAtDay[$i-$totalDays+1];
            $chartData['Trajectory']['P97'][$i] = $f97->weightAtDay[$i-$totalDays+1];
        }
        for ($i=$ga21; $i <= 308;$i++) {
            $chartData['InfantHypothetical']['weight'][$i] = $ihc->weightAtDay[$i];
            $chartData['InfantHypothetical']['weight_mhSD'][$i] = $ihc->weight_mhSD_AtDay[$i];
            $chartData['InfantHypothetical']['weight_phSD'][$i] = $ihc->weight_phSD_AtDay[$i];
            $chartData['Trajectory']['P3'][$i] = $ihc3->weightAtDay[$i];
            $chartData['Trajectory']['P10'][$i] = $ihc10->weightAtDay[$i];
            $chartData['Trajectory']['P50'][$i] = $ihc50->weightAtDay[$i];
            $chartData['Trajectory']['P90'][$i] = $ihc90->weightAtDay[$i];
            $chartData['Trajectory']['P97'][$i] = $ihc97->weightAtDay[$i];
        }

        //print_r($chartData['infanthypothetical']['weight']);

        //echo json_encode($chartData, JSON_PRETTY_PRINT);
        $this->chartData = $chartData;        
    }

}

?>