<?php
if(isset($_SESSION['unauthenticated_error']) && 
$_SESSION['unauthenticated_error']=='suspicious_access'){

    print"<div style='
    padding: 15px; 
    border: solid 2px #f44336; 
    border-radius: 8px; 
    background-color: #f8d7da; 
    color: #721c24;
    font-family: Arial, sans-serif;
    width: 100%;
    text-align: center;
    opacity: 0.95;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
'>
    <strong>Access Denied:</strong> You need to be logged in to view this page. Please log in to continue.
</div>";
    unset($_SESSION['unauthenticated_error']);

}

if(isset($_SESSION['login_error'])){
    print"<div style='
    padding: 15px; 
    border: solid 2px #f44336; 
    border-radius: 8px; 
    background-color: #f8d7da; 
    color: #721c24;
    font-family: Arial, sans-serif;
    width: 100%;
    text-align: center;
    opacity: 0.95;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
'>
    <strong>Access Denied:</strong> Please check your username or password.
</div>";
    unset($_SESSION['login_error']);
}

?>