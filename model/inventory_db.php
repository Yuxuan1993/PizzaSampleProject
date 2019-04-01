<?php

function get_current_inventory($db) {
    $query = 'SELECT * FROM inventory';
    $statement = $db->prepare($query);
    $statement->execute();
    $inventories = $statement->fetchAll();
    $statement->closeCursor();   
    return $inventories;
}

function deduct_inventory($db) {
    $query = 'UPDATE inventory SET quantity = quantity - 1 WHERE quantity > 0';
    $statement = $db->prepare($query);
    $statement->execute();    
    $statement->closeCursor();  
}

function get_supply_order($db) {
    $query = 'SELECT * FROM undeliveried_orders';
    $statement = $db->prepare($query);
    $statement->execute();
    $supply_order = $statement->fetchAll();
    $statement->closeCursor();   
    return $supply_order;
}

function add_supply_order($db, $flour_qty, $cheese_qty) {
    $query = 'INSERT INTO undeliveried_orders(flour_qty, cheese_qty) '
            . 'VALUES (:flour_qty, :cheese_qty)';
    $statement = $db->prepare($query);
    $statement->bindValue(':flour_qty',$flour_qty);
    $statement->bindValue(':cheese_qty',$cheese_qty);
    $statement->execute();
    $statement->closeCursor(); 
}

function delete_supply_order($db, $orderid) {
    $query = 'DELETE FROM undeliveried_orders WHERE orderid = :orderid';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':orderid', $orderid);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
