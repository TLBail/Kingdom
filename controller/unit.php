<?php

include_once();


if (isset($_GET['addUnite'])) {
    echo 'ajout de ' . $_GET['addUnite'] .  $_GET['addUniteName'];
    addUnit($_GET['addUniteName'],$_GET['addUnite']);
}
