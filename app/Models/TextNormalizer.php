<?php
namespace Qualifier\Models;

use Qualifier\Exceptions\JsonException;
use Qualifier\Http\Models\Language;
use vladkolodka\phpMorphy\Morphy;

class TextNormalizer {
    private $stop_words = [];
    private $words = [];
    private $morphy;

    /**
     * TextNormalizer constructor.
     * @param $text string
     * @param $language Language
     * @throws JsonException
     */
    public function __construct($text, $language) {
        $this->morphy = new Morphy($language->name);

        // load stop-words
        /** @noinspection PhpUndefinedMethodInspection */
        foreach ($language->stopWords()->get() as $word) {
            $this->stop_words[] = $word->name;
        }

        // TODO remove links, emails, etc

        // if language is not english, replace english symbols
        if ($language->name != 'en') $text = $this->convertSymbolsToCyrillic($text);

        $words = array_map(function ($word){
            return mb_strtoupper($word);
        }, $this->getWordsFromString($text));

        // TODO if words count != 0

        $new_words = array();

        foreach ($words as $word) {

            if (!in_array($word, $this->stop_words)) {
                $lemma = $this->morphy->lemmatize($word)[0];
                if ($lemma === false) $lemma = $word;

                if (mb_strlen($lemma) > 2)
                    isset($new_words[$lemma]) ? $new_words[$lemma]++ : $new_words[$lemma] = 1;
                
            }
        }
        $words_count = count($new_words);

        if(!$words_count) throw new JsonException('words_not_enough');
        
        foreach ($new_words as $word => $count) $this->words[$word] = $count / $words_count;
    }

    private function convertSymbolsToCyrillic($str) {
        return str_replace(
            array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya'),
            array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'),
            $str
        );
    }

    /**
     * @param $string string Input text
     * @return array Text words
     */

    private function getWordsFromString($string) {
        if (preg_match_all("/(\d?|\b)(([a-zа-я]'?){2,})(\d?|\b)/ui", $string, $matches)) {
            return $matches[2];
        }
        return array();
    }

    /**
     * @return array
     */
    public function getWords() {
        return $this->words;
    }
}