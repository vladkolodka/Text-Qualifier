<?php
namespace Qualifier\Models;

use Smalot\PdfParser\Parser as PdfParser;
use WordDocParser\doc as DocParser;

class TextParser{
    private $text = '';

    public function __construct($file_path, $extension) {
        switch ($extension) {
            case 'doc':
                $this->parseDoc($file_path);
                break;
            case 'docx':
                $this->parseDocx($file_path);
                break;
            case 'odt':
                $this->parseOdt($file_path);
                break;
            case 'txt':
                $this->parseTxt($file_path);
                break;
            case 'pdf':
                $this->parsePdf($file_path);
                break;
            default:
                // TODO FileFormatException
                break;
        }

        $this->text = trim(strip_tags(mb_convert_encoding($this->text, "UTF-8")), "'+=-+,._\r\n ");
        $this->text = preg_replace(['/(\r\n|\n)/u', '/ {2,}/u'], ' ', $this->text);

        // TODO if text isset
    }

    private function parseDoc($file_path){
        $doc = new DocParser();
        $doc->read($file_path);

        $this->text = $doc->parse();
    }
    
    private function parseOdt($filename) {
        $this->text = $this->getTextFromZippedXML($filename, "content.xml");
    }
    private function parseDocx($filename) {
        $this->text = $this->getTextFromZippedXML($filename, "word/document.xml");
    }
    private function getTextFromZippedXML($archiveFile, $contentFile) {
        // Создаёт "реинкарнацию" zip-архива...
        $zip = new \ZipArchive;
        // И пытаемся открыть переданный zip-файл
        if ($zip->open($archiveFile)) {
            // В случае успеха ищем в архиве файл с данными
            if (($index = $zip->locateName($contentFile)) !== false) {
                // Если находим, то читаем его в строку
                $content = $zip->getFromIndex($index);
                // Закрываем zip-архив, он нам больше не нужен
                $zip->close();

                $xml = new \DOMDocument();
                $xml->loadXML($content, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);

                $xml->preserveWhiteSpace = false;
                $xml->formatOutput = true;

                // После этого подгружаем все entity и по возможности include'ы других файлов
                // Проглатываем ошибки и предупреждения
                // После чего возвращаем данные без XML-тегов форматирования
                return strip_tags($xml->saveXML());
            }
            $zip->close();
        }
        // Если что-то пошло не так, возвращаем пустую строку
        return "";
    }

    private function parseTxt($file_path) {
        $this->text = file_get_contents($file_path);
    }
    private function parsePdf($file_path){
        $parser = new PdfParser();
        $pdf_file = $parser->parseFile($file_path);

        $this->text = $pdf_file->getText();
    }


    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }
}