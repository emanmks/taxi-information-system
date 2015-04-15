<?php

class imageResize
{
	var $imageName;
	var $resizedImageName;
	var $newWidth;
	var $newHeight;
	var $srcImage;
	var $destImage;
	
	function resizeImage()
	{
		$old_x = imagesx($this->srcImage);
		$old_y = imagesy($this->srcImage);
		
		if($old_x > $old_y)
		{
			$thumb_w = $this->newWidth;
			$thumb_h = $old_y*($this->newHeight/$old_x);
		}
		
		if($old_x < $old_y)
		{
			$thumb_w = $old_x*($this->newWidth/$old_y);
			$thumb_h = $this->newHeight;
		}
		
		if($old_x == $old_y)
		{
			$thumb_w = $this->newWidth;
			$thumb_h = $this->newHeight;
		}
		
		$this->destImage = Imagecreatetruecolor($thumb_w,$thumb_h);
		imagecopyresized($this->destImage,$this->srcImage,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	}	
}

class imageResizeJpeg extends imageResizeClass
{
	function __construct($imageName, $resizedImageName, $newWidth, $newHeight)
	{
		$this->imageName = $imageName;
		$this->resizedImageName = $resizedImageName;
		$this->newWidth = $newWidth;
		$this->newHeight = $newHeight;
	}
	
	function getResizedImage()
	{
		$this->srcImage = imagecreatefromjpeg($this->imageName);
		$this->resizeImage();
		imagejpeg($this->destImage, $this->resizedImageName);
	}
}

class imageResizePng extends imageResizeClass
{
	function __construct($imageName, $resizedImageName, $newWidth, $newHeight)
	{
		$this->imageName = $imageName;
		$this->resizedImageName = $resizedImageName;
		$this->newWidth = $newWidth;
		$this->newHeight = $newHeight;
	}
	
	function getResizedImage()
	{
		$this->srcImage = imagecreatefrompng($this->imageName);
		$this->resizeImage();
		imagepng($this->destImage, $this->resizedImageName);
	}
}

class imageResizeGif extends imageResizeClass
{
	function __construct($imageName, $resizedImageName, $newWidth, $newHeight)
	{
		$this->imageName = $imageName;
		$this->resizedImageName = $resizedImageName;
		$this->newWidth = $newWidth;
		$this->newHeight = $newHeight;
	}
	
	function getResizedImage()
	{
		$this->srcImage = imagecreatefromgif($this->imageName);
		$this->resizeImage();
		imagegif($this->destImage, $this->resizedImageName);
	}
}