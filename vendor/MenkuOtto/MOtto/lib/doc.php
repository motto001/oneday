<?php
/**
nyelvi  elemek:
minden kiiratást a GOB::messageT- megfelelő subtömbjébe kell iánytani.
alap: 'err' használatos: info,alert, de lehet bármi.

Ha van a kifekezésnek paraméterei akkor azt #PAR_ előtaggal kell kell beszúrni 
 #PAR_kulcs=partömb
 
az LT_change végigjárja a messagetömböt és a GOBB::LTalapján feltölti,lecseréli

alapértelmezetten a kirást használó osztályok töltik fel a GOB::LT-t a saját LT 
osztályaikkal. de ha használunk többnyelvűsítő applikációt akkor az felülírja
 az adatbázis vagy a lang filok alapján.

 */

