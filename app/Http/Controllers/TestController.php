<?php

namespace Qualifier\Http\Controllers;

use Qualifier\Http\Models;
use Qualifier\Http\Models\Topic;
use Qualifier\Http\Requests;
use Qualifier\Models\TextCategorization;
use Qualifier\Models\TextNormalizer;
use Qualifier\Models\TextParser;
use vladkolodka\linearAlgebra\Matrix;
use vladkolodka\linearAlgebra\SingularValueDecomposition;


class TestController extends Controller {
    public function clearTables() {
        \DB::table('documents')->truncate();
        \DB::table('words')->truncate();
        \DB::table('document_word')->truncate();
//        DB::table('stop_words')->truncate();
    }

    public function getTopics(){

        $str = "<form action='" . route('admin::documents.store') . "' enctype='multipart/form-data' method='post'>
    " . csrf_field() . "
    <input type='file' name='file'>
    <input type='text' name='language' value='ru'>
    <input type='text' name='topic' value='27'>
    <input type='submit'>
</form>";


        return $str;


//        return response()->json(['topics' => Topic::all()]);
    }

    public function test() {


        $documents = Models\Document::where('hash', '811fa552d1ef29a5e19b48cda6ecf9c7')->first();

        dd($documents->topic()->first());

        dd();

//        $m = 4500;
//        $n = 28;
//
//        $matrix = new Matrix($m, $n);
//
//        for ($i = 0; $i < $m; $i++)
//            for ($j = 0; $j < $n; $j++)
//                $matrix->matrix[$i][$j] = mt_rand(0, 2);
//
//        $svd = new SingularValueDecomposition($matrix);
//
//        dd($svd->getV());

        $language = Models\Language::OfLang('ru');

//        $parser = new TextParser(storage_path('app\\world.docx'), 'docx');
        $parser = new TextParser(storage_path('app\\m.odt'), 'odt');
//        $parser = new TextParser(storage_path('app\\m.doc'), 'doc');

//        dd($parser->getText());


        $normalizer = new TextNormalizer($parser->getText(), $language);

//        \Qualifier\Models\TextProcessor::createDocument($normalizer->getWords(),
//            Models\Topic::find(3), "Авитаминозы животных", $parser->getText(), true);


//        dd($normalizer->getWords());

        $matrixBuilder = new \Qualifier\Models\DocumentWordMatrixCreator($normalizer->getWords(), $language);


        $svd = new SingularValueDecomposition($matrixBuilder->getMatrix());

        $matrix = $svd->getV();
//
        $qualifier = new TextCategorization($matrix);

        $topics = Models\Topic::find($matrixBuilder->getTopicsByDocumentIndex($qualifier->getResults()));

        dd($topics);

//
//        $document_ids = $qualifier->getResults();
//        $topics = [];
//
//        foreach ($document_ids as $document_id) {
//            $topics[] = $matrixBuilder->getDocumentTopicByIndex($document_id);
//        }
//
//        dd($topics);
//
//        $rows = $matrix->getRowDimension();
//        $cols = $matrix->getColumnDimension();
//
//        $output = "<table border='1'>";
//        for ($i = 0; $i < $rows; $i++) {
//            $output .= "<tr>";
//            for ($j = 0; $j < $cols; $j++) {
//                $output .= "<td>{$matrix->get($i,$j)}</td>";
//            }
//            $output .= "</tr>";
//        }
//        $output .= "</table>";
//
//        return $output;
    }


    public function fillTable() {

        Models\Language::OfLang('ru')->topics()->createMany([
            ['name' => 'География'],
            ['name' => 'Геополитика'],
            ['name' => 'Туризм'],
        ]);


        dd();
        $topic = Models\Topic::first();
//        dd($topic);

        $document = Models\Document::create(['name' => ' Document 2', 'text' => 'Hello, galaxy! My name is Vladyslav Kolodka.']);
        $document->verified = true;

        $words = ['Hello', 'galaxy', 'My', 'name', 'is', 'Vladyslav', 'Kolodka'];

        foreach ($words as $word) {
            $temp = Models\Word::firstOrCreate(['name' => $word]);
            $document->words()->attach($temp->id, ['tf' => 5]);
        }


//        $document->words()->saveMany($word_models);

        $topic->documents()->save($document);

    }

    public function deleteUnusedWords() {
        $used_words_id = array_map(function ($connection) {
            return $connection->word_id;
        }, \DB::table('document_word')->distinct()->get());

        $unused_words = Models\Word::whereNotIn('id', $used_words_id)/*->delete()*/
        ;
    }
}
