<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 3600");

include_once("./config.php");

include_once("./Article.php");

// instantiate an article
$article = new Article($db);

$data = json_decode(file_get_contents("php://input"));

$article->title = $data->title;
$article->description = $data->description;
$article->published = $data->published;

if($article->createArticle()) {
    echo json_encode([
        "message" => "Article created"
    ]);
}else {
    echo json_encode([
        "message" => "Article not created"
    ]);
}

