<?php

$page["title"] = "Påmelding for Wolfenstein Lan";

$page["body"] = function () {
    global $page;
    ?>
    <h1><?php echo $page["title"]; ?></h1>

    <form action="">
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
