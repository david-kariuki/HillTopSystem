<?php
require_once "app/php/Modal.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['LOGGED_USER'])){
    header("location:http://" . ROOT ." ");
}
$user;
$table = "tbl_users";
$fields = array(
    "*",
);
$order_by = "firstName";
$order_set = "ASC";
$offset = 0;
$reference = array(
    "statement" => "Email = ?",
    "type"=>"s",
    "values"=>[
        $_SESSION['LOGGED_USER']
    ]
);

$response = $admin->database_read_by_ref($table,$fields,$order_by,$order_set,$offset,$reference);

if($response['status']){
    $user = $response['response'][0];
}else{
    echo "Error";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- config -->
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <title>Document</title>
    <!-- end config -->

    <!-- libs -->

    <!-- bootstrap -->
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <!-- end libs -->

    <!-- site libs -->
    <script data-main="libs/main" src="libs/require.js"></script>

    <link rel="stylesheet" href="libs/css/main.css">
    <!-- end site libs -->
    <!-- google charts Libs -->

    <script src="https://www.gstatic.com/charts/loader.js"></script>
    

    <!-- end google charts Libs -->
</head>

<body>
    <div class="navigation_panel">
        <div class="logo">
            <img src="logo.png" alt="">
        </div>
        <div class="timer">
            <div class="clocker">
                <ul>
                    <li class="time" id="hour">01</li>
                    <li class="time">:</li>
                    <li class="time" id="min">20</li>
                    <li class="time" id=period>am</li>
                    <li class="time"> </li>
                    <li class="time"> </li>
                    <li class="dates" id="day">20</li>
                    <li class="dates">/</li>
                    <li class="dates" id="month">30</li>
                    <li class="dates">/</li>
                    <li class="dates" id="Year">2020</li>
                </ul>
            </div>
        </div>
        <div class="search_bar">
            <div class="search_input">
                <input type="text">
            </div>
            <div class="search_display">

            </div>
        </div>
        <div class="nav_bar_navigation">
            <div class="icons_elem">
                <div class="icon_holder" onclick="render_dropdown_select('settings')">
                    <img src="res/images/icons/settings_dark.png" alt="">
                </div>
                <div class="icon_holder" onclick="render_dropdown_select('notification')">
                    <p>10</p>
                    <img src="res/images/icons/navNotification.png" alt="">
                </div>
                <div class="icon_holder" onclick="render_dropdown_select('userAccount')">
                    <img src="res/images/icons/user_dark.png" alt="">
                </div>
            </div>
            <div class="icons_select_dropdown">
                <div class="holder_elemental">
                    <div class="items_panel">
                        <div class="user_image">
                            <img src="res/images/icons/user_dark.png" alt="">
                        </div>
                        <div class="details_panel">
                            <div class="val_elem">
                                <p>User Name :</p>
                                <p><?php echo $admin->userName ?></p>
                            </div>
                            <div class="val_elem">
                                <p>Email :</p>
                                <p><?php echo $admin->Email ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="buttons_panel">
                        <ul>
                            <li> <button onclick="logUserOut()"> Log Out</button></li>
                            <li> <button onclick ="renderMainContentView('Account')"> Account</button></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="body_panel">
        <div class="side_panel">
            <div class="management_section">
                <p>Home</p>
                <div class="navigation_tab" onclick="renderMainContentView('Dashboard')">
                    <img src="res/images/icons/dashboard.png" alt="">
                    <p>Dashboard</p>
                </div>
            </div>
            <div class="management_section">
                <p>Store</p>
                <div class="navigation_tab" onclick="renderMainContentView('PointOfSale')">
                    <img src="res/images/icons/pos.png" alt="">
                    <p>P.O.S</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Orders')">
                    <img src="res/images/icons/transaction.png" alt="">
                    <p>Orders</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Catalogue')">
                    <img src="res/images/icons/catalogue.png" alt="">
                    <p>Catalogue</p>
                </div>
                <!-- <div class="navigation_tab" onclick="renderMainContentView('Customers')">
                    <img src="res/images/icons/customers.png" alt="">
                    <p>Customers</p>
                </div> -->
                <div class="navigation_tab" onclick="renderMainContentView('Sales')">
                    <img src="res/images/icons/sales_icon.png" alt="">
                    <p>Sales</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Transactions')">
                    <img src="res/images/icons/transaction.png" alt="">
                    <p>Transactions</p>
                </div>
            </div>
            <div class="management_section">
                <p>Management</p>
                <div class="navigation_tab" onclick="renderMainContentView('Vendors')">
                    <img src="res/images/icons/vendor.png" alt="">
                    <p>Vendors</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Notifications')"> 
                    <img src="res/images/icons/notifications.png" alt="">
                    <p>Notifications</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Reports',null,report_page_loader)">
                
                    <img src="res/images/icons/report.png" alt="">
                    <p>Reports</p>
                </div>
                <div class="navigation_tab" onclick="renderMainContentView('Settings')">
                    <img src="res/images/icons/settings.png" alt="">
                    <p>Settings</p>
                </div>
            </div>
            <div class="management_section">
                <p>Admin</p>
                <div class="navigation_tab" onclick="renderMainContentView('Account')">
                    <img src="res/images/icons/user.png" alt="">
                    <p>Account</p>
                </div>
                <?php
                $account_type = $admin->role;

                if($admin->role == "Moderator" || $admin->role == "Admin" || $admin->role == "superUser"){
                    ?>
                    <div class="navigation_tab" onclick="renderMainContentView('Moderators')">
                        <img src="res/images/icons/manager.png" alt="">
                        <p>Moderators</p>
                    </div>
                    <?php
                }
                ?>
                
            </div>
        </div>
        <div class="contentArea_panel">
        
        </div>
        <div class="right_side_panel">
            <div class="btn_close"><p onclick="close_right_panel()">X</p></div>
            <div class="transaction_sales">
                <h5>Transactions</h5>
                <ul>
                </ul>
            </div>
        </div>
    </div>
    <div class="system_elemental">
        <button onclick="close_system_elemental()">X</button>
        <div class="elemental_container">
            <div class="transaction_element">
                <h5>Transactions</h5>
                <div class="transaction_body">
                    <div class="input_group">
                        <p>Total Amount</p>
                        <input type="text" name="totalAmount" disabled>
                    </div>
                    <div class="input_group">
                        <p>Amount to Pay</p>
                        <input type="text" name="amountToPay" disabled>
                    </div>
                    <div class="input_group">
                        <p>Payment Method </p>
                        <select name="paymentMethod" id="">
                            <option value="M-Pesa">M-Pesa</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>
                    <div class="input_group">
                        <p>Amount Payed</p>
                        <input type="text" name="amountPayed" onkeyup="updatePayment()" autocomplete="off">
                    </div>
                    <div class="input_group">
                        <p>Balance</p>
                        <input type="text" name="balance">
                    </div>
                    
                </div>
                <button onclick="confirm_payment()">Confirm</button>
            </div>
        </div>
        
    </div>
</body>
</html>
