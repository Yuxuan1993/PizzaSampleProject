<?php include '../../view/header.php'; ?>
<main>
    <section>
        <h1>Today is day <?php echo $current_day; ?></h1>
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="next_day">
            <input type="submit" value="Advance to day <?php echo $current_day + 1; ?>" />
        </form>

        <form  action="index.php" method="post">
            <input type="hidden" name="action" value="initial_db">           
            <input type="submit" value="Initialize DB (making day = 1)" />
            <br>
        </form>
        <br>
        <h2>Today's Orders</h2>
        <?php if (count($todays_orders) > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Room No</th>
                    <th>Status</th>
                </tr>

                <?php foreach ($todays_orders as $todays_order) : ?>
                    <tr>
                        <td><?php echo $todays_order['id']; ?> </td>
                        <td><?php echo $todays_order['room_number']; ?> </td>  
                        <td><?php echo $todays_order['status']; ?> <td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No Orders Today </p>
        <?php endif; ?>
        <br>
        
        <h2>Inventory Information:</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Product</th>
                <th>Quantity</th>
            </tr>

            <?php foreach ($inventories as $key => $value) : ?>

                <tr>
                    <td><?php echo $value['product_id']; ?> </td>
                    <td><?php echo $value['product']; ?> </td>  
                    <td><?php echo $value['quantity']; ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
        
        <h2>Undelivered supply orders:</h2>
        <?php if (count($undelievered_orders) > 0): ?>
        <table>
            <tr>
                <th>ID</th>
                <th>Flour qty</th>
                <th>Cheese qty</th>
            </tr>

            <?php foreach ($undelievered_orders as $key => $value) : ?>

                <tr>
                    <td><?php echo $value['orderid']; ?> </td>
                    <td><?php echo $value['flour_qty']; ?> </td>  
                    <td><?php echo $value['cheese_qty']; ?> </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>No Orders Today</p>
        <?php endif; ?>

        
    </section>

</main>
<?php include '../../view/footer.php'; ?>

