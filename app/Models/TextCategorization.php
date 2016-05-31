<?php
namespace Qualifier\Models;

use vladkolodka\linearAlgebra\Matrix;

class TextCategorization {
    const CATEGORIES_COUNT = 3;

    private $results = [];

    public function __construct(Matrix $data) {

        $values = $this->CosineSimilarity($data);
        $values_count = count($values);
        $this->results = [];

        for ($i = 0; $i < self::CATEGORIES_COUNT; $i++){
            $index = -1;
            $value = $values[0];
            for ($j = 1; $j < $values_count; $j++){
                if($values[$j] > $value && $values[$j] <= 1 && !in_array($j, $this->results)){
                    $index = $j;
                    $value = $values[$j];
                }
            }
            if($index != -1) $this->results[] = $index;
        }
    }

    public function CosineSimilarity(Matrix $data) {
        $count = $data->getRowDimension();
        $k = ceil($count * 0.2);

        $count--;

        $multiplication = $modA =  array_fill(0, $count, 0);
        $modB = 0;

        for ($i = 0; $i < $k; $i++) {
            for ($j = 0; $j < $count; $j++) {
                $multiplication[$j] += $data->matrix[$i][$j] * $data->matrix[$i][$count];;
                $modA[$j] += pow($data->matrix[$i][$j], 2);
            }
            $modB += pow($data->matrix[$i][$count], 2);
        }
        $modB = sqrt($modB);

        $result = [];

        for ($i = 0; $i < $count; $i++) $result[$i] = $multiplication[$i] / (sqrt($modA[$i]) * $modB);

        return $result;
    }

    /**
     * @return array
     */
    public function getResults() {
//        dd($this->results);
        return $this->results;
    }
}