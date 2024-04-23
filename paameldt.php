<?php
include_once "backend/getFromDatabase.php";
include_once "funksjoner/automagic.php";

$page["title"] = "Påmeldte";

$page["body"] = function () {
    echo automagic::automagicTable(getFromDatabase::table("paamelding"));
};

include('template.php');
