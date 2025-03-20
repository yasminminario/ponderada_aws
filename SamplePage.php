<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Sample page - Employees and Products</h1>
<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

  $database = mysqli_select_db($connection, DB_DATABASE);

  VerifyEmployeesTable($connection, DB_DATABASE);
  VerifyProductsTable($connection, DB_DATABASE);

  $employee_name = htmlentities($_POST['ENAME']);
  $employee_address = htmlentities($_POST['EADDRESS']);

  if (strlen($employee_name) || strlen($employee_address)) {
    AddEmployee($connection, $employee_name, $employee_address);
  }

  $product_name = htmlentities($_POST['PNAME']);
  $product_price = htmlentities($_POST['PPRICE']);

  if (strlen($product_name) && is_numeric($product_price)) {
    AddProduct($connection, $product_name, $product_price);
  }
?>

<h2>Add Employee</h2>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>NAME</td>
      <td>ADDRESS</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="ENAME" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="EADDRESS" maxlength="90" size="60" />
      </td>
      <td>
        <input type="submit" value="Add Employee" />
      </td>
    </tr>
  </table>
</form>

<h2>Add Product</h2>
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>PRODUCT NAME</td>
      <td>PRICE</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="PNAME" maxlength="50" size="30" />
      </td>
      <td>
        <input type="number" step="0.01" name="PPRICE" />
      </td>
      <td>
        <input type="submit" value="Add Product" />
      </td>
    </tr>
  </table>
</form>

<h2>Employees List</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>ADDRESS</td>
  </tr>
<?php
$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");
while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>",$query_data[2], "</td>";
  echo "</tr>";
}
?>
</table>

<h2>Products List</h2>
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>NAME</td>
    <td>PRICE</td>
    <td>CREATED_AT</td>
  </tr>
<?php
$result = mysqli_query($connection, "SELECT * FROM PRODUCTS");
while($query_data = mysqli_fetch_row($result)) {
  echo "<tr>";
  echo "<td>",$query_data[0], "</td>",
       "<td>",$query_data[1], "</td>",
       "<td>R$ ",number_format($query_data[2], 2, ',', '.'), "</td>",
       "<td>",$query_data[3], "</td>";
  echo "</tr>";
}
?>

</table>

<?php
  mysqli_free_result($result);
  mysqli_close($connection);
?>

</body>
</html>

<?php
function AddEmployee($connection, $name, $address) {
   $n = mysqli_real_escape_string($connection, $name);
   $a = mysqli_real_escape_string($connection, $address);

   $query = "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
}

function AddProduct($connection, $name, $price) {
   $n = mysqli_real_escape_string($connection, $name);
   $p = floatval($price);

   $query = "INSERT INTO PRODUCTS (NAME, PRICE) VALUES ('$n', '$p');";

   if(!mysqli_query($connection, $query)) echo("<p>Error adding product data.</p>");
}

function VerifyEmployeesTable($connection, $dbName) {
  if(!TableExists("EMPLOYEES", $connection, $dbName)) {
     $query = "CREATE TABLE EMPLOYEES (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(45),
         ADDRESS VARCHAR(90)
       )";
     if(!mysqli_query($connection, $query)) echo("<p>Error creating EMPLOYEES table.</p>");
  }
}

function VerifyProductsTable($connection, $dbName) {
  if(!TableExists("PRODUCTS", $connection, $dbName)) {
     $query = "CREATE TABLE PRODUCTS (
         ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
         NAME VARCHAR(50),
         PRICE DECIMAL(10,2),
         CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP
       )";
     if(!mysqli_query($connection, $query)) echo("<p>Error creating PRODUCTS table.</p>");
  }
}

function TableExists($tableName, $connection, $dbName) {
  $t = mysqli_real_escape_string($connection, $tableName);
  $d = mysqli_real_escape_string($connection, $dbName);

  $checktable = mysqli_query($connection,
      "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

  if(mysqli_num_rows($checktable) > 0) return true;

  return false;
}
?>
