<?php
function TCVerification($tcno,$name,$surName,$birthYear){
    $client = new SoapClient("https://tckimlik.nvi.gov.tr/Service/KPSPublic.asmx?WSDL");
    try {
        $result = $client->TCKimlikNoDogrula([
            'TCKimlikNo' => $tcno,
            'Ad' => mb_strtoupper($name,"utf-8"),
            'Soyad' => mb_strtoupper($surName,"utf-8"),
            'DogumYili' => $birthYear
        ]);
        if ($result->TCKimlikNoDogrulaResult) {
            return true;
        } else {
            return false;
        }
    } catch (Exception $e) {
        return $e->faultstring;
    }
}
function checkTC($tcno){
    if(strlen($tcno) != 11){
        return false; 
    }  
    if($tcno[0] == '0'){ 
        return false; 
    }
    $checkMod1 = ((7*($tcno[0]+$tcno[2]+$tcno[4]+$tcno[6]+$tcno[8])-($tcno[1]+$tcno[3]+$tcno[5]+$tcno[7]))%10)==$tcno[9];
    $checkMod2 = (($tcno[0]+$tcno[1]+$tcno[2]+$tcno[3]+$tcno[4]+$tcno[5]+$tcno[6]+$tcno[7]+$tcno[8]+$tcno[9])%10)==$tcno[10];
    return $checkMod1 && $checkMod2;
}