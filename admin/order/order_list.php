<?php include '../../view/header.php'; ?>
<main>
    <section>
    <h1>Current Orders Report</h1>
        <h2>Orders Baked but not delivered</h2>
        <?php if (count($baked_orders) > 0): ?>
            <?php foreach ($baked_orders as $baked_order) : ?>
                <?php echo " ID:" . $baked_order['id']; ?>
                <?php echo "Room number:" . $baked_order['room_number']; ?><br>  
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Baked orders</p>
        <?php endif; ?>

        <h2>Orders Preparing(in the oven): Any ready now?</h2>
        <?php if (count($preparing_orders) > 0): ?>
            <?php foreach ($preparing_orders as $preparing_order) : ?>
                <?php echo "ID:" . $preparing_order['id']; ?> 
                <?php echo "Room number:" . $preparing_order['room_number']; ?> <br> 
             <?php endforeach; ?>
        <?php else: ?>
            <p>No orders are being prepared in Oven</p>
        <?php endif; ?>
        
        <h2>Inventory Information:</h2>
        <?php foreach ($inventories as $key => $value) : ?>
            <?php echo "ID:" . $value['product_id']; ?> 
            <?php echo "Product:" . $value['product']; ?>
            <?php echo "Quantity:" . $value['quantity']; ?> <br> 
        <?php endforeach; ?>
        
            
        <h2>Undelivered supply orders:</h2>
        <?php if (count($undelievered_orders) > 0): ?>
            <?php foreach ($undelievered_orders as $undelievered_order) : ?>
                <?php echo "Order " . $undelievered_order['orderid'] . ":"; ?> 
                <?php echo " Flour " . $undelievered_order['flour_qty']; ?>
                <?php echo " Cheese " . $undelievered_order['cheese_qty']; ?> <br> 
             <?php endforeach; ?>
        <?php else: ?>
            <p>No Orders Today</p>
        <?php endif; ?>
            
          
        <br>
        
        <form  action="index.php" method="post" >
            <input type="hidden" name="action" value="change_to_baked">
            <input type="submit" value="Mark Oldest Pizza Baked" />
            <br>
        </form>
        <br>  

    </section>
</main>
<?php include '../../view/footer.php'; 
