<?php
require('../../util/main.php');
require('../../model/database.php');
require('../../model/order_db.php');
require('../../model/inventory_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'list_orders';
    }
}

if ($action == 'list_orders') {
    try {
        $baked_orders = get_baked_orders($db);
        $preparing_orders = get_preparing_orders($db);
        $undelievered_orders = get_supply_order($db);
        $inventories = get_current_inventory($db);
        /*  Test
        echo nl2br('preparing orders: '.count($preparing_orders)."\n");
        echo nl2br('baked orders: '.count($baked_orders)."\n");
        foreach ($inventories as $key => $value) {
            echo nl2br('key: '.$key."\n");
            echo nl2br('qty: '.$value['quantity']."\n");
            $t = $value['quantity'] - count($preparing_orders);
            echo nl2br('T: '.$t."\n");
        }
        */
    include('order_list.php');
    } catch (Exception $e) {
        include ('../../errors/error.php');
        exit();
    }
} else if ($action == 'change_to_baked') {
    try {
        $next_id = get_oldest_preparing_id($db);
        change_to_baked($db, $next_id);
        header("Location: .");
    } catch (Exception $e) {
        include ('../../errors/error.php');
        exit();
    }
}
?>