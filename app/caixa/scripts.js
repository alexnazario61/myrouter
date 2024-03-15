// Function to display or hide an element based on its current display style
function mostra_menu(element, event) {
  // Get the element by its ID
  var el = document.getElementById(element);

  // Check if the element's display style is currently 'none'
  if (el.style.display == 'none') {
    // If it is, change the display style based on the browser
    if (document.selection) {
      el.style.display = '';
    } else {
      el.style.display = 'inline';
    }

    // Set the top and left positions of the element
    el.style.top = event.offsetY;
    el.style.left = event.offsetX;

  } else {
    // If the element is already displayed, hide it
    el.style.display = 'none';
  }
}

// Function to insert a tag into a textarea element
function insereTag(element, tag) {
  // Get the element by its ID
  var el = document.getElementById(element);

  // Check if the browser is Internet Explorer
  if (document.selection) {
    // If it is, insert the tag based on the tag parameter
    if (tag == 'b' || tag == 'i' || tag == 'u') {
      var newText = '[' + tag + '][/' + tag + ']';
    } else {
      var newText = " " + tag + " ";
    }

    el.value += newText;

  } else {
    // If the browser is Firefox, get the selected text
    var selectedText = document.selection ? document.selection.createRange().text : el.value.substring(el.selectionStart, el.selectionEnd);

    // Insert the tag based on the tag parameter
    if (tag == 'b' || tag == 'i' || tag == 'u') {
      var newText = '[' + tag + ']' + selectedText + '[/' + tag + ']';
    } else {
      var newText = " " + tag + " ";
    }

    // Insert the new text into the textarea
    el.value = el.value.substring(0, el.selectionStart) + newText + el.value.substring(el.selectionEnd, el.value.length);
  }
}

// Function to display a Flash object with the given parameters
function flash(file, width, height) {
  document.write("<object  classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0' width='" + width + "' height='" + height + "'>");
  document.write("<param name='movie' value='" + file + "'>");
  document.write("<param name='quality' value='high'>");
  document.write("<param name='wmode' value='transparent' />");
  document.write("<embed  src='" + file + "' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash' width='" + width + "' height='" + height + "' wmode='transparent'></embed>");
  document.write("</object>");
}

// Function to check if the CAPS LOCK key is pressed
function checar_caps_lock(ev) {
  // Get the event object
  var e = ev || window.event;

  // Get the code of the key that was pressed
  var codigo_tecla = e.keyCode ? e.keyCode : e.which;

  // Check if the SHIFT key was also pressed
  var tecla_shift = e.shiftKey ? e.shiftKey : ((codigo_tecla == 16) ? true : false);

  // Check if the key that was pressed is a letter and if the SHIFT key was not pressed, or if the key is a number and the SHIFT key was pressed
  if (((codigo_tecla >= 65 && codigo_tecla <= 90) && !tecla_shift) || ((codigo_tecla >= 97 && codigo_tecla <= 122) && tecla_shift)) {
    // If so, display a message
    document.getElementById('aviso_caps_lock').style.display = 'block';
  } else {
    // If not, hide the message
    document.getElementById('aviso_caps_lock').style.display = 'none';
  }
}

// Function to display a message in a div element
function abreDiv(valor, retorna) {
  // Get the div elements by their IDs
  var divFundo = document.getElementById('fundoPreto');
  var divAviso = document.getElementById('div_aviso');

  // Display the div elements
  divFundo.style.display = 'block';
  divAviso.style.display = 'block';

  // Set the position and size of the div element
  divAviso.style.top = '40%';
  divAviso.style.left = '35%';
  divAviso.style.width = '350px';
  divAviso.style.height = '50px';

  // Call the abreArquivoAjax function with the given parameters
  abreArquivoAjax('ajax/usuario/mostra_rs.php?valor=' + valor, 'div_aviso', retorna, true);
}

// Function to close the message div element
function fechaAviso() {
  // Get the div elements by their IDs
  var divFundo = document.getElementById('fundoPreto');
  var divAviso = document.getElementById('div_aviso');

  // Hide the div elements
  divFundo.style.display = 'none';
  divAviso.style.display = 'none';
}

// Function to open or close a div element
function abreFecha
