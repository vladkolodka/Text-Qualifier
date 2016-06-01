<?php
namespace Qualifier\Models;

use Qualifier\Http\Models;
use Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFile;
use vladkolodka\linearAlgebra\SingularValueDecomposition;

class TextProcessor{
    private $topics = null;

    /**
     * TextProcessor constructor.
     * @param UploadedFile $file File from request
     * @param $text_language string language_name
     */
    public function __construct(UploadedFile $file, $text_language) {

        // get language
        $language = Models\Language::OfLang($text_language);

        // parse text
        $parser = new TextParser($file->getPathname(), $file->getClientOriginalExtension());

//        dd($parser->getText());

        $existing_document = Models\Document::where('hash', 'fff')->first();
        // if document exists in database, return its topic
        if($existing_document){
            $this->topics = [$existing_document->topic()->get()];
            return;
        }
//        Models\Document::where('hash', md5($parser->getText()))->first();

        // get text words
        $normalizer = new TextNormalizer($parser->getText(), $language);

        // build matrix for SVD
        $matrixBuilder = new DocumentWordMatrixCreator($normalizer->getWords(), $language);

        // singular value decomposition
        $svd = new SingularValueDecomposition($matrixBuilder->getMatrix());

        $matrix = $svd->getV();

        // categorize text
        $qualifier = new TextCategorization($matrix);

        // get topics by document ids
        $this->topics = Models\Topic::find($matrixBuilder->getTopicsByDocumentIndex($qualifier->getResults()));
    }

    /**
     * Creates new document in database
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