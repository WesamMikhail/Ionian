<?php
$this->getView("HeaderView.php");
foreach($this->data as $member){
    echo $member . " <br/>";
}