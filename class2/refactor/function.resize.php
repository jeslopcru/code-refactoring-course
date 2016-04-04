<?php

require 'autoload.php';

function doResize($imagePath, $newPath, $configuration) {
	$resizerOptions = new ResizerOptions($configuration);
	$cmd = $resizerOptions->obtainResizerOption($imagePath,$newPath);

	$c = exec($cmd, $output, $return_code);
	if($return_code != 0) {
		error_log("Tried to execute : $cmd, return code: $return_code, output: " . print_r($output, true));
		throw new RuntimeException();
	}
}

function resize($imagePath,$opts=null){


	$configuration = new Configuration($opts);
	$urlPath = new UrlImage($imagePath);
	
	$resizer = new Resizer($urlPath, $configuration);
	
	if(empty($configuration->obtainOutputFilename()) && empty($configuration->obtainWidth()) && empty($configuration->obtainHeight())) {
		return 'cannot resize the image';
	}
	
	try {
		
		$imagePath = $resizer->obtainFilePath();
	} catch (Exception $e) {
		return 'image not found';
	}
	$path = new ImagePath($configuration);
	$newPath = $path->composeNewPath($imagePath);

	if($path->isInCache($newPath, $imagePath) == false):
		try {
			doResize($imagePath, $newPath, $configuration);
		} catch (Exception $e) {
			return 'cannot resize the image';
		}
	endif;

	// The new path must be the return value of resizer resize

	$cacheFilePath = str_replace($_SERVER['DOCUMENT_ROOT'],'',$newPath);

	return $cacheFilePath;

}
