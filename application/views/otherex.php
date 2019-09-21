<!DOCTYPE html>
<html lang="en">
<body>

<?php
  $account=$name=$gender=$date=$email=$remark="";
  $erracc=$errnam=$errgen=$errdate=$erremail=$errrem="";
# 設定必填項目
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["account"])) {
      $erracc="Account is required";
    } else {
      $account=test_input($_POST["account"]);
      if (!preg_match("/^[A-Za-z]{1,}[0-9]{1,}[A-Za-z]*[0-9]*/",$account)) {
      $erracc="";
      }
    }
  
    if (empty($_POST["name"])) {
      $errnam="Name is required";
    } else {
      $name = test_input($_POST["name"]);
    }
    
    if (empty($_POST["gender"])) {
      $errgen="Gender is required";
    } else {
      $gender=test_input($_POST["gender"]);
    }

    if (empty($_POST["date"])) {
      $errdate="Date is required";
    } else {
      $date=test_input($_POST["date"]);
    }

    if (empty($_POST["email"])) {
      $erremail="Email is required";
    } else {
      $email=test_input($_POST["email"]);
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr="Invalid email format";
      }
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
?>


<h2> Account Info </h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
  Account: <input type="text" name="account" value="<?php echo $account;?>">
  <span class="error">* <?php echo $erracc;?></span>
  <br><br>

  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $errnam;?></span>
  <br><br>

  Gender:
  <input type="radio" name="gender"
  <?php if (isset($gender) && $gender=="female") echo "checked";?>
  value="female">Female
  <input type="radio" name="gender"
  <?php if (isset($gender) && $gender=="male") echo "checked";?>
  value="male">Male
  <input type="radio" name="gender"
  <?php if (isset($gender) && $gender=="other") echo "checked";?>
  value="other">Other
  <br><br>

  Date: <input type="date" name="date" value="<?php echo ".date("Y年m月d日",$date).";?>">
  <span class="error"> * <?php echo $errdate;?></span>
  <br><br>

  Email: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error"> * <?php echo $erremail;?></span>
  <br><br>

  Remark: <textarea name="remark" rows="5" cols="40"><?php echo $remark;?></textarea>
  <br><br>
  <input type="submit" name="submit" value="Submit">
?>


<?php
  $servername="localhost";
  $username="aaaviv";
  $password=606650025;
  # 連線 mySQL
  $conn=new mysqli($servername,$username,$password);
  # 檢查連線
  if ($conn->connect_error) {
    die("Connection failed:".$conn->connect_error);
  }

  $sqlstate="CREATE DATABASE myDB";
  if ($conn->query($sqlstate) === TRUE) {
    echo "Database created successfully";
  } else {
    echo "Error creating database:".$conn->error;
}

# 建立資料庫
  $sql="CREATE DATABASE myDB (
    Account VARCHAR(15) NOT NULL PRIMARY KEY,
    Name VARCHAR(30) NOT NULL,
    Gender enum('Male','Female') NOT NULL,
    Date DATETIME NOT NULL,
    Email VARCHAR(30) NOT NULL,
    Remark VARCHAR(200),
  )";

  $sql="INSERT INTO myDB (Account,Name,Gender,Date,Email,Remark) 
  VALUES ($account,$name,$gender,$date,$email,$remark)";


  $conn->close();
?>

</body>
</html>

