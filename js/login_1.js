// type anything here
var text = 'hover me';

// this function turns a string into an array
var createLetterArray = function createLetterArray(string) {
  return string.split('');
};

// this function creates letter layers wrapped in span tags
var createLetterLayers = function createLetterLayers(array) {
  return array.map(function (letter) {
    var layer = '';
    //specify # of layers per letter
    for (var i = 1; i <= 2; i++) {
      // if letter is a space
      if (letter == ' ') {
        layer += '<span class="space"></span>';
      } else {
        layer += '<span class="letter-' + i + '">' + letter + '</span>';
      }
    }
    return layer;
  });
};

// this function wraps each letter in a parent container
var createLetterContainers = function createLetterContainers(array) {
  return array.map(function (item) {
    var container = '';
    container += '<div class="wrapper">' + item + '</div>';
    return container;
  });
};

// use a promise to output text layers into DOM first
var outputLayers = new Promise(function (resolve, reject) {
  document.getElementById('text').innerHTML = createLetterContainers(createLetterLayers(createLetterArray(text))).join('');
  resolve();
});

// then adjust width and height of each letter
var spans = Array.prototype.slice.call(document.getElementsByTagName('span'));
outputLayers.then(function () {
  return spans.map(function (span) {
    setTimeout(function () {
      span.parentElement.style.width = span.offsetWidth + 'px';
      span.parentElement.style.height = span.offsetHeight + 'px';
    }, 250);
  });
}).then(function () {
  // then slide letters into view one at a time
  var time = 250;
  return spans.map(function (span) {
    time += 75;
    setTimeout(function () {
      span.parentElement.style.top = '0px';
    }, time);
  });
});