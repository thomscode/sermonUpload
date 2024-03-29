<?php

/**************************************************
*	Thom Williams
*	201102W0001
*	CET-482
*	Senior Project - Sermon Uploader
**************************************************/


/*
This page is referenced from javascript and ajax
It provides Bible book, chapter, and verse information
	for the main page
*/
require_once "../mysql/Bible.php";

$bible = new Bible($localdb);


// Get the information from the Ajax request
if ($_POST) extract($_POST);
else if ($_GET) extract($_GET);

// Send the initial information
if ($method == "init") {
	$bookList	= $bible->get_books();
	$chapNum	= $bible->get_chapters_by_book($bookList[0]['bnum']);
	$verseNum = $bible->get_verses_by_chapter($bookList[0]['bnum'], 1);
	$verseText = $bible->get_verse_text(1, 1, 1, $verseNum);
	$output = array(
		"bookList" => $bookList,
		"chapNum" => $chapNum,
		"verseNum" => $verseNum,
		"verseText" => $verseText,
	);
	echo json_encode($output);
}

// If the book was changed
if ($method == 'bookChange') {
	$chapNum = $bible->get_chapters_by_book($book);
	$verseNum = $bible->get_verses_by_chapter($book, 1);
	$verseText = $bible->get_verse_text($book, 1, 1, $verseNum);
	$output = array(
		"chapNum" => $chapNum,
		"verseNum" => $verseNum,
		"verseText" => $verseText,
	);
	echo json_encode($output);
}

// If the chapter changed
if ($method == 'chapterChange')
{
	$startVerseNum = $bible->get_verses_by_chapter($book, $startChapter);
	$endVerseNum = $bible->get_verses_by_chapter($book, $endChapter);
	$verseText = $bible->get_verse_text($book, $startVerse, $startChapter, $endVerse, $endChapter);
	$output = array(
		"startVerseNum" => $startVerseNum,
		"endVerseNum" => $endVerseNum,
		"verseText" => $verseText,
	);
	echo json_encode($output);
}

// If the verse changed
if ($method == 'verseChange')
{
	$verseText = $bible->get_verse_text($book, $startVerse, $startChapter, $endVerse, $endChapter);
	$output = array(
		"verseText" => $verseText,
	);
	echo json_encode($output);
}

?>