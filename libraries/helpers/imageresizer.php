<?php

/**
 * ImageResizer - By DemonsHalo @ Lorenum.com
 * 
 * ImageResizer is based on PHP's GD library.
 * Feel free to modify the class and contribute to the Lorenum Open Source Library! 
 */
class Helpers_ImageResizer {

    //Orientation variables for image cutting
    public static $LEFT = 1;
    public static $CENTER = 2;
    public static $RIGHT = 3;
    
    //File related variables
    private $file;
    private $fileInfo;
    
    //Storing final size calculations
    private $outputWidth;
    private $outputHeight;
    
    //Processed image
    private $image;

    /**
     * Initiates the process by passing in the image file to be used by this class
     * Filetypes: PNG or JPEG
     * 
     * @param type $file filename/location
     */
    public function __construct($file) {
        $this->file = $file;
        $this->fileInfo = getimagesize($file);

        //Initiate the output size to be as the original size for error prevention.
        $this->outputWidth = $this->fileInfo[0];
        $this->outputHeight = $this->fileInfo[1];
    }

    public function getFile() {
        return $this->file;
    }

    public function getFileInfo() {
        return $this->fileInfo;
    }

    public function getOutputWidth() {
        return $this->outputWidth;
    }

    public function getOutputHeight() {
        return $this->outputHeight;
    }

    /**
     * Calculates the output image's height based on the desired width
     * 
     * @param int $width 
     */
    public function scaleWidthTo($width) {
        $this->outputWidth = $width;
        $this->outputHeight = $this->fileInfo[1] * ($width / $this->fileInfo[0]);
    }

    /**
     * Calculates the output image's width based on the desired height
     * 
     * @param int $height 
     */
    public function scaleHeightTo($height) {
        $this->outputHeight = $height;
        $this->outputWidth = $this->fileInfo[0] * ($height / $this->fileInfo[1]);
    }

    /**
     * Calculate width and height of output image based on scale change given as procentage
     * 
     * @param int $procent 
     */
    public function scaleBothTo($procent) {
        $this->outputWidth = $this->fileInfo[0] * $procent / 100;
        $this->outputHeight = $this->fileInfo[1] * $procent / 100;
    }

    /**
     * Process the Scaling and creates an output image
     * 
     * @return boolean True on success false on failure
     */
    public function processScaling() {
        if (($this->fileInfo[2] == IMAGETYPE_JPEG) || ($this->fileInfo[2] == IMAGETYPE_PNG)) {

            //Check original image-type and create suitable image layer
            if ($this->fileInfo[2] == IMAGETYPE_JPEG)
                $old_img = imagecreatefromjpeg($this->file);

            elseif ($this->fileInfo[2] == IMAGETYPE_PNG)
                $old_img = imagecreatefrompng($this->file);

            //Create new image with desired width and height
            $new_img = imagecreatetruecolor($this->outputWidth, $this->outputHeight);

            //Merge the new image and the old image (just like layers in photoshop)
            imagecopyresampled($new_img, $old_img, 0, 0, 0, 0, $this->outputWidth, $this->outputHeight, $this->fileInfo[0], $this->fileInfo[1]);

            //Store image resource
            $this->image = $new_img;

            //Free memory
            imagedestroy($old_img); //$new_img will be destoyed on __destruct

            return true;
        }
        else
            return false;
    }

    /**
     * Set cut width
     * 
     * @param int $width 
     */
    public function cutWidthTo($width) {
        $this->outputWidth = $width;
    }

    /**
     * Set cut height
     * 
     * @param int $height 
     */
    public function cutHeightTo($height) {
        $this->outputHeight = $height;
    }

    /**
     * Set cut width and height
     * 
     * @param array $dimensions ex array(800,600)
     */
    public function cutBothTo(array $dimensions) {
        $this->cutWidthTo($dimensions[0]);
        $this->cutHeightTo($dimensions[1]);
    }

    /**
     * Process image cutting using a given orientation. 
     * 
     * Orientations:
     *      LEFT    = cut from (0,0) to (outputWidth, outputHeight)
     *      Center  = cut from (centerX - outputWidth / 2, centerY - outputHeight/2) to (outputWidth, outputHeight)
     *      Right   = cut from (imageWidth - outputWidth,0) to (outputWidth, outputHeight)
     * 
     * @param int $orientation Static class variables, ex self::$LEFT
     * @return boolean True on success, false on failure.
     */
    public function processCutting($orientation) {
        if ((($this->fileInfo[2] == IMAGETYPE_JPEG) || ($this->fileInfo[2] == IMAGETYPE_PNG)) && is_int($orientation)) {

            //Check original image-type and create suitable image layer
            if ($this->fileInfo[2] == IMAGETYPE_JPEG)
                $old_img = imagecreatefromjpeg($this->file);

            elseif ($this->fileInfo[2] == IMAGETYPE_PNG)
                $old_img = imagecreatefrompng($this->file);

            //Create new image with desired width and height
            $new_img = imagecreatetruecolor($this->outputWidth, $this->outputHeight);

            if ($orientation == self::$LEFT) {
                imagecopy($new_img, $old_img, 0, 0, 0, 0, $this->outputWidth, $this->outputHeight);
            } else if ($orientation == self::$CENTER) {
                imagecopy($new_img, $old_img, 0, 0, ($this->fileInfo[0] / 2) - ($this->outputWidth / 2), ($this->fileInfo[1] / 2) - ($this->outputHeight / 2), $this->outputWidth, $this->outputHeight);
            } else if ($orientation == self::$RIGHT) {
                imagecopy($new_img, $old_img, 0, 0, $this->fileInfo[0] - $this->outputWidth, 0, $this->outputWidth, $this->outputHeight);
            }

            $this->image = $new_img;

            //Free memory
            imagedestroy($old_img); //$new_img will be destoyed on __destruct

            return true;
        }
        else
            return false;
    }

    /**
     * Save image to the harddrive as PNG
     * 
     * @param string $filename filename the image will be stored under 
     *      WARNING: don't put .png at the end of the filename
     * @return boolean true on success, false on failure 
     */
    public function savePNG($filename) {       
        if (!empty($this->image)) {
            return imagepng($this->image, $filename . ".png");
        } else {
            return false;
        }
    }

    /**
     * Save image to the harddrive as JPEG
     * 
     * @param string $filename filename the image will be stored under 
     *      WARNING: don't put .jpog at the end of the filename
     * @return boolean true on success, false on failure 
     */
    public function saveJPEG($filename) {
        if (!empty($this->image)) {
            return imagejpeg($this->image, $filename . ".jpeg");
        } else {
            return false;
        }
    }

    /**
     * Output Buffers image and returns it
     * 
     * @return string/boolean image as string if exists, false on failure.
     */
    public function getImage() {
        if (!empty($this->image)) {
            //Start output buffer
            ob_start();

            //Output
            imagepng($this->image);

            //Put the output in a variable
            $imagevariable = ob_get_contents();

            //Clean the buffer
            ob_end_clean();

            return $imagevariable;
        }
        else
            return false;
    }

    function __destruct() {
        if ($this->image != null)
            imagedestroy($this->image);
    }

}