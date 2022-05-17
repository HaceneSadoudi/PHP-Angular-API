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


$result = $article->getArticles();

$num = $result->rowCount();

if ($num > 0) {
    $i = 0;
    $articles = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $articles[$i]['id']    = $row['id'];
        $articles[$i]['title'] = $row['title'];
        $articles[$i]['description'] = $row['description'];
        $articles[$i]['published'] = $row['published'];
        $i++;
    }
    // convert to json
    echo json_encode($articles);
} else {
    echo json_encode([
        "message" => "No articles found"
    ]);
}
