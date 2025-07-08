<?php

function findShortestWord($str)
{
    $words = explode(' ', $str);

    $shortestWord = $words[0];
    $shortestLength = strlen($words[0]);

    foreach ($words as $word) {
        $currentLength = strlen($word);
        if ($currentLength < $shortestLength) {
            $shortestLength = $currentLength;
            $shortestWord = $word;
        }
    }

    return [
        'length' => $shortestLength,
        'word' => $shortestWord
    ];
}

echo "=== SHORTEST WORD FINDER ===\n\n";
echo "Enter a sentence: ";
$userInput = trim(fgets(STDIN));

if (empty($userInput)) {
    echo "Error: Please enter a valid sentence.\n";
    exit(1);
}

$result = findShortestWord($userInput);

echo "\nOUTPUT: " . $result['length'] . " – BECAUSE THE SHORTEST WORD IS \"" . $result['word'] . "\"\n";

?>