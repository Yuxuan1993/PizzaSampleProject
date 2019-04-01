<?php
require('../../util/main.php');
require('../../model/database.php');
require('../../model/day_db.php');
require('../../model/initial.php');
require('../../model/inventory_db.php');

// Note that you don't have to put all your code in this file.
// You can use another file day_helpers.php to hold helper functions
// and call them from here.

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list';
    }
}
 $current_day = get_current_day($db);
if ($action == 'list') {
    try {
        $todays_orders = get_todays_orders($db, $current_day);
        $undelievered_orders = get_supply_order($db);
        $inventories = get_current_inventory($db);
        foreach ($inventories as $key => $value) {
            if ($value['quantity'] < 150) {
                echo nl2br($value['product'].': '.$value['quantity']."\n");
            }
            else {
                continue;
            }
            
        }
        
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
    include('day_list.php');
} else if ($action == 'next_day') {
    try {
        finish_orders_for_day($db, $current_day);
        increment_day($db);
        
        $inventories = get_current_inventory($db);
        $flour_qty = 0;
        $cheese_qty = 0;
        foreach ($inventories as $key => $value) {
            if ($value['quantity'] < 150 && $value['product'] === 'flour') { // 150 = 3 days inventory qty
                $flour_qty = 150 - $value['quantity']; 
                if ($flour_qty % $value['unit_qty'] > 0) {
                    $temp = floor($flour_qty / $value['unit_qty']); 
                    $flour_qty = ($temp + 1) * $value['unit_qty']; 
                }
            } else if ($value['quantity'] < 150 && $value['product'] === 'cheese') {
                $cheese_qty = 150 - $value['quantity'];
                if ($cheese_qty % $value['unit_qty'] > 0) {
                    $temp = floor($cheese_qty / $value['unit_qty']);
                    $cheese_qty = ($temp + 1) * $value['unit_qty'];
                }
            } else {
                continue;
            }
            
        }
        if ($flour_qty > 0 && $cheese_qty > 0) {
            add_supply_order($db, $flour_qty, $cheese_qty);
        }
        header("Location: .");
    } catch (Exception $e) {
        include('../errors/error.php');
        exit();
    }
} else if ($action == 'initial_db') {
    try {
        initial_db($db);
        header("Location: .");
    } catch (Exception $e) {
        include ('../errors/error.php');
        exit();
    } 
}
?>