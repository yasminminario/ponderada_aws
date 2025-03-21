<?php include "../inc/dbinfo.inc"; ?>
<html>
<head>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 20px; }
    h1, h2 { color: #333; }
    table { border-collapse: collapse; width: 60%; margin-bottom: 20px; background: #fff; }
    td { padding: 8px; border: 1px solid #ccc; }
    input[type="text"], input[type="number"] { padding: 5px; }
    input[type="submit"] { padding: 6px 12px; background: #4CAF50; color: white; border: none; cursor: pointer; }
    input[type="submit"]:hover { background: #45a049; }
  </style>
</head>
<body>

<h1>Employees and Products</h1>

<?php
// Conexão com o banco
$connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
if (mysqli_connect_errno()) echo "Erro de conexão: " . mysqli_connect_error();
mysqli_select_db($connection, DB_DATABASE);

// Cria tabelas se não existirem
VerifyEmployeesTable($connection);
VerifyProductsTable($connection);

// Adiciona employee
if (!empty($_POST['ENAME']) || !empty($_POST['EADDRESS'])) {
  AddEmployee($connection, $_POST['ENAME'], $_POST['EADDRESS']);
}

// Adiciona product
if (!empty($_POST['PNAME']) && is_numeric($_POST['PPRICE'])) {
  AddProduct($connection, $_POST['PNAME'], $_POST['PPRICE']);
}
?>

<!-- Formulário de funcionário -->
<h2>Add Employee</h2>
<form method="POST">
  <input type="text" name="ENAME" placeholder="Name" maxlength="45" />
  <input type="text" name="EADDRESS" placeholder="Address" maxlength="90" />
  <input type="submit" value="Add" />
</form>

<!-- Formulário de produto -->
<h2>Add Product</h2>
<form method="POST">
  <input type="text" name="PNAME" placeholder="Product Name" maxlength="50" />
  <input type="number" step="0.01" name="PPRICE" placeholder="Price" />
  <input type="submit" value="Add" />
</form>

<!-- Lista de funcionários -->
<h2>Employees List</h2>
<table>
  <tr><td>ID</td><td>Name</td><td>Address</td></tr>
  <?php
  $res = mysqli_query($connection, "SELECT * FROM EMPLOYEES");
  while($row = mysqli_fetch_row($res)) {
    echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>{$row[2]}</td></tr>";
  }
  ?>
</table>

<!-- Lista de produtos -->
<h2>Products List</h2>
<table>
  <tr><td>ID</td><td>Name</td><td>Price</td><td>Created At</td></tr>
  <?php
  $res = mysqli_query($connection, "SELECT * FROM PRODUCTS");
  while($row = mysqli_fetch_row($res)) {
    echo "<tr><td>{$row[0]}</td><td>{$row[1]}</td><td>R$ ".number_format($row[2],2,',','.')."</td><td>{$row[3]}</td></tr>";
  }
  mysqli_free_result($res);
  mysqli_close($connection);
  ?>
</table>

</body>
</html>

<?php
// Funções de banco
function AddEmployee($conn, $name, $addr) {
  $n = mysqli_real_escape_string($conn, $name);
  $a = mysqli_real_escape_string($conn, $addr);
  mysqli_query($conn, "INSERT INTO EMPLOYEES (NAME, ADDRESS) VALUES ('$n', '$a')");
}

function AddProduct($conn, $name, $price) {
  $n = mysqli_real_escape_string($conn, $name);
  $p = floatval($price);
  mysqli_query($conn, "INSERT INTO PRODUCTS (NAME, PRICE) VALUES ('$n', '$p')");
}

function VerifyEmployeesTable($conn) {
  mysqli_query($conn, "CREATE TABLE IF NOT EXISTS EMPLOYEES (ID int AUTO_INCREMENT PRIMARY KEY, NAME VARCHAR(45), ADDRESS VARCHAR(90))");
}

function VerifyProductsTable($conn) {
  mysqli_query($conn, "CREATE TABLE IF NOT EXISTS PRODUCTS (ID int AUTO_INCREMENT PRIMARY KEY, NAME VARCHAR(50), PRICE DECIMAL(10,2), CREATED_AT TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
}
?>
