<?php
$this->getView("HeaderView.php");
foreach($this->data as $member){
    echo $member . " <br/>";
}
?>
<form method="POST" enctype="multipart/form-data" action="/PHP-Framework/test/test2">
    <input type="file" name="foo" value=""/>
    <input type="submit" value="Upload File"/>
</form>