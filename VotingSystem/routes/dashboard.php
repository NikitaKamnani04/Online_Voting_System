<?php

   session_start();   //whenever we use session variable we start the session 
   if(!isset($_SESSION['userdata'])){     //user session is not activated so that we are on login page only
    header("location: ../");   //shift on home page
   }
   
   $userdata=$_SESSION['userdata'];    //userdata is an array
   $groupsdata=$_SESSION['groupsdata'];

   if($_SESSION['userdata']['status']==0){
    $status='<b style="color:red">Not Voted</b>';
   }
   else{
    $status='<b style="color:green">Voted</b>';
   }

?>

<html>
    <head>
        <title>public opinion poll-Dashboard</title>
        <link rel="stylesheet" href="../css/stylesheet.css">
    </head>
    <body>
     
    <style>
        #backbtn{
            padding: 5px;
            border-radius: 10px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            float:left;
            margin:10px;
            background: linear-gradient(
        to right,
        #a517ba,#5f1178 
    );
        }
        #logoutbtn{
            padding: 5px;
            border-radius: 10px;
            background-color: #3498db;
           color: white;
            border-radius: 5px;
            float:right;
            margin:10px;
            background: linear-gradient(
        to right,
        #a517ba,#5f1178 
    );
        }
        #Profile{
            background-color:white;
            width:30%;
            padding:20px;
            float:left;
        }
        #Group{
            background-color:white;
            width:40%;
            padding:10px;
            float:right;
        }
        #votebtn{
            padding: 5px;
            border-radius: 5px;
            background-color: #3498db;
            color: white;
            border-radius: 5px;
            float:left;
            background: linear-gradient(
        to right,
        #a517ba,#5f1178 
    );
        }
        #mainpanel{
          padding:10px;
        }
        #voted{
            padding: 5px;
            border-radius: 10px;
            background-color: green;
            color: white;
            border-radius: 5px;
        }
    </style>



    <div id="mainSection">
    <center>
       <div id="headerSection">
        <a href="../"><button id="backbtn">Back</button></a>
        <a href="logout.php"><button id="logoutbtn">Logout</button></a>
        <h1 style="color: white; margin-top: 10px;" class=" ">Online Voting System</h1>
    </div>
    </center>
    <hr>
    <div id="mainpanel">
    <div id="Profile">
    <center><img src="../uploads/<?php echo $userdata['photo'] ?>" height="100" width="100"></center><br><br>
    <b>Name:</b> <?php echo $userdata['name']?><br><br>
    <b>Mobile:</b> <?php echo $userdata['mobile']?><br><br>
    <b>Address:</b> <?php echo $userdata['address']?><br><br>
    <b>Status:</b> <?php echo $status?><br><br>
    </div>
   <div id="Group">
     <?php
       if($_SESSION['groupsdata']){
         for($i=0; $i<count($groupsdata); $i++){
              ?>
                <div>
                  <center>  <img style="margin: right" src="../uploads/<?php echo $groupsdata[$i]['photo'] ?>" height="50" width="100"></center><br>
                    <b> Group Name: </b><?php echo $groupsdata[$i]['name']?><br>
                    <b> Votes:     </b><?php echo $groupsdata[$i]['votes']?><br>
                    <form action="../api/vote.php" method="POST">
                        <input type="hidden" name="gvotes" value="<?php echo $groupsdata[$i]['votes']?>">
                        <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['id']?>">
                        <?php
                         if($_SESSION['userdata']['status']==0){
                          ?>
                              <input type="submit" name="votebtn" value="Vote" id="votebtn"><br>
                          <?php
                         }
                         else{
                          ?>
                          <button disabled type="button" name="votebtn" value="Vote" id="voted">Voted</button>
                         <?php
                         }
                        ?>
                        
                       
                    </form>
                </div>
         <hr>
         
              <?php
         }
       }
       else{

       }
     ?>
   </div>
    </div>
    
   </div>
    </body>
</html>


