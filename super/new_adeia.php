<?php
session_start();

// require the db configuration file to make the PDO connection to the db
require 'dbconfig.php';
// function to connect to the database
require 'connection.php';
// construct the pdo object to connect to the database
$pdo = connect($host, $db, $user, $password);

function list_leavetypes($pdo)
{
    //fetch user data from the database
    $sql = "SELECT * FROM leavetypes";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $rows = $statement->fetchAll();
    
    $types = array();
    foreach ($rows as $row) {
        //echo $row[0].' -> '.$row[1].'<br>';
        $types[$row[0]] = $row[1];
    }

    return $types;

}

function return_dept($dept, $pdo) 
{
    $sql = "SELECT deptname FROM departments WHERE iddept=?";
    $statement = $pdo->prepare($sql);
    $statement->execute([$dept]);
    $row = $statement->fetch();

    return $row['deptname'];
}

function return_supervisor($dept, $pdo)
{
    $sql = "SELECT supervisor FROM departments WHERE iddept=?";
    $statement = $pdo->prepare($sql);
    $statement ->execute([$dept]);
    $row = $statement->fetch();

    return $row['supervisor'];
}

$deptname = return_dept($_SESSION['department'], $pdo);
$types = list_leavetypes($pdo);
$_SESSION['supervisor'] = return_supervisor($_SESSION['department'], $pdo);

?>


<div class="spacer"></div>
<h1>Αίτηση νέας άδειας</h1>
<h2>Συμπληρώστε τα στοιχεία της αίτησής σας:</h2>
<div class="form-container">
<form class="pure-form pure-form-aligned" action="" method="post">
    <fieldset>
        <div class="pure-control-group">
            <label for="name">Όνομα</label>
            <input type="text" class="pure-input-1-3" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" readonly>
            <!--span class="pure-form-message-inline">This is a required field.</span-->
        </div>
        <div class="pure-control-group">
            <label for="surname">Επίθετο</label>
            <input type="text" class="pure-input-1-3" id="surname" name="surname" value="<?php echo$_SESSION['surname']; ?>" readonly>
        </div>
        <div class="pure-control-group">
            <label for="department">Τμήμα</label>
            <input type="text" class="pure-input-1-3" id="department" name="department" value="<?php echo $deptname; ?>" readonly>
        </div>
        <div class="pure-control-group">
            <label for="protocol">Αριθμός Πρωτ.</label>
            <input type="text" class="pure-input-1-3" id="protocol" name="protocol">
        </div>
        <div class="pure-control-group">
            <label for="protocoldate">Ημερομηνία Πρωτ.</label>
            <input type="date" class="pure-input-1-3" id="protocoldate" name="protocoldate">
        </div>
        <div class="pure-control-group">
            <label for="leavetype">Είδος άδειας</label>
            <select id="leavetype" class="pure-input-1-3">
                <?php
                foreach ($types as $typeid => $type) {
                    echo '<option value="'.$typeid.'">'.$type.'</option>';
                }
                ?>
            </select>
        </div>
        <div class="pure-control-group">
            <label for="startdate">Ημερομηνία έναρξης</label>
            <input type="date" class="pure-input-1-3" id="startdate" name="startdate">
        </div>
        <div class="pure-control-group">
            <label for="days">Αριθμός ημερών</label>
            <input type="text" class="pure-input-1-3" id="days" name="days">
        </div>
        <div class="pure-control-group">
            <label for="decription">Περιγραφή</label>
            <textarea class="pure-input-1-3" id="decription" name="decription" placeholder="Γράψτε μια περιγραφή της άδειας"></textarea>
        <div class="pure-controls">
            <button type="submit" class="pure-button pure-button-primary">Υποβολή</button>
        </div>
    </fieldset>
</form>
</div>

<script src="./js/form_new.js"></script>
<?php print_r($_SESSION); ?>
