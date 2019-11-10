require('../../css/admin/admin.scss');

import EasyMDE from "easymde";
import 'core-js';

console.log('js');

document.addEventListener('DOMContentLoaded', (ev) => {
  console.log('js2');

  Array.from(document.getElementsByClassName("markdown-editor")).forEach(
    function(textarea, index, array) {
      new EasyMDE({element: textarea});
    }
  );
})



