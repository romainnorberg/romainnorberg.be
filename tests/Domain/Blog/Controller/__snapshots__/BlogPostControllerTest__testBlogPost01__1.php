<?php return '
<p>We are using /SMS API services in this example</p>
<h3 id="prerequisites-assuming-that-you-have">Prerequisites, assuming that you have: <a href="#prerequisites-assuming-that-you-have" class="permalink">#</a>
</h3>
<ul>
<li>An OVH account</li>
<li>Valid access to the OVH API <em>(doc: <a href="https://docs.ovh.com/gb/en/customer/first-steps-with-ovh-api/">First Steps with the API</a>)</em>
</li>
<li>Credentials needed to access services <em>(Doc: <a href="https://api.ovh.com/createToken/index.cgi?GET=/sms&amp;GET=/sms/*&amp;PUT=/sms/*&amp;DELETE=/sms/*&amp;POST=/sms/*">Creating API Keys for your script for SMS services</a>)</em>
</li>
<li>An SMS account configured in your OVH manager</li>
<li>Postman is not unknown to you <em>(define env. variable, ...)</em>
</li>
</ul>
<h1 id="introduction">Introduction <a href="#introduction" class="permalink">#</a>
</h1>
<h2 id="ovh-api">OVH API <a href="#ovh-api" class="permalink">#</a>
</h2>
<p><img src="https://api.ovh.com/images/ovh-under-construction.png" alt="ovh-api"></p>
<p>OVH API is a Web service allowing OVH customers to buy, manage, upgrade and configure OVH products without using the graphical customer interface (OVH manager).</p>
<h2 id="postman-pre-request-scripts">Postman Pre-request scripts <a href="#postman-pre-request-scripts" class="permalink">#</a>
</h2>
<p>Pre-request scripts are snippets of code associated with a collection request that are executed before the request is sent. This is perfect for use-cases like including the timestamp in the request headers or sending a random alphanumeric string in the URL parameters.</p>
<p><em>Doc: <a href="https://www.getpostman.com/docs/v6/postman/scripts/pre_request_scripts">Postman Pre-request scripts</a></em></p>
<h1 id="let-s-go">Let\'s go <a href="#let-s-go" class="permalink">#</a>
</h1>
<h2 id="process">Process <a href="#process" class="permalink">#</a>
</h2>
<h3 id="1-import-curl">1) Import curl <a href="#1-import-curl" class="permalink">#</a>
</h3>
<p>Copy/paste content of <a href="https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa#file-request-curl">request.curl</a> into prompt window <em>(File &gt; Import &gt; "Paste Raw text")</em> and confirm</p>
<pre><code class="language-json hljs json" data-lang="json">curl -X GET \\
 https://api.ovh.com/<span class="hljs-number">1.0</span>/sms \\
-H \'Content-Type: application/json; charset=utf<span class="hljs-number">-8</span>\' \\
-H \'X-Ovh-Application: xxxxxx\' \\
-H \'X-Ovh-Consumer: {{lf_ovh_api_app_consumer_key}}\' \\
-H \'X-Ovh-Signature: {{lf_ovh_api_app_consumer_signature}}\' \\
-H \'X-Ovh-Timestamp: {{lf_ovh_api_app_timestamp}}\' \\
-H \'cache-control: no-cache\'
</code></pre>
<p><img src="https://thepracticaldev.s3.amazonaws.com/i/dlkneheob182kwalioaa.png" alt="import curl request"></p>
<h3 id="2-define-variables">2) Define variables <a href="#2-define-variables" class="permalink">#</a>
</h3>
<ul>
<li>
<p>In Headers tab, fill <code>X-Ovh-Application</code> with your application key <em>(e.g. AmJgcE99XcibYrV1)</em>.</p>
<p><img src="https://thepracticaldev.s3.amazonaws.com/i/t82pp1x2ooq1yyaolqt8.png" alt="Postman headers tab"></p>
</li>
<li>
<p>Define env. variable</p>
<ul>
<li>
<code>lf_ovh_api_app_consumer_key</code> with your consumer key</li>
<li>
<code>lf_ovh_api_app_secret</code> with your app secret</li>
</ul>
</li>
</ul>
<p><img src="https://thepracticaldev.s3.amazonaws.com/i/n600ryjw1zruxnkak3en.png" alt="Postman Manage Environments"></p>
<p><em>(doc: <a href="https://www.getpostman.com/docs/v6/postman/environments_and_globals/variables">Postman Variables</a>)</em></p>
<h3 id="3-try-to-run">3) Try to run <a href="#3-try-to-run" class="permalink">#</a>
</h3>
<p>If you send the request as it is, the OVH API will return an error because the signature and the timestamp are not filled.</p>
<p>Response after press "Send" button:</p>
<pre><code class="language-json hljs json" data-lang="json">{
 <span class="hljs-attr">"errorCode"</span>: <span class="hljs-string">"QUERY_TIME_OUT"</span>,
 <span class="hljs-attr">"httpCode"</span>: <span class="hljs-string">"400 Bad Request"</span>,
 <span class="hljs-attr">"message"</span>: <span class="hljs-string">"Query out of time"</span>
}
</code></pre>
<h3 id="4-pre-request-script">4) Pre-request Script <a href="#4-pre-request-script" class="permalink">#</a>
</h3>
<p>Copy/paste content of <a href="https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa#file-pre-request-script">pre-request-script</a> into "Pre-request Script" tab textarea.</p>
<p><img src="https://thepracticaldev.s3.amazonaws.com/i/xvyl6sf6qboq6gy9xpfy.png" alt="pre-request script tab"></p>
<pre><code class="language-javascript hljs javascript" data-lang="javascript">pm.sendRequest({
 <span class="hljs-attr">url</span>: <span class="hljs-string">"https://api.ovh.com/1.0/auth/time"</span>,
 <span class="hljs-attr">method</span>: <span class="hljs-string">"GET"</span>,
 <span class="hljs-attr">headers</span>: {
 <span class="hljs-string">\'Content-Type\'</span>: <span class="hljs-string">\'application/json; charset=utf-8\'</span>
 },
 <span class="hljs-attr">body</span>: {}
 },
 <span class="hljs-function"><span class="hljs-keyword">function</span> (<span class="hljs-params">err, res</span>) </span>{
 
 pm.expect(err).to.not.be.ok;
 pm.expect(res).to.have.property(<span class="hljs-string">\'code\'</span>, <span class="hljs-number">200</span>);
 pm.expect(res).to.have.property(<span class="hljs-string">\'status\'</span>, <span class="hljs-string">\'OK\'</span>);
 
 <span class="hljs-keyword">var</span> serverTimestamp = res.text();
 postman.setGlobalVariable(<span class="hljs-string">"lf_ovh_api_app_server_timestamp"</span>, serverTimestamp);
 
 <span class="hljs-keyword">var</span> time_delta = serverTimestamp - <span class="hljs-built_in">Math</span>.round(<span class="hljs-keyword">new</span> <span class="hljs-built_in">Date</span>().getTime()/<span class="hljs-number">1000</span>);
 <span class="hljs-keyword">var</span> now = <span class="hljs-built_in">Math</span>.round(<span class="hljs-keyword">new</span> <span class="hljs-built_in">Date</span>().getTime()/<span class="hljs-number">1000</span>) + time_delta;
 <span class="hljs-keyword">var</span> body = <span class="hljs-string">\'\'</span>;
 
 postman.setGlobalVariable(<span class="hljs-string">"lf_ovh_api_app_timestamp"</span>, now);
 
 <span class="hljs-keyword">var</span> toSign = environment.lf_ovh_api_app_secret + <span class="hljs-string">\'+\'</span> + environment.lf_ovh_api_app_consumer_key + <span class="hljs-string">\'+\'</span> + pm.request.method + <span class="hljs-string">\'+\'</span> + pm.request.url.toString() + <span class="hljs-string">\'+\'</span> + body + <span class="hljs-string">\'+\'</span> + now;
 
 <span class="hljs-keyword">var</span> signature = <span class="hljs-string">\'$1$\'</span> + CryptoJS.SHA1(toSign);
 
 postman.setGlobalVariable(<span class="hljs-string">"lf_ovh_api_app_consumer_signature"</span>, signature);
 }
);
</code></pre>
<h3 id="5-try-to-run">5) Try to run <a href="#5-try-to-run" class="permalink">#</a>
</h3>
<p>Normally you should then have the following response from OVH API 🎉🎉</p>
<pre><code class="language-json hljs json" data-lang="json"> [
 <span class="hljs-string">"sms-rnXXXXX-1"</span>
 ]
</code></pre>
<p>😠the API returns you an error? check your credentials, check "Possibles issues" section below.</p>
<h2 id="possibles-issues">Possibles issues <a href="#possibles-issues" class="permalink">#</a>
</h2>
<h3 id="empty-response">Empty response [] <a href="#empty-response" class="permalink">#</a>
</h3>
<p>No problem, the service works but you have to configure an SMS account in your OVH manager.</p>
<h3 id="invalid-signature-400-bad-request">Invalid signature (400 Bad Request) <a href="#invalid-signature-400-bad-request" class="permalink">#</a>
</h3>
<p>Check if your consumer_key and app_secret are valid.</p>
<h3 id="this-call-has-not-been-granted-403-forbidden">This call has not been granted (403 Forbidden) <a href="#this-call-has-not-been-granted-403-forbidden" class="permalink">#</a>
</h3>
<p>Make sure that you have generated the key with the permissions that are good for the service</p>
<p><em>Doc: <a href="https://api.ovh.com/createToken/index.cgi?GET=/sms&amp;GET=/sms/*&amp;PUT=/sms/*&amp;DELETE=/sms/*&amp;POST=/sms/*">Creating API Keys for your script for SMS services</a></em></p>
<h3 id="another-issue">Another issue ? <a href="#another-issue" class="permalink">#</a>
</h3>
<p>Do not hesitate to leave a comment with the error encountered.</p>
<h2 id="evolution">Evolution <a href="#evolution" class="permalink">#</a>
</h2>
<p>⚠️ the "Pre-request" script only supports the GET method for the moment. You are free to upgrade the script to support POST, PUT &amp; DELETE methods.</p>
<h2 id="alternative">Alternative <a href="#alternative" class="permalink">#</a>
</h2>
<p>Use and test the OVH API directly from the browser with your OVH account: https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/</p>
<p><img src="https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/images/connection_api_log.jpg" alt="ovh-api-login"></p>
<p><img src="https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/images/api.jpg" alt="ovh-api-service"></p>
<h2 id="script-sources">Script sources <a href="#script-sources" class="permalink">#</a>
</h2>
<p>Check <a href="https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa">https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa</a></p>
 ';
