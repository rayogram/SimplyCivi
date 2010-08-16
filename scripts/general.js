// generic JS fixes

// various JavaScript object.
var SimplyCivi = {};

// jump to the value in a select drop down
SimplyCivi.go = function(e) {
  var destination = e.options[e.selectedIndex].value;
  if (destination && destination != 0) location.href = destination;
};

