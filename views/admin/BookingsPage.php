  <section id="bookings" class="section visible">
        <h1>Bookings</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User</th>
                    <th>Vehicle</th>
                    <th>Slot</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="bookingsTable">
             
                 <?php foreach($content as $data):?>
                    <tr>
                        <td><?= $data["booking_id"]?></td>
                        <td><?= $data["username"]?></td>
                        <td><?= $data["vehicle"]?></td>
                        <td><?= $data["slot"]?></td>
                        <td><?= $data["start_time"]?></td>
                        <td><?= $data["end_time"]?></td>
                        <td class="status <?php  echo $data["status"]?>"><?= $data["status"]?></td>
                      
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </section>