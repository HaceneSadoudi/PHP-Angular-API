<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Max-Age: 3600");

include_once("./config.php");

include_once("./Article.php");

// instantiate an article
$article = new Article($db);


$article->id = isset($_GET['id']) ? (int) $_GET['id'] : die('ERROR: ID not found.');

if($article->getArticle()) {
    $article_item = array(
        'id' => $article->id,
        'title' => $article->title,
        'description' => $article->description,
        'published' => $article->published
    );
    echo json_encode($article_item);
}else {
    echo json_encode([
        "message" => "ERROR: No article found with ID $_GET[id]" 
    ]);
}



