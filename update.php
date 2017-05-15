<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>Update Record</title>
      <!-- Sets initial viewport load and disables zooming  -->
      <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
      <!-- SmartAddon.com Verification -->
      <meta name="smartaddon-verification" content="936e8d43184bc47ef34e25e426c508fe" />
      <meta name="keywords" content=" London School Management System">
      <meta name="school_name" content="This is a simple School Management System">
      <link rel="shortcut icon" href="favicon_16.ico"/>
      <link rel="bookmark" href="favicon_16.ico"/>
      <!-- site css -->
      <link rel="stylesheet" href="css/site.min.css">
      <link rel="stylesheet" href="css/custom.css">
      <!-- <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'> -->
      <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
      <script type="text/javascript" src="js/site.min.js"></script>
   </head>
   <body >
  <?php include("navbar.php");?>
     <div class="container">
     <div class="row">
        <ol class="breadcrumb breadcrumb-arrow ">
           <div class="col-md-8">
               <li><a href="index.php"><i class="glyphicon glyphicon-home"></i> Home</a></li>
               <li ><span><i class="glyphicon glyphicon-comment"></i> Add New Record</span></li>
               <li><a href="select.php"><i class="glyphicon glyphicon-list"></i> Select School</a></li>
               <li><a href="read.php"><i class="glyphicon glyphicon-user"></i> Display All Members</a></li>
            </ol>
           </div><!-- /.col-xsm-4  -->
           </div>
           </div>
          <div class="container">
           <div class="row">
         <h4 class="example-title">Here You Can Update Details  </h4>
         <div class="row">
            <div class="col-md-12">
               <div class="panel panel-primary">
                  <div class="panel-heading">
                     <h2 class="panel-title"><strong>Add New Record</strong></h2>
                  </div>
                  <div class="panel-body">
                     <div class="col-md-6">
                        <?php
                           // get passed parameter value, in this case, the record ID
                           // isset() is a PHP function used to verify if a value is there or not
                                       $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');
                           
                           //include database connection
                                       include 'config/db_connector.php';
                           
                           // read current record's data
                                       try {
                               // prepare select query
                                         $query = "SELECT * FROM school_ WHERE id = ? LIMIT 0,1";
                                         $stmt = $con->prepare( $query );
                           
                               // this is the first question mark
                                         $stmt->bindParam(1, $id);
                           
                               // execute our query
                                         $stmt->execute();
                           
                               // store retrieved row to a variable
                                         $row = $stmt->fetch(PDO::FETCH_ASSOC);
                           
                               // values to fill up our form
                                         $name = $row['name'];
                                         $school_name = $row['school_name'];
                                         $email = $row['email'];
                           }//end try
                           
                           // show error
                           catch(PDOException $exception){
                             die('ERROR: ' . $exception->getMessage());
                           }//catch() end data retrieving 
                           
                           // check if form was submitted
                           if($_POST){
                           
                             try{
                           
                                   //  update query in this case, it seemed like we have so many fields to pass and 
                                   // it is better to label them and not use question marks
                               $query = "UPDATE school_ 
                               SET name=:name, school_name=:school_name, email=:email 
                               WHERE id = :id";
                           
                                   // prepare query for excecution
                               $stmt = $con->prepare($query);
                           
                                   // posted values
                               $name=htmlspecialchars(strip_tags($_POST['name']));
                               $school_name=htmlspecialchars(strip_tags($_POST['school_name']));
                               $email=htmlspecialchars(strip_tags($_POST['email']));
                           
                                   // bind the parameters
                               $stmt->bindParam(':name', $name);
                               $stmt->bindParam(':school_name', $school_name);
                               $stmt->bindParam(':email', $email);
                               $stmt->bindParam(':id', $id);
                           
                                   // Execute the query
                               if($stmt->execute()){
                                echo"<img src='img/updating.gif'>";
                                echo "<div class='alert alert-success'>"." <h2>Please Wait....</h2><br/>Your New Record Is Saved!!!!!!</div>";
                                echo" ";
                           
                                ?>
                        <!-- Redirect To display all record page -->
                        <script type="text/javascript"> 
                           $(window).load(function () {
                            window.setTimeout(function () {
                             window.location.href = "read.php";
                           }, 2000)<!-- 1000 ms = 1 second -->
                           });
                        </script><!--/.load()-->
                        <?php
                           }else{
                             echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                                   }//end else
                           
                                          die;//hide the form after the member information updated 
                           
                               }//end try
                           
                               // show errors
                               catch(PDOException $exception){
                                 die('ERROR: ' . $exception->getMessage());
                               }
                             }
                             ?>
                        <!--we have our html form here where new user information will be entered-->
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
                           <table class='table table-hover table-responsive table-bordered'>
                              <tr>
                                 <td>Name</td>
                                 <td><input type='text' name='name' value="<?php echo htmlspecialchars($name, ENT_QUOTES);  ?>" class='form-control' /></td>
                              </tr>
                              <tr>
                                 <td>school_name</td>
                                 <td><textarea name='school_name' class='form-control'><?php echo htmlspecialchars($school_name, ENT_QUOTES);  ?></textarea></td>
                              </tr>
                              <tr>
                                 <td>email</td>
                                 <td><input type='text' name='email' value="<?php echo htmlspecialchars($email, ENT_QUOTES);  ?>" class='form-control' /></td>
                              </tr>
                              <tr>
                                 <td></td>
                                 <td>
                                    <input type='submit' value='Save Changes' class='btn btn-primary' />
                                    <a href='read.php' class='btn btn-danger'>Back to read products</a>
                                 </td>
                              </tr>
                           </table>
                        </form>
                     </div>
                     <!-- /.col-md-6-->
                  </div>

  


                  <!-- /.panel-body--> 
               </div>
               <!-- /.panel panel-primary-->
            </div>
            <!-- /.col-md-12-->
            <div class="copyright clearfix">
               <p>&copy; 2017 <a href="https://github.com/rob88/School-Management-System" target="_blank">My github</a>,  Inc. All rights reserved.</p>
            </div>
            <!-- /.copyright  -->
         </div>
         <!-- /.row  -->
      </div>
      <!-- /.container> -->
   </body>
</html>