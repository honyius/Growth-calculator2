<?php

class ref_TG
{
    function __construct()
    {       
        //$f = "ref_TG.txt";
        $f = "ref_TG_exact.txt";
        $myArr = file($f);        
        $data = array();        
        for($i=0; $i < count($myArr); $i++) {
            $data[$i] = str_getcsv($myArr[$i], "\t");              
            for ($j=24; $j <= 34; $j++) {                
                if ($data[$i][(($j-24)*5)]*1 != 0 && $data[$i][(($j-24)*5)]*1 != '#N/A')
                    $this->P3[$j][$i+158] = $data[$i][(($j-24)*5)];
                if ($data[$i][(($j-24)*5)+1]*1 != 0 && $data[$i][(($j-24)*5)+1]*1 != '#N/A')
                    $this->P10[$j][$i+158] = $data[$i][(($j-24)*5)+1];
                if ($data[$i][(($j-24)*5)+2]*1 != 0 && $data[$i][(($j-24)*5)+2]*1 != '#N/A')
                    $this->P50[$j][$i+158] = $data[$i][(($j-24)*5)+2];
                if ($data[$i][(($j-24)*5)+3]*1 != 0 && $data[$i][(($j-24)*5)+3]*1 != '#N/A')
                    $this->P90[$j][$i+158] = $data[$i][(($j-24)*5)+3];
                if ($data[$i][(($j-24)*5)+4]*1 != 0 && $data[$i][(($j-24)*5)+4]*1 != '#N/A')
                    $this->P97[$j][$i+158] = $data[$i][(($j-24)*5)+4];
            }
        }       
    }    
}
//$ref_TG = new ref_TG();
//print_r($ref_TG->P97[29]);
?>