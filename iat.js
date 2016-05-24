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


function iat (concept1, concept2, attribute1, attribute2, arrConcept1, arrConcept2, arrAttribute1, arrAttribute2) {

	categories_order = concept1 + ", " + concept2 + ", " + attribute1 + ", " + attribute2;
	matrixReturn = [[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]]];
	i = 0;
  //Current/starting trials
	numTrials = 20;
  //Current block on; always start with 1
	curBlock = 1;
  //Current trial on; always start with 1
	curTrial = 1;
	c = "?"
	start = 0;
	diff = 0;
	post = 0;

	nameLeft = makeSpan(1, concept1);
	nameRight = makeSpan(1, concept2);

	$("#directions").html(numTrials + " words will be shown. Press 'e' if the word is " + nameLeft.toLowerCase()  + ", 'i' if the word is " + nameRight.toLowerCase() + ".");
	$("#left").html(nameLeft);
	$("#right").html(nameRight);
	$("#start").show();
	$("#error").hide();

	$(document).keyup(function(e) {
		$("#error").hide();
		switch (curBlock) {
			case 1:
				arrLeft = arrConcept1;
				arrRight = arrConcept2;
				break;
			case 2:
				arrLeft = arrAttribute1;
				arrRight = arrAttribute2;					 
				break;
			case 3:
				arrLeft1 = arrConcept1;
				arrLeft2 = arrAttribute1;
				arrRight1 = arrConcept2;
				arrRight2 = arrAttribute2;
				break;
			case 4:
				arrLeft1 = arrConcept1;
				arrLeft2 = arrAttribute1;
				arrRight1 = arrConcept2;
				arrRight2 = arrAttribute2;
				break;
			case 5:
				arrLeft = arrConcept2;
				arrRight = arrConcept1;
				break;
			case 6:
				arrLeft1 = arrConcept2;
				arrLeft2 = arrAttribute1;
				arrRight1 = arrConcept1;
				arrRight2 = arrAttribute2;
				break;
			case 7:
				arrLeft1 = arrConcept2;
				arrLeft2 = arrAttribute1;
				arrRight1 = arrConcept1;
				arrRight2 = arrAttribute2;
				break;
			default:
				c = "DONE";
				break;				
		}
				

		if (e.which == spaceKey && c == "?") {
			$("#start").hide();
			date = new Date();
			seconds = date.getTime()/1000;
			start = seconds;
			
			if (curBlock == 1 || curBlock == 2 || curBlock == 5) {
				arrLeftStack =  shuffle(arrLeft.slice());
				arrRightStack = shuffle(arrRight.slice());
			} else {
				arrLeftStackAux1 = shuffle(arrLeft1.slice());
				arrLeftStackAux2 = shuffle(arrLeft2.slice());

				arrRightStackAux1 = shuffle(arrRight1.slice());
				arrRightStackAux2 = shuffle(arrRight2.slice());

				if (curTrial%2 == 0) {
					arrRightStack = arrRightStackAux1;
					arrLeftStack = arrLeftStackAux1;
				} else {
					arrLeftStack = arrLeftStackAux2;
					arrRightStack = arrRightStackAux2;
				}

			}

			c = Math.floor(Math.random() *10);
			if(c < 5){ 															//If random number < 5, pick from left array	
				item = arrLeftStack.pop();
			} 																			//Ends if statement to check if random number < 5
			else { 														//If random number >= 5, pick from right array
				
				item = arrRightStack.pop();
			}																			//Ends else if to choose positive word
					
			if (arrConcept1.indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color1");
				matrixReturn[curBlock-1][3][i] = concept1;
			} else if(arrConcept2.indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color1");
				matrixReturn[curBlock-1][3][i] = concept2;
			} else if(arrAttribute1.indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color2");
				matrixReturn[curBlock-1][3][i] = attribute1;
			} else if(arrAttribute2.indexOf(item) >= 0) {
				$("#console").removeClass();
				$("#console").addClass("color2");
				matrixReturn[curBlock-1][3][i] = attribute2;
			}

			$("#console").html(item);

			matrixReturn[curBlock-1][0][i] = item;
		} else if ((e.which == eKey || e.which == iKey) && c != "?" && c != "DONE") {
			date = new Date();
			seconds = date.getTime()/1000;
			diff = seconds - start; // time to select an answer
			start = seconds;
			matrixReturn[curBlock-1][1][i] = diff;
			if ((e.which == eKey && c < 5) || (e.which == iKey && c >= 5)) {
				matrixReturn[curBlock-1][2][i] = 0;
				curTrial++;
				if (curTrial > numTrials) {
					$("#error").hide();																		
					curTrial = 1;
					curBlock++;
					if (curBlock == 1 || curBlock == 2 || curBlock == 3 || curBlock == 6) {
						numTrials = 20;
					} else if (curBlock == 4 || curBlock == 5 || curBlock == 7) {
						numTrials = 40;
					}
					c = "?";
					$("#console").html("");
					$("#start").show();
					i = 0;
				} else {
					c = Math.floor(Math.random() *10);
					if (curBlock == 1 || curBlock == 2 || curBlock == 5) {
						if (arrLeftStack.length == 0 && arrRightStack.length == 0) {
							arrLeftStack = arrLeft.slice();
							arrRightStack = arrRight.slice();
						} else {
							if (arrLeftStack.length == 0) {
								c = 7;
							} 
							if (arrRightStack.length == 0) {
								c = 3;
							}
						}

						arrLeftStack = shuffle(arrLeftStack);
						arrRightStack = shuffle(arrRightStack);
					} else {
						if (curTrial%2 == 0) {
							if (arrLeftStackAux1.length == 0 && arrRightStackAux1.length == 0) {
								arrLeftStackAux1 = shuffle(arrLeft1.slice());
								arrRightStackAux1 = shuffle(arrRight1.slice());
							} else {
								if (arrLeftStackAux1.length == 0) {
									c = 7;
								} 
								if (arrRightStackAux1.length == 0) {
									c = 3;
								}
							}
							arrLeftStack = arrLeftStackAux1;
							arrRightStack = arrRightStackAux1;
						} else {
							if (arrLeftStackAux2.length == 0 && arrRightStackAux2.length == 0) {
								arrLeftStackAux2 = shuffle(arrLeft2.slice());
								arrRightStackAux2 = shuffle(arrRight2.slice());
							} else {
								if (arrLeftStackAux2.length == 0) {
									c = 7;
								} 
								if (arrRightStackAux2.length == 0) {
									c = 3;
								}
							}
							arrLeftStack = arrLeftStackAux2;
							arrRightStack = arrRightStackAux2;
						}
					}

					
					if(c < 5){ 													//If random number < 5, pick from left array
						item = arrLeftStack.pop();
					} 																			//Ends if statement to check if random number < 5
					else { 														//If random number >= 5, pick from right array
						item = arrRightStack.pop();
					}																			//Ends else if to choose positive word

					if (arrConcept1.indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color1");
						matrixReturn[curBlock-1][3][i+1] = concept1;
					} else if(arrConcept2.indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color1");
						matrixReturn[curBlock-1][3][i+1] = concept2;
					} else if(arrAttribute1.indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color2");
						matrixReturn[curBlock-1][3][i+1] = attribute1;
					} else if(arrAttribute2.indexOf(item) >= 0) {
						$("#console").removeClass();
						$("#console").addClass("color2");
						matrixReturn[curBlock-1][3][i+1] = attribute2;
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
				nameLeft  = makeSpan(1,concept1)
				nameRight = makeSpan(1,concept2)
				break;
			case 2:
				nameLeft  = makeSpan(2,attribute1)
				nameRight = makeSpan(2,attribute2)
				break;
			case 3:
				nameLeft  = makeSpan(1,concept1) + " or " + makeSpan(2,attribute1)
				nameRight = makeSpan(1,concept2) + " or " + makeSpan(2,attribute2)
				break;
			case 4:
				nameLeft  = makeSpan(1,concept1) + " or " + makeSpan(2,attribute1)
				nameRight = makeSpan(1,concept2) + " or " + makeSpan(2,attribute2)
				break;
			case 5:
				nameLeft  = makeSpan(1,concept2)
				nameRight = makeSpan(1,concept1)
				break;
			case 6:
				nameLeft  = makeSpan(1,concept2) + " or " + makeSpan(2,attribute1)
				nameRight = makeSpan(1,concept1) + " or " + makeSpan(2,attribute2)
				break;
			case 7:
				nameLeft  = makeSpan(1,concept2) + " or " + makeSpan(2,attribute1)
				nameRight = makeSpan(1,concept1) + " or " + makeSpan(2,attribute2)
				break;
			default:
				c = "DONE";
				break;				
		}
		if (c != "DONE") {
			$("#directions").html(numTrials + " words will be shown. Press 'e' if the word is " + nameLeft.toLowerCase()  + ", 'i' if the word is " + nameRight.toLowerCase() + ".");
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
			
			if (post == 0) {
        sendData(jsonMatrix, categories_order)
				post = 1;
			}
			
			
		}
	});
	
  // Ending iat()
}


