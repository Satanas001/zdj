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
 * Resize an image to a new size
 *
 * @param string $image The complete path of the image
 * @param integer $xMax Maximum width of the new image
 * @param integer $yMax Maximum height of the new image
 * @param boolean $strict   if set to true, the image will have the size of xMAx x Ymax
 * @return void
 */
function resizeImage(string $image, int $xMax = 300, int $yMax = 300, bool $strict = false) {
    $image = $_SERVER['DOCUMENT_ROOT'].$image ;
    
    if (file_exists($image)) {
        list($width, $height, $type) = getimagesize($image);

        switch ($type) {
            case 1:
                $img = imagecreatefromgif($image);
                break;
            case 2:
                $img = imagecreatefromjpeg($image);
                break;
            case 3:
                $img = imagecreatefrompng($image);
                break;
        }

        if ($img) {
            // on vérifie que l'image source n'est pas plus petite que l'image destination
            if ($width > $xMax || $height > $yMax) {
                $ratioX = $xMax / $width;
                $ratioY = $yMax / $height;

                if ($ratioX <= $ratioY) {
                    $ratio = $ratioX;
                } else {
                    $ratio = $ratioY;
                }
            } 
            else {
                $ratio = 1;
            }

            $destWidth = round($width * $ratio);
            $destHeight = round($height * $ratio);

            $destImage = imagecreatetruecolor($destWidth, $destHeight);
            imagealphablending($destImage, false);
            imagesavealpha($destImage, true);

            if (imagecopyresampled($destImage, $img, 0, 0, 0, 0, $destWidth, $destHeight, $width, $height)) {
                switch ($type) {
                    case 1:
                        imagegif($destImage, $image);
                        break;
                    case 2:
                        imagejpeg($destImage, $image, 100);
                        break;
                    case 3:
                        imagepng($destImage, $image, 0);
                        break;
                }
            }

            imagedestroy($destImage);

            if ($strict) {
                switch ($type) {
                    case 1:
                        $img1 = imagecreatefromgif($image);
                        break;
                    case 2:
                        $img1 = imagecreatefromjpeg($image);
                        break;
                    case 3:
                        $img1 = imagecreatefrompng($image);
                        break;
                }

                $img2 = imagecreatetruecolor($xMax, $yMax);
                $blanc = imagecolorallocate($img2, 255, 255, 255);
                imagealphablending($destImage, false);
                imagesavealpha($destImage, true);
                imagefill($img2, 1, 1, $blanc);
                $x = round(($xMax - $destWidth) / 2, 0) ;
                $y = round(($yMax - $destHeight) / 2, 0) ;
                imagecopy($img2, $img1, $x, $y, 0, 0, $destWidth, $destHeight);

                switch ($type) {
                    case 1:
                        imagegif($img2, $image);
                        break;
                    case 2:
                        imagejpeg($img2, $image, 100);
                        break;
                    case 3:
                        imagepng($img2, $image, 0);
                        break;
                }
            }
        }

        imagedestroy($img);
    }
}

/**
 * Split the title of game, book, film, etc.
 *
 * @param string $title Full title of the opus
 * @return array    return an associative array['article' => string article, 'title' => string title]
 */
function splitTitle(string $title):array {
    $article = '' ;

    if (substr(strtolower($title), 0, 2) == "l'") {
        $article = substr($title, 0, 2) ;
        $title = substr($title, 2) ;
    }
    elseif (substr(strtolower($title), 0, 3) == 'le ' || substr(strtolower($title), 0, 3) == 'la ') {
        $article = substr($title, 0, 3) ;
        $title = substr($title, 3) ;
    }
    elseif (substr(strtolower($title), 0, 4) == 'les ') {
        $article = substr($title, 0, 4) ;
        $title = substr($title, 4) ;
    }
    elseif (substr(strtolower($title), 0, 4) == 'the ') {
        $article = substr($title, 0, 4) ;
        $title = substr($title, 4) ;
    }

    return ['article' => $article, 'title' => $title] ;
}

/**
 * Return a string representation to be used in URLs
 *
 * @param string $title Represents the title to be used in URLs
 * @return string
 */
function urlTitle(string $title, string $spaceReplacer = '-') : string
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

    $title = preg_replace('`[^a-z0-9]+`', $spaceReplacer, $title);

    return trim($title, '-');
}
