<?php
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists('infoUser')) {
    function infoUser($id)
    {
        return DB::table('users')->where('id',$id)->first();
    }
}
if (!function_exists('getSpesialis')) {
    function getSpesialis($name)
    {
        $spesialis = DB::table('teraphis')->where('nama',$name)->first()->spesialis;
        $spesialis = json_decode($spesialis,true);
        $result = null;

        foreach ($spesialis as $key => $data) {
          $result .= infoProduct($data['product_id'])->name.', ';
        }
        return $result;
    }
}
if(!function_exists('getRole')){
    function getRole(){
      return Auth::user()->role;
    }
}


if (!function_exists('randomAvatarName')) {
    function randomAvatarName($length) {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
}

// ---- DigitalCode24 ---- //

    function testHelper(){
        dd('success');
    }

    function userbyid($id)
    {
        return M\Users::find($id);
    }

    function groupbyid($id)
    {
        return M\Groups::find($id);
    }

    function uri2(){
        return Request::segment(2);
    }

    function uri3(){
        return Request::segment(3);
    }

    function uri4(){
        return Request::segment(4);
    }

    function uri5(){
        return Request::segment(5);
    }

    function slug($str)
    {
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
    }

    function tgl_indo($date)
    {
        if(session('lang')==2){
            $bln_indo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
        } else{
            $bln_indo = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        }

        $tahun = substr($date, 0, 4);
        $bulan = substr($date, 5, 2);
        $tgl   = substr($date, 8, 2);

        $result = $tgl . " " . $bln_indo[(int)$bulan-1] . " ". $tahun;
        return($result);
    }


    // DC24
    function composeReply($status,$msg,$payload = null) {
        header("Content-Type: application/json");
        $reply = json_encode(array(
                "SENDER" => "Sistem Informasi Developer Properti",
                "STATUS" => $status,
                "MESSAGE" => $msg,
                "PAYLOAD" => $payload));

        return $reply;
    }

    // DC24
    function composeReply2($status,$msg,$payload = null) { //LARAVEL WAY
        $reply = json_encode(array(
                  "SENDER" => "Sistem Informasi Developer Properti",
                  "STATUS" => $status,
                  "MESSAGE" => $msg,
                  "PAYLOAD" => $payload));

        return Response::make($reply, '200')->header('Content-Type', 'application/json');
    }

    function asset_url() {
        return URL::to('/');
    }

    function formatYMD($dateDMY) {
        if($dateDMY != "") {
            $a = explode("-",$dateDMY);
            return $a[2]."-".$a[1]."-".$a[0];
        }
        else {
            return "0000-00-00";
        }
    }

    function formatDMY($dateYMD) {
        if($dateYMD != "") {
            $a = explode("-",$dateYMD);
            return $a[2]."-".$a[1]."-".$a[0];
        }
        else {
            return "0000-00-00";
        }
    }

    
    function tglIndo($tgl,$mode) {
        if($tgl != "" && $mode != "" && $tgl!= "0000-00-00" && $tgl != "0000-00-00 00:00:00") {
            $t = explode("-",$tgl);
            $bln = array();
            $bln["01"]["LONG"] = "Januari";
            $bln["01"]["SHORT"] = "Jan";
            $bln["1"]["LONG"] = "Januari";
            $bln["1"]["SHORT"] = "Jan";
            $bln["02"]["LONG"] = "Februari";
            $bln["02"]["SHORT"] = "Feb";
            $bln["2"]["LONG"] = "Februari";
            $bln["2"]["SHORT"] = "Feb";
            $bln["03"]["LONG"] = "Maret";
            $bln["03"]["SHORT"] = "Mar";
            $bln["3"]["LONG"] = "Maret";
            $bln["3"]["SHORT"] = "Mar";
            $bln["04"]["LONG"] = "April";
            $bln["04"]["SHORT"] = "Apr";
            $bln["4"]["LONG"] = "April";
            $bln["4"]["SHORT"] = "Apr";
            $bln["05"]["LONG"] = "Mei";
            $bln["05"]["SHORT"] = "Mei";
            $bln["5"]["LONG"] = "Mei";
            $bln["5"]["SHORT"] = "Mei";
            $bln["06"]["LONG"] = "Juni";
            $bln["06"]["SHORT"] = "Jun";
            $bln["6"]["LONG"] = "Juni";
            $bln["6"]["SHORT"] = "Jun";
            $bln["07"]["LONG"] = "Juli";
            $bln["07"]["SHORT"] = "Jul";
            $bln["7"]["LONG"] = "Juli";
            $bln["7"]["SHORT"] = "Jul";
            $bln["08"]["LONG"] = "Agustus";
            $bln["08"]["SHORT"] = "Ags";
            $bln["8"]["LONG"] = "Agustus";
            $bln["8"]["SHORT"] = "Ags";
            $bln["09"]["LONG"] = "September";
            $bln["09"]["SHORT"] = "Sep";
            $bln["9"]["LONG"] = "September";
            $bln["9"]["SHORT"] = "Sep";
            $bln["10"]["LONG"] = "Oktober";
            $bln["10"]["SHORT"] = "Okt";
            $bln["11"]["LONG"] = "November";
            $bln["11"]["SHORT"] = "Nov";
            $bln["12"]["LONG"] = "Desember";
            $bln["12"]["SHORT"] = "Des";

            $b = $t[1];

            if (strpos($t[2], ":") === false) { //tdk ada format waktu
                $jam = "";
            }
            else {
                $j = explode(" ",$t[2]);
                $t[2] = $j[0];
                $jam = $j[1];
            }

            return $t[2]." ".$bln[$b][$mode]." ".$t[0]." ".$jam;
        }
        else {
            return "-";
        }
    }

    function bulanIndo($b,$mode) {
        $bln["01"]["LONG"] = "Januari";
        $bln["01"]["SHORT"] = "Jan";
        $bln["1"]["LONG"] = "Januari";
        $bln["1"]["SHORT"] = "Jan";
        $bln["02"]["LONG"] = "Februari";
        $bln["02"]["SHORT"] = "Feb";
        $bln["2"]["LONG"] = "Februari";
        $bln["2"]["SHORT"] = "Feb";
        $bln["03"]["LONG"] = "Maret";
        $bln["03"]["SHORT"] = "Mar";
        $bln["3"]["LONG"] = "Maret";
        $bln["3"]["SHORT"] = "Mar";
        $bln["04"]["LONG"] = "April";
        $bln["04"]["SHORT"] = "Apr";
        $bln["4"]["LONG"] = "April";
        $bln["4"]["SHORT"] = "Apr";
        $bln["05"]["LONG"] = "Mei";
        $bln["05"]["SHORT"] = "Mei";
        $bln["5"]["LONG"] = "Mei";
        $bln["5"]["SHORT"] = "Mei";
        $bln["06"]["LONG"] = "Juni";
        $bln["06"]["SHORT"] = "Jun";
        $bln["6"]["LONG"] = "Juni";
        $bln["6"]["SHORT"] = "Jun";
        $bln["07"]["LONG"] = "Juli";
        $bln["07"]["SHORT"] = "Jul";
        $bln["7"]["LONG"] = "Juli";
        $bln["7"]["SHORT"] = "Jul";
        $bln["08"]["LONG"] = "Agustus";
        $bln["08"]["SHORT"] = "Ags";
        $bln["8"]["LONG"] = "Agustus";
        $bln["8"]["SHORT"] = "Ags";
        $bln["09"]["LONG"] = "September";
        $bln["09"]["SHORT"] = "Sep";
        $bln["9"]["LONG"] = "September";
        $bln["9"]["SHORT"] = "Sep";
        $bln["10"]["LONG"] = "Oktober";
        $bln["10"]["SHORT"] = "Okt";
        $bln["11"]["LONG"] = "November";
        $bln["11"]["SHORT"] = "Nov";
        $bln["12"]["LONG"] = "Desember";
        $bln["12"]["SHORT"] = "Des";

        return $bln[$b][$mode];
    }

    function tglInggris($tgl,$mode) {
        if($tgl != "" && $mode != "" && $tgl!= "0000-00-00" && $tgl != "0000-00-00 00:00:00" && $tgl != "-") {
            $t = explode("-",$tgl);
            $bln = array();
            $bln["01"]["LONG"] = "January";
            $bln["01"]["SHORT"] = "Jan";
            $bln["1"]["LONG"] = "January";
            $bln["1"]["SHORT"] = "Jan";
            $bln["02"]["LONG"] = "February";
            $bln["02"]["SHORT"] = "Feb";
            $bln["2"]["LONG"] = "February";
            $bln["2"]["SHORT"] = "Feb";
            $bln["03"]["LONG"] = "March";
            $bln["03"]["SHORT"] = "Mar";
            $bln["3"]["LONG"] = "March";
            $bln["3"]["SHORT"] = "Mar";
            $bln["04"]["LONG"] = "April";
            $bln["04"]["SHORT"] = "Apr";
            $bln["4"]["LONG"] = "April";
            $bln["4"]["SHORT"] = "Apr";
            $bln["05"]["LONG"] = "May";
            $bln["05"]["SHORT"] = "May";
            $bln["5"]["LONG"] = "May";
            $bln["5"]["SHORT"] = "May";
            $bln["06"]["LONG"] = "June";
            $bln["06"]["SHORT"] = "Jun";
            $bln["6"]["LONG"] = "June";
            $bln["6"]["SHORT"] = "Jun";
            $bln["07"]["LONG"] = "July";
            $bln["07"]["SHORT"] = "Jul";
            $bln["7"]["LONG"] = "July";
            $bln["7"]["SHORT"] = "Jul";
            $bln["08"]["LONG"] = "August";
            $bln["08"]["SHORT"] = "Aug";
            $bln["8"]["LONG"] = "August";
            $bln["8"]["SHORT"] = "Aug";
            $bln["09"]["LONG"] = "September";
            $bln["09"]["SHORT"] = "Sep";
            $bln["9"]["LONG"] = "September";
            $bln["9"]["SHORT"] = "Sep";
            $bln["10"]["LONG"] = "October";
            $bln["10"]["SHORT"] = "Oct";
            $bln["11"]["LONG"] = "November";
            $bln["11"]["SHORT"] = "Nov";
            $bln["12"]["LONG"] = "December";
            $bln["12"]["SHORT"] = "Dec";

            $b = $t[1];

            if (strpos($t[2], ":") === false) { //tdk ada format waktu
                $jam = "";
            }
            else {
                $j = explode(" ",$t[2]);
                $t[2] = $j[0];
                $jam = $j[1];
            }

            return $t[2]." ".$bln[$b][$mode]." ".$t[0]." ".$jam;
        }
        else {
            return "-";
        }
    }

    function blnInggris($aBln,$mode) {
        $bln = array();
        $bln["01"]["LONG"] = "January";
        $bln["01"]["SHORT"] = "Jan";
        $bln["1"]["LONG"] = "January";
        $bln["1"]["SHORT"] = "Jan";
        $bln["02"]["LONG"] = "February";
        $bln["02"]["SHORT"] = "Feb";
        $bln["2"]["LONG"] = "February";
        $bln["2"]["SHORT"] = "Feb";
        $bln["03"]["LONG"] = "March";
        $bln["03"]["SHORT"] = "Mar";
        $bln["3"]["LONG"] = "March";
        $bln["3"]["SHORT"] = "Mar";
        $bln["04"]["LONG"] = "April";
        $bln["04"]["SHORT"] = "Apr";
        $bln["4"]["LONG"] = "April";
        $bln["4"]["SHORT"] = "Apr";
        $bln["05"]["LONG"] = "May";
        $bln["05"]["SHORT"] = "May";
        $bln["5"]["LONG"] = "May";
        $bln["5"]["SHORT"] = "May";
        $bln["06"]["LONG"] = "June";
        $bln["06"]["SHORT"] = "Jun";
        $bln["6"]["LONG"] = "June";
        $bln["6"]["SHORT"] = "Jun";
        $bln["07"]["LONG"] = "July";
        $bln["07"]["SHORT"] = "Jul";
        $bln["7"]["LONG"] = "July";
        $bln["7"]["SHORT"] = "Jul";
        $bln["08"]["LONG"] = "August";
        $bln["08"]["SHORT"] = "Ags";
        $bln["8"]["LONG"] = "August";
        $bln["8"]["SHORT"] = "Ags";
        $bln["09"]["LONG"] = "September";
        $bln["09"]["SHORT"] = "Sep";
        $bln["9"]["LONG"] = "September";
        $bln["9"]["SHORT"] = "Sep";
        $bln["10"]["LONG"] = "October";
        $bln["10"]["SHORT"] = "Oct";
        $bln["11"]["LONG"] = "November";
        $bln["11"]["SHORT"] = "Nov";
        $bln["12"]["LONG"] = "December";
        $bln["12"]["SHORT"] = "Des";

        return $bln[$aBln][$mode];
    }

    function randomDigits($length){
        $digits = "";
        $numbers = range(0,9);
        shuffle($numbers);
        for($i = 0;$i < $length;$i++) {
          $digits .= $numbers[$i];
        }
        return $digits;
    }

    function createCode($codeLength) {
        $kode = strtoupper(substr(md5(Helper::randomDigits($codeLength)), 0,($codeLength-1) ));

        return $kode;
    }

    function mapExcelColumn($idx) {
        if($idx == 0) $colName = "A";
        if($idx == 1) $colName = "B";
        if($idx == 2) $colName = "C";
        if($idx == 3) $colName = "D";
        if($idx == 4) $colName = "E";
        if($idx == 5) $colName = "F";
        if($idx == 6) $colName = "G";
        if($idx == 7) $colName = "H";
        if($idx == 8) $colName = "I";
        if($idx == 9) $colName = "J";
        if($idx == 10) $colName = "K";
        if($idx == 11) $colName = "L";
        if($idx == 12) $colName = "M";
        if($idx == 13) $colName = "N";
        if($idx == 14) $colName = "O";
        if($idx == 15) $colName = "P";
        if($idx == 16) $colName = "Q";
        if($idx == 17) $colName = "R";
        if($idx == 18) $colName = "S";
        if($idx == 19) $colName = "T";
        if($idx == 20) $colName = "U";
        if($idx == 21) $colName = "V";
        if($idx == 22) $colName = "W";
        if($idx == 23) $colName = "X";
        if($idx == 24) $colName = "Y";
        if($idx == 25) $colName = "Z";

        return $colName;
    }

    // DC24
    // function getReferenceInfo($refKtgId, $refValueId) {
    //     $ref = DB::table("sid_references")
    //         ->where("R_CATEGORY",$refKtgId)
    //         ->where("R_ID",$refValueId)
    //         ->first();

    //     if(count($ref) > 0) {
    //         return $ref->{"R_INFO"};
    //     }
    //     else {
    //         return "";
    //     }
    // }

   
    function formatPonsel($ponsel,$prefix) {
        if(trim($ponsel) != "" && trim($ponsel) != "-") {
            if(substr($ponsel,0,5) == "+6262" || substr($ponsel,0,4) == "+620" || substr($ponsel,0,4) == "6262" || substr($ponsel,0,3) == "620") {
                //+626281xxxx
                if(substr($ponsel,0,5) == "+6262")  {
                    if($prefix == "+62") {
                        $ponsel = "+62".substr($ponsel,5);
                    }
                    if($prefix == "0") {
                        $ponsel = "0".substr($ponsel,5);
                    }
                    if(trim($prefix) == "") {
                        $ponsel = substr($ponsel,5);
                    }
                }

                //+62081xxxx
                if(substr($ponsel,0,4) == "+620") {
                    if($prefix == "+62") {
                        $ponsel = "+62".substr($ponsel,4);
                    }
                    if($prefix == "0") {
                        $ponsel = "0".substr($ponsel,4);
                    }
                    if(trim($prefix) == "") {
                        $ponsel = substr($ponsel,4);
                    }
                }

                //626281xxxx
                if(substr($ponsel,0,4) == "6262") {
                    if($prefix == "+62") {
                        $ponsel = "+62".substr($ponsel,4);
                    }
                    if($prefix == "0") {
                        $ponsel = "0".substr($ponsel,4);
                    }
                    if(trim($prefix) == "") {
                        $ponsel = substr($ponsel,4);
                    }
                }

                //62081xxxx
                if(substr($ponsel,0,3) == "620")  {
                    if($prefix == "+62") { //no change
                        $ponsel = "+62".substr($ponsel,3);
                    }
                    if($prefix === "0") {
                        $ponsel = "0".substr($ponsel,3);
                    }
                    if(trim($prefix) == "") {
                        $ponsel = substr($ponsel,3);
                    }
                }
            }
            else {
                //+6281xxxxx
                if(substr($ponsel,0,3) == "+62")  {
                    if($prefix == "+62") { //no change

                    }
                    if($prefix == "0") {
                        $ponsel = "0".substr($ponsel,3);
                    }
                    if(trim($prefix) == "") {
                        $ponsel = substr($ponsel,3);
                    }
                }

                //628xxxxx
                if(substr($ponsel,0,2) == "62") {
                    if($prefix == "+62") {
                        $ponsel = "+".$ponsel;
                    }
                    if($prefix == "0") {
                        $ponsel = "0".substr($ponsel,2);
                    }
                    if(trim($prefix) == "") {
                        $ponsel = substr($ponsel,2);
                    }
                }

                //8132333
                if(substr($ponsel,0,1) == "8")  {
                    if($prefix == "+62") {
                        $ponsel = "+62".$ponsel;
                    }
                    if($prefix == "0") {
                        $ponsel = "0".$ponsel;
                    }
                    if(trim($prefix) == "") { //no change

                    }
                }

                //081xxxxx
                if(substr($ponsel,0,2) == "08") {
                    if($prefix == "+62") {
                        $ponsel = "+62".substr($ponsel,1);
                    }
                    if($prefix == "0") { //no change

                    }
                    if(trim($prefix) == "") {
                        $ponsel = substr($ponsel,1);
                    }
                }
            }
        }

        return $ponsel;
    }
