<?php

/**
 * Returns the formatted icon according to the file extension
 *
 * @param string $file  Name of the file
 * @return string
 */
function fileExtensionFormat(string $file): string
{
    switch (pathinfo($file, PATHINFO_EXTENSION)) {
        case 'pdf':
            $extension = 'fa-regular fa-file-pdf text-danger';
            break;
        case 'docx':
            $extension = 'fa-regular fa-file-word text-primary';
            break;
        case 'doc':
            $extension = 'fa-regular fa-file-word text-primary';
            break;
        case 'jpg':
            $extension = 'fa-regular fa-file-image text-dark';
            break;
        case 'png':
            $extension = 'fa-regular fa-file-image text-dark';
            break;
        case 'jpeg':
            $extension = 'fa-regular fa-file-image text-dark';
            break;
        default:
            $extension = 'fas fa-download basecolor-text';
    }

    return $extension;
}

/**
 * returns the size of a file in a more meaningful version
 *
 * @param float $bytes  Size of the file in bytes
 * @return string   
 */
function fileSizeFormat(float $bytes): string
{
    $result = '';
    $bytesArray = [
        0 => ['unite' => 'To', 'valeur' => pow(1024, 4)],
        1 => ['unite' => 'Go', 'valeur' => pow(1024, 3)],
        2 => ['unite' => 'Mo', 'valeur' => pow(1024, 2)],
        3 => ['unite' => 'ko', 'valeur' => 1024],
        4 => ['unite' => 'o', 'valeur' => 1],
    ];

    foreach ($bytesArray as $item) {
        if ($bytes >= $item['valeur']) {
            $result = $bytes / $item['valeur'];
            $result = str_replace('.', ',', strval(round($result, 1))) . ' ' . $item['unite'];
            break;
        }
    }

    return $result;
}

/**
 * Return a formatted string representing the number # ###,## unity
 *
 * @param mixed $number     the number to be formatted
 * @param integer $decimal  the number of decimal
 * @param string $unity     the measure unity (default: blank)
 * @return string
 */
function numberFormat(mixed $number, int $decimal = 0, string $unity = '') : string
{
    if (!is_numeric($number)) {
        return '#NAN' ;
    }

    $unityLabel = $unity ? ' '.$unity : '' ;
    
    return number_format($number, $decimal, ',', ' ').$unityLabel ;
}

/**
 * Return a string representation to be used in URLs
 *
 * @param string $title Represents the title to be used in URLs
 * @return string
 */
function urlTitle(string $title) : string
{
    $title = preg_replace('#Ç#', 'C', $title);
    $title = preg_replace('#ç#', 'c', $title);
    $title = preg_replace('#è|é|ê|ë#', 'e', $title);
    $title = preg_replace('#È|É|Ê|Ë#', 'E', $title);
    $title = preg_replace('#à|á|â|ã|ä|å#', 'a', $title);
    $title = preg_replace('#@|À|Á|Â|Ã|Ä|Å#', 'A', $title);
    $title = preg_replace('#ì|í|î|ï#', 'i', $title);
    $title = preg_replace('#Ì|Í|Î|Ï#', 'I', $title);
    $title = preg_replace('#ð|ò|ó|ô|õ|ö#', 'o', $title);
    $title = preg_replace('#Ò|Ó|Ô|Õ|Ö#', 'O', $title);
    $title = preg_replace('#ù|ú|û|ü#', 'u', $title);
    $title = preg_replace('#Ù|Ú|Û|Ü#', 'U', $title);
    $title = preg_replace('#ý|ÿ#', 'y', $title);
    $title = preg_replace('#Ý#', 'Y', $title);

    $title = mb_convert_case($title, MB_CASE_LOWER, 'UTF-8');

    $title = preg_replace('`[^a-z0-9]+`', '-', $title);

    return trim($title, '-');
}
