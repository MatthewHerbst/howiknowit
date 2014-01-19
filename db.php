<?php
$DB = 'howiknowit';
$db;

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
	//Select the collection/table
	$collection = $db->$table;
	$collection->insert($document);

	//TODO: check for error
}

/*
	Queries the specified collection/table for documents
*/
function queryCollection($collection, $document) {
	$cursor = $db->$collection->find();
}

?>