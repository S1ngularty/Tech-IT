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

if(isset($_SESSION['invalid_acct_stat'])){
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
    <strong>Access Denied:</strong> Please inform the Administrator to activate your account first.
</div>";
    session_destroy();
}

if(isset($_SESSION['validating']) && 
$_SESSION['validating']=='yes'){

    print"<div style='
   padding: 15px; 
    border: solid 2px #ffc107; /* Solid Bootstrap warning color for the border */
    border-radius: 8px; 
    background-color: rgba(255, 193, 7, 0.2); /* Background with the warning color and opacity */
    color: #856404; /* Dark text color for contrast */
    font-family: Arial, sans-serif;
    width: 100%;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
'>
    <strong>Creating Your Account Failed:</strong> Please put a valid details.
</div>";
    unset($_SESSION['validating']);

}

if(isset($_SESSION['item_error']) && 
$_SESSION['item_error']=='yes'){

    print"<div style='
   padding: 15px; 
    border: solid 2px #ffc107;
    border-radius: 8px; 
    background-color: rgba(255, 193, 7, 0.2); 
    color: #856404; 
    font-family: Arial, sans-serif;
    width: 100%;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
'>
    <strong>Creating Your Product Failed:</strong> Please check your product details.
</div>";
    unset($_SESSION['item_error']);

}

if(isset($_SESSION['user_error']) && 
$_SESSION['user_error']=='yes'){

    print"<div style='
   padding: 15px; 
    border: solid 2px #ffc107;
    border-radius: 8px; 
    background-color: rgba(255, 193, 7, 0.2); 
    color: #856404; 
    font-family: Arial, sans-serif;
    width: 100%;
    text-align: center;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
'>
    <strong>Updating Your Profile Failed:</strong> Please check your personal details.
</div>";
    unset($_SESSION['user_error']);

}

?>