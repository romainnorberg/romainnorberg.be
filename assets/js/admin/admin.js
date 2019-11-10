require('../../css/admin/admin.scss');

import EasyMDE from "easymde";
import 'core-js';

document.addEventListener('DOMContentLoaded', () => {
  Array.from(document.getElementsByClassName("markdown-editor")).forEach(
    function (textarea, index, array) {
      new EasyMDE({element: textarea});
    }
  );
})
