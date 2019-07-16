<?php
require_once "../autoload.php";
$contact = new Contacts();
$data = $contact->get_contact_information($_GET['cid']);

if (isset($_POST["update"])) {

    if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
        $contact_info = array(
            'first_name' => trim($_POST['first_name']),
            'last_name' => trim($_POST['last_name']),
        );
        if ($contact->update_contact_information($contact_info, $_GET["cid"])) {
            header("Location: http://localhost/AddressBook/index.php");
            $_SESSION["errorType"] = "success";
            $_SESSION["errorMsg"] = "Contact updated successfully.";
        } else {
            $_SESSION["errorType"] = "danger";
            $_SESSION["errorMsg"] = "Failed to update contact.";
        }
    }

}
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
            <li class="breadcrumb-item active">Edit Contact</li>
        </ol>
    </nav>

    <body class="bg-light container">
        <br>
        <div class="col-md-12">
            <h4 class="mb-3">Update Contact</h4>
            <form class="needs-validation" novalidate="" action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="first_name">*First Name</label>
                    <input type="text" class="form-control" name="first_name" id="first_name" max="100"
                        value="<?php echo $data[0]["first_name"]; ?>" pattern="^[A-Za-z]{1,50}$" required>
                    <div class="invalid-feedback">
                        Valid First Name is required, Only letters.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="last_name">*Last Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name"
                            max="25" value="<?php echo $data[0]["last_name"]; ?>" pattern="^[A-Za-z]{1,50}$" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Your Last Name is required, Only letters.
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="phone">*Phone</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone" max="50"
                            value="<?php echo $data[0]["phone"]; ?>" pattern="^[0-9]{7,11}$" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Your Phone is required. You can only use Min 10 digits.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email">*Email</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email" max="50"
                            value="<?php echo $data[0]["email"]; ?>"
                            pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Your Valid Email is required.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address1">*Address 1</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1"
                            max="100" value="<?php echo $data[0]["address1"]; ?>"
                            pattern="^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Your Address is required.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address1">Address 2</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2"
                            max="100" value="<?php echo $data[0]["address2"]; ?>"
                            pattern="^[A-Za-z0-9 _]*[A-Za-z0-9][A-Za-z0-9 _]*$">
                    </div>
                </div>

                <div class="mb-3">

                    <label for="country">*Country</label>
                    <div class="input-group">

                        <select required name="country" class="countries" id="countryId">
                            <option value="<?php echo $data[0]["country"]; ?>">*Select Country</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="state">*State</label>

                    <select name="state" class="states" id="stateId">
                        <option value="">Select State</option>
                    </select>

                    <label for="city">*City</label>
                    <select name="city" class="cities" id="cityId">
                        <option value="<?php echo $data[0]["city"]; ?>">Select City</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="postcode">*Postcode</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode"
                            max="100" value="<?php echo $data[0]["postcode"]; ?>" pattern="^[0-9]{3,7}$" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Your Postcode is required. You can only use digits.
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes">Notes</label>
                    <div class="input-group">
                        <textarea type="textarea" class="form-control" id="notes" name="notes" placeholder="Notes"
                            rows="5"><?php echo $data[0]["notes"]; ?></textarea>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-dark btn-lg btn-block" name="update" type="submit">Update</button>

            </form>
        </div>
</div>

<!-- Optional JavaScript -->
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
    'use strict'
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation')

        // Loop over them and prevent submission
        Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    }, false)
}())
</script>

</body>

</html>