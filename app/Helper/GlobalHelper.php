<?php

use Box\Spout\Common\Exception\InvalidArgumentException as InvalidArgumentExceptionAlias;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Common\Exception\UnsupportedTypeException as UnsupportedTypeExceptionAlias;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\Exception\ReaderNotOpenedException;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use JetBrains\PhpStorm\ArrayShape;

enum ExportFileType : string {
    case XLSX = "xlsx";
    case CSV = "csv";
}

/**
 * @param string $kode
 * @param string $message
 * @param float|null $sleep
 * @return void
 */
function echoFlush(string $kode = "", string $message = "", float|null $sleep=null){
    echo "\n".json_encode(['success'=>true,'kode'=>$kode,'message'=>$message]);
    if(!empty($usleep) || $sleep != null) usleep(1000000 * $sleep);
    flush();
    ob_flush();
}

/**
 * @param $value
 * @param int $digit
 * @return string
 */
function toCurrency($value , int $digit =0 ): string
{
    return number_format((float) $value, $digit);
}

/**
 * @param $value
 * @return int
 */
function fromCurrency($value): int
{
    list($value) = explode("]", str_replace("[>", "", $value));
    $value = $value == "" ? "0" : $value;

    $result = str_starts_with($value, ".") ? "0" . $value : $value;
    return (int) str_replace(",", "", $result);
}

/**
 * @param string $date
 * @return string|null
 */
function convertDate(string $date = ""): ?string {
    $arr = explode("-", $date);
    return  ($date == "" or $date == "0000-00-00") ? "" : $arr[2] . "/" . $arr[1] . "/" . $arr[0];
}

/**
 * @param string $date
 * @return string|null
 */
function unconvertDate(string $date = ""): ?string {
    if(empty($date)) return null;
    $arr = explode('/',$date);
    return $arr[2]."-".$arr[1]."-".$arr[0];
}

/**
 * @param UploadedFile $file
 * @param string $path
 * @param string|null $customName
 * @param int|null $resizeWidth
 * @param int|null $resizeHeight
 * @return string
 * @throws Exception
 */
function uploadImage(UploadedFile $file,
                     string       $path,
                     ?string      $customName = null,
                     ?int         $resizeWidth = null,
                     ?int         $resizeHeight = null): string
{
    $name = uniqid().time().".".$file->getClientOriginalExtension();
    if($customName != null) $name = $customName;

    $image = Image::make($file->getRealPath());

    if($resizeHeight != null && $resizeWidth != null) $image->resize($resizeWidth,$resizeHeight,fn($constraint) => $constraint->aspectRatio());

    $store = Storage::disk('public')->put($path."/".$name,$image->encode());
    if(!$store) throw new Exception("Gagal dalam mengupload gambar, coba beberapa saat lagi...",400);
    return Storage::url($path."/".$name);
}

/**
 * @param UploadedFile $file
 * @param string $path
 * @param string|null $customName
 * @return string
 * @throws Exception
 */
function uploadFile(UploadedFile $file,
                    string $path,
                    ?string $customName = null) :string
{
    $name = uniqid().time().".".$file->getClientOriginalExtension();
    if($customName != null) $name = $customName;

    $store = Storage::disk('public')->put($path."/".$name,$file);
    if(!$store) throw new Exception("Gagal dalam mengupload gambar, coba beberapa saat lagi...",400);

    return Storage::url($path."/".$name);
}

/**
 * @param array $header
 * @param Collection $values
 * @param callable $callback
 * @param ExportFileType $type
 * @return array
 * @throws IOException
 * @throws InvalidArgumentExceptionAlias
 * @throws WriterNotOpenedException
 */
#[ArrayShape(['relativePath' => "string", 'url' => "string", 'size' => "string"])]
function exportSpout(array $header, Collection $values, callable $callback, ExportFileType $type = ExportFileType::XLSX) : array
{

    /// For debug purpose, we should check performance time
//    $startTimer = microtime(true);

    echoFlush("prepare_folder","Sedang membuat folder penyimpanan sementara",0.01);
    /// Create folder if not exists, when exists do nothing
    $folder = "temp/export";
    $storagePath = Storage::disk('public')->path($folder);
    File::ensureDirectoryExists($storagePath);

    $writer = WriterEntityFactory::createXLSXWriter();
    $filename = uniqid().time().".xlsx";

    if($type == ExportFileType::CSV){
        $writer = WriterEntityFactory::createCSVWriter();
        $filename = uniqid().time().".csv";
    }

    $fullpath = $storagePath."/".$filename;
    $writer->openToFile($fullpath);

    /// Create Header
    $header = WriterEntityFactory::createRowFromArray($header);
    $writer->addRow($header);

    /// Create multiple row content
    $no = 0;
    foreach($values->chunk(1000) as $chunk){
        $no = $no + count($chunk);
        echoFlush("read_row","Sedang membaca data ke-$no",sleep: 0.020);

        $tempArr = $chunk->map(fn($value) => WriterEntityFactory::createRowFromArray($callback($value)))->toArray();
        $writer->addRows($tempArr);
    }

    $writer->close();

    echoFlush("prepare_download","Sedang menyiapkan file");
    echo "\n";

    /// For Debug Purpose
//    $endTimer = microtime(true) - $startTimer;

    $result = [
        'relativePath' =>Storage::disk('public')->path("$folder/$filename"),
        'url' => asset(Storage::url("$folder/$filename")),
        'size'=> formatBytes(Storage::disk('public')->size("$folder/$filename")),
    ];
    return $result;
}

/**
 * @param UploadedFile $file
 * @param callable $callback
 * @return Collection
 * @throws IOException
 * @throws ReaderNotOpenedException
 * @throws UnsupportedTypeExceptionAlias
 * @throws Exception
 * TODO: Allowed memory size of 536870912 bytes exhausted (tried to allocate 8392704 bytes)
 */

function importSpout(UploadedFile $file, callable $callback): Collection
{
    /// For debug purpose, we should check performance time
    $startTimer = microtime(true);

    echoFlush("prepare_file","Sedang mempersiapkan file untuk diimport",0.0000001);
    $uploadFile = uploadFile(file: $file,path: 'temp/import');
    $storePath = Storage::disk('public')->path($uploadFile);

    echoFlush("load_file","Sedang mempersiapkan file untuk dibaca",0.0000001);
    $reader = ReaderEntityFactory::createReaderFromFile($storePath);
    $reader->setShouldFormatDates(true);
    $reader->open($storePath);

    $tempArr = [];
    $no = 0 ;

    foreach ($reader->getSheetIterator() as $sheet){
        foreach($sheet->getRowIterator() as $row){
            $cells = $row->toArray();

            /// Skip First Iteration, because we know first row is header
            if(!is_int($cells[0])) continue;

            $result = $callback($cells);
            $tempArr[] = $result;
        }
    }

    $reader->close();

    echoFlush("remove_file","Sedang menghapus temporary file import",0.005);
    /// Remove Excel if already exist reading
    Storage::disk('public')->delete($uploadFile);
    echo "\n";

    /// For Debug Purpose
    $endTimer = microtime(true) - $startTimer;
//    dd($tempArr);
    return collect(value: $tempArr);
}

/**
 * @param int|float $size
 * @param int $precision
 * @return string
 * reference [https://stackoverflow.com/a/2510540/7360353]
 */
function formatBytes(int | float $size, int $precision = 2) : string
{
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
