<!-- Show these admin pages only when the admin is logged in -->
<?php  require '../assets/partials/_admin-check.php';   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Validation</title>
        <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- External CSS -->
    
    <?php 
        require '../assets/styles/admin.php';
        require '../assets/styles/admin-options.php';
        $page="passenger-validation";
    ?>

    <link href="../node_modules/lightbox2/dist/css/lightbox.min.css" rel="stylesheet" />
    <script src="../node_modules/lightbox2/dist/js/lightbox-plus-jquery.min.js"></script>

    <!-- KEENPLIFY SCRIPTS -->
    <script src="../node_modules/pure-context-menu/pure-context-menu.min.js" type="module"></script>
</head>
<body>
    <!-- Requiring the admin header files -->
    <?php require '../assets/partials/_admin-header.php';?>

            <?php
                $sql = "select * from passengers WHERE type != 'Regular'";
                $result = mysqli_query($conn, $sql);
                $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>

            <section class="container px-4">
                <script type="module" defer>
                    import PureContextMenu from '../node_modules/pure-context-menu/pure-context-menu.min.js';

                    const html = document.querySelector('html')

                    const rows = document.querySelectorAll('tr.ctx-menu')

                    for (const row of rows) {
                        const passengerJSON = row.getAttribute('data-passenger')
                        const passenger = JSON.parse(passengerJSON)

                        row.addEventListener('contextmenu', event => {
                            
                            event.preventDefault()

                            const items = [
                            {
                                label: "View ID",
                                callback: () => {
                                    document.querySelector(`#btn-${passenger.id}-view`)?.click()
                                }
                            },
                            {
                                label: passenger.is_verified == '1' ? 'Unverify' : 'Verify',
                                callback: () => {
                                    document.querySelector(`#btn-${passenger.id}-verify`)?.click()
                                }
                            }
                        ]
                        let bodyMenu = new PureContextMenu(html, items)
                        return false
                        })
                    }
                </script>
                <table class="table table-hover table-bordered">
                    <thead>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Type</th>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $row) {
                            $isVerified = $row['is_verified'] == 1
                            ?>
                                <tr class="ctx-menu" data-passenger='<?= json_encode($row) ?>'>
                                    <td><?= $row['name'] ?></td>
                                    <td><?= $row['phone'] ?></td>
                                    <td>
                                        <?php if ($isVerified) {
                                            echo '<span class="badge" style="background: green">Verified</span>';
                                        } else {
                                            echo '<span class="badge" style="background: gray">Unverified</span>';
                                            
                                        }?>
                                    </td>
                                    <td><?= $row['type'] ?></td>
                                    <td style="display: none">
                                        <?php 
                                            if (isset($row['valid_id_image_url'])) {
                                                ?>
                                                <a 
                                                    class="btn btn-primary btn-sm"
                                                    href="<?= $row['valid_id_image_url'] ?>"
                                                    data-lightbox="<?= $row['id'] ?>"
                                                    data-title="<?= $row['name'] ?> (<?= $row['type'] ?>)"
                                                    id="btn-<?= $row['id'] ?>-view"
                                                >View ID</a>
                                                <?php
                                            }
                                        ?>
                                        <a 
                                            class="btn btn-sm <?= $isVerified ? 'btn-danger' : 'btn-success' ?>" 
                                            href="../server/set-verified.php?id=<?= $row['id'] ?>&is_verified=<?= $isVerified ? 0 : 1 ?>"
                                            id="btn-<?= $row['id'] ?>-verify"
                                        >
                                            <?= $isVerified ? 'Unverify' : 'Verify'?>
                                        </a>
                                    </td>
                                </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>
</html>