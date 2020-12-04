<?php 
include 'header.php';
include 'connect.php';?>
        <div id=registrationform ></div>



        Please enter your registration details<br /><br />

        <form name= reg method=post action=reg.php onsubmit="checkForm()">

            <label for="fname">First name:</label><br>
            <input type=text name=firstname />
            <br />
            <label for="lname">Last name:</label><br>
            <input type=text name=lastname />
            <br />
            <label for="email">Email:</label><br>
            <input type=text name=email />
            <br />
            <label for="dofbirth">Date of Birth:</label><br>
            <input type=date  min="0000-01-01" max="2999-12-31" name=dob />
            <br />
            <label for="uname">Username:</label><br>
            <input type=text name=registerusername />
            <br />
            <label for="pword">Password:</label><br>
            <input type=text name=registerpassword />
            <br /><br>
            <input type=submit name=regsubmit value=Registreer />  <br> <br>
            <a href="<?php echo 'inlog.php'; ?>" style="left: 700px"> Inloggen </a>
            <script>

                function mypage(){
                    alert ("sign up is sucessful go to login")
                }
            </script>

        </form>
    </div>
    <script>
        function checkForm(){
            valid = true;

            if ( document.reg.registerpassword.value == "" )
            {
                alert ( "Please fill in your password" );
                document.reg.registerpassword.focus()
                valid = false;
            }

            return valid;

        }

    </script>
<?php



if (isset($_POST['regsubmit'])) {
    print_r($_POST);
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $user = $_POST['registerusername'];

    $pass = $_POST['registerpassword'];
    $query = "INSERT INTO customersgegevens(firstname, lastname, email, dob, username, password) VALUES(?,?,?,?,?,?)";

    $statement = mysqli_prepare($Connection, $query);
    mysqli_stmt_bind_param($statement, 'sissss', $firstname, $lastname, $email, $dob, $user, $pass);
    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

}



?>



    </body>
</html>
