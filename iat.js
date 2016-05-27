const E_KEY = 69
const I_KEY = 73
const SPACE_KEY = 32

// The array index corresponds to the block number (there is no Block 0)
const trialLengths = [-1, 20, 20, 20, 40, 40, 20, 40]
//const trialLengths = [-1, 5, 5, 5, 10, 10, 5, 10]

var wordArrs;
var concepts;
var attributes;
var curBlock = 0;
var curTrial;
var currentState;
var dataSent = false;

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

function getBlockWords() {
  if (typeof(curBlock) === 'undefined')
    throw Error('curBlock must be defined')
  if (typeof(wordArrs) === 'undefined')
    throw Error('wordArrs must be defined')

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
  return blockWords;
}

/**
 * Sets the information regarding the displayed word
 */
function setWordInfo(item, matrix) {
  var value;
  if (wordArrs['concept1'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color1");
    value = concepts[1];
  } else if(wordArrs['concept2'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color1");
    value = concepts[2];
  } else if(wordArrs['attribute1'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color2");
    value = attributes[1];
  } else if(wordArrs['attribute2'].indexOf(item) >= 0) {
    $("#console").removeClass();
    $("#console").addClass("color2");
    value = attributes[2];
  } else {
    throw Error("item was not found in any word lists")
  }
  matrix[curBlock-1][3][curTrial] = value;
}

function getSideLabels() {
  var labels = {}
  switch (curBlock) {
    case 1:
      labels['LEFT']  = makeSpan(1,concepts[1])
      labels['RIGHT'] = makeSpan(1,concepts[2])
      break;
    case 2:
      labels['LEFT']  = makeSpan(2,attributes[1])
      labels['RIGHT'] = makeSpan(2,attributes[2])
      break;
    case 3:
      labels['LEFT']  = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[1])
      labels['RIGHT'] = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[2])
      break;
    case 4:
      labels['LEFT']  = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[1])
      labels['RIGHT'] = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[2])
      break;
    case 5:
      labels['LEFT']  = makeSpan(1,concepts[2])
      labels['RIGHT'] = makeSpan(1,concepts[1])
      break;
    case 6:
      labels['LEFT']  = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[1])
      labels['RIGHT'] = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[2])
      break;
    case 7:
      labels['LEFT']  = makeSpan(1,concepts[2]) + " or " + makeSpan(2,attributes[1])
      labels['RIGHT'] = makeSpan(1,concepts[1]) + " or " + makeSpan(2,attributes[2])
      break;
    default:
      break;        
  }
  return labels;
}

function endIAT(matrix, categories_order) {
  $("#start").hide();
  $("#console").removeClass();
  $("#console").html("You have completed the IAT");
  $("#directions").html("");
  $("#left").html("");
  $("#right").html("");
  jsonMatrix = JSON.stringify(matrix);
  console.log(matrix)
  
  if (!dataSent) {
    sendData(jsonMatrix, categories_order)
    dataSent = true;
  }
}

function checkStacks(wordStack) {
  var state = currentState;
  if (wordStack['LEFT'].length == 0 && wordStack['RIGHT'].length == 0) {
    wordStack['LEFT'] = blockWords['LEFT'].slice();
    wordStack['RIGHT'] = blockWords['RIGHT'].slice();
  } else { // If once side is non-empty
    if (wordStack['LEFT'].length == 0) {
      state = 'RIGHT';
    } 
    if (wordStack['RIGHT'].length == 0) {
      state = 'LEFT';
    }
  }
  return state;
}

function setLabels(trials, labels) {
  $("#directions").html(trials + " words will be shown. Press “e” if the word is "
      + labels['LEFT'].toLowerCase()  + ", “i” if the word is " + labels['RIGHT'].toLowerCase() + ".");
  $("#left").html(labels['LEFT']);
  $("#right").html(labels['RIGHT']);
  if (currentState == 'NEW_BLOCK') {
    $("#start").show();
    $("#error").hide();
  }

}

function nextBlock() {
  curTrial = 0;
  curBlock++;
  currentState = "NEW_BLOCK";
  $("#console").html("");
  $("#start").show();
}

function isCorrect(e) {
return (e.which == E_KEY && currentState == 'LEFT')
  || (e.which == I_KEY && currentState == 'RIGHT')
}

function onKeyDown(e, wordStack, dataMatrix, categories_order) {
  if (currentState == 'DONE')
    return;

  blockWords = getBlockWords(curBlock, wordArrs);
  if (Object.keys(blockWords).length == 0)
    currentState = 'DONE';

  // This if block is run at the beginning of each IAT block
  if (e.which == SPACE_KEY && currentState == "NEW_BLOCK") {
    $("#start").hide();
    wordStack['LEFT']  = shuffle(blockWords['LEFT'].slice());
    wordStack['RIGHT'] = shuffle(blockWords['RIGHT'].slice());
    start = new Date().getTime()/1000;
    currentState = newState();

    var item = wordStack[currentState].pop();
    setWordInfo(item, dataMatrix);
    $("#console").html(item);
    dataMatrix[curBlock-1][0][curTrial] = item;

  } else if ((e.which == E_KEY || e.which == I_KEY) && (currentState == "LEFT" || currentState == "RIGHT")) {
    var seconds = new Date().getTime()/1000;
    if (typeof dataMatrix[curBlock-1][1][curTrial] === 'undefined') {
      dataMatrix[curBlock-1][1][curTrial] = seconds - start;
      console.log("Setting: " + dataMatrix[curBlock-1][1][curTrial])
    }
    start = seconds;

    // If the correct key is pressed
    if (isCorrect(e)) {
      // An entry of 0 in dataMatrix[?][2][?] represents a correct answer
      if (typeof dataMatrix[curBlock-1][2][curTrial] === 'undefined') {
        dataMatrix[curBlock-1][2][curTrial] = 0;
      }
      curTrial++;
      $("#error").hide();                                    

      // Reseting for the next block
      if (curTrial >= trialLengths[curBlock]) {
        nextBlock();
      } else { // If not reseting
        currentState = newState();
        currentState = checkStacks(wordStack);
        item = wordStack[currentState].pop();
        setWordInfo(item, dataMatrix);
        $("#console").html(item);
        dataMatrix[curBlock-1][0][curTrial] = item;
      }
    } else { // If the incorrect key is pressed
      $("#error").show();
      dataMatrix[curBlock - 1][2][curTrial] = 1;
    }
  }      
    
  sideLabels = getSideLabels();
  if (Object.keys(sideLabels).length == 0) {
    currentState = 'DONE';
  }

  if (currentState != "DONE") {
    setLabels(trialLengths[curBlock], sideLabels)
  } else {
    endIAT(dataMatrix, categories_order);
  }

}

function iat (argConcepts, argAttributes, argWordArrs) {
  
  concepts = argConcepts;
  attributes = argAttributes;
  wordArrs = argWordArrs;
  var categories_order = concepts[1] + ", " + concepts[2]
    + ", " + attributes[1] + ", " + attributes[2];
  // The shape of the matrix is (block number,
  // [word shown, respone time, correct, word's con/attr], trial number]
  var dataMatrix = [ [ [],[],[],[] ] , [ [],[],[],[] ] , [ [],[],[],[] ]
    , [ [],[],[],[] ] , [ [],[],[],[] ] , [ [],[],[],[] ] , [ [],[],[],[] ] ];

  var start = 0;
  nextBlock();

  var sideLabels = {};
  sideLabels['LEFT']  = makeSpan(1, concepts[1]); 
  sideLabels['RIGHT'] = makeSpan(1, concepts[2]); 
  setLabels(trialLengths[curBlock], sideLabels);

  var wordStack = {}
  var blockWords = {}

  $(document).keydown(function(e) {
    onKeyDown(e, wordStack, dataMatrix, categories_order);
  });
} 

