<?php
session_start();
require('../util/main.php');
require('../model/database.php');
require('../model/order_db.php');
require('../model/topping_db.php');
require('../model/size_db.php');
require('../model/day_db.php');
require('../model/inventory_db.php');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'student_welcome';
    }
}
$room = filter_input(INPUT_POST, 'room', FILTER_VALIDATE_INT);
if ($room == NULL) {
    $room = filter_input(INPUT_GET, 'room');
    if ($room == NULL || $room == FALSE) {
        $room = 1;
    }
}
if ($action == 'student_welcome' || $action == 'select_room') {
    try {
        $sizes = get_sizes($db);
        $toppings = get_toppings($db);
        $room_preparing_orders = get_preparing_orders_of_room($db, $room);
        $room_baked_orders = get_baked_orders_of_room($db, $room);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include('student_welcome.php');
} else if ($action == 'order_pizza') {
    try {
        $sizes = get_sizes($db);
        $toppings = get_toppings($db);
        $preparing_orders = get_preparing_orders($db);
        
        
        echo nl2br('preparing orders: '.count($preparing_orders)."\n");
        $inventories = get_current_inventory($db);
        foreach ($inventories as $key => $value) {
            echo nl2br('key: '.$key."\n");
            echo nl2br('qty: '.$value['quantity']."\n");
        }
        
        
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include ('order_pizza.php');
} elseif ($action == 'add_order') { // the action when click on the "order pizza" button
    $size_id = filter_input(INPUT_GET, 'pizza_size', FILTER_VALIDATE_INT);
    $room = filter_input(INPUT_GET, 'room', FILTER_VALIDATE_INT);
    $n = filter_input(INPUT_GET, 'n', FILTER_VALIDATE_INT); // pizza qty
    if (empty($n)) {
        $n = 1; // no input: default to old single order case
    }
    $topping_ids = filter_input(INPUT_GET, 'pizza_topping', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);

    if ($size_id == NULL || $size_id == FALSE || $topping_ids == NULL) {
        // string $e will be displayed as is--see errors.php
        $e = "Invalid size or topping data size_id =$size_id, topping_ids = , $topping_ids";
        include('../errors/error.php');
        exit();
    }
    $inventories = get_current_inventory($db);
    $preparing_orders = get_preparing_orders($db);
    foreach ($inventories as $key => $value) {
        if ($n > ($value['quantity'] - count($preparing_orders))) { // fail an order if inventory not enough
            $e = "Not enough inventory.";
            include('../errors/error.php');
            exit();
        }
        else {
            continue;
        }
    }
    
    try {
        $current_day = get_current_day($db);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    $status = 'Preparing';

    try {
        for ($i = 0; $i < $n; $i++) {
            add_order($db, $room, $size_id, $current_day, $status, $topping_ids);
            deduct_inventory($db);
        }
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    header("Location: .?room=$room");
} elseif ($action == 'update_order_status') {
    try {
        update_to_finished($db, $room);
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    header("Location: .?room=$room");
}
?>