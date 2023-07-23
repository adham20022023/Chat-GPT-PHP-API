<?php

require __DIR__ . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

$open_ai_key = '';
$open_ai = new OpenAi($open_ai_key);

$answer = '';

if (isset($_POST['send'])) {
    //To Get Text Result
    $complete = $open_ai->completion([
        'model' => 'text-davinci-003',
        'prompt' => $_POST['prompt'],
        'temperature' => 0.9,
        'max_tokens' => 3000,
        'frequency_penalty' => 0,
        'presence_penalty' => 0.6,
    ]);

    $complete = json_decode($complete, true);

    $answer = $complete['choices'][0]['text'];
    $answer = htmlspecialchars($answer); // Prevent HTML content from being executed
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat GPT API</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f1f1f1;
        background-image: linear-gradient(45deg, #f1f1f1 25%, transparent 25%, transparent 75%, #f1f1f1 75%, #f1f1f1),
            linear-gradient(45deg, #f1f1f1 25%, transparent 25%, transparent 75%, #f1f1f1 75%, #f1f1f1);
        background-size: 20px 20px;
        background-position: 0 0, 10px 10px;
    }

    h1 {
        text-align: center;
    }

    form {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 20px;
    }

    label {
        font-weight: bold;
        margin-right: 10px;
    }

    input[type="text"] {
        padding: 10px;
        width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: border-color 0.3s ease;
    }

    input[type="text"]:focus {
        border-color: #007bff;
        outline: none;
    }

    input[type="submit"] {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .result {
        margin-top: 20px;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.5s ease;
    }

    .copy-btn {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 10px;
        display: block;
        width: 100%;
        text-align: center;
    }

    .copy-btn:hover {
        background-color: #0056b3;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>
</head>
<body>
    <h1>Ask a question</h1>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="prompt">Question:</label>
        <input type="text" name="prompt" id="prompt" required>
        <input type="submit" name="send" value="Ask">
    </form>

    <?php if (!empty($answer)) : ?>
        <div class="result">
            <h2>Answer:</h2>
            <p><code><?php echo nl2br($answer); ?></code></p>
            <button class="copy-btn" onclick="copyAnswer()">Copy Answer</button>
        </div>
    <?php endif; ?>

    <script>
        function copyAnswer() {
            var answerText = document.querySelector('.result code');
            var textArea = document.createElement('textarea');
            textArea.value = answerText.textContent;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Answer copied to clipboard!');
        }
   </script>