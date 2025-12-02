 <section id="payments" class="section visible">
        <h1>Payments</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Booking ID</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="paymentsTable">

                <?php foreach($content as $data):?>
                    <tr>
                        <td class="table-data"><?= $data["payment_id"]?></td>
                        <td class="table-data"><?= $data["booking_id"]?></td>
                        <td class="table-data"><?= $data["amount"]?></td>
                        <td class="table-data"><?= $data["payment_method"]?></td>
                        <td class="table-data"><?= $data["payment_status"]?></td>
                        <td class="table-data"><?= $data["payment_date"]?></td>
                    </tr>

                <?php endforeach;?>
            </tbody>
        </table>
    </section>