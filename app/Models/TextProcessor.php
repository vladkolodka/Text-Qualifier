<?php

namespace Qualifier\Models;

use Qualifier\Exceptions\JsonException;
use Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFile;
use Qualifier\Http\Models\Language;
use Qualifier\Http\Models\Topic;
use Qualifier\Http\Models\Document;
use Qualifier\Http\Models\Word;
use vladkolodka\linearAlgebra\SingularValueDecomposition;

class TextProcessor {
    private $text;
    private $text_name;

    public function __construct(UploadedFile $file, $text_language) {
        $this->language = Language::OfLang($text_language);

        $this->text = (new TextParser($file->getPathname(), $file->getClientOriginalExtension()))->getText();
        $file_name = $file->getClientOriginalName();

        $this->text_name = substr($file_name, 0, strpos($file_name, '.'));
    }

    /**
     * Creates new document in database
     * @param $words array
     * @param $topic Topic
     * @param string $text_name
     * @param string $text_raw
     * @param bool $verified
     * @return \Illuminate\Database\Eloquent\Model
     */
    public static function createDocument(array $words, Topic $topic, string $text_name, string $text_raw, bool $verified) {
        $document = Document::create(['name' => $text_name, 'text' => $text_raw, 'hash' => md5($text_raw)]);
        $document->verified = $verified;

        $word_keys = array_keys($words);

        foreach ($word_keys as $word) {
            $temp = Word::firstOrCreate(['name' => $word]);
            $document->words()->attach($temp->id, ['tf' => $words[$word]]);
        }

        return $topic->documents()->save($document);
    }

    public function analyze(bool $save = false) {
//        if ($topic_id = $this->documentExists()) return [Topic::find($topic_id)];

        $document = $this->documentExists();

        if($document && $document['verified']) return [Topic::find($document['topic_id'])];

        $words = (new TextNormalizer($this->text, $this->language))->getWords();

        $matrix = new DocumentWordMatrixCreator($words, $this->language);

        $V = (new SingularValueDecomposition($matrix->getMatrix()))->getV();

        $results = (new TextCategorization($V))->getResults();

        $topics = Topic::find($matrix->getTopicsByDocumentIndex($results));

        if ($save && !$document) $this->createDocument($words, $topics[0], $this->text_name, $this->text, false);

        return $topics;
    }

    public function save($topic_id) {
        if ($this->documentExists()) throw new JsonException('text_exists');
        $words = (new TextNormalizer($this->text, $this->language))->getWords();
        return $this->createDocument($words, Topic::find($topic_id), $this->text_name, $this->text, true);
    }

    private function documentExists() {
        $existing_document = Document::where('hash', md5($this->text))->first();


        if($existing_document){
            return [
                'topic_id' => $existing_document->topic_id,
                'verified' => $existing_document->verified
            ];
        }

        return null;
//        return $existing_document ? $existing_document->topic_id : 0;
    }

}