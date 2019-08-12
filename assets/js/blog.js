require('../css/blog.scss');

import hljs from 'highlight.js/lib/highlight';

['javascript', 'php', 'json'].forEach((langName) => {
  const langModule = require(`highlight.js/lib/languages/${langName}`);
  hljs.registerLanguage(langName, langModule);
});

hljs.initHighlightingOnLoad();
