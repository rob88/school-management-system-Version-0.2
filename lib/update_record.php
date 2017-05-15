  <?php
   
      

                           // get passed parameter value, in this case, the record ID
                           // isset() is a PHP function used to verify if a value is there or not
  $id=isset($_GET['id']) ? $_GET['id'] : die('ERROR: Record ID not found.');

            // include database connection
    
               
                           // read current record's data
  try {
 // include database connection
   include("../config/db_connector.php");
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
   $id = $row['id'];
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
                                // $id=htmlspecialchars(strip_tags($_POST['id']));
                                 $school_name=htmlspecialchars(strip_tags($_POST['school_name']));
                                 $email=htmlspecialchars(strip_tags($_POST['email']));

                                   // bind the parameters
                                 $stmt->bindParam(':name', $name);
                                 $stmt->bindParam(':school_name', $school_name);
                                 $stmt->bindParam(':email', $email);
                                 $stmt->bindParam(':id', $id);

                                   // Execute the query
                                 if($stmt->execute()){
                                    echo"<img src='..\img/updating.gif'>";
                                    echo "<div class='alert alert-success'>"." <h2>Please Wait....</h2><br/>Your New Record Is Saved!!!!!!</div>";
                                    header('Location: ..\read.php');
                                     ?>
                                    

                                <?php
                            }else{
                               echo "<div class='alert alert-danger'>Unable to update record. Please try again.</div>";
                                   }//end else

                                        

                               }//end try

                               // show errors
                               catch(PDOException $exception){
                                   die('ERROR: ' . $exception->getMessage());
                               }// end error handling 

                           }// if($_POST)


                          // die;//hide the form after the member information updated 
 ?>