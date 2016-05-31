<?php
namespace Qualifier\Models;

use Qualifier\Http\Models;
use Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFile;
use vladkolodka\linearAlgebra\SingularValueDecomposition;

class TextProcessor{
    private $topics = null;
    
    public function __construct(UploadedFile $file, $text_language) {

        // TODO words count limit

        $language = Models\Language::OfLang($text_language);
        
        $parser = new TextParser($file->getPathname(), $file->getExtension());
        $normalizer = new TextNormalizer($parser->getText(), $text_language);
        $matrixBuilder = new \Qualifier\Models\DocumentWordMatrixCreator($normalizer->getWords(), $language);
        
        $svd = new SingularValueDecomposition($matrixBuilder->getMatrix());

        $matrix = $svd->getV();
//
        $qualifier = new TextCategorization($matrix);

        $this->topics = Models\Topic::find($matrixBuilder->getTopicsByDocumentIndex($qualifier->getResults()));
    }

    /**
     * @param $words array
     * @param $topic Models\Topic
     */
    public static function createDocument(array $words, Models\Topic $topic, string $text_name, string $text_raw, bool $verified){
        $document = Models\Document::create(['name' => $text_name, 'text' => $text_raw]);
        $document->verified = $verified;

        $word_keys = array_keys($words);

        foreach ($word_keys as $word) {
            $temp = Models\Word::firstOrCreate(['name' => $word]);
            $document->words()->attach($temp->id, ['tf' => $words[$word]]);
        }


//        $document->words()->saveMany($word_models);

        $topic->documents()->save($document);
    }

    /**
     * @return null
     */
    public function getTopics() {
        return $this->topics;
    }
}