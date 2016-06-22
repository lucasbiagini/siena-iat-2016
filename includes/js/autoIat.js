function kd(keyVal) {
  $("body").trigger ( {
    type: 'keydown', keyCode: keyVal, which: keyVal, charCode: keyVal
  } );
}
function autoIat() {
  for (var h = 0; h < 7; h++) {
    kd(32);
    for (var i = 0; i < 80; i++) {
      keyVal = 69 + ((i%2)*4);
      kd(keyVal)
    }
  }
}
autoIat()
