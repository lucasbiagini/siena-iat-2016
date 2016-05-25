const E_KEY = 69
const I_KEY = 73
const SPACE_KEY = 32

var wordArrs;
var concepts;
var attributes;
var curBlock;
var i;
var curTrial;
var currentState;

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

function getBlockWords(curBlock, wordArrs) {
  var blockWords = {}
  switch (curBlock) {
    case 1:
      blockWords['LEFT'] = wordArrs['concept1'];
      blockWords['RIGHT'] = wordArrs['concept2'];
      break;
    case 2:
      blockWords['LEFT'] = wordArrs['attribute1'];
      blockWords['RIGHT'] = wordArrs['attribute2'];           
      break;
    case 3:
      blockWords['LEFT'] = wordArrs['concept1'].concat(wordArrs['attribute1']);
      blockWords['RIGHT'] = wordArrs['concept2'].concat(wordArrs['attribute2']);
      break;
    case 4:
      blockWords['LEFT'] = wordArrs['concept1'].concat(wordArrs['attribute1']);
      blockWords['RIGHT'] = wordArrs['concept2'].concat(wordArrs['attribute2']);
      break;
    case 5:
      blockWords['LEFT'] = wordArrs['concept2'];
      blockWords['RIGHT'] = wordArrs['concept1'];
      break;
    case 6:
      blockWords['LEFT'] = wordArrs['concept2'].concat(wordArrs['attribute1']);
      blockWords['RIGHT'] = wordArrs['concept1'].concat(wordArrs['attribute2']);
      break;
    case 7:
      blockWords['LEFT'] = wordArrs['concept2'].concat(wordArrs['attribute1']);
      blockWords['RIGHT'] = wordArrs['concept1'].concat(wordArrs['attribute2']);
      break;
    default:
      break;        
  }
  if (jQuery.isEmptyObject(blockWords)) {
    return false;
  } else {
    return blockWords;
  }
}

/**
 * Sets the information regarding the displayed word
 */
function setWordInfo(item, wordArrs, curBlock, matrix) {
  if (wordArrs['concept1'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color1");
    matrix[curBlock-1][3][i] = concepts[1];
  } else if(wordArrs['concept2'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color1");
    matrix[curBlock-1][3][i] = concepts[2];
  } else if(wordArrs['attribute1'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color2");
    matrix[curBlock-1][3][i] = attributes[1];
  } else if(wordArrs['attribute2'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color2");
    matrix[curBlock-1][3][i] = attributes[2];
  }
}

function iat (argConcepts, argAttributes, argWordArrs) {
  
  concepts = argConcepts;
  attributes = argAttributes;
  wordArrs = argWordArrs;

  var categories_order = concepts[1] + ", " + concepts[2] + ", " + attributes[1] + ", " + attributes[2];
  // The shape of the matrix is (block number, [word shown, respone time, correct, word's con/attr], trial number]
  var matrixReturn = [[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]],[[],[],[],[]]];
  i = 0;

  // CHANGE AFTER DEBUGGING
  //var numTrials = 5;
  var numTrials = 20;

  curBlock = 1;
  curTrial = 1;
  currentState = "NEW_BLOCK"
  var start = 0;
  var diff = 0;
  var post = 0;

  var nameLeft = makeSpan(1, concepts[1]);
  var nameRight = makeSpan(1, concepts[2]);

  $("#directions").html(numTrials + " words will be shown. Press 'e' if the word is "
      + nameLeft.toLowerCase()  + ", 'i' if the word is " + nameRight.toLowerCase() + ".");
  $("#left").html(nameLeft);
  $("#right").html(nameRight);
  $("#start").show();
  $("#error").hide();

  //$(document).keyup(function(e) {
  var wordStack = {}
  var blockWords = {}
  $(document).keydown(function(e) {
    $("#error").hide();

    //console.log("curTrial " + curTrial)
    //console.log("i        " + i)

    blockWords = getBlockWords(curBlock, wordArrs);
    if (blockWords == false) {
      currentState = 'DONE';
    }        

    // This if block is run at the beginning of each IAT block
    if (e.which == SPACE_KEY && currentState == "NEW_BLOCK") {
      $("#start").hide();
      var date = new Date();
      var seconds = date.getTime()/1000;
      var start = seconds;
      
      wordStack['LEFT']  = shuffle(blockWords['LEFT'].slice());
      wordStack['RIGHT'] = shuffle(blockWords['RIGHT'].slice());
      currentState = newState();
      var item = wordStack[currentState].pop();
          
      setWordInfo(item, wordArrs, curBlock, matrixReturn);

      $("#console").html(item);

      matrixReturn[curBlock-1][0][i] = item;
    //} else if ((e.which == E_KEY || e.which == I_KEY) && currentState != "NEW_BLOCK" && currentState != "DONE") {
    } else if ((e.which == E_KEY || e.which == I_KEY) && (currentState == "LEFT" || currentState == "RIGHT")) {
      // Not sure if these should be var's or not
      var date = new Date();
      var seconds = date.getTime()/1000;
      var diff = seconds - start; // time to select an answer
      var start = seconds;
      matrixReturn[curBlock-1][1][i] = diff;
      // An entry of 0 in matrixReturn[?][2][?] represents a correct answer
      if ((e.which == E_KEY && currentState == 'LEFT') || (e.which == I_KEY && currentState == 'RIGHT')) {
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
          if (wordStack['LEFT'].length == 0 && wordStack['RIGHT'].length == 0) {
            wordStack['LEFT'] = blockWords['LEFT'].slice();
            wordStack['RIGHT'] = blockWords['RIGHT'].slice();
          } else { // If once side is non-empty
            if (wordStack['LEFT'].length == 0) {
              currentState = 'RIGHT';
            } 
            if (wordStack['RIGHT'].length == 0) {
              currentState = 'LEFT';
            }
          }

          // Not sure why they are being shuffled here
          wordStack['LEFT'] = shuffle(wordStack['LEFT'].slice());
          wordStack['RIGHT'] = shuffle(wordStack['RIGHT'].slice());
          
          if ( currentState == 'LEFT' ){
            item = wordStack['LEFT'].pop();
          } else {             
            item = wordStack['RIGHT'].pop();
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
        // This might be recording data points that we do not want recorded
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
      // Good for debugging
      //$('body').html(jsonMatrix)
      
      if (post == 0) {
        sendData(jsonMatrix, categories_order)
        post = 1;
      }
    }
  });
  
  // Ending iat()
}


