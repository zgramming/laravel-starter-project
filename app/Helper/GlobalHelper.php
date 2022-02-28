<?php

use Illuminate\Http\UploadedFile;
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
