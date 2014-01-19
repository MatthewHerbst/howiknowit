<?php
$DB = "howiknowit";
$db = "";

/*
	Connect to the database
*/
function connectDB() {
	global $DB;
	global $db;
	
	//Connects to MongoDB instance running at localhost:27017
	$connection = new MongoClient();

	//Select a db
	$db = $connection->$DB;
}

/*
	Inserts the given document into the specified collection/table
*/
function insertIntoCollection($table, $document) {
	global $db;

	//Select the collection/table
	$collection = $db->$table;
	
	//Perform the insert
	$options = array("w" => 1)
	$result = $collection->insert($document, $options);

	//TODO: check for error

	//Return the generated ObjectId
	return $result['upserted'];
}

/*
	Queries the specified collection/table for documents using $q as the query
	Returns a cursor to the query results
*/
function queryCollection($collection, $q) {
	global $db;

	$cursor = $db->$collection->find($q);

	return $cursor;

	//TODO: error check
}

/*
	Returns an array containing the title of each media piece
*/
function getMedia() {
	global $db;

	//Array to store media items returned
	$media = array();

	//Get a cursor to the documents in the media collection
	$cursor = $db->"media"->find();

	//Iterate through all the items the cursor has access to
	foreach($cursor as $item)
	{
		//Put that item into the media array
    	array_push($media, $item->"title");
	}

	return $media;
}

/*
	Parses a large block of text
	Breaks the block in paragraphs, storing each in the database
	Further, looks at each word in each paragraph and keep track of important words
*/
function parseText($media_id, $text) {
	//Generate the paragraphs
	$paragraphs = explode("\n\n", $text);

	//Add each paragraph to the paragraph collection
	for($i = 0; $i < count($paragraphs); ++$i) {
		//Create the document
		$document = array(
							"media_id" => $media_id,
							"location" => $i,
							"text"	   => $paragraphs[$i];
						 );

		//Insert it into the paragraphs collection
		$paragraph_id = insertIntoCollection("paragraphs", $document);

		//Generate words from the paragraph
		parseWords($media_id, $paragraph_id, $paragraphs[$i]);
	}
}

/*
	Given a paragraph, extracts important words and saves them to the database
*/
function parseWords($media_id, $paragraph_id, $paragraph) {
	//Remove punctuation, then fix for extra white spaces
	$paragraph = preg_replace("/[^\w]+/", "", $paragraph);
	$paragraph = preg_replace("/\s{2,}/g", " ", $paragraph);

	//Generate an array of all the words
	$words = explode(" ", $paragraph);

	//Go through all the words
	for($i = 0; $i < count($words); ++$i) {

		//If the cursor returned no results
		if(!inBlacklist($words[$i])) {
			//Create the document for the word
			$document = array(
								"media_id" 		=> $media_id,
								"paragraph_id"	=> $paragraph_id,
								"word"			=> $words[$i]
							 );

			//Insert it into the words collection
			insertIntoCollection("words", $document);
		} //Else do nothing - we don't care about the word
	}
}

/*
	Checks to see if a given word is in the blacklist (the list of words deemed unimportant)
*/
function inBlacklist($word) {
	//Gets a cursor to the results of a query for the word
	$cursor = queryCollection("blacklist-words", array('word' => $word));

	return $cursor->count() > 0;
}

