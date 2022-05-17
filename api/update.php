<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With");


include_once("./config.php");

include_once("./Article.php");

// instantiate an article
$article = new Article($db);

$data = json_decode(file_get_contents("php://input"));

$article->id = $data->id;
$article->title = $data->title;
$article->description = $data->description;
$article->published = $data->published;


$res_arr = $article->updateArticle();
if (!$res_arr["exists"]) {
    echo json_encode([
        "message" => "Article not found"
    ]);
} else {
    if ($res_arr["done"]) {
        echo json_encode([
            "message" => "Article updated"
        ]);
    } else {
        echo json_encode([
            "message" => "Article not updated"
        ]);
    }
}
