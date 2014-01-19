/*
	Developed by Matthew Herbst (github.com/MatthewHerbst) at MHacks III. Detroit, MI 1/17/2014 - 1/19/2014

	For the availability of their data, many many thanks to:
	https://drupal.org/project/namedb
	http://download.geonames.org/export/
	http://wordnet.princeton.edu/wordnet/download/current-version/
*/

var hostname = 'http://ec2-54-200-198-231.us-west-2.compute.amazonaws.com/';
var db = 'howiknowit';

//Retrieve the MongoDB Client
var MongoClient = require('mongodb').MongoClient;

/*
	Save the media information and then parse it
*/
function processMedia(media) {
	//TODO: should parse media title for words too!

	//Create a new entry from the media item
	var entry = {
					title 	: media.title,
					content : media.content
				};

	//Connect to the db
	MongoClient.connect('mongodb://localhost:27017/' + db, function(err, db) {
		if(!err) {
    		console.log('Connected to ' + db);

    		//Add the entry for the media item into the db
    		//TODO: show check for insert error
    		var media_id = db.collection('media').insert(entry);

    		//TODO: will eventually need if-else checks on media.type to decide what function to call here
    		parseText(media_id, media.content);
  		} else {
  			console.log('Error connecting to ' + db + '\n' + err);
  		}
	});
};

/*
	Go through the text of the media and process it
*/
function parseText(media_id, text) {
	//Find all the paragraphs (denoted here as two spaces)
	var paragraphs = text.split('\n\n'); //TODO: this is far from perfect

	//Go through each paragraph
	for(var i = 0; i < paragraphs.length; ++i) {
		//Create an entry for it
		var entry = {
						media_id : media_id,
						number	 : i,
						content	 : paragraphs[i]
					};
		
		//Connect to the db
		MongoClient.connect('mongodb://localhost:27017/' + db, function(err, db) {
			if(!err) {
	    		console.log('Connected to ' + db);

	    		//Add the entry for the media item into the db
	    		//TODO: show check for insert error
	    		var paragraph_id = db.collection('paragraphs').insert(entry);
	    		console.log('Inserted paragraph ' + paragraph_id);

	    		//Find the words in the paragraph
	    		parseParagraph(media_id, paragraph_id, paragraphs[i]);
	  		} else {
	  			console.log('Error connecting to ' + db + '\n' + err);
	  		}
		});
	}
};

/*
	Generic method for inserting a document into the specified collection.
	//TODO: actually use this
*/
function insertIntoCollection(collection, entry) {
		//Connect to the db
		MongoClient.connect('mongodb://localhost:27017/' + db, function(err, db) {
			if(!err) {
	    		console.log('Connected to ' + db);

	    		//TODO: show check for insert error
	    		var id = db.collection(collection).insert(entry);
	    		console.log(id + ' inserted');

	    		return id;
	  		} else {
	  			console.log('Error connecting to ' + db + '\n' + err);
	  		}
		});
};

/*
	Parses individual words from the passed in paragraph
*/
function parseParagraph(media_id, paragraph_id, text) {
	//Remove punctuation then fix for extra spaces created by removing punctuation
	text = text.replace(/[\.,-\/#!$%\^&\*;:{}=\-_`~()]/g,"");
	text = text.replace(/\s{2,}/g," ");

	//Find every word
	var words = text.split(' ');

	//Go through all the found words
	for(var i = 0; i < words.length; ++i) {
		//Check to see if the word is in the blacklist
		if(!isBlack(words[i])) {
			//Add the word
			addWord(media_id, paragraph_id, words[i]);
		}
	}
};

/*
	Adds a word into the database
*/
function addWord(media_id, paragraph_id, word) {
	var entry = {
					media_id 	 : media_id,
					paragraph_id : paragraph_id,
					word 		 : word 
				};

	//Connect to the db
	MongoClient.connect('mongodb://localhost:27017/' + db, function(err, db) {
		if(!err) {
    		console.log('Connected to ' + db);

    		//Add the word into the db
    		//TODO: show check for insert error
    		var word_id = db.collection('words').insert(entry);
    		console.log('Inserted word ' + word_id);
  		} else {
  			console.log('Error connecting to ' + db + '\n' + err);
  		}
	});
};

/*
	Returns true if the given string can be parsed as a Date in JavaScript
	http://www.w3schools.com/jsref/jsref_parse.asp
*/
function isDate(text) {
	var d = Date.parse(text);
	var minutes = 1000 * 60;
	var hours = minutes * 60;
	var days = hours * 24;
	var years = days * 365;
	var y = Math.round(d/years);

	return y != 'NaN';
};