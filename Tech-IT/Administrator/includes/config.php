<?php 

$conn=mysqli_connect('localhost','root','','techit');
if(! $conn){
    print 'connect to the database first';
}else{
    session_start();
}

?>