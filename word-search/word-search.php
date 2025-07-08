<?php

class WordSearch
{
    public function findWordIndices($words, $target)
    {
        $indices = [];

        for ($i = 0; $i < count($words); $i++) {
            if ($words[$i] === $target) {
                $indices[] = $i;
            }
        }

        return $indices;
    }
}

echo "=== WORD SEARCH ===\n\n";

echo "Enter the number of words: ";
$wordCount = (int) trim(fgets(STDIN));

if ($wordCount <= 0 || $wordCount > 1000) {
    echo "Error: Number of words must be between 1 and 1000.\n";
    exit(1);
}

echo "\nEnter the words (one per line):\n";
$words = [];
for ($i = 0; $i < $wordCount; $i++) {
    echo "Word " . ($i + 1) . ": ";
    $word = trim(fgets(STDIN));
    if (empty($word)) {
        echo "Error: Word cannot be empty.\n";
        $i--; // Retry this word
        continue;
    }
    $words[] = $word;
}

echo "\nEnter the target word to search for: ";
$target = trim(fgets(STDIN));

if (empty($target)) {
    echo "Error: Target word cannot be empty.\n";
    exit(1);
}

$wordSearch = new WordSearch();
$foundIndices = $wordSearch->findWordIndices($words, $target);

echo "\nSEARCH RESULTS:\n";
echo "Target: \"$target\"\n";

if (empty($foundIndices)) {
    echo "Result: Target word not found in the array.\n";
} else {
    echo "Output: [" . implode(", ", $foundIndices) . "]\n";
    echo "Occurrences: " . count($foundIndices) . "\n";
}

?>