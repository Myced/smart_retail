<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

<style>
    * {       
    margin:0;
    padding:0;
    list-style: none;
    text-decoration: none;
}
#wrapper    {       
    width:400px;
    margin:50px auto 0 auto;
    border-radius:20px;
    overflow:hidden;
    background:#222;
    border:1px solid #00c6ff;
    border: inset 1px #555;
}

.number     {      
    padding: 0 50px 0 0;
    float:right;
}

a.selected 
{       
    background:#00c6ff;
    color:#333;
}

li   {       

    font-family:'Roboto Condensed', Arial, Helvetica, sans-serif;
    font-size:20px;


    color:#00c6ff;
}


li a {       
    color:#00c6ff;
    padding:20px;
    width:100%;
    display: block;
    background-image: linear-gradient(to left,
        transparent,
        transparent 50%,
        #00c6ff 50%,
        #00c6ff);
    background-position: 100% 0;
    background-size: 200% 100%;
    transition: all .5s ease-in;


}

li a:hover 
{        
    background-position: 0 0;
    color:#333;
}
</style>

<div >
     <ul id="wrapper">
        <li><a href="#">Projects <span class="number">3</span> </a></li>
        <li><a href="#">Music <span class="number">4</span> </a></li>
        <li><a href="#">Photos <span class="number">2</span> </a></li>
    </ul>
</div>