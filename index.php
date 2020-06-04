<?php
require('./mysql.php');
$conn = connect();
$sql = "SELECT email, password FROM users";

/*$result  = $conn -> query($sql);
// Numeric array
$row = $result -> fetch_array(MYSQLI_NUM);
printf ("%s (%s)\n", $row[0], $row[1]);
$teachers = array();
*/

//$conn->query("INSERT INTO giang_vien (first_name, last_name) VALUES ('B','Nguyen Van')");
if (isset($_POST['first_name']) && isset($_POST['last_name'])) {
    $firstName = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    if (!empty($firstName) && !empty($last_name)) {
        $conn->query("INSERT INTO giang_vien (first_name, last_name) VALUES ('" . $firstName . "', '" . $last_name . "')");
    } else {
        print("Co loi xay ra!.");
    }

}

$users = array("Nguyen Van A", "Nguyen Van B", "Nguyen Van C");
?>
<?php require_once "./header.php"?>
<body>
<form action="index.php" method="POST">
    <div>
        <label>
            First
        </label>
        <input name="first_name" type="text"/>
    </div>

    <div>
        <label>
            Last
        </label>
        <input name="last_name" type="text"/>
    </div>

    <button type="submit">Them Giang Vien</button>
</form>

</form>

<h2>Sinh viên</h2>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Ten</th>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach ($users as $user) {
        $row = "<tr>

        <td>".$user."</td>
       
    </tr>";
        echo $row;
    }
    ?>


    </tbody>
</table>
<?php require_once "./footer.php"?>
</body>
</html>

<!--kyutyfhfhyfuul-->