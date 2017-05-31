<?php
namespace lib\jog;
use lib\db\DB;
/**
 * Class Azonosit
 * session-be írja az useridet vagy nullát
 */
class Azonosit
{
    function __construct()
    {
        $this->alap();
    }

    function alap()
    {
        if(!isset($_SESSION['userid'])) {$_SESSION['userid']=0;}

    }
    public static function set_userdata($userid,$user_mezok='')
    {
        $userDataT_sql=\CONF::$userDataT_sql;
        if($userDataT_sql=='')
        {
            if($user_mezok==''){$user_mezok=\CONF::$user_mezok ;}
            $sql="SELECT ".$user_mezok." FROM userek WHERE id='".$userid."'";
        }
        else
        {eval('$sql='.$userDataT_sql.';');}    
        $userT= DB::assoc_sor($sql);
        if(empty($userT)){\GOB::$hibaT['sysErr']['db']['Azonosit::set_userdata']=' Az useradat lekérdezés üres tömböt adott vissza. SQL='.$sql;}
        return $userT;
    }


}