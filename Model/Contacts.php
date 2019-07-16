<?php
class Contacts
{
    public function __construct()
    {}

    public function new_contact($contact_info)
    {
        $this->create_new_contact($contact_info);
        return true;

    }

    public function create_new_contact($contact_info) //key value array

    {

        $handler = new MYSQLHandler(__TABLE__);
        $handler->save($contact_info);
    }

    public function get_all_contacts($current_index)
    {
        $handler = new MYSQLHandler(__TABLE__);
        $data = $handler->get_data(array(), $current_index);
        return $data;
    }
    

    public function search_contact($name)
    {
        $handler = new MYSQLHandler(__TABLE__);
        $data = $handler->search('name', trim($name));
        return $data;
    }

    public function get_contact_information($id)
    {
        $handler = new MYSQLHandler(__TABLE__);
        $data = $handler->get_record_by_id($id, __PRIMARY_KEY__);
        return $data;
    }

    public function update_contact_information($user_data, $id)
    {
        $handler = new MYSQLHandler(__TABLE__);
        if ($handler->update($user_data, __PRIMARY_KEY__, $id)) {
            return true; //updated user data successfully
        } else {
            return false; //couldnt update or smth went wrong
        }
    }

    public function count_data($page)
    {
        $no_of_records_per_page = __RECORDS_PER_PAGE__;
        $offset = ($page - 1) * $no_of_records_per_page;

        $conn = mysqli_connect(__HOST__, __USER__, __PASS__, __DB__);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $total_pages_sql = "SELECT COUNT(*) FROM " . __TABLE__;
        $result = mysqli_query($conn, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM " . __TABLE__ . " LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($res_data)) {
        }
        mysqli_close($conn);
        return array($res_data, $total_pages);
    }

    public function export_json()
    {

        $conn = mysqli_connect(__HOST__, __USER__, __PASS__, __DB__);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            die();
        }

        $sql = "select * from " . __TABLE__;

        $response = array();
        $contacts = array();
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($result)) {
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $phone = $row['phone'];
            $email = $row['email'];
            $postcode = $row['postcode'];
            $address1 = $row['address1'];
            $address2 = $row['address2'];
            $notes = $row['notes'];
            $city = $row['city'];
            $country = $row['country'];

            $contacts[] = array('first_name' => $first_name, 'last_name' => $last_name, 'phone' => $phone, 'email' => $email, 'address1' => $address1, 'address2' => $address2, 'postcode' => $postcode, 'notes' => $notes, 'city' => $city, 'country' => $country);
        }

        $response['contacts'] = $contacts;

        $fp = fopen('results.json', 'w');
        fwrite($fp, json_encode($response));
        fclose($fp);
    }

}