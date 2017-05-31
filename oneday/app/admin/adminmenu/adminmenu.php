<?php
namespace app\admin;
class Adminmenu_ADT
{
    public static $ADT=[
'view'=><<<html
     <div class="navbar-header"><a class="navbar-brand navbar-link" href="index.php">Home</a>
            <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">
            Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li role="presentation"><a href="index.php?app=admin\club">Felhasználók</a></li>
                   <!-- <li  class="active" role="presentation"><a href="index.php?app=admin\email">Emailok</a></li>-->
                    <li role="presentation"><a href="index.php?app=admin\szallas">Szállás</a></li>
                    <li role="presentation"><a href="index.php?app=admin\slider">Slider</a></li>   
                    <li role="presentation"><a href="index.php?app=admin|nyito">Nyitólap</a></li> 
                    <li role="presentation"><a href="index.php?app=admin|hirdet" >Hirdetés</a></li> 
    				 <li role="presentation"><a href="index.php?app=admin|email" >Email</a></li> 
					 <li role="presentation"><a href="index.php?app=admin|club&task=jelszo" >Jelszó</a></li> 
                </ul>
            </div>     
        
html
   ];      
}

