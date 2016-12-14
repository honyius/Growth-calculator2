<?php

class refG_Fenton
{   
    
    function __construct()
    {        
        $this->GA = array();
        $this->timeDecimal = array();
        $this->L = array();
        $this->M = array();
        $this->S = array();
        $this->P3 = array();
        $this->P10 = array();
        $this->P50 = array();
        $this->P90 = array();
        $this->P97 = array();
        $this->WG = array();
        $this->WG_cumulative = array();
        
        $this->L = [ 158=>
            0.0909561423514779,
            0.1329265721716140,
            0.1750714373432920,
            0.2175070281008730,
            0.2603496346787210,
            0.3037155473111960,
            0.3477210562326590,
            0.3924736580911800,
            0.4378785970501050,
            0.4836388647880560,
            0.5294486593973620,
            0.5750021789703520,
            0.6199936215993580,
            0.6641171853767070,
            0.7070719833381510,
            0.7486701722181040,
            0.7888369524496490,
            0.8275024394092870,
            0.8645967484735190,
            0.9000499950188490,
            0.9337922944217780,
            0.9657558673404900,
            0.9959213559118870,
            1.0243178237515900,
            1.0509764397569000,
            1.0759283728251100,
            1.0992047918535300,
            1.1208368657394700,
            1.1408557633802100,
            1.1592926536730700,
            1.1761787055153500,
            1.1915450878043400,
            1.2054229694373500,
            1.2178435193116800,
            1.2288379063246400,
            1.2384372993735200,
            1.2466728673556200,
            1.2535757791682500,
            1.2591772037087100,
            1.2635083098743100,
            1.2666002665623300,
            1.2684842426700900,
            1.2691914070948800,
            1.2687529287340100,
            1.2671999764847800,
            1.2645637192444900,
            1.2608753259104400,
            1.2561659653799400,
            1.2504668065502900,
            1.2438090183187800,
            1.2362237695827200,
            1.2277422292394200,
            1.2183955661861600,
            1.2082149493202600,
            1.1972315475390100,
            1.1854765297397200,
            1.1729810648196800,
            1.1597763216762000,
            1.1458934692065800,
            1.1313636763081300,
            1.1162181118781500,
            1.1004879448139500,
            1.0842043440128300,
            1.0673984783721000,
            1.0501015167890500,
            1.0323446281609700,
            1.0141589813851600,
            0.9955757453589070,
            0.9766260889794920,
            0.9573411811442110,
            0.9377521907503520,
            0.9178902866952350,
            0.8977866378762050,
            0.8774724131906090,
            0.8569787815357930,
            0.8363369118091050,
            0.8155779729078900,
            0.7947331337294920,
            0.7738335631711490,
            0.7529104301300010,
            0.7319949035031820,
            0.7111181521878230,
            0.6903113450810600,
            0.6696056510800260,
            0.6490322390818710,
            0.6286222779841260,
            0.6084069366847030,
            0.5884173840815320,
            0.5686847890725420,
            0.5492403205556610,
            0.5301151474288190,
            0.5113404385898820,
            0.4929473629352950,
            0.4749670893600810,
            0.4574307867592010,
            0.4403696240276150,
            0.4238147700602850,
            0.4077973937521700,
            0.3923477903851190,
            0.3774761621394040,
            0.3631726180937150,
            0.3494263937136340,
            0.3362267244647390,
            0.3235628458126110,
            0.3114239932228300,
            0.2997994021601150,
            0.2886783080693750,
            0.2780499463757090,
            0.2679035525033570,
            0.2582283618765560,
            0.2490136099195460,
            0.2402485320565630,
            0.2319223637150630,
            0.2240243403964260,
            0.2165436976759660,
            0.2094696711322110,
            0.2027914963436870,
            0.1964984088889210,
            0.1905796443464410,
            0.1850244382827780,
            0.1798220259885520,
            0.1749616424784730,
            0.1704325227552560,
            0.1662239018216140,
            0.1623250146802600,
            0.1587250963339100,
            0.1554133818300460,
            0.1523791072458650,
            0.1496115096882760,
            0.1470998263089560,
            0.1448332942595830,
            0.1428011506918370,
            0.1409926327573950,
            0.1393969774408510,
            0.1380034178838610,
            0.1368011833851440,
            0.1357795030763340,
            0.1349276060890650,
            0.1342347215549710,
            0.1336900786056860,
            0.1332829069964100,
            0.1330024508243850,
            0.1328379685288900,
            0.1327787191727720,
            0.1328139618188760,
            0.1329329555300490,
            0.1331249593691390,
            0.1333792300718070,
            0.1336849708484980,
            0.1340313313844360,
            0.1344074590376620,
            0.1348025011662180,
            0.1352056051281430,
            0.1356059182814780,
            0.1359925966694330,
            0.1363549960940520,
            0.1366826721162200,
            0.1369651889819860,
            0.1371921109374030,
            0.1373530022285200,
            0.1374374271013890,
            0.1374349173885760,
            0.1373342594125150,
            0.1371234939855080,
            0.1367906295063700,
            0.1363236743739200,
            0.1357106369869740,
            0.1349395257443490,
            0.1339984700136320,
            0.1328783814441020,
            0.1315729539667310,
            0.1300760024812640,
            0.1283813418874410,
            0.1264827870850040,
            0.1243741529736970,
            0.1220488029916680,
            0.1194897169604260,
            0.1166694910848390,
            0.1135602701081820,
            0.1101341987737300,
            0.1063634218247580,
            0.1022200840045420,
            0.0976826917125799,
            0.0928760694415406,
            0.0880713597772581,
            0.0835460669617911,
            0.0795776952371987,
            0.0764437488455398,
            0.0744217320288732,
            0.0737742713460118,
            0.0744218066411153,
            0.0759425910436921,
            0.0779000000000000
        ];
        $this->M = [ 158 =>
            512.9417451083040000,
            520.8651337558340000,
            528.9082176961300000,
            537.1507937910380000,
            545.6726589024010000,
            554.5536098920650000,
            563.8734436218730000,
            573.7093340290830000,
            584.0781277854330000,
            594.9363442971410000,
            606.2378800458420000,
            617.9366315131650000,
            629.9864951807440000,
            642.3413675302100000,
            654.9558478536900000,
            667.8007000847020000,
            680.8628527981540000,
            694.1299373794490000,
            707.5895852139900000,
            721.2294276871790000,
            735.0370961844210000,
            749.0006573395590000,
            763.1181885006100000,
            777.3977777297590000,
            791.8479483376340000,
            806.4772236348640000,
            821.2941269320750000,
            836.3071815398950000,
            851.5249612280310000,
            866.9572003249670000,
            882.6147937179710000,
            898.5086867533860000,
            914.6498247775550000,
            931.0491531368230000,
            947.7176171775340000,
            964.6661487271140000,
            981.9053686779120000,
            999.4455869871960000,
            1017.2971000933200000,
            1035.4702044346300000,
            1053.9751964494800000,
            1072.8223725762200000,
            1092.0220328698000000,
            1111.5845605666900000,
            1131.5204220849000000,
            1151.8400874590500000,
            1172.5540267237300000,
            1193.6727099135500000,
            1215.2066070631100000,
            1237.1661872595900000,
            1259.5618977990600000,
            1282.4041641865700000,
            1305.7034109796900000,
            1329.4700627360200000,
            1353.7145440131300000,
            1378.4472793686200000,
            1403.6781825179200000,
            1429.4054178072300000,
            1455.6154002134500000,
            1482.2940338713600000,
            1509.4272229157400000,
            1537.0008714813500000,
            1565.0008837029900000,
            1593.4131639702000000,
            1622.2236225326300000,
            1651.4181755000100000,
            1680.9827392368600000,
            1710.9032301077000000,
            1741.1655644770300000,
            1771.7556587093800000,
            1802.6594279769500000,
            1833.8627600288700000,
            1865.3515151911700000,
            1897.1115525975900000,
            1929.1287313818700000,
            1961.3889106777400000,
            1993.8779496189200000,
            2026.5817118536000000,
            2059.4861648622100000,
            2092.5773799574200000,
            2125.8414329663600000,
            2159.2643997161500000,
            2192.8323560339100000,
            2226.5313777467700000,
            2260.3475238163800000,
            2294.2664652984600000,
            2328.2734853428400000,
            2362.3538502338700000,
            2396.4928262558900000,
            2430.6756796932400000,
            2464.8876768302600000,
            2499.1136774988000000,
            2533.3291931229700000,
            2567.5003867192100000,
            2601.5930148514000000,
            2635.5728340834600000,
            2669.4056009793100000,
            2703.0570721028400000,
            2736.4927690936200000,
            2769.6728103315100000,
            2802.5519109366300000,
            2835.0845511047700000,
            2867.2252110317000000,
            2898.9283709132300000,
            2930.1485109451400000,
            2960.8412185633700000,
            2990.9875477275400000,
            3020.5940189208900000,
            3049.6682598668600000,
            3078.2178982888600000,
            3106.2505619103200000,
            3133.7738784546600000,
            3160.7965828851600000,
            3187.3528766821600000,
            3213.5024278429800000,
            3239.3060116048500000,
            3264.8244032049700000,
            3290.1183778805500000,
            3315.2487108688000000,
            3340.2759424834800000,
            3365.2552097984900000,
            3390.2362466479300000,
            3415.2685519424100000,
            3440.4016245925800000,
            3465.6849635090400000,
            3491.1680676024200000,
            3516.8992012269600000,
            3542.8982339399200000,
            3569.1566405016400000,
            3595.6646611160400000,
            3622.4125359870500000,
            3649.3905053186000000,
            3676.5888093146300000,
            3703.9976713254200000,
            3731.6069270672900000,
            3759.4060246226500000,
            3787.3843952202500000,
            3815.5314700888200000,
            3843.8366804571100000,
            3872.2894575538700000,
            3900.8792370781600000,
            3929.5955575463800000,
            3958.4280602922500000,
            3987.3663911198100000,
            4016.4001958331100000,
            4045.5191202361900000,
            4074.7128101331000000,
            4103.9709103002600000,
            4133.2830418786900000,
            4162.6388023740700000,
            4192.0277882644300000,
            4221.4395960278000000,
            4250.8638221422100000,
            4280.2900630857100000,
            4309.7079149765000000,
            4339.1069656570000000,
            4368.4767946937800000,
            4397.8069812936400000,
            4427.0871046633300000,
            4456.3067440096300000,
            4485.4554785393200000,
            4514.5230634335800000,
            4543.5033012850500000,
            4572.3940420978200000,
            4601.1933118504000000,
            4629.8991365212800000,
            4658.5095420889900000,
            4687.0225545320100000,
            4715.4361903210800000,
            4743.7482472482400000,
            4771.9563044268000000,
            4800.0579314623100000,
            4828.0506979603300000,
            4855.9321735264000000,
            4883.6999277660900000,
            4911.3515658491100000,
            4938.8855109214100000,
            4966.3010041051000000,
            4993.5973220865100000,
            5020.7737415519300000,
            5047.8295391876800000,
            5074.7639916800700000,
            5101.5762429664400000,
            5128.2623837580600000,
            5154.8154515401300000,
            5181.2283510488800000,
            5207.4939870205400000,
            5233.6052641913300000,
            5259.5550872975000000,
            5285.3375332799300000,
            5310.9736397867700000,
            5336.5114051734600000,
            5362.0000000000000000
        ];
        $this->S = [ 158 =>
            0.1417533137687070,
            0.1432726248264880,
            0.1448299864453670,
            0.1464507656660770,
            0.1481603295293510,
            0.1499840450759220,
            0.1519472793465210,
            0.1540743732580800,
            0.1563660668801170,
            0.1587994994347350,
            0.1613507840202340,
            0.1639960337349170,
            0.1667113616770860,
            0.1694728809450430,
            0.1722569795861330,
            0.1750463694757070,
            0.1778300863171220,
            0.1805974407627780,
            0.1833377434650750,
            0.1860403050764140,
            0.1886944362491940,
            0.1912896281689500,
            0.1938195242832960,
            0.1962819203019250,
            0.1986747924676670,
            0.2009961170233480,
            0.2032438702117970,
            0.2054160282758410,
            0.2075105871987630,
            0.2095259969942660,
            0.2114611617064770,
            0.2133150051199780,
            0.2150864510193470,
            0.2167744231891670,
            0.2183778454140170,
            0.2198956361890400,
            0.2213265923522920,
            0.2226693890847450,
            0.2239226962779320,
            0.2250851838233860,
            0.2261555216126410,
            0.2271323795372290,
            0.2280144289059840,
            0.2288003736256580,
            0.2294889502009200,
            0.2300788965537400,
            0.2305689506060900,
            0.2309578502799370,
            0.2312443334972540,
            0.2314271378002450,
            0.2315049919965300,
            0.2314766161591430,
            0.2313407299813530,
            0.2310960531564310,
            0.2307413053776460,
            0.2302752063382660,
            0.2296966033868980,
            0.2290072799448660,
            0.2282119555062170,
            0.2273154772203320,
            0.2263226922365940,
            0.2252384477043830,
            0.2240675907730820,
            0.2228149685648060,
            0.2214854275745560,
            0.2200838136702180,
            0.2186149726924110,
            0.2170837504817550,
            0.2154949928788710,
            0.2138535457243780,
            0.2121642548662010,
            0.2104319663203020,
            0.2086615262706760,
            0.2068577809086250,
            0.2050255764254500,
            0.2031697590124520,
            0.2012951748609340,
            0.1994066701602390,
            0.1975090910546860,
            0.1956072836435690,
            0.1937060940242260,
            0.1918103682939920,
            0.1899249525502050,
            0.1880546928902000,
            0.1862044354118400,
            0.1843790262250490,
            0.1825833114518180,
            0.1808221372146610,
            0.1791003496360930,
            0.1774227948386280,
            0.1757943189447810,
            0.1742196397200810,
            0.1727005227194210,
            0.1712357812870510,
            0.1698241004102390,
            0.1684641650762520,
            0.1671546602723580,
            0.1658942709858240,
            0.1646816822039540,
            0.1635155789149210,
            0.1623946461077630,
            0.1613175687715560,
            0.1602830318953750,
            0.1592897204682980,
            0.1583363194794000,
            0.1574215139177470,
            0.1565439887721710,
            0.1557024290312690,
            0.1548955196836310,
            0.1541219457178430,
            0.1533803921224930,
            0.1526695438861710,
            0.1519880859974650,
            0.1513347034450370,
            0.1507080812176140,
            0.1501069043039300,
            0.1495298576927150,
            0.1489756263727010,
            0.1484428953326210,
            0.1479303495612030,
            0.1474366740471370,
            0.1469605537790680,
            0.1465006737456410,
            0.1460557189354990,
            0.1456243743372880,
            0.1452053249396510,
            0.1447972771735480,
            0.1443994306431670,
            0.1440114781259310,
            0.1436331338415750,
            0.1432641120098350,
            0.1429041268504460,
            0.1425528925831450,
            0.1422101234276510,
            0.1418755336033320,
            0.1415488373292020,
            0.1412297488242600,
            0.1409179823075040,
            0.1406132519979330,
            0.1403152721145460,
            0.1400237568763990,
            0.1397384205038610,
            0.1394589772186160,
            0.1391851412424040,
            0.1389166267969650,
            0.1386531481040410,
            0.1383944193853710,
            0.1381401548624830,
            0.1378900687520020,
            0.1376438752656520,
            0.1374012886149440,
            0.1371620230113880,
            0.1369257926664950,
            0.1366923117917760,
            0.1364612945995350,
            0.1362324553203740,
            0.1360055082031840,
            0.1357801674976540,
            0.1355561474534730,
            0.1353331623203290,
            0.1351109263479100,
            0.1348891596413460,
            0.1346677169809480,
            0.1344465878221990,
            0.1342257674760280,
            0.1340052512533640,
            0.1337850344651340,
            0.1335651124222680,
            0.1333454804467700,
            0.1331261341154440,
            0.1329070692598850,
            0.1326882817227700,
            0.1324697673467730,
            0.1322515219745690,
            0.1320335414488340,
            0.1318158215708990,
            0.1315983571911860,
            0.1313811422092080,
            0.1311641704831320,
            0.1309474358711270,
            0.1307309322313620,
            0.1305146534220060,
            0.1302985934555240,
            0.1300827498932240,
            0.1298671238452580,
            0.1296517165760740,
            0.1294365293501190,
            0.1292215634318430,
            0.1290068200856920,
            0.1287922992136510,
            0.1285779693809700,
            0.1283637678161740,
            0.1281496303853210
        ];
        
        $this->timeDecimal[158] = 22+(4/7);        
        for ($i=159;$i < 351;$i++) {            
            $this->timeDecimal[$i] = $this->timeDecimal[$i-1] + (1/7);
        }
        for ($i=158; $i < 351; $i++) {            
            $this->P3[$i] = pow((1 + $this->L[$i] * $this->S[$i] * -1.88079360815125), (1/$this->L[$i])) * $this->M[$i];            
            $this->P10[$i] = pow((1 + $this->L[$i] * $this->S[$i] * -1.2815515655446), (1/$this->L[$i])) * $this->M[$i];
            $this->P50[$i] = pow((1 + $this->L[$i] * $this->S[$i] * 0), (1/$this->L[$i])) * $this->M[$i];                        
            $this->P90[$i] = pow((1 + $this->L[$i] * $this->S[$i] * 1.2815515655446), (1/$this->L[$i])) * $this->M[$i];            
            $this->P97[$i] = pow((1 + $this->L[$i] * $this->S[$i] * 1.88079360815125), (1/$this->L[$i])) * $this->M[$i];
            if ($i > 158) {
                $this->WG[$i-1] = $this->M[$i] / $this->M[$i-1];                
            }
            if ($i == 159) {
                $this->WG_cumulative[$i-1] = $this->WG[$i-1];
            }
            if ($i > 159) {
                $this->WG_cumulative[$i-1] = $this->WG_cumulative[$i-2] * $this->WG[$i-1];
            }
        }
    }
}

//$refG = new refG();
//print_r($refG->WG_cumulative);
//echo normsinv(0.1, 9);

?>