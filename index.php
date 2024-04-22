<?php
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    include_once "backend/submitFunctions.php";

    submitFunctions::insertIntoTable("paamelding", [
        "fornavn" => $_POST['fornavn'],
        "etternavn" => $_POST['etternavn'],
        "email" => $_POST['email'],
    ]);
    echo "$_POST[fornavn] $_POST[etternavn] er lagt til i databasen";
}

$page["title"] = "Påmelding for Wolfenstein Lan";

$page["body"] = function () {
    global $page;
    ?>
    <h1><?php echo $page["title"]; ?></h1>

    <form action="" method="post">
        <label for="fornavn">Fornavn</label>
        <input type="text" name="fornavn" id="fornavn" placeholder="Fornavn">
        <label for="etternavn">Etternavn</label>
        <input type="text" name="etternavn" id="etternavn" placeholder="Etternavn">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Email">
        <button type="submit">Meld Deg På</button>
    </form>

<?php };

include('template.php');
