<?php
namespace lib\db;
defined( '_MOTTO' ) or die( 'Restricted access' );
class DB
{
/**
figyelem! a LINIT mindig a végére kerüljon mert levágja!
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
        if(\CONF::$sql_log='full'){\GOB::$logT['sql'][]=$sql;};
       
        try {
            $stmt = \GOB::$db->prepare($sql);
            $stmt->execute();
            $result=$stmt->rowCount();
          
        } catch (PDOException $e) {
            \GOB::$logT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }
    
   static public function assoc_tomb($sql)
    {
        if(\CONF::$sql_log='full'){\GOB::$logT['sql'][]=$sql;};
        $result = array();
        try {
            $stmt = \GOB::$db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            while ($row = $stmt->fetch()) {
                $result[] = $row;
            }
        } catch (PDOException $e) {
            \GOB::$logT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }
   static public function assoc_sor($sql)
    {
        if(\CONF::$sql_log='full'){\GOB::$logT['sql'][]=$sql;}
        $result = array();
        try {
            $stmt = \GOB::$db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            if (!empty($row)) {
                $result = $row;
            }

        } catch (PDOException $e) {
            \GOB::$logT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }
   static public function egymezo($sql) 
   {
    if(\CONF::$sql_log='full'){\GOB::$logT['sql'][]=$sql;}
        $result = '';
        try {
            $stmt = \GOB::$db->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $row = $stmt->fetch();
            if (!empty($row)) {
                $result = $row[0];
            }

        } catch (PDOException $e) {
            \GOB::$echoT['hiba']['pdo'][] = $e->getMessage();
        }
        return $result;
    }

}