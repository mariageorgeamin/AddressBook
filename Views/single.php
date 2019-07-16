<?php
require_once "../autoload.php";
include 'header.php';
$contact = new Contacts();
$data = $contact->get_contact_information($_GET['cid']);
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
</head>

<div class="container">
    <br>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item active"> Contact Details</li>
        </ol>
    </nav>

    <body class="bg-light container">
        <div class="card">
            <h5 class="card-header">Contact Details</h5>
            <div class="card-body">
                <h5 class="card-title">First Name:
                    <?php echo $data[0]["first_name"]; ?>
                    <h5 class="card-title">Last Name:
                        <?php echo $data[0]['last_name']; ?></h5>
                    <h5 class="card-title">Phone:
                        <?php echo $data[0]["phone"]; ?></h5>
                    <h5 class="card-title">Email: <a
                            href="mailto:<?php echo $data[0]["email"]; ?>"><?php echo $data[0]["email"]; ?></a></h5>
                    <h5 class="card-title">Postcode:
                        <?php echo $data[0]["postcode"]; ?></h5>
                    <h5 class="card-title">Notes:
                        <?php echo $data[0]["notes"]; ?></h5>
                    <h5 class="card-title">Address 1:
                        <?php echo $data[0]["address1"]; ?></h5>
                    <h5 class="card-title">Address 2:
                        <?php echo $data[0]["address2"]; ?></h5>
            </div>
        </div>

    </body>

</html>