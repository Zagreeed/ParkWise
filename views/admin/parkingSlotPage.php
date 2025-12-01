 <section id="slots" class="section visible">
        <h1>Parking Slots</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Slot ID</th>
                    <th>Slot Number</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id="slotsTable">
                <?php foreach($content as $slot): ?>
                    <tr>
                        <td><?= $slot['slot_id'] ?></td>
                        <td><?= $slot['slot_number'] ?></td>
                        <td><?= $slot['location'] ?></td>
                        <td><?= $slot['status'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
 </section>