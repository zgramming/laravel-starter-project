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

    $store = Storage::put($path."/".$name,$image->encode());
    if(!$store) throw new Exception("Gagal dalam mengupload gambar, coba beberapa saat lagi...",400);

    return $path."/".$name;
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

    $store = Storage::put($path."/".$name,$file);
    if(!$store) throw new Exception("Gagal dalam mengupload gambar, coba beberapa saat lagi...",400);

    return $path."/".$name;
}

/**
 * @param string $path
 * @param array $header
 * @param Collection $values
 * @param callable $callback
 * @return string
 * @throws IOException
 * @throws InvalidArgumentExceptionAlias
 * @throws WriterNotOpenedException
 */
function exportSpout(string $path, array $header, Collection $values, callable $callback) : string{

    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToFile($path);

    /// Create Header
    $header = WriterEntityFactory::createRowFromArray($header);
    $writer->addRow($header);

    /// Create multiple row content
    $valuesCollection = $values->map(fn($value)=>WriterEntityFactory::createRowFromArray($callback($value)))->toArray();
    $writer->addRows($valuesCollection);

    $writer->close();

    return storage_path($path);
}

/**
 * @param string $path
 * @param callable $callback
 * @return array
 * @throws IOException
 * @throws ReaderNotOpenedException
 * @throws UnsupportedTypeExceptionAlias
 */
function importSpout(string $path, callable $callback): array
{
    $reader = ReaderEntityFactory::createReaderFromFile($path);
    $reader->setShouldFormatDates(true);
    $reader->open($path);

    $tempArr = [];
    $no = 0 ;
    foreach ($reader->getSheetIterator() as $sheet){
        foreach($sheet->getRowIterator() as $row){
            $cells = $row->toArray();

            /// Skip First Iteration, because we know first row is header
            if(!is_int($cells[0])) continue;

            $result = $callback($cells);
            $tempArr[] = $result;


            $response = [
                'message' => 'Reading data '.++$no,
            ];

            echo response()->json($response);

            flush();
            ob_flush();
        }
    }

    $reader->close();
    return $tempArr;
}
