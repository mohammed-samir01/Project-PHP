<?php
     //data for connection
    $servername = "localhost";
    $username = "root";
    $pass = "";
    $dbname = "cafeteria";


    //error1
    if(!isset($_GET['dateFrom']) && !isset($_GET['dateTo'])){
        $error = 'ERROR: You did not select date or user';
        file_put_contents("user.json", "");
        header("location:../../resources/views/checksUser.php?error=".$error);
    }

    //error2
    if(isset($_GET['dateFrom']) && !isset($_GET['dateTo'])){
        $error = 'ERROR: Please select date from And date to';
        file_put_contents("user.json", "");
        header("location:../../resources/views/checksUser.php?error=".$error);
    }

    //error3
    if(!isset($_GET['dateFrom']) && isset($_GET['dateTo'])){
        $error = 'ERROR: Please select date from And date to';
        file_put_contents("user.json", "");
        header("location:../../resources/views/checksUser.php?error=".$error);
    }


    



    //when admin select only dates
    if(isset($_GET['dateFrom']) && isset($_GET['dateTo'])){
        //database connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //get the selected user
        $sql = "select orders.id ,orders.created_at ,orders.action ,orders.order_status, users.name , product_orders.quantity*products.price as TOTAL from orders ,users , product_orders, products  where users.id = orders.id_users AND products.id = product_orders.id_products AND orders.id = product_orders.id_orders  AND created_at BETWEEN '{$_GET['dateFrom']}' AND '{$_GET['dateTo']}'";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $stm->setFetchMode(PDO::FETCH_ASSOC);   //delete the repeat
        $users = $stm->fetchAll();
        // var_dump($_GET['dateFrom']);
        $jUsers = json_encode($users);
        $jFile = fopen("user.json", "w");
        fwrite($jFile,$jUsers);
        header("location:../../resources/views/checksUser.php");
        // var_dump($users[0]['name']);

        

        // //users
        // echo "<table border=1 >";

        // foreach ($users as $user) {
        //         echo "<tr> <td>" .$user['name']."</td> </tr>";
        // }
 
        // echo "</table> <br> <br>" ;    

                




        // //orders
        // echo "<table border=1>";

        // foreach ($users as $user) {
        //         echo "<tr> <td>" .$user['created_at']."</td> </tr>";
        // }

        // echo "</table>";  
    }


   
       



                    
            
?>
