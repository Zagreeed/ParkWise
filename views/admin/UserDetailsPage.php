 <section id="users" class="section visible">
        <h1>Users</h1>
        <table class="data-table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody id="usersTable">
                  <?php foreach($content as $data):?>
                    <tr>
                        <td class="table-data"><?= $data["user_id"]?></td>
                        <td class="table-data"><?= $data["username"]?></td>
                        <td class="table-data"><?= $data["email"]?></td>
                        <td class="table-data"><?= $data["phonenumber"]?></td>
                        <td class="table-data"><?= $data["address"]?></td>
                    </tr>

                <?php endforeach;?>
            </tbody>
        </table>
    </section>