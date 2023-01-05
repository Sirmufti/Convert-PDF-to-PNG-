<?php

use \ConvertApi\ConvertApi;
ConvertApi::setApiSecret('SD5V72tBTKzpqKb3');


$msg = "";
$contents = "";
$output = "";
if (isset($_POST["submit"])) {
    $filename = $_FILES["formFile"]["name"];
    $filetype = $_FILES["formFile"]["type"];
    $filetemp = $_FILES["formFile"]["tmp_name"];
    $dir = 'uploads/' . $filename;

    if ($filetype == "application/pdf") {
        move_uploaded_file($filetemp, $dir);
        $result = ConvertApi::convert(
            'png',
            [
                'File' => $dir,
            ],
            'pdf'
        );
        $contents = $result->getFile()->getContents();
        $output = "converted_files/" . rand() . ".png";
        $fopen = fopen($output, "w");
        fwrite($fopen, $contents);
        fclose($fopen);

        if ($result) {
            $msg = "<div class='alert alert-success'>File converted.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Something wrong.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid file format.</div>";
    }
}
