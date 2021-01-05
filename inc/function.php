<?php
//include "db" file to connect to database
include "db.php";
//"connect" variable is from "db" file for connect to database
//check users login function
function login($username, $password, $type) {
    global $connect;
    //get query result
    $query = "select * from userlogin where username='$username' AND password='$password' AND type='$type' AND status='active'";
    //execute query
    $run_c = mysqli_query($connect, $query);
    //if user exist in system
    if (mysqli_num_rows($run_c) > 0) {
        $row_c = mysqli_fetch_array($run_c);
        //return user id;
        return $row_c['id'];
    } else return 0;
    $connect->close();
}
//update payment details by user type (normaluser or staff) function
function updatePaymentDetails($userid, $username, $usertype, $nameoncard, $cardnumber, $expmonth, $expyear, $cvv) {
    global $connect;
    //query to update payment details
    $query = "UPDATE payment SET name_on_card='$nameoncard',creadi_card_number='$cardnumber',exp_month='$expmonth', exp_year='$expyear',cvv='$cvv' where user_id='$userid' AND user_name='$username' AND user_type='$usertype'";
    //execute query
    $run_c = mysqli_query($connect, $query);
    $connect->close();
}
//check if user have a payment details function
function checkPaymentDetails($user, $id, $type) {
    global $connect;
    //query to get payment details belpng to username id and type(trainer or staff or normal_user)
    $query = "select * from payment where user_id='$id' AND user_name='$user' AND user_type='$type'";
    //execute query
    $run_c = mysqli_query($connect, $query);
    if (mysqli_num_rows($run_c) > 0) {
        $row_c = mysqli_fetch_array($run_c);
        //if user have ceadit card number in system return 1
        $creadi_card_number = $row_c['creadi_card_number'];
        if ($creadi_card_number != "") return 1;
        //if user not have ceadit card number in system return 0
        else return 0;
    }
    $connect->close();
}
//open order from user function
function openOrderFromUser($price) {
    //get date
    $d = $mydate = getdate(date("U"));
    $open_date = "$mydate[year]-$mydate[mon]-$mydate[mday]";
    global $connect;
    //query insert new order
    $insertData = "INSERT INTO orderr(date_open,price,status,type)
    VALUES('$open_date',$price,'pending','user')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    //get inserted order id and return it
    $order_id = $connect->insert_id;
    return $order_id;
    $connect->close();
}
//sned Order From User function
function snedOrderFromUser($userid, $orderid, $itemid, $usertype, $quantity, $type) {
    global $connect;
    //query to add item belong to orderid and user type
    $insertData1 = "INSERT INTO iteminorder(userid,orderid,itemid,usertype,quantity,type)
    VALUES('$userid','$orderid','$itemid','$usertype','$quantity','$type')";
    //update item quantity
    $insertData2 = "UPDATE items SET quantity=quantity-'$quantity' where id='$itemid' ";
    //execute queries
    $exec1 = mysqli_query($connect, $insertData1);
    $exec2 = mysqli_query($connect, $insertData2);
    $connect->close();
}
//register function for add user in system
function register($fname, $lname, $gender, $dob, $email, $phone_number, $address, $username, $password, $securityQustion, $answer) {
    global $connect;
    //inser into payment (username and user type details) for save user details and if user want to pay only update payment details (card number,exp motth etc..)
    $insertData = "INSERT INTO payment(user_name,user_type)
    VALUES('$username','user')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    //get inserted payment id payment
    $pay_id = $connect->insert_id;
    //add user in system query
    $insertData = "INSERT INTO normal_user(fname,lname,gender,dob,email,phone_number,address,user_name,password,payment_id) 
    VALUES('$fname','$lname','$gender','$dob','$email','$phone_number','$address','$username','$password','$pay_id')";
    //execute query
    $run_c2 = mysqli_query($connect, $insertData);
    //get inserted user id
    $user_id = $connect->insert_id;
    //update payment (user id)
    $insertData = "UPDATE payment SET user_id='$user_id' where id='$pay_id'";
    //execute query
    $run_c3 = mysqli_query($connect, $insertData);
    //add user detais to userlogin table "active" user (can login)
    $insertData = "INSERT INTO userlogin(id,type,username,password,status,email) 
    VALUES('$user_id','user','$username','$password','active','$email')";
    //execute query
    $run_c4 = mysqli_query($connect, $insertData);
    //add user security question and answer (user can change password if he forgot)
    $insertData = "INSERT INTO forgotpassword(username,email,question,answer) 
    VALUES('$username','$email','$securityQustion','$answer')";
    //execute query
    $run_c4 = mysqli_query($connect, $insertData);
    $connect->close();
}
//subscription function to add trainer in system but trainer can't login while admin not confirm trainer
function subscription($fname, $lname, $gender, $address, $phone_number, $dob, $email, $username, $password, $subscriptiontype, $subscriptionstartdate, $status, $weight, $height, $fat, $nameoncard, $cardnumber, $expmonth, $expyear, $cvv, $isSportHabits, $isMedicalProblems, $securityQustion, $answer) {
    global $connect;
    //inser into payment (payment details)
    $insertData = "INSERT INTO payment(user_name,user_type,name_on_card,creadi_card_number,exp_month,exp_year,cvv)
    VALUES('$username','trainer','$nameoncard','$cardnumber','$expmonth','$expyear','$cvv')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    //get inserted user id payment
    $pay_id = $connect->insert_id;
    //add trainer detais to trainers table "not active" user (can't login while admin not confirm trainer)
    $insertData = "INSERT INTO trainer(fname,lname,gender,address,phonenumber,dob,email,user_name,password,subscriptiontype,subscriptionstartdate,status,payment_id,height,weight,fat,sporthabits,medicalproblems)
    VALUES('$fname','$lname','$gender','$address','$phone_number','$dob','$email','$username','$password','$subscriptiontype','$subscriptionstartdate','$status','$pay_id','$height','$weight','$fat','$isSportHabits','$isMedicalProblems')";
    //execute query
    $run_c2 = mysqli_query($connect, $insertData);
    //get inserted user id
    $trainer_id = $connect->insert_id;
    //update payment (user id)
    $insertData = "UPDATE payment SET user_id='$trainer_id' where id='$pay_id' ";
    //execute query
    $run_c3 = mysqli_query($connect, $insertData);
    //add user detais to userlogin table "not active" user (can't login while admin not confirm trainer)
    $insertData = "INSERT INTO userlogin(id,type,username,password,status,email) 
    VALUES('$trainer_id','trainer','$username','$password','$status','$email')";
    //execute query
    $run_c4 = mysqli_query($connect, $insertData);
    //add user security question and answer (user can change password if he forgot)
    $insertData = "INSERT INTO forgotpassword(username,email,question,answer) 
    VALUES('$username','$email','$securityQustion','$answer')";
    //execute query
    $run_c4 = mysqli_query($connect, $insertData);
    // $connect -> close();
    
}
/////////////////////////////SUPPLIER//////////////////////////////////////////
//new supplier function for add supplier in system
function newSupplier($fullname, $email, $phonenumber) {
    global $connect;
    //add supplier query
    $insertData = "INSERT INTO supplier(full_name,email,phone_number) 
    VALUES('$fullname','$email','$phonenumber')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
    //if query added successfully in system show message
    if (isset($run_c)) {
        echo '<script> w2alert("supplier add successfully");</script>';
    }
}
//get all suppliers function
function getSuppliers() {
    global $connect;
    //get all suppliers from database query
    $query = "SELECT * FROM supplier";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    //suppliers array for save all suppliers
    $suppliers = null;
    $i = 0;
    //get all suupliers and insert suppliers objects abd save them into suppliers array
    while ($row_c = mysqli_fetch_array($resultSet)) {
        //supplier object
        $obj = new supplier($row_c['id'], $row_c['full_name'], $row_c['email'], $row_c['phone_number']);
        //add object to suppliers array
        $suppliers[$i] = $obj;
        $i++;
    }
    //return suppliers array
    return $suppliers;
    $connect->close();
}
//delete Supplier details function
function deleteSupplier($id) {
    global $connect;
    //query
    $query = "DELETE FROM supplier WHERE id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//update Supplier details function
function updateSupplier($id, $fullname, $email, $phonenumber) {
    global $connect;
    //update supplier details query
    $query = "UPDATE supplier SET full_name='$fullname' , email='$email' , phone_number='$phonenumber' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
/////////////////////////////ADMIN//////////////////////////////////////////
//add new admin function for add admin in system
function newAdmin($number, $fname, $lname, $gender, $dob, $email, $phone_number, $address, $username, $password, $startDate) {
    global $connect;
    //add ammin to system query
    $insertData = "INSERT INTO admin(admin_number,fname,lname,dob,gender,address,email,phone_number,user_name,password,start_date) 
    VALUES('$number','$fname','$lname','$dob','$gender','$address','$email','$phone_number','$username','$password','$startDate')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    //get inserted admin id
    $admin_id = $connect->insert_id;
    //add admin for table 'userlogin' (can login)
    $insertData = "INSERT INTO userlogin(id,type,username,password,status,email) 
    VALUES('$admin_id','admin','$username','$password','active','$email')";
    $run_c2 = mysqli_query($connect, $insertData);
    //if queries add successfully in system show message
    if (isset($run_c) && isset($run_c2)) {
        echo '<script> w2alert("admin add successfully");</script>';
    }
    $connect->close();
}
//get all admins function
function getAdmins() {
    global $connect;
    //get admins query
    $query = "SELECT * FROM admin";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $adminAraay = null;
    $i = 0;
    //get admin details and insert object save into 'adminAraay' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $id = $row_c['id'];
        $number = $row_c['admin_number'];
        $fname = $row_c['fname'];
        $lname = $row_c['lname'];
        $dob = $row_c['dob'];
        $gender = $row_c['gender'];
        $address = $row_c['address'];
        $email = $row_c['email'];
        $phonenumber = $row_c['phone_number'];
        $seniority = $row_c['seniority'];
        $startDate = $row_c['start_date'];
        $username = $row_c['user_name'];
        $password = $row_c['password'];
        //insert admin object
        $obj = new Admin($id, $fname, $lname, $gender, $dob, $email, $address, $phonenumber, $username, $password, $number, $seniority, $startDate);
        //add to 'adminAraay'
        $adminAraay[$i] = $obj;
        $i++;
    }
    return $adminAraay;
    $connect->close();
}
//delete admin details funtion
function deleteAdmin($id) {
    global $connect;
    //delete query
    $query = "DELETE FROM admin WHERE id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//delete exercise from workPlam
function deleteExcerciseFromWorkplan($workPlanId, $excerciseId, $day, $week) {
    global $connect;
    //delete query
    $query = "DELETE FROM workplanexercise WHERE exerciseid='$excerciseId' AND workplanid='$workPlanId' AND day='$day' AND week ='$week'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//update admin details function
function updateAdmin($id, $email, $address, $phonenumber, $password) {
    global $connect;
    //update admin table query
    $query = "UPDATE admin SET email='$email' , address='$address' , phone_number='$phonenumber', password='$password' where id='$id' ";
    //execute query
    $exec = mysqli_query($connect, $query);
    //update userlogin table query (admin details)
    $query = "UPDATE userlogin SET email='$email' AND password='$password' where id='$id' AND type='trainer'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
/////////////////////////////Staff//////////////////////////////////////////
//staff register function for add staff in system
function staffRegister($number, $fname, $lname, $address, $phonenumber, $gender, $dob, $email, $role, $perhour, $workstart, $username, $password) {
    global $connect;
    //query to insert payment details
    $insertData = "INSERT INTO payment(user_name,user_type)
    VALUES('$username','staff')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    //get inserted payment id
    $pay_id = $connect->insert_id;
    //add staff in system query
    $insertData = "INSERT INTO staff(staff_number,fname,lname,address,phone_number,gender,dob,email,role,per_hour,start_work,user_name,password,payment_id) 
    VALUES('$number','$fname','$lname','$address','$phonenumber','$gender','$dob','$email','$role','$perhour','$workstart','$username','$password' ,'$pay_id')";
    //execute query
    $run_c2 = mysqli_query($connect, $insertData);
    //get inserted user id
    $staff_id = $connect->insert_id;
    //update payment (staff id)
    $insertData = "UPDATE payment SET user_id='$staff_id' where id='$pay_id'";
    //execute query
    $run_c3 = mysqli_query($connect, $insertData);
    //add staff detais to userlogin table "active" staff (can login)
    $insertData = "INSERT INTO userlogin(id,type,username,password,status,email) 
    VALUES('$staff_id','staff','$username','$password','active','$email')";
    //execute query
    $run_c2 = mysqli_query($connect, $insertData);
    if (isset($run_c) && isset($run_c2) && isset($run_c3)) {
        echo '<script> w2alert("staff adding successfully");</script>';
    }
    $connect->close();
}
//get all staff details function
function getStaff() {
    global $connect;
    //get staff query
    $query = "SELECT * FROM staff";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $staffAraay = null;
    $i = 0;
    //get staff details and insert objects save into 'staffAraay' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $id = $row_c['id'];
        $number = $row_c['staff_number'];
        $fname = $row_c['fname'];
        $lname = $row_c['lname'];
        $dob = $row_c['dob'];
        $gender = $row_c['gender'];
        $address = $row_c['address'];
        $email = $row_c['email'];
        $phonenumber = $row_c['phone_number'];
        $startWork = $row_c['start_work'];
        $endwork = $row_c['end_work'];
        $username = $row_c['user_name'];
        $password = $row_c['password'];
        $role = $row_c['role'];
        $perhour = $row_c['per_hour'];
        //insert Staff object
        $obj = new Staff($id, $fname, $lname, $gender, $dob, $email, $address, $phonenumber, $username, $password, $number, $startWork, $endwork, $role, $perhour);
        //add to 'adminAraay'
        $staffAraay[$i] = $obj;
        $i++;
    }
    return $staffAraay;
    $connect->close();
}
//update staff details function
function updateStaff($id, $email, $address, $phonenumber, $password, $perhour) {
    global $connect;
    //update query
    $query = "UPDATE staff SET email='$email' , address='$address' , phone_number='$phonenumber', password='$password' , per_hour='$perhour' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    //update 'userlogin' table staff details
    $query = "UPDATE userlogin SET email='$email', password='$password' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
/////////////////////////////customers//////////////////////////////////////////
//get all customers details function
function getCustomers() {
    global $connect;
    //get normal_user details query
    $query = "SELECT * FROM normal_user";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $customersArray = null;
    $i = 0;
    //get normal_user details and insert object save into 'customersArray' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $id = $row_c['id'];
        $fname = $row_c['fname'];
        $lname = $row_c['lname'];
        $dob = $row_c['dob'];
        $gender = $row_c['gender'];
        $address = $row_c['address'];
        $email = $row_c['email'];
        $phonenumber = $row_c['phone_number'];
        $username = $row_c['user_name'];
        $password = $row_c['password'];
        //insert user object
        $obj = new User($id, $fname, $lname, $gender, $dob, $email, $address, $phonenumber, $username, $password);
        //add object to 'customersArray'
        $customersArray[$i] = $obj;
        $i++;
    }
    return $customersArray;
    $connect->close();
}
/////////////////////////////Subscriptions//////////////////////////////////////////
//get all subscriptions (trainers) details function
function getSubscriptions($status) {
    global $connect;
    //get subscriptions by status ('active' or not 'active')
    $query = "SELECT * FROM trainer WHERE status='$status'";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $trainers = null;
    $i = 0;
    //get subscriptions details and insert object save into 'trainers' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $id = $row_c['id'];
        $fname = $row_c['fname'];
        $lname = $row_c['lname'];
        $dob = $row_c['dob'];
        $gender = $row_c['gender'];
        $address = $row_c['address'];
        $email = $row_c['email'];
        $phonenumber = $row_c['phonenumber'];
        $username = $row_c['user_name'];
        $password = $row_c['password'];
        $subscriptiontype = $row_c['subscriptiontype'];
        $subscriptionstartdate = $row_c['subscriptionstartdate'];
        $subscriptionenddate = $row_c['subscriptionenddate'];
        $status = $row_c['status'];
        $height = $row_c['height'];
        $weight = $row_c['weight'];
        $fat = $row_c['fat'];
        $sporthabits = $row_c['sporthabits'];
        $medicalproblems = $row_c['medicalproblems'];
        $workPlanId = $row_c['work_plan_id'];
        //insert Trainer object
        $obj = new Trainer($id, $fname, $lname, $gender, $dob, $email, $address, $phonenumber, $username, $password, $subscriptiontype, $subscriptionstartdate, $subscriptionenddate, $status, $height, $weight, $fat, $sporthabits, $medicalproblems);
        //check if subscription status is active and have workpkan id (for get workplan details)
        if ($status == 'active') {
            //get all workplans by "getWorkPlans" function
            $workplans = getWorkPlans();
            //get workplan belong for trainer
            $all = count((array)getWorkPlans());
            for ($j = 0;$j < $all;$j++) {
                if ($workPlanId == $workplans[$j]->id) $obj->WorkPlan = $workplans[$j];
            }
        }
        //add object to 'trainers'
        $trainers[$i] = $obj;
        $i++;
    }
    return $trainers;
    //$connect -> close();
    
}
//set trianer workplan and change status to active function
function confirmSubscriptionAndSetWorkOut($trainerId, $workPlanName) {
    //get workplans by "getWorkPlans" function
    global $connect;
    $workplans = getWorkPlans();
    $obj = null;
    $workPlanId = - 1;
    //get workplan object by send workplan name and save in 'obj'
    $count = count((array)getWorkPlans());
    for ($j = 0;$j < $count;$j++) {
        if ($workPlanName == $workplans[$j]->name) $obj = $workplans[$j];
    }
    //check if 'obj' not null
    if ($obj != null) $workPlanId = $obj->id;
    //if workplan value no negative
    if ($workPlanId != - 1) {
        global $connect;
        //update trainer status and workplan id
        $status = "active";
        $updateData = "UPDATE trainer SET status='$status',work_plan_id='$workPlanId' WHERE id='$trainerId'";
        //execute query
        $run_c = mysqli_query($connect, $updateData);
        //update trainer status in 'userlogin' table(can login)
        $updateData1 = "UPDATE userlogin SET status='$status' WHERE id='$trainerId'";
        $run_c1 = mysqli_query($connect, $updateData1);
    }
    $connect->close();
}
//cancel subscription function
function cancelSubscription($id) {
    global $connect;
    //delete from all tables in system
    $query = "DELETE FROM trainer WHERE id='$id' ";
    $exec = mysqli_query($connect, $query);
    $query = "DELETE FROM userlogin WHERE id='$id' ";
    $exec = mysqli_query($connect, $query);
    $query = "DELETE FROM payment WHERE user_id='$id' ";
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//get all items details function
function getItems() {
    global $connect;
    //get items query
    $query = "SELECT * FROM items";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $items = null;
    $i = 0;
    //get items details and insert objects save into 'items' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $id = $row_c['id'];
        $name = $row_c['item_name'];
        $price = $row_c['price'];
        $quantity = $row_c['quantity'];
        $img = $row_c['image'];
        $desc = $row_c['description'];
        //insert Item object
        $obj = new Item($id, $name, $price, $quantity, $img, $desc);
        //add to 'items'
        $items[$i] = $obj;
        $i++;
    }
    return $items;
    $connect->close();
}
//get getOrdersUserType function
function getAllOrders($type) {
    global $connect;
    //get otders Type 'user' query
    $query = "SELECT * FROM orderr WHERE type='$type'";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $orders = null;
    $i = 0;
    //get orders type 'user' details and insert objects save into 'orders' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        //insert orfder object and save into 'orders'
        $orders[$i] = new Orders($row_c['id'], $row_c['date_open'], $row_c['price'], $row_c['status'], $row_c['type']);
        $i++;
    }
    return $orders;
   $connect->close();
}
/////////////////////////////Orders From Users//////////////////////////////////////////
//get users orders details function
function getUsersOrders() {
    global $connect;
    //get users orders by 'getOrdersUserType' function
    $orders = getAllOrders('user');
    $totalOrders = count((array)getAllOrders('user'));
    //if orders not null
    if ($orders != null) {
        for ($i = 0;$i < $totalOrders;$i++) {
            //get order id ans save in variable
            $OrderId = $orders[$i]->id;
            //get items in order (type 'user') belong order id
            $query1 = "SELECT * FROM iteminorder WHERE orderid='$OrderId' AND type='user'";
            //execute query
            $resultSet1 = mysqli_query($connect, $query1);
            // $items=null;
            $j = 0;
            while ($row_c1 = mysqli_fetch_array($resultSet1)) {
                $userid = $row_c1['userid'];
                $itemid = $row_c1['itemid'];
                $itemquantity = $row_c1['quantity'];
                $usertype = $row_c1['usertype'];
                //get items by "getItems" function for get item details
                $allItems = getItems();
                $totalItems = count((array)getItems());
                for ($it = 0;$it < $totalItems;$it++) {
                    if ($allItems[$it]->id == $itemid) {
                        $item_name = $allItems[$it]->name;
                        $item_price = $allItems[$it]->price;
                        $item_image = $allItems[$it]->img;
                        $item_desc = $allItems[$it]->description;
                        //add item object to orded (array of objects)
                        $orders[$i]->items[$j] = new Item($itemid, $item_name, $item_price, $itemquantity, $item_image, $item_desc);
                    }
                }
                $j++;
            }
            //check type of user (customer or trainer or staff) for belong user to order
            if ($userid != - 1) {
                if ($usertype == 'user') {
                    $customers = getCustomers();
                    $count = count((array)getCustomers());
                    for ($u = 0;$u < $count;$u++) {
                        if ($customers[$u]->id == $userid) $orders[$i]->User = $customers[$u];
                    }
                }
                if ($usertype == 'trainer') {
                    $subscription = getSubscriptions("active");
                    $count = count((array)getSubscriptions("active"));
                    for ($u = 0;$u < $count;$u++) {
                        if ($subscription[$u]->id == $userid) $orders[$i]->User = $subscription[$u];
                    }
                }
                if ($usertype == 'staff') {
                    $staff = getStaff();
                    $count = count((array)getStaff());
                    for ($u = 0;$u < $count;$u++) {
                        if ($staff[$u]->id == $userid) $orders[$i]->User = $staff[$u];
                    }
                }
            }
        }
        return $orders;
    } else return null;
}
/////////////////////////////Items//////////////////////////////////////////
//add new item function
function newItem($name, $price, $quantity, $img, $desc) {
    global $connect;
    //inser item query
    $insertData = "INSERT INTO items(item_name,price,quantity,image,description) 
    VALUES('$name','$price','$quantity','$img','$desc')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
    if (isset($run_c)) {
        echo '<script> w2alert("item add successfully");</script>';
    }
}
//delete item details function
function deleteItem($id) {
    global $connect;
    //delete item query
    $query = "DELETE FROM items WHERE id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//update item details function
function updateItem($id, $quantity, $price) {
    global $connect;
    //update item function
    $query = "UPDATE items SET quantity='$quantity' , price='$price' where id='$id'";
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
/////////////////////////////Orders From Suppliers//////////////////////////////////////////
//get all orders from suppliers details function
function getOrdersFromSuppliers() {
    global $connect;
    //get sorders type suppliers by "getAllOrders" function
    $suppliersOrders = getAllOrders('supplier');
    $totalSuppliersOrders = count((array)getAllOrders('supplier'));
    $orderSupplier = null;
    for ($i = 0;$i < $totalSuppliersOrders;$i++) {
        //get order type supplier details
        $id = $suppliersOrders[$i]->id;
        $openDate = $suppliersOrders[$i]->dateOpen;
        $price = $suppliersOrders[$i]->price;
        $status = $suppliersOrders[$i]->status;
        $type = $suppliersOrders[$i]->type;
        //get all orders supplier from table 'orderssuppliers' belong order id
        $query2 = "SELECT * FROM orderssuppliers WHERE order_id='$id'";
        //execute query
        $resultSet2 = mysqli_query($connect, $query2);
        $row_c2 = mysqli_fetch_array($resultSet2);
        //get query result details supplier id and admin id belong order id
        $supplier_id = $row_c2['supplier_id'];
        $admin_id = $row_c2['admin_id'];
        //get duppliers by "getSuppliers" function and get supplier belong 'supplier id' and save in object 'supplierObj'
        $suppliers = getSuppliers();
        $totalSuppliers = count((array)getSuppliers());
        $supplierObj = null;
        for ($y = 0;$y < $totalSuppliers;$y++) if ($suppliers[$y]->id == $supplier_id) $supplierObj = $suppliers[$y];
        //get admins by "getAdmins" function and get admin belong 'admin id' (create the order) and save in object 'adminObj'
        $admins = getAdmins();
        $totalAdmins = count((array)getAdmins());
        $adminObj = null;
        for ($x = 0;$x < $totalAdmins;$x++) if ($admins[$x]->id == $admin_id) $adminObj = $admins[$x];
        //insert order object
        $obj = new Orders($id, $openDate, $price, $status, $type);
        //insert admin object and belong to order
        $obj->User = new Admin($adminObj->id, $adminObj->fname, $adminObj->lname, $adminObj->gender, $adminObj->dateOfBirth, $adminObj->email, $adminObj->address, $adminObj->phoneNumber, $adminObj->username, $adminObj->password, $adminObj->adminNumber, $adminObj->seniority, $adminObj->startDate);
        //inser supplier object and belong to order
        $obj->Supplier = new supplier($supplierObj->id, $supplierObj->fullname, $supplierObj->email, $supplierObj->phoneNumber);
        //add order to 'orderSupplier'
        $orderSupplier[$i] = $obj;
    }
    return $orderSupplier;
    $connect->close();
}
//get suppliers orders details function ('supplier' type)
function getAllSuppliersOrdersdetails() {
    global $connect;
    //get item in order type supplier query
    $query = "SELECT * FROM iteminorder WHERE type='supplier' AND usertype='admin'";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $itemsinorder = null;
    $i = 0;
    //get details and save in 'itemsinorder'
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $data_item['userid'] = $row_c['userid'];
        $data_item['orderid'] = $row_c['orderid'];
        $data_item['itemid'] = $row_c['itemid'];
        $data_item['usertype'] = $row_c['usertype'];
        $data_item['quantity'] = $row_c['quantity'];
        $data_item['itemtype'] = $row_c['itemtype'];
        $itemsinorder[$i] = $data_item;
        $i++;
    }
    return $itemsinorder;
    $connect->close();
}
//get supplier id by id function
function getSupplierId($name) {
    $suppliers = getSuppliers();
    $totalSuppliers = count((array)getSuppliers());
    for ($i = 0;$i < $totalSuppliers;$i++) {
        if ($suppliers[$i]->fullname == $name) $id = $suppliers[$i]->id;
    }
    return $id;
    $connect->close();
}
//open new order from supplier function
function openOrderFromSupplier($date_open, $adminId, $supplierId) {
    global $connect;
    $orderid = "";
    //insert data in 'order' table query status 'pending'
    $insertData = "INSERT INTO orderr(date_open,status,type) 
    VALUES('$date_open','pending','supplier')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    //get inserted order id for belong to 'orderssuppliers' table
    $orderid = $connect->insert_id;
    //insert data in 'orderssuppliers' table query
    $insertDataa = "INSERT INTO orderssuppliers(order_id,admin_id,supplier_id) 
    VALUES('$orderid','$adminId','$supplierId')";
    //execute query
    $run_c1 = mysqli_query($connect, $insertDataa);
    return $orderid;
    $connect->close();
}
//add items (protein) to supplier order function
function addItemsToSupplierOrder($itemname, $orderid, $userid, $quantity) {
    //get items by "getItems" function
    $items = getItems();
    $totalItems = count((array)getItems());
    $itemid = '';
    //get item id by compare name (item name send by function) and save item id in variable
    for ($i = 0;$i < $totalItems;$i++) {
        if ($items[$i]->name == $itemname) {
            $itemid = $items[$i]->id;
        }
    }
    global $connect;
    //inser data into 'iteminorder' table query
    $insertData = "INSERT INTO iteminorder(userid,orderid,itemid,usertype,quantity,type,itemtype) 
    VALUES('$userid','$orderid','$itemid','admin','$quantity','supplier','protein')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
//add insruments to supplier order function
function addInstrumentsToSupplierOrder($instrumentName, $orderid, $userid, $quantity) {
    //get instruments by "getInstrumentsDetails" function
    $instruments = getInstrumentsDetails();
    $totalInstruments = count((array)getInstrumentsDetails());
    $instrumentId = '';
    //get instrument id by compare name (instrument name send by function) and save instrument id in variable
    for ($i = 0;$i < $totalInstruments;$i++) {
        if ($instruments[$i]->name == $instrumentName) {
            $instrumentId = $instruments[$i]->number;
        }
    }
    global $connect;
    //inser data into 'iteminorder' table query
    $insertData = "INSERT INTO iteminorder(userid,orderid,itemid,usertype,quantity,type,itemtype) 
    VALUES('$userid','$orderid','$itemid','admin','$quantity','supplier','instrument')";
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
/////////////////////////////Work Schedule//////////////////////////////////////////
//get work schedule details function
function getWorkScchedule() {
    global $connect;
    //get work schedule details query
    $query = "SELECT * FROM workschedule";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $workschedule = null;
    $i = 0;
    //get work schedule details and save in 'workschedule'
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $data_item['hour'] = $row_c['hour'];
        $data_item['sunday'] = $row_c['sunday'];
        $data_item['monday'] = $row_c['monday'];
        $data_item['tuesday'] = $row_c['tuesday'];
        $data_item['wedensday'] = $row_c['wedensday'];
        $data_item['thursday'] = $row_c['thursday'];
        $data_item['friday'] = $row_c['friday'];
        $data_item['saturday'] = $row_c['saturday'];
        $workschedule[$i] = $data_item;
        $i++;
    }
    return $workschedule;
    $connect->close();
}
//delete workschedule row details (by hour) function
function deleteWorkPlanRow($hour) {
    global $connect;
    //delete query
    $query = "DELETE FROM workschedule WHERE hour='$hour'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//update workScedule row details function
function וupdateWorkPlanRow($hour, $sunday, $monday, $tuesday, $wedensday, $thursday, $friday, $saturday) {
    global $connect;
    //update query
    $query = "UPDATE workschedule SET hour='$hour' , sunday='$sunday' , monday='$monday', tuesday='$tuesday', wedensday='$wedensday' , thursday='$thursday', friday='$friday'  , saturday='$saturday'   where hour='$hour' ";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//add new workScedule Row (hour or shift) function
function newWorkScheduleRow($hour) {
    global $connect;
    //update query
    $insertData = "INSERT INTO workschedule(hour) 
    VALUES('$hour')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
/////////////////////////////Lessons Details/////////////////////////////////////////
//get all lesson details function
function getLessonsDetails() {
    global $connect;
    //get lessons details query
    $query1 = "SELECT * FROM lesson";
    //execute query
    $resultSet1 = mysqli_query($connect, $query1);
    $lessons = null;
    $i = 0;
    //get lessons details and save into "$lessons" array of objects
    while ($row_c1 = mysqli_fetch_array($resultSet1)) {
        $lessonnumber = $row_c1['lessonnumber'];
        $lessonMaxtrainers = $row_c1['maxtrainers'];
        $startDate = $row_c1['startDate'];
        $day = $row_c1['day'];
        $hour = $row_c1['hour'];
        $registers = $row_c1['registers'];
        $status = $row_c1['status'];
        $lessonType = $row_c1['type'];
        $room_number = $row_c1['room_number'];
        //get lesson type details by "getLessonsTypeDetails" function and save belong type in "lessonsTypesObj" object
        $lessonsType = getLessonsTypeDetails();
        $totalLessonsTypes = count((array)getLessonsTypeDetails());
        $lessonsTypesObj = null;
        for ($j = 0;$j < $totalLessonsTypes;$j++) if ($lessonsType[$j]->type == $lessonType) $lessonsTypesObj = $lessonsType[$j];
        //get rooms details by "getRoomsDetails" function and save belong room number in "roomObj" object
        $rooms = getRoomsDetails();
        $totalRooms = count((array)getRoomsDetails());
        $roomObj = null;
        for ($z = 0;$z < $totalRooms;$z++) if ($rooms[$z]->roomNumber == $room_number) $roomObj = $rooms[$z];
        //insert lesson object
        $obj = new Lesson($lessonnumber, $lessonMaxtrainers, $startDate, $day, $hour, $registers, $status);
        //insert lesson type object and belong to lesson object
        $obj->LessonType = new LessonType($lessonsTypesObj->type, $lessonsTypesObj->difficulty, $lessonsTypesObj->durationTime);
        //insert room object and belong to lesson object
        $obj->Room = new Room($roomObj->roomNumber, $roomObj->maxNumberOfTrainers, $roomObj->roomType);
        //add lesson to "lessons"
        $lessons[$i] = $obj;
        $i++;
    }
    return $lessons;
    $connect->close();
}
//delete lessons Schedule row (by lesson number) details function
function deleteLessonsScheduleRow($lessonNumber) {
    global $connect;
    //delete lesson query
    $query = "DELETE FROM lesson WHERE lessonnumber='$lessonNumber'";
    //execute query
    $exec = mysqli_query($connect, $query);
    //delete users in lesson query
    $query = "DELETE FROM userinlesson WHERE lessonnumber='$lessonNumber'";
    //execute query
    $exec = mysqli_query($connect, $query);
}
//add new Lesson function
function newLesson($lessonType, $maxtrainers, $startDate, $day, $hour, $roomType) {
    global $connect;
    //'is lessons' variable for check if lesson already exist (check by date and hour )
    $isLesson = 0;
    //get lessons by "getLessonsDetails" function
    $Lessons = getLessonsDetails();
    $totalLessons = count((array)getLessonsDetails());
    for ($i = 0;$i < $totalLessons;$i++) {
        //get lesson start date and diff in startDate var send by function
        $date1 = date_create($Lessons[$i]->startDate);
        $date2 = date_create($startDate);
        $diff = date_diff($date1, $date2);
        $res = $diff->format("%a");
        //if lesson and hour date already exist 'isLesson' set var = 1
        if ($res == 0 && $Lessons[$i]->hour == $hour) $isLesson = 1;
    }
    //if lesson not exist
    if ($isLesson == 0) {
        //get room number (compare by room type send by function) for belong to lesson
        $query = "SELECT roomnumber FROM room WHERE roomtype='$roomType'";
        //execute query
        $resultSet = mysqli_query($connect, $query);
        $row_c = mysqli_fetch_array($resultSet);
        $roomnumber = $row_c['roomnumber'];
        //insert lesson
        $insertData = "INSERT INTO lesson(maxtrainers,startDate,day,hour,registers,status,type,room_number) 
    VALUES('$maxtrainers','$startDate','$day','$hour',0,'active','$lessonType','$roomnumber')";
        //execute query
        $run_c2 = mysqli_query($connect, $insertData);
        //return 1
        return 1;
        //if lesson already exist return 0
        
    } else return 0;
    $connect->close();
}
/////////////////////////////Rooms Details/////////////////////////////////////////
//get rooms Details function
function getRoomsDetails() {
    global $connect;
    //get rooms Details query
    $query = "SELECT * FROM room";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $rooms = null;
    $i = 0;
    //get rooms Details and save in 'rooms' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $roomNumber = $row_c['roomnumber'];
        $maxNumberOfTrainers = $row_c['maxnumoftrainers'];
        $roomType = $row_c['roomtype'];
        //insert room object
        $obj = new Room($roomNumber, $maxNumberOfTrainers, $roomType);
        //save object in 'rooms'
        $rooms[$i] = $obj;
        $i++;
    }
    return $rooms;
    $connect->close();
}
//update room Details function
function updateRoomDetails($roomNumber, $roomtype, $maxnumoftrainers) {
    global $connect;
    //update query
    $query = "UPDATE room SET roomtype='$roomtype' , maxnumoftrainers='$maxnumoftrainers' where roomnumber='$roomNumber'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//add new room details in system function
function newRoom($roomtype, $maxnumoftrainers) {
    global $connect;
    //insert query
    $insertData = "INSERT INTO room(roomtype,maxnumoftrainers) 
    VALUES('$roomtype','$maxnumoftrainers')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
/////////////////////////////Lessons Type Details/////////////////////////////////////////
//get lesson types Details function
function getLessonsTypeDetails() {
    global $connect;
    //get lesson types Details query
    $query = "SELECT * FROM lessontype";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $lessontype = null;
    $i = 0;
    //get lesson types Details and save in 'lessontype' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $difficutly = $row_c['difficutly'];
        $durationtime = $row_c['durationtime'];
        $lessonType = $row_c['type'];
        //insert 'LessonType' object
        $obj = new LessonType($lessonType, $difficutly, $durationtime);
        //save into "lessontype"
        $lessontype[$i] = $obj;
        $i++;
    }
    return $lessontype;
    $connect->close();
}
//update lesson type details function
function updateLessonType($type, $difficutly, $durationtime) {
    global $connect;
    //update lesson type details query
    $query = "UPDATE lessontype SET difficutly='$difficutly' , durationtime='$durationtime' where type='$type'";
    //execute query
    $exec = mysqli_query($connect, $query);
}
//add new lesson type query
function newLessonType($type, $difficutly, $durationtime) {
    global $connect;
    //insert lesson type query
    $insertData = "INSERT INTO lessonType(type,difficutly,durationtime) 
    VALUES('$type','$difficutly','$durationtime')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
/////////////////////////////signin for lessons Details/////////////////////////////////////////
//get signin for lessons details function by status
function getSigninForLessonDetails($status) {
    global $connect;
    //get signin for lessons details by status
    $query1 = "SELECT * FROM userinlesson WHERE status='$status'";
    //execute query
    $resultSet1 = mysqli_query($connect, $query1);
    $registerForLessons = null;
    $i = 0;
    $obj = null;
    //get signin for lessons details and save in 'registerForLessons' (array of objects)
    while ($row_c1 = mysqli_fetch_array($resultSet1)) {
        $userid = $row_c1['userid'];
        $lessonnumber = $row_c1['lessonnumber'];
        $registertime = $row_c1['registertime'];
        $status = $row_c1['status'];
        //insert object "UserInLesson"
        $obj = new UserInLesson($registertime, $status);
        //get lessons details by "getLessonsDetails" function for belong lesson to 'UserInLesson' object
        $Lessons = getLessonsDetails();
        $count = count((array)getLessonsDetails());
        for ($u = 0;$u < $count;$u++) {
            if ($Lessons[$u]->lessonNumber == $lessonnumber) $obj->setLesson($Lessons[$u]);
        }
        //get trainers details by "getSubscriptions" function (status active) for belong trainer to 'UserInLesson' object
        $trainers = getSubscriptions('active');
        $count = count((array)getSubscriptions('active'));
        for ($j = 0;$j < $count;$j++) {
            if ($trainers[$j]->id == $userid) $obj->setUser($trainers[$j]);
        }
        //add obj (userInLesson object) to "registerForLessons"
        $registerForLessons[$i] = $obj;
        $i++;
    }
    return $registerForLessons;
    $connect->close();
}
/////////////////////////////Intrument Details/////////////////////////////////////////
//get Instruments details function
function getInstrumentsDetails() {
    global $connect;
    //get Instruments details query
    $query = "SELECT * FROM instrument";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $instruments = null;
    $i = 0;
    //get Instruments details and save in 'instruments' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        //insert instrument object
        $obj = new Instrument($row_c['id'], $row_c['numberr'], $row_c['name'], $row_c['buy_date'], $row_c['last_check_date'], $row_c['test_date'], $row_c['image']);
        //add to "instruments"
        $instruments[$i] = $obj;
        $i++;
    }
    return $instruments;
    $connect->close();
}
//delete instrument details function (by id)
function deleteInstrument($id) {
    global $connect;
    //delete instrument details query
    $query = "DELETE FROM instrument WHERE id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
}
//add new instrument details in system function
function newInstrumenet($name, $number, $buyDate, $image) {
    global $connect;
    //insert instrument details query
    $insertData = "INSERT INTO instrument(numberr,name,buy_date,image) 
    VALUES('$number','$name','$buyDate','$image')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    if (isset($run_c)) {
        echo '<script> w2alert("instrument add successfully");</script>';
    }
    $connect->close();
}
//update Instrument Details function
function updateInstrumentDetails($id, $lastcheck, $testdate) {
    global $connect;
    //update Instrument Details query
    $query = "UPDATE instrument SET last_check_date='$lastcheck' , test_date='$testdate' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//update user order status from pending to sent
function updateUserOrderStatus($orderId) {
    global $connect;
    //update user order status from pending to sent query
    $query = "UPDATE orderr SET status='sent' where id='$orderId'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
/////////////////////////////user sign in for lesson functions/////////////////////////////////////////
//after trainer signin for lesson insert data in 'userinlesson' table in sql status "pending"
function signinForLesson($userid, $lessonnumber, $registertime) {
    global $connect;
    //insert data query
    $insertData = "INSERT INTO userinlesson(userid,lessonnumber,registertime,status) 
      VALUES('$userid','$lessonnumber','$registertime','pending')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
/////////////////////////////subscription types functions/////////////////////////////////////////
//get susbcription type Details function
function getSusbcriptionTypDetails() {
    global $connect;
    //get susbcription type Details query
    $query = "SELECT * FROM subscriptiontype";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $susbcriptiontype = array();
    $i = 0;
    //get susbcription type Details and save in 'susbcriptiontype' array
    while ($row_c = mysqli_fetch_array($resultSet, MYSQLI_ASSOC)) {
        $data_item['id'] = $row_c['id'];
        $data_item['name'] = $row_c['name'];
        $data_item['duration'] = $row_c['duration'];
        $data_item['price'] = $row_c['price'];
        $data_item['description'] = $row_c['description'];
        $susbcriptiontype[$i] = $data_item;
        $i++;
    }
    return $susbcriptiontype;
    $connect->close();
}
//update susbcription type Details function
function updateSusbcriptionTypeDetails($id, $name, $description) {
    global $connect;
    //update susbcription type Details query
    $query = "UPDATE subscriptiontype SET name='$name', description='$description' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
//add new susbcription type details function
function newSusbcriptionType($name, $price, $duration, $description) {
    global $connect;
    //insert susbcription type details query
    $insertData = "INSERT INTO subscriptiontype(name,price,duration,description) 
    VALUES('$name','$price','$duration','$description')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
/////////////////////////////Exercise functions/////////////////////////////////////////
//get Exercise details function
function getExercises() {
    global $connect;
    //get Exercise details query
    $query = "SELECT * FROM exercise";
    $resultSet = mysqli_query($connect, $query);
    $exercises = null;
    $i = 0;
    //get exercises details and save in 'exercises' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        //insert exercise object
        $obj = new Exercise($row_c['id'], $row_c['exercise_name'], $row_c['difficulty'], $row_c['rehearsals'], $row_c['sets'], $row_c['bodyPart'], $row_c['rest'], $row_c['speed'], $row_c['loadd'], $row_c['description'], $row_c['image']);
        //add obj to "exercises"
        $exercises[$i] = $obj;
        $i++;
    }
    return $exercises;
    $connect->close();
}
//add new Exercise details function
function newExercise($name, $difficulty, $rehearsals, $sets, $bodyPart, $rest, $speed, $load, $description, $img) {
    global $connect;
    //insert Exercise details query
    $insertData = "INSERT INTO exercise(exercise_name,difficulty,rehearsals,sets,bodyPart,rest,speed,loadd,image,description) 
    VALUES('$name','$difficulty','$rehearsals','$sets','$bodyPart','$rest','$speed','$load','$img','$description')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    if (isset($run_c)) {
        echo '<script> w2alert("Exercise add successfully");</script>';
    }
    $connect->close();
}
//update Exercise details function
function updateExercise($id, $description) {
    global $connect;
    //update Exercise details query
    $query = "UPDATE exercise SET description='$description' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
/////////////////////////////Menu functions/////////////////////////////////////////
//get Menus details function
function getMenus() {
    global $connect;
    //get Menus details query
    $query = "SELECT * FROM menu";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $menus = null;
    $i = 0;
    //get Menus details and save in 'menus' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        //insert menu object
        $obj = new Menu($row_c['id'], $row_c['name'], $row_c['adjustment'], $row_c['firstMeal'], $row_c['secondMeal'], $row_c['thirdMeal'], $row_c['fourthMeal'], $row_c['fifthMeal'], $row_c['description']);
        //add to 'menus'
        $menus[$i] = $obj;
        $i++;
    }
    return $menus;
    $connect->close();
}
//add new Menu details funtion
function newMenu($name, $adjustment, $firstMeal, $secondMeal, $thirdMeal, $fourthMeal, $fifthMeal, $description) {
    global $connect;
    //insert Menu details query
    $insertData = "INSERT INTO menu(name,adjustment,firstMeal,secondMeal,thirdMeal,fourthMeal,fifthMeal,description) 
    VALUES('$name','$adjustment','$firstMeal','$secondMeal','$thirdMeal','$fourthMeal','$fifthMeal','$description')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    if (isset($run_c)) {
        echo '<script> w2alert("Menu add successfully");</script>';
    }
    $connect->close();
}
//update Menu details function
function updateMenu($id, $adjustment, $firstMeal, $secondMeal, $thirdMeal, $fourthMeal, $fifthMeal, $description) {
    global $connect;
    //update Menu details query
    $query = "UPDATE menu SET adjustment='$adjustment', firstMeal='$firstMeal' ,secondMeal='$secondMeal', thirdMeal='$thirdMeal', fourthMeal='$fourthMeal', fifthMeal='$fifthMeal',description='$description' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    $connect->close();
}
/////////////////////////////Work Plan functions/////////////////////////////////////////
//get workplans details function
function getWorkPlans() {
    global $connect;
    //get workplans details query
    $query = "SELECT * FROM workplan";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $workplans = null;
    $i = 0;
    //get workplans details and save in 'workplans' (array of objects)
    while ($row_c = mysqli_fetch_array($resultSet)) {
        //get menu id to belong menu object for workplan
        $menu_id = $row_c['menu_id'];
        //insert workplan object
        $obj = new WorkPlan($row_c['id'], $row_c['name'], $row_c['about'], $row_c['duration'], $row_c['goal'], $row_c['requierments'], $row_c['targetGroup']);
        //get menus by "" function to belong menu object for workplan (compare by menu id)
        $menu = getMenus();
        $totalMenus = count((array)getMenus());
        for ($j = 0;$j < $totalMenus;$j++) {
            if ($menu[$j]->idMenu == $menu_id) $obj->Menu = $menu[$j];
        }
        //add to "workplans"
        $workplans[$i] = $obj;
        $i++;
    }
    return $workplans;
    $connect->close();
}
//add new WorkPlan details function
function newWorkPlann($name, $about, $duration, $goal, $requierments, $targetGroup, $menu_id) {
    global $connect;
    //insert WorkPlan details query
    $insertData = "INSERT INTO workplan(name,about,duration,goal,requierments,targetGroup,menu_id) 
    VALUES('$name','$about','$duration','$goal','$requierments','$targetGroup','$menu_id')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
//add exercise to workplan function
function addExerciseToWorkPlan($week, $day, $exerciseid, $workplanId) {
    global $connect;
    //add add exercise to workplan query
    $insertData = "INSERT INTO workplanexercise(week,day,workplanid,exerciseid) 
    VALUES('$week','$day','$workplanId','$exerciseid')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    $connect->close();
}
//get menu Id by name function
function getMenuId($name) {
    //get menu by "getMenus" function to compare name with name var send by function and return menu id
    $menus = getMenus();
    $totalMenus = count((array)getMenus());
    $id = 0;
    for ($i = 0;$i < $totalMenus;$i++) {
        if ($menus[$i]->name == $name) $id = $menus[$i]->idMenu;
    }
    return $id;
    $connect->close();
}
//get get exercise Id by exercise name function
function getExerciseId($name) {
    //get exercise by "getExercises" function to compare name with name var send by function and return exercise id
    $exercises = getExercises();
    $totalExercises = count((array)getExercises());
    for ($i = 0;$i < $totalExercises;$i++) {
        if ($exercises[$i]->name == $name) $id = $exercises[$i]->id;
    }
    return $id;
    $connect->close();
}
//get exercises in work plan Details function
function getExercisesInWorkPlan($workPlanId) {
    global $connect;
    //get exercises in work plan Details query
    $query = "SELECT * FROM workplanexercise WHERE workplanid='$workPlanId'";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $exerciseInWorkplan = null;
    $i = 0;
    //get exercises in work plan Details and save in array "exerciseInWorkplan"
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $data_item['week'] = $row_c['week'];
        $data_item['day'] = $row_c['day'];
        $data_item['workplanid'] = $row_c['workplanid'];
        $data_item['exerciseid'] = $row_c['exerciseid'];
        //save in 'data_item' in 'exerciseInWorkplan'
        $exerciseInWorkplan[$i] = $data_item;
        $i++;
    }
    return $exerciseInWorkplan;
    $connect->close();
}
//get subscription by id and status
function getSubsDetails($Trainerid, $status) {
    //subscription object
    $subscription = null;
    //get trainers by "getSubscriptions" function and return trainer object equal trainer id and status
    $trainer = getSubscriptions($status);
    $count = count((array)getSubscriptions($status));
    for ($i = 0;$i < $count;$i++) {
        if ($trainer[$i]->id == $Trainerid) $subscription = $trainer[$i];
    }
    return $subscription;
    $connect->close();
}
////update signup for lesson status (ok/cancel) function
function updateLessonRegisterStatus($userid, $lessonnumber, $status) {
    global $connect;
    //check if status is 'cancel'
    if ($status == 'cancel') {
        //update status to 'cancel' query
        $query = "UPDATE userinlesson SET status='$status' where userid='$userid' AND lessonnumber='$lessonnumber'";
        //execute query
        $exec = mysqli_query($connect, $query);
    }
    //check if status is 'ok'
    else if ($status == 'ok') {
        //get number of registers for lesson  and max trainer belong lesson number
        $select = "select registers,maxtrainers from lesson where lessonnumber='$lessonnumber'";
        //execute query
        $run_c = mysqli_query($connect, $select);
        if (mysqli_num_rows($run_c) > 0) {
            $row_c = mysqli_fetch_array($run_c);
            //get variables (registers and maxtrainers)
            $registers = $row_c['registers'];
            $maxtrainers = $row_c['maxtrainers'];
            //if is place in lesson
            if ($registers < $maxtrainers) {
                //update lesson registers number+1 query
                $query1 = "UPDATE Lesson SET registers=registers+1 where lessonnumber='$lessonnumber'";
                //execute query
                $exec = mysqli_query($connect, $query1);
                //update userinlesson trainer status 'ok'
                $query2 = "UPDATE userinlesson SET status='$status' where userid='$userid' AND lessonnumber='$lessonnumber'";
                //execute query
                $exec = mysqli_query($connect, $query2);
                return 1;
            }
            //if status is 'ok' but noplace in lesson
            else {
                //update userinlesson trainer status 'cancel'
                $query3 = "UPDATE userinlesson SET status='cancel' where userid='$userid' AND lessonnumber='$lessonnumber'";
                //execute query
                $exec = mysqli_query($connect, $query3);
                return 0;
            }
        }
    }
    $connect->close();
}
//update Lessons Status (if lesson date expired) function this function call always
function updateLessonsStatus() {
    global $connect;
    //get date now
    $timeNow = new DateTime("now", new DateTimeZone('Asia/Tel_Aviv'));
    $date = $timeNow->format('Y-m-d');
    //check if date now bigger than lesson date if yes chang lesson to 'not active'
    $query = "UPDATE lesson SET status='not active' WHERE startDate < '$date'";
    //execute query
    $exec = mysqli_query($connect, $query);
}
//get Subscription Type Price by name function
function getSubscriptionTypePrice($name) {
    $price = 0;
    //get Subscription Type details to compare Subscription Type name send by function with Subscription Type objects
    $types = getSusbcriptionTypDetails();
    $totalSusbcriptionType = count((array)getSusbcriptionTypDetails());
    for ($i = 0;$i < $totalSusbcriptionType;$i++) {
        if ($types[$i]['name'] == $name) $price = $types[$i]['price'];
    }
    return $price;
    $connect->close();
}
//get users names and emails to check if userme or email exist in system function
function getUsersNamesAndEmails() {
    global $connect;
    //get all users in system by "userlogin" table
    $query = "SELECT * FROM userlogin";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $users = null;
    $i = 0;
    ////get all users in system and save in "users" array
    while ($row_c = mysqli_fetch_array($resultSet)) {
        $users[$i]['username'] = $row_c['username'];
        $users[$i]['email'] = $row_c['email'];
        $i++;
    }
    return $users;
    $connect->close();
}
//check if trainer answer for Feedback function
function isTrainerAnswerForFeedback($Trainerid) {
    global $connect;
    //get feedback query by trainer id
    $query = "SELECT * FROM feedbacktrainers WHERE trainerid='$Trainerid'";
    //execute query
    $run_c = mysqli_query($connect, $query);
    //if trainer answer for feedback return 1 else return 0
    if (mysqli_num_rows($run_c) > 0) {
        return 1;
    } else return 0;
}
//update feedback answer function
function updateFeedback($trainerid, $workplanid, $answer) {
    global $connect;
    //update trainer 'feedback' column from 0 to 1
    $query = "UPDATE trainer SET feedback='1' where id='$trainerid'";
    //execute query
    $exec = mysqli_query($connect, $query);
    //update feedback answer query
    $insertData = "INSERT INTO feedbacktrainers(trainerid,workplanid,answer) 
    VALUES('$trainerid','$workplanid','$answer')";
    //execute query
    $run_c = mysqli_query($connect, $insertData);
    //send workplanid to csv function for check forupdate weight in csv file
    require_once ('../mlAlgorithm.php');
    //insert DecidsionTreeAlgorithm object for use updateWeights function then send workplan id
    $checkForUpdateDataset = new DecidsionTreeAlgorithm();
    $checkForUpdateDataset->updateWeights($workplanid);
}
//get subscribe left days function
function getLeftDays($Trainerid) {
    //get subscription details by "getSubsDetails" function
    $trainer = getSubsDetails($Trainerid, 'active');
    //get subscription register date
    $startDate = $trainer->subscriptionStartDate;
    //get Susbcription Type Details for get duration
    $types = getSusbcriptionTypDetails();
    $duration = 0;
    $days = 0;
    $totalSusbcriptionType = count((array)getSusbcriptionTypDetails());
    //compare trainer subscription type name with Susbcription Type names for get duration
    for ($i = 0;$i < $totalSusbcriptionType;$i++) {
        if ($types[$i]['name'] == $trainer->subscriptionType) $duration = $types[$i]['duration'];
    }
    //if duration is not zero
    if ($duration > 0) {
        //diff duration with subscription register date and return left days
        $date1 = date_create(date("Y-m-d"));
        $date2 = date_create($startDate);
        $diff = date_diff($date1, $date2);
        $days = $duration - $diff->format("%a");
    }
    return $days;
}
//get feedbacks by workplan and answer function
function getWorkplanFeedbacks($workplanId, $answer) {
    global $connect;
    //if answer is yes or no
    if ($answer == "yes" || $answer == "no") {
        //get number of feedback by answer belong workplan id query
        $query = "SELECT * FROM feedbacktrainers WHERE workplanid='$workplanId' AND answer='$answer'";
        //execute query
        $run_c = mysqli_query($connect, $query);
        //return number of feedback by andwer belong workplan id
        if (mysqli_num_rows($run_c) > 0) {
            return mysqli_num_rows($run_c);
        }
    } else {
        //if answer not yes or no return numbe of all feddbacks belongs workplan id
        $query = "SELECT * FROM feedbacktrainers WHERE workplanid='$workplanId'";
        //execute query
        $run_c = mysqli_query($connect, $query);
        return mysqli_num_rows($run_c);
    }
}
//get total instuments need to test function
function instrumentNeedToCheck() {
    //get instrument details by "getInstrumentsDetails" function
    $instruments = getInstrumentsDetails();
    $totalInstruments = count((array)getInstrumentsDetails());
    $total = 0;
    for ($i = 0;$i < $totalInstruments;$i++) {
        //get total instuments need to test (time now <= for instrument test date )
        $testdate = $instruments[$i]->testDate;
        $date1 = date_create(date("Y-m-d"));
        $date2 = date_create($testdate);
        $diff = date_diff($date1, $date2);
        if ($diff->format("%a") <= 14) $total++;
    }
    return $total;
}
//check forgot pasword details function
function checkForgotPasswordData($username, $email, $question, $answer) {
    global $connect;
    //get all 'forgotpassword' table details equal send function details
    $query = "SELECT * FROM forgotpassword WHERE username='$username' AND email='$email' 
    AND question='$question' AND answer='$answer'";
    $resultSet = mysqli_query($connect, $query);
    //if data exist return 1 else return 0
    if (mysqli_num_rows($resultSet) > 0) {
        return 1;
    } else return 0;
}
//set new password function
function setNewPassword($password, $username, $email) {
    global $connect;
    //get user login type that email and username equal variable send by function
    $query = "SELECT type FROM userlogin WHERE username='$username' AND email='$email' AND status='active'";
    //execute query
    $resultSet = mysqli_query($connect, $query);
    $type = '';
    //get user login type
    if (mysqli_num_rows($resultSet) > 0) {
        $row_c = mysqli_fetch_array($resultSet);
        $type = $row_c['type'];
    }
    if ($type != '') {
        //update userlogin table login password
        $query = "UPDATE userlogin SET password='$password' where username='$username' AND email='$email'";
        $exec = mysqli_query($connect, $query);
        //if type is trainer update trainer table password
        if ($type == 'trainer') {
            $query = "UPDATE trainer SET password='$password' WHERE user_name='$username' AND email='$email'";
            $exec = mysqli_query($connect, $query);
            return 1;
        }
        //if type is normal user update normal user table password
        if ($type == 'user') {
            $query = "UPDATE normal_user SET password='$password' WHERE user_name='$username' AND email='$email'";
            $exec = mysqli_query($connect, $query);
            return 1;
        }
    } else return 0;
}
//set new workplan for trainer (update workplan) function
function setNewWorkplanForTrainer($trainerId, $workplanName) {
    global $connect;
    //get workplan by "getWorkPlans" function to get workplan id belong work plan name
    $plans = getWorkPlans();
    $totalWorkplans = count((array)getWorkPlans());
    $workplanid = 0;
    for ($i = 0;$i < $totalWorkplans;$i++) {
        if ($plans[$i]->name == $workplanName) $workplanid = $plans[$i]->id;
    }
    if ($workplanid != 0) {
        //update workplan id
        $query = "UPDATE trainer SET work_plan_id='$workplanid' WHERE id='$trainerId'";
        $exec = mysqli_query($connect, $query);
    }
}
//check if user id login function
function checkStatus($id) {
    if ($_SESSION['id'] == $id) return true;
    else return false;
}
//get number of new orders from users(status 'padding')
function getNumberOfNewOrdesFromUsers() {
    //connect to database and get number of new orders from users status 'pending'
    global $connect;
    $query = "SELECT * FROM orderr WHERE type='user' AND status='pending'";
    $resultSet = mysqli_query($connect, $query);
    if (mysqli_num_rows($resultSet) > 0) return mysqli_num_rows($resultSet);
    else return 0;
}
//"update Subscribe Details function
function updateSubscripeDetails($id, $email, $address, $phonenumber, $status) {
    global $connect;
    //update trainer details query in trainer table
    $query = "UPDATE trainer SET email='$email', address='$address' , phonenumber='$phonenumber', status='$status' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
    //update trainer details query in userlogin table
    $query = "UPDATE userlogin SET status='$status', email='$email' where id='$id'";
    //execute query
    $exec = mysqli_query($connect, $query);
}
?>