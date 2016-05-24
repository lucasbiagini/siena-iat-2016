var eKey = 69
var iKey = 73
var spaceKey = 32

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex ;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}

function makeSpan(colorNumber, value) {
  return "<span class='color"+ colorNumber +"'>" + value + "</span>";
}

function sendData(jsonMatrix, categories_order) {
  $.post( "ajax/iat.php", {"matrix" : jsonMatrix, "type": 1, "categories_order": categories_order}, function(result) {
      $("#results").html(result);
  });
}

function newState() {
	if (Math.floor((Math.random()*2)) == 0) {
		return 'LEFT';
	} else {
		return 'RIGHT';
	}
}

function iat (concepts, attributes, wordArrs) {

	categories_order = concepts[1] + ", " + concepts[2] + ", " + attributes[1] + ", " + attributes[2];

	// The shape of the matrix is (block number, [word shown, respone time, correct, word's con/attr], trial number]
	matrixReturn = [[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]]];
	i = 0;
	//Current/starting trials

	// CHANGE AFTER DEBUGGING
	//numTrials = 5;
	numTrials = 20;

	//Current block on; always start with 1
	curBlock = 1;
	//Current trial on; always start with 1
	curTrial = 1;
	currentState = "NEW_BLOCK"
	start = 0;
	diff = 0;
	post = 0;

	nameLeft = makeSpan(1, concepts[1]);
	nameRight = makeSpan(1, concepts[2]);

	$("#directions").html(numTrials + " words will be shown. Press 'e' if the word is "
			+ nameLeft.toLowerCase()  + ", 'i' if the word is " + nameRight.toLowerCase() + ".");
	$("#left").html(nameLeft);
	$("#right").html(nameRight);
	$("#start").show();
	$("#error").hide();

	//$(document).keyup(function(e) {
	$(document).keydown(function(e) {
		$("#error").hide();

		// arrLeftCon represents the array containing the list of concepts on the left
		// arrLeftAttr represents the array containing the list of attributes on the left
		switch (curBlock) {
			case 1:
				arrLeft = wordArrs['concept1'];
				arrRight = wordArrs['concept2'];
				break;
			case 2:
				arrLeft = wordArrs['attribute1'];
				arrRight = wordArrs['attribute2'];					 
				break;
			case 3:
				arrLeftCon = wordArrs['concept1'];
				arrLeftAttr = wordArrs['attribute1'];
				arrRightCon = wordArrs['concept2'];
				arrRightAttr = wordArrs['attribute2'];
				break;
			case 4:
				arrLeftCon = wordArrs['concept1'];
				arrLeftAttr = wordArrs['attribute1'];
				arrRightCon = wordArrs['concept2'];
				arrRightAttr = wordArrs['attribute2'];
				break;
			case 5:
				arrLeft = wordArrs['concept2'];
				arrRight = wordArrs['concept1'];
				break;
			case 6:
				arrLeftCon = wordArrs['concept2'];
				arrLeftAttr = wordArrs['attribute1'];
				arrRightCon = wordArrs['concept1'];
				arrRightAttr = wordArrs['attribute2'];
				break;
			case 7:
				arrLeftCon = wordArrs['concept2'];
				arrLeftAttr = wordArrs['attribute1'];
				arrRightCon = wordArrs['concept1'];
				arrRightAttr = wordArrs['attribute2'];
				break;
			default:
				currentState = "DONE";
				break;				
		}
				

		// This if block is run at the beginning of each IAT block
		if (e.which == spaceKey && currentState == "NEW_BLOCK") {
			$("#start").hide();
			date = new Date();
			seconds = date.getTime()/1000;
			start = seconds;
			
			if (curBlock == 1 || curBlock == 2 || curBlock == 5) {
				arrLeftStack =  shuffle(arrLeft.slice());
				arrRightStack = shuffle(arrRight.slice());
			} else { // if ( curBlock == 3, 4, 6, 7 )
				arrLeftStack = shuffle(arrLeftCon.concat(arrLeftAttr));
				arrRightStack = shuffle(arrRightCon.concat(arrRightAttr));
			/*
				arrLeftConStack = shuffle(arrLeftCon.slice());
				arrLeftAttrStack = shuffle(arrLeftAttr.slice());

				arrRightConStack = shuffle(arrRightCon.slice());
				arrRightAttrStack = shuffle(arrRightAttr.slice());

				// I have no idea what this modulus is doing
				if (curTrial%2 == 0) {
					arrRightStack = arrRightConStack;
					arrLeftStack = arrLeftConStack;
				} else {
					arrLeftStack = arrLeftAttrStack;
					arrRightStack = arrRightAttrStack;
				}
				*/

			}

			currentState = newState();
			// If currentState is < 5 the value comes from the left array, else the right
			if(currentState == 'LEFT'){
				item = arrLeftStack.pop();
			}	else {
				item = arrRightStack.pop();
			}
					
			if (wordArrs['concept1'].indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color1");
				matrixReturn[curBlock-1][3][i] = concepts[1];
			} else if(wordArrs['concept2'].indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color1");
				matrixReturn[curBlock-1][3][i] = concepts[2];
			} else if(wordArrs['attribute1'].indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color2");
				matrixReturn[curBlock-1][3][i] = attributes[1];
			} else if(wordArrs['attribute2'].indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color2");
				matrixReturn[curBlock-1][3][i] = attributes[2];
			}

			$("#console").html(item);

			matrixReturn[curBlock-1][0][i] = item;
		} else if ((e.which == eKey || e.which == iKey) && currentState != "NEW_BLOCK" && currentState != "DONE") {
			// Not sure if we need a new date object here
			date = new Date();
			seconds = date.getTime()/1000;
			diff = seconds - start; // time to select an answer
			start = seconds;
			matrixReturn[curBlock-1][1][i] = diff;
			// An entry of 0 in matrixReturn[?][2][?] represents a correct answer
			if ((e.which == eKey && currentState == 'LEFT') || (e.which == iKey && currentState == 'RIGHT')) {
				matrixReturn[curBlock-1][2][i] = 0;
				curTrial++;

				// Reseting for the next block
				if (curTrial > numTrials) {
					$("#error").hide();																		
					curTrial = 1;
					curBlock++;
					if (curBlock == 1 || curBlock == 2 || curBlock == 3 || curBlock == 6) {
						// CHANGE AFTER DEBUGGING
						//numTrials = 5;
						numTrials = 20;
					} else if (curBlock == 4 || curBlock == 5 || curBlock == 7) {
						// CHANGE AFTER DEBUGGING
						//numTrials = 10;
						numTrials = 40;
					}
					currentState = "NEW_BLOCK";
					$("#console").html("");
					$("#start").show();
					i = 0;
				} else { // If not reseting
					currentState = newState();
					//
					// If both sides are empty
					if (arrLeftStack.length == 0 && arrRightStack.length == 0) {
						arrLeftStack = arrLeft.slice();
						arrRightStack = arrRight.slice();
					} else { // If once side is non-empty
						if (arrLeftStack.length == 0) {
							// Why is being set to 7?!
							currentState = 'RIGHT';
						} 
						if (arrRightStack.length == 0) {
							currentState = 'LEFT';
						}
					}

					// Not sure why they are being shuffled here
					arrLeftStack = shuffle(arrLeftStack);
					arrRightStack = shuffle(arrRightStack);
					
					if ( currentState == 'LEFT' ){
						item = arrLeftStack.pop();
					} else { 						
						item = arrRightStack.pop();
					}								

					if (wordArrs['concept1'].indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color1");
						matrixReturn[curBlock-1][3][i+1] = concepts[1];
					} else if(wordArrs['concept2'].indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color1");
						matrixReturn[curBlock-1][3][i+1] = concepts[2];
					} else if(wordArrs['attribute1'].indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color2");
						matrixReturn[curBlock-1][3][i+1] = attributes[1];
					} else if(wordArrs['attribute2'].indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color2");
						matrixReturn[curBlock-1][3][i+1] = attributes[2];
					}

					$("#console").html(item);

					matrixReturn[curBlock-1][0][i+1] = item;
					i++;
				}
			} else {
				$("#error").show();
				matrixReturn[curBlock-1][2][i] = 1;
				matrixReturn[curBlock-1][0][i+1] = matrixReturn[curBlock-1][0][i];
				matrixReturn[curBlock-1][3][i+1] = matrixReturn[curBlock-1][3][i];
				i++;
			}


		}			
			
		// Sets the labels specifying which side the concepts/attributes are associated with
		switch (curBlock) {
			case 1:
				nameLeft  = makeSpan(1,concepts[1])
				nameRight = makeSpan(1,concepts[2])
				break;
			case 2:
				nameLeft  = makeSpan(2,attributes[1])
				nameRight = makeSpan(2,attributes[2])
				break;
			case 3:
				nameLeft  = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[1])
				nameRight = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[2])
				break;
			case 4:
				nameLeft  = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[1])
				nameRight = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[2])
				break;
			case 5:
				nameLeft  = makeSpan(1,concepts[2])
				nameRight = makeSpan(1,concepts[1])
				break;
			case 6:
				nameLeft  = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[1])
				nameRight = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[2])
				break;
			case 7:
				nameLeft  = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[1])
				nameRight = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[2])
				break;
			default:
				currentState = "DONE";
				break;				
		}
		if (currentState != "DONE") {
			$("#directions").html(numTrials + " words will be shown. Press 'e' if the word is "
					+ nameLeft.toLowerCase()  + ", 'i' if the word is " + nameRight.toLowerCase() + ".");
			$("#left").html(nameLeft.replace(" or ", "<br>or<br>"));
			$("#right").html(nameRight.replace(" or ", "<br>or<br>"));
		} else {
			$("#start").hide();
			$("#console").removeClass();
			$("#console").html("You have completed the IAT");
			$("#directions").html("");
			$("#left").html("");
			$("#right").html("");
			jsonMatrix = JSON.stringify(matrixReturn);
			$('body').html(jsonMatrix)
			
			if (post == 0) {
        sendData(jsonMatrix, categories_order)
				post = 1;
			}
		}
	});
	
	// Ending iat()
}


