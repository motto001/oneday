<?php
namespace lib\image;
//echo substr(ImageManipulator::webnev('G  H $@@@jh j h___hagsdzasdgg h fsd T BZ  É$ß$ßŁ$;ß$ hrtrt retrt terterererterewrtereterer.jpg'), 0,30);

echo ImageManipulator::vanfile_plusz('kk/hh.php');
class ImageManipulator
{
    protected $width;
    protected $height;
    protected $image;

    public function __construct($file = null)
    {
        if (null !== $file) {
            if (is_file($file)) {
                $this->setImageFile($file);
            } else {
                $this->setImageString($file);
            }
        }
    }
    public function uni_nev()
    {
        global  $userid;
        $webnev=$userid.'_'.mktime().'_'.rand(1, 999);
        return $webnev;
    }
   static public function vanfile_plusz($filename)
    {
        $van=false;
        $fileParts = pathinfo($filename);
        if(is_file($filename)){$van=true;}
        $i=1;
        while ($van)
        { 
           $file=$fileParts['filename'].$i ;
           if(!is_file($fileParts['dirname'].'/'.$file.'.'.$fileParts['extension'])){$van=false;$filename=$fileParts['dirname'].'/'.$file.'.'.$fileParts['extension'];}
          $i++;  
        }
        return $filename;
    }
 public function webnev($string)
    {$webnev='';
        $string= strtolower($string);
        $hungarianABC = array( 'á','é','í','ó','ö','ő','ú','ü','ű','&','#','@','$','%','/','\\',' ','-',',','+',);
        //$englishABC = array( 'a','e','i','o','o','o','u','u','u','A','E','I','O','O','O','U','U','U','e','e','e','e','e','e','e');
        $englishABC = array( 'a','e','i','o','oe','oe','u','u','u','_and_','_se_','_at_','_doll_','_szaz_','_slash_','_bslash_','_','_','_com_','_plus_');
        $string=str_replace($hungarianABC, $englishABC, $string);
        $string= preg_replace("/(_+)/", '_', $string);

        $webabc = array( 'a','e','i','o','u','b','c','d','f','g','h','j','k','l','m','n','p','_','q','r','s','z','v','w','x','y','t','0','1','2','3','4','5','6','7','8','9','.');

        for ($n = 0; $n < strlen($string); ++$n)
        {
            if (in_array($string{$n},$webabc))
            {$webnev.=$string{$n};}     
        }
        return $webnev;
    }
    /**
     * Set image resource from file
     *
     * @param string $file Path to image file
     * @return ImageManipulator for a fluent interface
     * @throws InvalidArgumentException
     */
    public function setImageFile($file)
    {
        if (!(is_readable($file) && is_file($file))) {
            throw new InvalidArgumentException("Image file $file is not readable");
        }

        if (is_resource($this->image)) {
            imagedestroy($this->image);
        }

        list ($this->width, $this->height, $type) = getimagesize($file);

        switch ($type) {
            case IMAGETYPE_GIF :
                $this->image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG :
                $this->image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG :
                $this->image = imagecreatefrompng($file);
                break;
            default :
                throw new InvalidArgumentException("Image type $type not supported");
        }

        return $this;
    }
    /**
     * Set image resource from string data
     *
     * @param string $data
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function setImageString($data)
    {
        if (is_resource($this->image)) {
            imagedestroy($this->image);
        }

        if (!$this->image = imagecreatefromstring($data)) {
            throw new RuntimeException('Cannot create image from data string');
        }
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
        return $this;
    }

    /**
     * Resamples the current image
     *
     * @param int $width New width
     * @param int $height New height
     * @param bool $constrainProportions Constrain current image proportions when resizing
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function resample($width, $height, $constrainProportions = true)
    {
        if (!is_resource($this->image)) {
            throw new RuntimeException('No image set');
        }
        if ($constrainProportions) {
            if ($this->height >= $this->width) {
                $width = round($height / $this->height * $this->width);
            } else {
                $height = round($width / $this->width * $this->height);
            }
        }
        $temp = imagecreatetruecolor($width, $height);
        imagecopyresampled($temp, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
        return $this->_replace($temp);
    }
    /**
     * Enlarge canvas
     *
     * @param int $width Canvas width
     * @param int $height Canvas height
     * @param array $rgb RGB colour values
     * @param int $xpos X-Position of image in new canvas, null for centre
     * @param int $ypos Y-Position of image in new canvas, null for centre
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function enlargeCanvas($width, $height, array $rgb = array(), $xpos = null, $ypos = null)
    {
        if (!is_resource($this->image)) {
            throw new RuntimeException('No image set');
        }
        $width = max($width, $this->width);
        $height = max($height, $this->height);
        $temp = imagecreatetruecolor($width, $height);
        if (count($rgb) == 3) {
            $bg = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
            imagefill($temp, 0, 0, $bg);
        }
        if (null === $xpos) {
            $xpos = round(($width - $this->width) / 2);
        }
        if (null === $ypos) {
            $ypos = round(($height - $this->height) / 2);
        }
        imagecopy($temp, $this->image, (int) $xpos, (int) $ypos, 0, 0, $this->width, $this->height);
        return $this->_replace($temp);
    }
    /**
     * Crop image
     *
     * @param int|array $x1 Top left x-coordinate of crop box or array of coordinates
     * @param int $y1 Top left y-coordinate of crop box
     * @param int $x2 Bottom right x-coordinate of crop box
     * @param int $y2 Bottom right y-coordinate of crop box
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function crop($x1, $y1 = 0, $x2 = 0, $y2 = 0)
    {
        if (!is_resource($this->image)) {
            throw new RuntimeException('No image set');
        }
        if (is_array($x1) && 4 == count($x1)) {
            list($x1, $y1, $x2, $y2) = $x1;
        }
        $x1 = max($x1, 0);
        $y1 = max($y1, 0);
        $x2 = min($x2, $this->width);
        $y2 = min($y2, $this->height);
        $width = $x2 - $x1;
        $height = $y2 - $y1;
        $temp = imagecreatetruecolor($width, $height);
        imagecopy($temp, $this->image, 0, 0, $x1, $y1, $width, $height);
        return $this->_replace($temp);
    }
    /**
     * Replace current image resource with a new one
     *
     * @param resource $res New image resource
     * @return ImageManipulator for a fluent interface
     * @throws UnexpectedValueException
     */
    protected function _replace($res)
    {
        if (!is_resource($res)) {
            throw new UnexpectedValueException('Invalid resource');
        }
        if (is_resource($this->image)) {
            imagedestroy($this->image);
        }
        $this->image = $res;
        $this->width = imagesx($res);
        $this->height = imagesy($res);
        return $this;
    }
    /**
     * Save current image to file
     *
     * @param string $fileName
     * @return void
     * @throws RuntimeException
     */

//save($targetFolder.'/' .$newNamePrefix.$filenev);
    public function save($fileName, $type = IMAGETYPE_JPEG)
    {
        $dir = dirname($fileName);
        /*
        if (!is_dir($dir)) {
        if (!mkdir($dir, 0755, true)) {
        throw new RuntimeException('Error creating directory ' . $dir);
        }
        }*/
        try {
            switch ($type) {
                case IMAGETYPE_GIF :
                    if (!imagegif($this->image, $fileName)) {
                        throw new RuntimeException;
                    }
                    break;
                case IMAGETYPE_PNG :
                    if (!imagepng($this->image, $fileName)) {
                        throw new RuntimeException;
                    }
                    break;
                case IMAGETYPE_JPEG :
                default :
                    if (!imagejpeg($this->image, $fileName, 95)) {
                        throw new RuntimeException;
                    }
            }
        } catch (Exception $ex) {
            throw new RuntimeException('Error saving image file to ' . $fileName);
        }
    }

    /**
     * Returns the GD image resource
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->image;
    }

    /**
     * Get current image resource width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get current image height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}

