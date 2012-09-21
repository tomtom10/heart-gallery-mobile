<?php

class ThumbnailCreator {
	public static function create($originalFilePath, $size, $directory) {
		# Find dimensions of resized thumbnail
		$originalImage = imagecreatefromjpeg($originalFilePath);
		$originalWidth = imagesx($originalImage);
		$originalHeight = imagesy($originalImage);
		$smallerEdge = min($originalWidth, $originalHeight);
		$cropX = ($originalWidth - $smallerEdge) / 2;
		$cropY = ($originalHeight - $smallerEdge) / 2;

		# Resize and save thumbnail
		$thumbnailFileName = uniqid('thumbnail_') . ".jpg";
		$thumbnailFilePath = "$directory/$thumbnailFileName";
		$thumbnailImage = imagecreatetruecolor($size, $size);
		imagecopyresampled($thumbnailImage, $originalImage, 0, 0, $cropX, $cropY, $size, $size, $smallerEdge, $smallerEdge);
		imagejpeg($thumbnailImage, $thumbnailFilePath, 90);
		imagedestroy($originalImage);
		imagedestroy($thumbnailImage);

		return $thumbnailFileName;
	}
}
