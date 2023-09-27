<?php

require 'dbcon.php';

if(isset($_POST['save_User']))
{
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $country = mysqli_real_escape_string($con, $_POST['country']);

    if($name == NULL || $email == NULL || $password == NULL || $country == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "INSERT INTO userregistration (fullname,email,password,country) VALUES ('$name','$email','$password','$country')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'User Created Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'User Not Created'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['update_User']))
{
    $User_id = mysqli_real_escape_string($con, $_POST['User_id']);

    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
   

    if($name == NULL || $email == NULL || $password == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }

    $query = "UPDATE userregistration SET fullname='$name', email='$email', password='$password' 
                WHERE id='$User_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'User Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'User Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['User_id']))
{
    $User_id = mysqli_real_escape_string($con, $_GET['User_id']);

    $query = "SELECT * FROM userregistration WHERE id='$User_id'";
    $query_run = mysqli_query($con, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $User = mysqli_fetch_array($query_run);
		
        $country = "SELECT name FROM countries where code='".$User['country']."'";
		$resultcountry = mysqli_query($con,$country);
		$row = mysqli_fetch_array($resultcountry);
		$User['country']= $row['name'];
		
        $res = [
            'status' => 200,
            'message' => 'User Fetch Successfully by id',
            'data' => $User
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'User Id Not Found'
        ];
        echo json_encode($res);
        return;
    }
}

if(isset($_POST['delete_User']))
{
    $User_id = mysqli_real_escape_string($con, $_POST['User_id']);

    $query = "DELETE FROM userregistration WHERE id='$User_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'User Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'User Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>