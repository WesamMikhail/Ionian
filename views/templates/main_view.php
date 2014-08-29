<?php
$this->setTitle("VIEW PAGE!");
$this->addCSS("test.css");
$this->addJS("test.js");
?>
<!DOCTYPE HTML>
<html>
<head>
    <!-- Document Title Dynamically loaded -->
    <?php
    //Title has to be in a variable because empty does not execute on a function as value!
    $title = $this->getTitle();

    if (!empty($title))
        echo "<title>" . $this->getTitle() . "</title>";
    else
        echo "<title>" . APPLICATION_NAME . "</title>";
    ?>

    <!-- HTML5 CSS RESET SHEET -->
    <link href='<?php echo $this->getCSSLink("reset.css") ?>' rel='stylesheet' type='text/css'>

    <!-- Document CSS Files Dynamically loaded -->
    <?php foreach ($this->getCSS() as $file) echo "<link href='$file' rel='stylesheet' type='text/css'>"; ?>

    <!-- Document JS Files Dynamically loaded -->
    <?php foreach ($this->getJS() as $file) echo "<script src='$file' type='text/javascript'></script>"; ?>
</head>
<body>
    <div>
        <?php
            print_r($this->data);
        ?>
    </div>
</body>
</html>