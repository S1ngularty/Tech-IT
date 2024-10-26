<?php  
session_start();
include('structure/Header.html');
include('structure/sidebar.html');



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
   body .container{
   grid-area: 2/5/7/15;
   display: grid;
   gap: 10px;
   padding: 0%;
grid-template-columns: 100px 100px 100px 100px 100px 100px 100px 100px 100px 100px;
grid-template-rows: 100px 100px 100px 100px 50px;

    }
    body .container #box{
        border: blue solid thin;
        margin: 5px;
        border-radius: 5px;
        padding: 10px;
    }

    body .container .box1{
        grid-area: 1/1/3/5;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    body .container .box2{
        grid-area: 1/5/3/9;
    }
     body .container .box4{
        grid-area: 3/5/5/9;
    }
    body .container .box3{
        grid-area: 3/1/5/5;
    }

    body .container #box .view{
        height: 80px;
        justify-content: end;
        display: flex;
        align-items: end;
        padding:10px ;

    }
    body .container #box .content{
        padding-top: 5px;
    }


    
</style>
<body>
<div class="container">
    <div class="box1" id="box">
        <div class="content">
        <p><strong>Algorithm</strong> - A specific, logical set of instructions used to perform a task or solve a particular problem,
         often implemented in programming to automate solutions.</p>
    </div>
   <div class="view"> <button class="btn btn-primary">View More</button></div>
</div>
    <div id="box" class="box2">
    <div class="content">
        <p><strong>Array</strong> A structured collection of elements of the same data type stored at contiguous memory locations,
         allowing easy access by indexing.</p>
    </div>
   <div class="view"> <button class="btn btn-primary">View More</button></div>
    </div>
    <div id="box" class="box3">
    <div class="content">
        <p><strong>Bandwidth</strong>- The maximum amount of data that can be transmitted over a network connection within a specific time,
         often measured in megabits per second (Mbps).
</p>
    </div>
   <div class="view"> <button class="btn btn-primary">View More</button></div>
    </div>
    <div id="box" class="box4">
    <div class="content">
        <p><strong>Database</strong>- A systematically organized collection of data stored electronically,
         designed to allow efficient retrieval, management, and updating.


</p>
    </div>
   <div class="view"> <button class="btn btn-primary">View More</button></div>
    </div>
</div>  
</body>
</html>