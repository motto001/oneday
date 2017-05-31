<?php
namespace lib\db;
defined( '_MOTTO' ) or die( 'Restricted access' );
class CONF
{

    public static $adminok=array(1,2);
    public static $sql_log='full';//lehet 'no','parancs': a lekérdezéseket nem
    public static $host = 'localhost';
    public static $felhasznalonev = 'root';
    public static $jelszo = '';
    public static $adatbazis = 'oneday';
}
class GOB
{
  public static   $logT=[];
  public static   $db=null;
}

class Connect
{
    static public function connect()
    {
        $res = true;
        try {
            $db = new \PDO("mysql:dbname=" . CONF::$adatbazis . ";host=" . CONF::$host, CONF::$felhasznalonev, CONF::$jelszo, array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            GOB::$db = $db;
            //$db->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        } catch (PDOException $e) {
            die(GOB::$logT['hiba']['pdo'] = "Adatbazis kapcsolodasi hiba: " . $e->getMessage());
            $res = false;
        }
        return $res;
    }
}
class DB
{
    /**
     figyelem! a LIMIT mindig a végére kerüljon mert levágja!
     */
    static public function assoc_tomb_Count($sql)
    {
        $cout_sql=explode('LIMIT',$sql)[0];
        $result['dataT']=self::assoc_tomb($sql);
        $result['sum']=self::Count($cout_sql);
        return $result;
    }
    static public function Count($sql)
    {
        if(CONF::$sql_log='full'){GOB::$logT['sql'][]=$sql;};
         
        try {
            $stmt = GOB::$db->prepare($sql);
            $stmt->execute();
            $result=$stmt->rowCount();

        } catch (PDOException $e) {
            GOB::$logT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }

    static public function assoc_tomb($sql)
    {
        if(CONF::$sql_log='full'){GOB::$logT['sql'][]=$sql;};
        $result = array();
        try {
            $stmt = GOB::$db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                $result[] = $row;
            }
        } catch (PDOException $e) {
            GOB::$logT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }
    static public function assoc_sor($sql)
    {
        if(CONF::$sql_log='full'){GOB::$logT['sql'][]=$sql;}
        $result = array();
        try {
            $stmt = GOB::$db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            if (!empty($row)) {
                $result = $row;
            }

        } catch (PDOException $e) {
            GOB::$logT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }
    static public function egymezo($sql)
    {
        if(CONF::$sql_log='full'){GOB::$logT['sql'][]=$sql;}
        $result = '';
        try {
            $stmt = GOB::$db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            if (!empty($row)) {
                $result = $row[0];
            }

        } catch (PDOException $e) {
            GOB::$echoT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }
    /**
     truev-al vagy false-al tér vissza a hibát GOB::$hiba['pdo'][]-ba írja
     */
    static public function parancs($sql)
    {
        $result['bool'] = true;
        $result['res'] ='ok';
         
        if (CONF::$sql_log != 'no') {
            GOB::$logT['sql'][] = $sql;
        }
    
        try {
            $stmt = GOB::$db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            GOB::$logT['hiba']['pdo'][]= $e->getMessage();
            $result['bool'] = false;
            $result['res'] = $e->getMessage();
        }
    
        return $result;
    }
    /**
     a beszúrt id-el tér vissza a hibát GOB::$hiba['pdo'][]-ba írja
     */
    static public function beszur($sql)
    {if(CONF::$sql_log!='no'){GOB::$logT['sql'][]=$sql;}
    $result['bool'] = true;
    $result['res'] ='ok';
    $result['id'] =0;
    try {
        $stmt = GOB::$db->prepare($sql);
        $stmt->execute();
        $result['id'] =GOB::$db->lastInsertId();
    
    } catch (PDOException $e) {
        GOB::$logT['hiba']['pdo'][] = $e->getMessage();
        $result['bool'] = false;
        $result['err'] = $e->getMessage();
    }
    if($result['id']==0){$result['bool'] = false;$result['res']='no_succes';
    GOB::$logT['hiba']['sql'][] =$sql;
    }
    return $result;
    }
}