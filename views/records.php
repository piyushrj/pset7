<div>
    <table class="table table-striped">

        <thead>
            <tr>
                <th>Transaction</th>
                <th>Date/Time</th>
                <th>Symbol</th>
                <th>Shares</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody><?php foreach ($records as $record): ?>
        <tr>
            <td><?=($record["action"]) ?></td>
            <td><?=($record["datetime"]) ?></td>
            <td><?=($record["symbol"]) ?></td>
            <td><?=($record["shares"]) ?></td>
            <td><?= "\${$record["price"]}" ?></td>
            
        </tr>
            <?php endforeach ?>
        </tbody>
        </table>

</div>