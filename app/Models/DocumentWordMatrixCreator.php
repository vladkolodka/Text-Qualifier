<?php
namespace Qualifier\Models;

use Qualifier\Exceptions\JsonException;
use Qualifier\Http\Models\Language;
use vladkolodka\linearAlgebra\Matrix;

class DocumentWordMatrixCreator {
    private $documents = [];
    private $documents_count = 0;
    private $matrix = null;
    private $words = [];

    /**
     * DocumentWordMatrixCreator constructor.
     * @param $new_document_words array
     * @param $language Language
     * @throws JsonException
     */
    public function __construct($new_document_words, $language) {
        // load documents and their words from database
        /** @noinspection PhpUndefinedMethodInspection */
        $this->documents = $language->documents()->verified()->with('words')->get();
        /** @noinspection PhpUndefinedMethodInspection */
        $this->documents_count = $this->documents->count() + 1;

        if($this->documents_count == 1) throw new JsonException('empty_database_documents');


        // select words that are found in several documents
        foreach ($this->documents as $document)
            foreach ($document->words as $word)
                if (isset($this->words[$word->name])) $this->words[$word->name]++;
                else $this->words[$word->name] = 1;

        foreach ($new_document_words as $word => $tf)
            if (isset($this->words[$word])) $this->words[$word]++;
            else $this->words[$word] = 1;

        // delete words in a single copy
        foreach ($this->words as $word => $count) {
            if ($count == 1) unset($this->words[$word]);
        }
//        dd($this->words);

        // [words][documents]
        $this->matrix = new Matrix(count($this->words), $this->documents_count);

        // fill matrix
        for ($i = 0; $i < $this->documents_count - 1; $i++) {
            foreach ($this->documents[$i]->words as $word) {
                if (array_key_exists($word->name, $this->words)) {
                    $this->matrix->matrix[$this->getIndexByKey($word->name)][$i] = $word->pivot->tf * log(($this->documents_count) / $this->words[$word->name]);
                }
            }
        }
        foreach ($new_document_words as $word => $tf) {
            if (array_key_exists($word, $this->words)) {
                $this->matrix->matrix[$this->getIndexByKey($word)][$this->documents_count - 1] = $tf * log(($this->documents_count) / $this->words[$word]);
            }
        }

    }

    private function getIndexByKey($key) {
        $index = 0;
        foreach ($this->words as $word => $count) {
            if ($word == $key) return $index;
            $index++;
        }
        return false;
    }

    /**
     * @return Matrix
     */
    public function getMatrix() {
        return $this->matrix;
    }

    public function getTopicsByDocumentIndex($indexes) {
        $indexes = array_count_values($indexes);
        arsort($indexes);
        $indexes = array_keys($indexes);

        $ids = [];
        foreach ($indexes as $index) {
            $ids[] = $this->documents[$index]->topic_id;
        }

        return $ids;
    }
}