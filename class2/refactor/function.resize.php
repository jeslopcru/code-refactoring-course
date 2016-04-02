<?php

require 'autoload.php';

function sanitize($path) {
	return urldecode($path);
}
function injectFileSystem(FileSystem $fileSystem)
{
	$this->fileSystem = $fileSystem;
}
function isInCache($path, $imagePath) {
	$isInCache = false;
	if(file_exists($path) == true):
		$isInCache = true;
		$origFileTime = date("YmdHis",filemtime($imagePath));
		$newFileTime = date("YmdHis",filemtime($path));
		if($newFileTime < $origFileTime): # Not using $opts['expire-time'] ??
			$isInCache = false;
		endif;
	endif;

	return $isInCache;
}

function composeNewPath($imagePath, $configuration) {
	$w = $configuration->obtainWidth();
	$h = $configuration->obtainHeight();
	$filename = md5_file($imagePath);
	$finfo = pathinfo($imagePath);
	$ext = $finfo['extension'];

	$cropSignal = $configuration->obtainCrop() == true ? "_cp" : "";
	$scaleSignal = $configuration->obtainScale() == true ? "_sc" : "";
	$widthSignal = !empty($w) ? '_w'.$w : '';
	$heightSignal = !empty($h) ? '_h'.$h : '';
	$extension = '.'.$ext;

	$newPath = $configuration->obtainCache() .$filename.$widthSignal.$heightSignal.$cropSignal.$scaleSignal.$extension;

	if($configuration->obtainOutputFilename()) {
		$newPath = $configuration->obtainOutputFilename();
	}

	return $newPath;
}

/**
 * @param Configuration $configuration
 * @param $imagePath
 * @param $newPath
 * @return string
 */
function defaultShellCommand($configuration, $imagePath, $newPath) {
	$w = $configuration->obtainWidth();
	$h = $configuration->obtainHeight();

	$command = $configuration->obtainConvertPath() ." " . escapeshellarg($imagePath) .
	" -thumbnail ". (!empty($h) ? 'x':'') . $w ."".
	($configuration->obtainMaxOnly()== true ? "\>" : "") .
	" -quality ". escapeshellarg($configuration->obtainQuality()) ." ". escapeshellarg($newPath);

	return $command;
}

function isPanoramic($imagePath) {
	list($width,$height) = getimagesize($imagePath);
	return $width > $height;
}

function composeResizeOptions($imagePath, $configuration) {
	$opts = $configuration->asHash();
	$w = $configuration->obtainWidth();
	$h = $configuration->obtainHeight();

	$resize = "x".$h;

	$hasCrop = (true === $opts['crop']);

	if(!$hasCrop && isPanoramic($imagePath)):
		$resize = $w;
	endif;

	if($hasCrop && !isPanoramic($imagePath)):
		$resize = $w;
	endif;

	return $resize;
}

function commandWithScale($imagePath, $newPath, $configuration) {
	$opts = $configuration->asHash();
	$resize = composeResizeOptions($imagePath, $configuration);

	$cmd = $configuration->obtainConvertPath() ." ". escapeshellarg($imagePath) ." -resize ". escapeshellarg($resize) .
		" -quality ". escapeshellarg($opts['quality']) . " " . escapeshellarg($newPath);

	return $cmd;
}

function commandWithCrop($imagePath, $newPath, $configuration) {
	$opts = $configuration->asHash();
	$w = $configuration->obtainWidth();
	$h = $configuration->obtainHeight();
	$resize = composeResizeOptions($imagePath, $configuration);

	$cmd = $configuration->obtainConvertPath() ." ". escapeshellarg($imagePath) ." -resize ". escapeshellarg($resize) .
		" -size ". escapeshellarg($w ."x". $h) .
		" xc:". escapeshellarg($opts['canvas-color']) .
		" +swap -gravity center -composite -quality ". escapeshellarg($opts['quality'])." ".escapeshellarg($newPath);

	return $cmd;
}

function doResize($imagePath, $newPath, $configuration) {
	$opts = $configuration->asHash();
	$w = $configuration->obtainWidth();
	$h = $configuration->obtainHeight();

	if(!empty($w) and !empty($h)):
		$cmd = commandWithCrop($imagePath, $newPath, $configuration);
		if(true === $opts['scale']):
			$cmd = commandWithScale($imagePath, $newPath, $configuration);
		endif;
	else:
		$cmd = defaultShellCommand($configuration, $imagePath, $newPath);
	endif;

	$c = exec($cmd, $output, $return_code);
	if($return_code != 0) {
		error_log("Tried to execute : $cmd, return code: $return_code, output: " . print_r($output, true));
		throw new RuntimeException();
	}
}

function resize($imagePath,$opts=null){


	$path = new ImagePath($imagePath);
	$configuration = new Configuration($opts);

	$resizer = new Resizer($path, $configuration);

	// This has to go to Configuration as Exception in initialization

	if(empty($configuration->asHash()['output-filename']) && empty($w) && empty($h)) {
		return 'cannot resize the image';
	}

	// This has to be done in resizer resize

	try {
		$imagePath = $resizer->obtainFilePath();
	} catch (Exception $e) {
		return 'image not found';
	}


	$newPath = composeNewPath($imagePath, $configuration);

    $create = !isInCache($newPath, $imagePath);

	if($create == true):
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
