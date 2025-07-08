<?php

class IslandCounter
{
    private $matrix;
    private $rows;
    private $cols;
    private $visited;

    public function countIslands($matrix)
    {
        $this->matrix = $matrix;
        $this->rows = count($matrix);
        $this->cols = count($matrix[0]);
        $this->visited = array_fill(0, $this->rows, array_fill(0, $this->cols, false));

        $islandCount = 0;

        for ($i = 0; $i < $this->rows; $i++) {
            for ($j = 0; $j < $this->cols; $j++) {
                if ($this->matrix[$i][$j] == 1 && !$this->visited[$i][$j]) {
                    $this->dfs($i, $j);
                    $islandCount++;
                }
            }
        }

        return [
            'count' => $islandCount,
            'matrix' => $this->matrix,
            'visual' => $this->getVisualRepresentation()
        ];
    }

    private function dfs($row, $col)
    {
        if (
            $row < 0 || $row >= $this->rows ||
            $col < 0 || $col >= $this->cols ||
            $this->visited[$row][$col] ||
            $this->matrix[$row][$col] == 0
        ) {
            return;
        }

        $this->visited[$row][$col] = true;

        $directions = [
            [-1, 0], // up
            [1, 0],  // down
            [0, -1], // left
            [0, 1]   // right
        ];

        foreach ($directions as $dir) {
            $newRow = $row + $dir[0];
            $newCol = $col + $dir[1];
            $this->dfs($newRow, $newCol);
        }
    }

    private function getVisualRepresentation()
    {
        $visual = [];
        for ($i = 0; $i < $this->rows; $i++) {
            $row = "";
            for ($j = 0; $j < $this->cols; $j++) {
                $row .= ($this->matrix[$i][$j] == 1) ? "X" : "~";
            }
            $visual[] = $row;
        }
        return $visual;
    }

    public function displayMatrix($matrix)
    {
        echo "\nMatrix:\n";
        foreach ($matrix as $row) {
            echo "[" . implode(",", $row) . "]\n";
        }
        echo "\n";
    }

    public function displayVisual($visual)
    {
        echo "Output:\n";
        foreach ($visual as $row) {
            echo "\"$row\"\n";
        }
        echo "\n";
    }
}

echo "=== ISLAND COUNTER ===\n\n";

echo "Enter matrix dimensions:\n";
echo "Number of rows: ";
$rows = (int) trim(fgets(STDIN));
echo "Number of columns: ";
$cols = (int) trim(fgets(STDIN));

if ($rows <= 0 || $cols <= 0) {
    echo "Error: Invalid dimensions. Please enter positive numbers.\n";
    exit(1);
}

echo "\nEnter the matrix (row by row, space-separated 0s and 1s):\n";
echo "Example: 1 1 0 1\n\n";

$matrix = [];
for ($i = 0; $i < $rows; $i++) {
    echo "Row " . ($i + 1) . ": ";
    $input = trim(fgets(STDIN));
    $row = array_map('intval', explode(' ', $input));

    if (count($row) != $cols) {
        echo "Error: Row must contain exactly $cols values.\n";
        $i--; // Retry this row
        continue;
    }

    foreach ($row as $val) {
        if ($val !== 0 && $val !== 1) {
            echo "Error: Only 0 and 1 are allowed.\n";
            $i--; // Retry this row
            continue 2;
        }
    }

    $matrix[] = $row;
}

$counter = new IslandCounter();
$result = $counter->countIslands($matrix);


$counter->displayMatrix($result['matrix']);
$counter->displayVisual($result['visual']);

echo "Number of Islands: " . $result['count'] . "\n";

?>