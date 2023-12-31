<?php
require __DIR__.'/vendor/autoload.php';

use Orhanerday\OpenAi\OpenAi;

$open_ai_key = getenv('OPENAI_API_KEY');

$open_ai = new OpenAi($open_ai_key);
$keyword = $_POST['keyword'];
$tone = $_POST['tone'];
$min_density = $_POST['min_density'];
$max_density = $_POST['max_density'];
$text_content = $open_ai->chat([
    'model' => 'gpt-3.5-turbo',
    'messages' => [
        [
            "role" => "system",
            "content" => "Hi there"
        ],
        [
            "role" => "user",
            "content" => "generate an article on '$keyword' with keyword density ranging from $min_density - $max_density % and your writing style of $tone."
        ],
    ],
    'temperature' => 1.0,
    'max_tokens' => 200,
    'frequency_penalty' => 0,
    'presence_penalty' => 0,
]);
$text_content = json_decode($text_content, true);
$text_content = $text_content['choices'][0]['message']['content'] ?? '';

$image_content = $open_ai->image([
    "prompt" => "Generate images about '$keyword'. I NEED to test how the tool works with extremely simple prompts. DO NOT add any detail, just use it AS-IS:",
    "n" => 4,
    "size" => "256x256",
    "response_format" => "url",
 ]);
$image_content = json_decode($image_content, true);
$image_content = $image_content['data'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Output</title>
    <style>
        .output-text{
            white-space: break-spaces;
            width: 100%;
        }
        .output-text img {
            display: inline-block;
            text-align: center;
            width: 40%;
            margin: 4px auto;
        }
    </style>
</head>
<body>
    <h1>AI generated content on <?= $keyword?></h1>
    <div class="output-text" id="output_container"></div>
    <script type="text/javascript">
        let image_content = <?php echo json_encode($image_content); ?>;
        let text_content = <?php echo json_encode($text_content); ?>;
        text_content = text_content.split('\n\n'); // find line breaks in the AI generated text and split into array of paragraphs
        const newImageURLs = image_content.map(a=>a.url);
        let newAIContent = text_content.map(p =>  `<p>${p}</p>`); // enclose split paragraphs into <p></p> tag
        let splice_count = 1;
        // insert images in-between paragraphs 
        for (let i = 0; i < newImageURLs.length; i++) {
            const newIMG = `<img src='${newImageURLs[i]}' alt='' />`;
            newAIContent.splice(splice_count, 0, newIMG);
            splice_count += 3;
        }  
        const AIContainer = document.querySelector('#output_container');
        // inject content into DOM
        AIContainer.innerHTML = newAIContent.join("");

    </script>
</body>
</html>