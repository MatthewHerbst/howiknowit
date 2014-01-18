var hostname = 'http://ec2-54-200-198-231.us-west-2.compute.amazonaws.com/';
var db = 'howiknowit';

//Retrieve
var MongoClient = require('mongodb').MongoClient;

/*
	Save the media information and then parse it
*/
function processMedia(media) {
	//Create a new entry from the media item
	var entry = {
					name 	: media.name,
					info 	: media.infoString,
					type 	: media.type,
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
	//TODO: eventually make this much more complicated (ex. helper methods below)
	
	//Find all the paragraphs (denoted here as two spaces)
	//TODO: this isn't perfect.
	var paragraphs = text.split('\n\n');

	//Go through each paragraph
	for(var i = 0; i < paragraphs.length; ++i) {
		//Create an entry for it
		var entry = {
						media_id : media_id,
						number	 : i,
						content	 : paragraphs[i]
					};

		//Add it to the database
		//Connect to the db
		MongoClient.connect('mongodb://localhost:27017/' + db, function(err, db) {
			if(!err) {
	    		console.log('Connected to ' + db);

	    		//Add the entry for the media item into the db
	    		//TODO: show check for insert error
	    		var paragraph_id = db.collection('paragraphs').insert(entry);
	    		console.log('Inserted paragraph ' + paragraph_id);

	    		//Find the words in the paragraph
	    		parseParagraph(paragraph_id, paragraphs[i]);
	  		} else {
	  			console.log('Error connecting to ' + db + '\n' + err);
	  		}
		});
	}

};

/*
	Parses individual words from the passed in paragraph
*/
function parseParagraph(paragraph_id, text) {

};

/* Need an order of precedence to check */
//TODO: verify precedence with ML

//http://www.w3schools.com/jsref/jsref_parse.asp
function isDate(text) {
	var d = Date.parse(text);
	var minutes = 1000 * 60;
	var hours = minutes * 60;
	var days = hours * 24;
	var years = days * 365;
	var y = Math.round(d/years);

	return y != 'NaN';
};

function isName(text) {

};

function isCity(text) {

};

function isQuotation(text) {

};

function isSpecialText(text) {

};