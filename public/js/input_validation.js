// document.addEventListener("DOMContentLoaded", function() {
	// function numberOnly(evt) {
	  // var theEvent = evt || window.event;

	  // // Handle paste
	  // if (theEvent.type === 'paste') {
	  //     key = event.clipboardData.getData('text/plain');
	  // } else {
	  // // Handle key press
	  //     var key = theEvent.keyCode || theEvent.which;
	  //     key = String.fromCharCode(key);
	  // }
	  // var regex = /[0-9]|\./;
	  // if( !regex.test(key) ) {
	  //   theEvent.returnValue = false;
	  //   if(theEvent.preventDefault) theEvent.preventDefault();
	  // }

	//   this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
	// }
// });

function numberOnly(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}