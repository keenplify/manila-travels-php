<!-- Show these admin pages only when the admin is logged in -->
<?php  require '../assets/partials/_admin-check.php';   ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers</title>
        <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/d8cfbe84b9.js" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- CSS -->
    <?php 
        require '../assets/styles/admin.php';
        require '../assets/styles/admin-options.php';
        $page="customer";
        ?>
        
    <!-- KEENPLIFY SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/long-press-event@2.4.6/dist/long-press-event.min.js" type="module"></script>
    <script src="/node_modules/pure-context-menu/pure-context-menu.min.js" type="module"></script>
</head>
<body>
    <!-- Requiring the admin header files -->
    <?php require '../assets/partials/_admin-header.php';?>

    <!-- Add, Edit and Delete Customers -->
    <?php
        /*
            1. Check if an admin is logged in
            2. Check if the request method is POST
        */
        if($loggedIn && $_SERVER["REQUEST_METHOD"] == "POST")
        {
            if(isset($_POST["submit"]))
            {
                /*
                    ADDING Customers
                 Check if the $_POST key 'submit' exists
                */
                // Should be validated client-side
                $cname = $_POST["cfirstname"] . " " . $_POST["clastname"];
                $cphone = $_POST["cphone"];
        
                $customer_exists = exist_customers($conn,$cname,$cphone);
                $customer_added = false;
        
                if(!$customer_exists)
                {
                    // Route is unique, proceed
                    $sql = "INSERT INTO `customers` (`customer_name`, `customer_phone`, `customer_created`) VALUES ('$cname', '$cphone', current_timestamp());";
                    $result = mysqli_query($conn, $sql);
                    // Gives back the Auto Increment id
                    $autoInc_id = mysqli_insert_id($conn);
                    // If the id exists then, 
                    if($autoInc_id)
                    {
                        $code = rand(1,99999);
                        // Generates the unique userid
                        $customer_id = "CUST-".$code.$autoInc_id;
                        
                        $query = "UPDATE `customers` SET `customer_id` = '$customer_id' WHERE `customers`.`id` = $autoInc_id;";
                        $queryResult = mysqli_query($conn, $query);

                        if(!$queryResult)
                            echo "Not Working";
                    }

                    if($result)
                        $customer_added = true;
                }
    
                if($customer_added)
                {
                    // Show success alert
                    echo '<div class="my-0 alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Successful!</strong> Customer Added
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
                else{
                    // Show error alert
                    echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Customer already exists
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
            }
            if(isset($_POST["edit"]))
            {
                // EDIT ROUTES
                $cname = $_POST["cname"];
                $cphone = $_POST["cphone"];
                $customer_id = $_POST["customer_id"];
                $id_if_customer_exists = exist_customers($conn,$cname,$cphone);

                if(!$id_if_customer_exists || $id == $id_if_customer_exists)
                {
                    $updateSql = "UPDATE `customers` SET
                    `customer_name` = '$cname',
                    `customer_phone` = '$cphone' WHERE `customers`.`customer_id` = '$customer_id'";

                    $updateResult = mysqli_query($conn, $updateSql);
                    $rowsAffected = mysqli_affected_rows($conn);
    
                    $messageStatus = "danger";
                    $messageInfo = "";
                    $messageHeading = "Error!";
    
                    if(!$rowsAffected)
                    {
                        $messageInfo = "No Edits Administered!";
                    }
    
                    elseif($updateResult)
                    {
                        // Show success alert
                        $messageStatus = "success";
                        $messageHeading = "Successfull!";
                        $messageInfo = "Customer details Edited";
                    }
                    else{
                        // Show error alert
                        $messageInfo = "Your request could not be processed due to technical Issues from our part. We regret the inconvenience caused";
                    }
    
                    // MESSAGE
                    echo '<div class="my-0 alert alert-'.$messageStatus.' alert-dismissible fade show" role="alert">
                    <strong>'.$messageHeading.'</strong> '.$messageInfo.'
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }
                else{
                    // If customer details already exists
                    echo '<div class="my-0 alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Customer already exists
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                }

            }
            if(isset($_POST["delete"]))
            {
                // DELETE ROUTES
                $id = $_POST["id"];
                // Delete the route with id => id
                $deleteSql = "DELETE FROM `customers` WHERE `customers`.`id` = $id";
                $deleteResult = mysqli_query($conn, $deleteSql);
                $rowsAffected = mysqli_affected_rows($conn);
                $messageStatus = "danger";
                $messageInfo = "";
                $messageHeading = "Error!";

                if(!$rowsAffected)
                {
                    $messageInfo = "Record Doesnt Exist";
                }

                elseif($deleteResult)
                {   
                    $messageStatus = "success";
                    $messageInfo = "Customer Details deleted";
                    $messageHeading = "Successfull!";
                }
                else{

                    $messageInfo = "Your request could not be processed due to technical Issues from our part. We regret the inconvenience caused";
                }

                // Message
                echo '<div class="my-0 alert alert-'.$messageStatus.' alert-dismissible fade show" role="alert">
                <strong>'.$messageHeading.'</strong> '.$messageInfo.'
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        }
        ?>
        <?php
            // $resultSql = "SELECT * FROM `customers` LEFT JOIN `bookings` On bookings.customer_id = customers.customer_id ORDER BY customer_created DESC";
            $resultSql = "SELECT COALESCE(bookings.customer_id, customers.customer_id) AS realCustomerId, customers.id AS realId, customers.*, bookings.*, routes.*
            FROM `customers`
            LEFT JOIN `bookings` ON bookings.customer_id = customers.customer_id
            LEFT JOIN `routes` ON bookings.route_id = routes.route_id
            ORDER BY customers.customer_created DESC";
                            
            $resultSqlResult = mysqli_query($conn, $resultSql);

            if(!mysqli_num_rows($resultSqlResult)){ ?>
                <!-- Customers are not present -->
                <div class="container mt-4">
                    <div id="noCustomers" class="alert alert-dark " role="alert">
                        <h1 class="alert-heading">No Customers Found!!</h1>
                        <p class="fw-light">Be the first person to add one!</p>
                        <hr>
                        <div id="addCustomerAlert" class="alert alert-success" role="alert">
                                Click on <button id="add-button" class="button btn-sm"type="button"data-bs-toggle="modal" data-bs-target="#addModal">ADD <i class="fas fa-plus"></i></button> to add a customer!
                        </div>
                    </div>
                </div>
            <?php }
            else { ?>   
            <!-- If Customers are present -->
            <section id="customer">
                <div id="head">
                    <h4>Customer Status</h4>
                </div>
                <div id="customer-results">
                    <div>
                        <button id="add-button" class="button btn-sm"type="button"data-bs-toggle="modal" data-bs-target="#addModal">Add Customer Details <i class="fas fa-plus"></i></button>
                    </div>
                    <script type="module" defer>
                        import PureContextMenu from '/node_modules/pure-context-menu/pure-context-menu.min.js';

                        const html = document.querySelector('html')

                        const rows = document.querySelectorAll('tr.ctx-menu')

                        for (const row of rows) {
                            const customerJSON = row.getAttribute('data-customer')
                            const customer = JSON.parse(customerJSON)
                            row.addEventListener('contextmenu', event => {
                                console.log(customer)

                                event.preventDefault()

                                const items = [
                                {
                                    label: "Edit",
                                    callback: () => {
                                        console.log(`#${customer.realCustomerId}-edit-btn`)
                                        document.querySelector(`#${customer.realCustomerId}-edit-btn`)?.click()
                                    }
                                },
                                {
                                    label: "Delete",
                                    callback: () => {
                                        console.log(`#${customer.realCustomerId}-delete-btn`)
                                        document.querySelector(`#${customer.realCustomerId}-delete-btn`)?.click()
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
                            <th>ID</th>
                            <th>PNR</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Bus</th>
                            <th>Route</th>
                            <th>Seat</th>
                            <th>Amount</th>
                            <th>Departure</th>
                            <th>Booked</th>
                        </thead>
                        <?php
                            while($row = mysqli_fetch_assoc($resultSqlResult))
                            {
                                    // echo "<pre>";
                                    // var_export($row);
                                    // echo "</pre>";
                                $id = $row["realId"];
                                $customer_id = $row["realCustomerId"];
                                $customer_name = $row["customer_name"];
                                $customer_phone = $row["customer_phone"]; 
                                $route_id = $row["route_id"];
                                $pnr = $row["booking_id"];
                                $bus_no = $row["bus_no"];

                                // $customer_name = get_from_table($conn, "customers","customer_id", $customer_id, "customer_name");
                                
                                // $customer_phone = get_from_table($conn,"customers","customer_id", $customer_id, "customer_phone");

                                // $bus_no = get_from_table($conn, "routes", "route_id", $route_id, "bus_no");

                                $route = $row["customer_route"];

                                $booked_seat = $row["booked_seat"];
                                
                                $booked_amount = $row["booked_amount"];

                                $dep_date = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_date");

                                $dep_time = get_from_table($conn, "routes", "route_id", $route_id, "route_dep_time");

                                $booked_timing = $row["booking_created"];
            
                                
                        ?>
                        <tr class="ctx-menu" data-customer='<?= json_encode($row) ?>'>
                            <td>
                                <?php
                                    echo $customer_id;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $pnr;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $customer_name;
                                ?>
                            </td>
                            <td>
                                <?php
                                    echo $customer_phone;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $bus_no;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $route;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $booked_seat;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo '₱'.$booked_amount;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $dep_date . " , ". $dep_time;
                                ?>
                            </td>
                            <td>
                                <?php 
                                    echo $booked_timing;
                                ?>
                            </td>
                            <td style="display: none">
                            <button class="button edit-button " 
                                data-link="<?php echo $_SERVER['REQUEST_URI']; ?>"
                                data-customer_id="<?php echo $customer_id;?>"
                                data-name="<?php echo $customer_name;?>"
                                data-phone="<?php echo $customer_phone;?>"
                                id="<?=$customer_id ?>-edit-btn"
                            >Edit</button>
                            <button 
                                class="button delete-button"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="<?php echo $id;?>"
                                id="<?=$customer_id ?>-delete-btn"
                            >Delete</button>
                            </td>
                        </tr>
                    <?php 
                        }
                    ?>
                    </table>
                </div>
            </section>
            <?php } ?>   
        </div>
    </main>
    <!-- All Modals Here -->
    <!-- Add Route Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add A Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addCustomerForm" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                            <div class="mb-3">
                                <label for="cfirstname" class="form-label">Customer Firstname</label>
                                <input type="text" class="form-control" id="cfirstname" name="cfirstname">
                            </div>
                            <div class="mb-3">
                                <label for="clastname" class="form-label">Customer Lastname</label>
                                <input type="text" class="form-control" id="clastname" name="clastname">
                            </div>
                            <div class="mb-3">
                                <label for="cphone" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" id="cphone" name="cphone">
                            </div>
                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!-- Add Anything -->
                    </div>
                    </div>
                </div>
        </div>
        <!-- Delete Modal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="z-index: 999;">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-exclamation-circle"></i></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h2 class="text-center pb-4">
                    Are you sure?
                </h2>
                <p>
                    Do you really want to delete these customer details? <strong>This process cannot be undone.</strong>
                </p>
                <!-- Needed to pass id -->
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="delete-form"  method="POST">
                    <input id="delete-id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="delete-form" name="delete" class="btn btn-danger">Delete</button>
            </div>
            </div>
        </div>
    </div>
    <!-- External JS -->
    <script src="../assets/scripts/admin_customer.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</body>
</html>