function sprintf() {
  // Return a formatted string
  // 
  // version: 903.3016
  // discuss at: http://phpjs.org/functions/sprintf
  // +   original by: Ash Searle (http://hexmen.com/blog/)
  // + namespaced by: Michael White (http://getsprink.com)
  // +    tweaked by: Jack
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      input by: Paulo Ricardo F. Santos
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +      input by: Brett Zamir (http://brettz9.blogspot.com)
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // *     example 1: sprintf("%01.2f", 123.1);
  // *     returns 1: 123.10
  // *     example 2: sprintf("[%10s]", 'monkey');
  // *     returns 2: '[    monkey]'
  // *     example 3: sprintf("[%'#10s]", 'monkey');
  // *     returns 3: '[####monkey]'

  const regex = /%%|%(\d+\$)?([-+\'#0 ]*)(\*\d+\$|\*|\d+)?(\.(\*\d+\$|\*|\d+))?([scboxXuidfegEG])/g;
  const a = arguments;
  let i = 0;
  let format = a[i++];

  const pad = (str, len, chr, leftJustify) => {
    if (!chr) chr = ' ';
    const padding = (str.length >= len) ? '' : Array(1 + len - str.length >>> 0).join(chr);
    return leftJustify ? str + padding : padding + str;
  };

  const justify = (value, prefix, leftJustify, minWidth, zeroPad, customPadChar) => {
    let diff = minWidth - value.length;
    if (diff > 0) {
      if (leftJustify || !zeroPad) {
        value = pad(value, minWidth, customPadChar, leftJustify);
      } else {
        value = value.slice(0, prefix.length) + pad('', diff, '0', true) + value.slice(prefix.length);
      }
    }
    return value;
  };

  const formatBaseX = (value, base, prefix, leftJustify, minWidth, precision, zeroPad) => {
    // Note: casts negative numbers to positive ones
    const number = value >>> 0;
    prefix = prefix && number && {'2': '0b', '8': '0', '16': '0x'}[base] || '';
    value = prefix + pad(number.toString(base), precision || 0, '0', false);
    return justify(value, prefix, leftJustify, minWidth, zeroPad);
  };

  const formatString = (value, leftJustify, minWidth, precision, zeroPad, customPadChar) => {
    if (precision != null) {
      value = value.slice(0, precision);
    }
    return justify(value, '', leftJustify, minWidth, zeroPad, customPadChar);
  };

  const doFormat = (substring, valueIndex, flags, minWidth, _, precision, type) => {
    if (substring == '%%') return '%';

    let leftJustify = false;
    let positivePrefix = '';
    let zeroPad = false;
    let prefixBaseX = false;
    let customPadChar = ' ';

    if (flags) {
      for (let j = 0; j < flags.length; j++) {
        switch (flags.charAt(j)) {
          case ' ': positivePrefix = ' '; break;
          case '+': positivePrefix = '+'; break;
          case '-': leftJustify = true; break;
          case "'": customPadChar = flags.charAt(j + 1); break;
          case '0': zeroPad = true; break;
          case '#': prefixBaseX = true; break;
        }
      }
    }

    if (minWidth === '') {
      minWidth = 0;
    } else if (minWidth === '*') {
      minWidth = +a[i++];
    } else if (typeof minWidth === 'string' && minWidth.charAt(0) === '*') {
      minWidth = +a[minWidth.slice(1, -1)];
    } else {
      minWidth = +minWidth;
    }

    if (minWidth < 0) {
      minWidth = -minWidth;
      leftJustify = true;
    }

    if (precision === '') {
      precision = 'fFeE'.indexOf(type) > -1 ? 6 : (type === 'd') ? 0 : void(0);
    } else if (precision === '*') {
      precision = +a[i++];
    } else if (typeof precision === 'string' && precision.charAt(0) === '*') {
      precision = +a[precision.slice(1, -1)];
    } else {
      precision = +precision;
    }

    let value = valueIndex ? a[valueIndex.slice(0, -1)] : a[i++];

    switch (type) {
      case 's': return formatString(String(value), leftJustify, minWidth, precision, zeroPad, customPadChar);
      case 'c': return formatString(String.fromCharCode(+value), leftJustify,
