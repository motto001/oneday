<?php
use lib\base\File;

//print_r(File::lista('test/res',false)) ;//kilistázza az összes filet és könytárat
//print_r(File::allowlista('test/res',['jpg','png'])) ;
$allowT=['jpg','png'];
$refT['dir']=['cim'=>'ujdir cím','text'=>'ujtext'];
$refT['up']=['text'=>'uj uptext'];
//print_r(File::kep_cim('test/res',$allowT,$refT)) ;
//print_r(File::readCSV_assocT('test/res/adat.csv',',',['elso','masodik','harmadik'])) ;
//print_r(File::readCSV_assocT('test/res/adat.csv',',',['elso'])) ;
print_r(File::readCSV_assocT('test/res/adat.csv',',',[])) ;
//print_r(File::readCSV_assocT('test/res/adat.csv',',',['elso','masodik'])) ;
 $dataT=File::readCSV_assocT('test/res/adat.csv',',',['elso','masodik']);
print_r(File::mezoToKey('elso',$dataT));