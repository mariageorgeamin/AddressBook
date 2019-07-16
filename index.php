<?php
require_once "autoload.php";
include 'Views/header.php';
$db = new MYSQLHandler("contacts");
$current_index = isset($_GET["next"]) && is_numeric($_GET["next"]) ? (int) $_GET["next"] : 0;
// $contacts = $db->get_data(array(), $current_index);
$contact = new Contacts();
$contacts = $contact->get_all_contacts(array(), $current_index);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$res_data = $contact->count_data($page)[0];
$total_pages = $contact->count_data($page)[1];

if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['json'])) {
    $contact->export_json();
}
?>

<head>
    <script type="text/javascript">
    <!--
    function Warn() {
        alert("You will find results.json in your project folder");
    }
    //-->
    </script>
</head>

<div class="row">
    <?php if ($ERROR_MSG != "") {?>
    <div class="alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <p><?php echo $ERROR_MSG;
    ?></p>
    </div>
    <?php }
?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Address Book</h3>
        </div>
        <div class="panel-body">

            <div class="col-lg-12" style="padding-left: 0; padding-right: 0;">
                <form action="index.php" method="get">
                    <div class="col-lg-6 pull-left" style="padding-left: 0;">

                    </div>
                </form>
                <div class="pull-right"><a href="./Views/new.php?m="><button class="btn btn-success"><span
                                class="glyphicon glyphicon-user"></span> Add New Contact</button></a></div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered ">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Phone</th>
                        <th>Action </th>

                    </tr>
                    <?php foreach ($res_data as $res) {?>
                    <tr>
                        <td><?php echo $res["id"]; ?></td>
                        <td><?php echo $res["first_name"]; ?>&nbsp<?php echo $res["last_name"]; ?></td>
                        <td><?php echo $res["phone"]; ?></td>

                        <td>
                            <a href="Views/single.php?cid=<?php echo $res["id"]; ?>"><button
                                    class="btn btn-sm btn-info"><span class="glyphicon glyphicon-zoom-in"></span>
                                    View</button></a>&nbsp;
                            <a href="Views/edit.php?m=update&cid=<?php echo $res["id"]; ?>"><button
                                    class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-edit"></span>
                                    Edit</button></a>&nbsp;
                            <a href="Views/delete.php?cid=<?php echo $res["id"]; ?>"
                                onclick="return confirm('Are you sure?')"><button class="btn btn-sm btn-danger"><span
                                        class="glyphicon glyphicon-remove-circle"></span> Delete</button></a>&nbsp;
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div class="col-lg-12 center">

            <ul class="pagination">
                <li><a href="?page=1">First</a></li>
                <li class="<?php if ($page <= 1) {echo 'disabled';}?>">
                    <a href="<?php if ($page <= 1) {echo '#';} else {echo "?page=" . ($page - 1);}?>">Prev</a>
                </li>
                <li class="<?php if ($page >= $total_pages) {echo 'disabled';}?>">
                    <a
                        href="<?php if ($page >= $total_pages) {echo '#';} else {echo "?page=" . ($page + 1);}?>">Next</a>
                </li>
                <li><a href="?page=<?php echo $total_pages; ?>">Last</a></li>
            </ul>

            <form action="index.php" method="post">
                <input type="submit" class="btn btn-default" name="json" value="Export JSON" onclick="Warn();" />
            </form>
            <br>

        </div>
    </div>