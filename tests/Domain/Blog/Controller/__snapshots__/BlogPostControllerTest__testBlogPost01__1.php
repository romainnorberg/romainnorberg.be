<?php return '<p>Weareusing/SMSAPIservicesinthisexample</p><h3id="prerequisites-assuming-that-you-have">Prerequisites,assumingthatyouhave:<ahref="#prerequisites-assuming-that-you-have"class="permalink">#</a></h3><ul><li>AnOVHaccount</li><li>ValidaccesstotheOVHAPI<em>(doc:<ahref="https://docs.ovh.com/gb/en/customer/first-steps-with-ovh-api/">FirstStepswiththeAPI</a>)</em></li><li>Credentialsneededtoaccessservices<em>(Doc:<ahref="https://api.ovh.com/createToken/index.cgi?GET=/sms&amp;GET=/sms/*&amp;PUT=/sms/*&amp;DELETE=/sms/*&amp;POST=/sms/*">CreatingAPIKeysforyourscriptforSMSservices</a>)</em></li><li>AnSMSaccountconfiguredinyourOVHmanager</li><li>Postmanisnotunknowntoyou<em>(defineenv.variable,...)</em></li></ul><h1id="introduction">Introduction<ahref="#introduction"class="permalink">#</a></h1><h2id="ovh-api">OVHAPI<ahref="#ovh-api"class="permalink">#</a></h2><p><imgsrc="https://api.ovh.com/images/ovh-under-construction.png"alt="ovh-api"></p><p>OVHAPIisaWebserviceallowingOVHcustomerstobuy,manage,upgradeandconfigureOVHproductswithoutusingthegraphicalcustomerinterface(OVHmanager).</p><h2id="postman-pre-request-scripts">PostmanPre-requestscripts<ahref="#postman-pre-request-scripts"class="permalink">#</a></h2><p>Pre-requestscriptsaresnippetsofcodeassociatedwithacollectionrequestthatareexecutedbeforetherequestissent.Thisisperfectforuse-caseslikeincludingthetimestampintherequestheadersorsendingarandomalphanumericstringintheURLparameters.</p><p><em>Doc:<ahref="https://www.getpostman.com/docs/v6/postman/scripts/pre_request_scripts">PostmanPre-requestscripts</a></em></p><h1id="let-s-go">Let\'sgo<ahref="#let-s-go"class="permalink">#</a></h1><h2id="process">Process<ahref="#process"class="permalink">#</a></h2><h3id="1-import-curl">1)Importcurl<ahref="#1-import-curl"class="permalink">#</a></h3><p>Copy/pastecontentof<ahref="https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa#file-request-curl">request.curl</a>intopromptwindow<em>(File&gt;Import&gt;"PasteRawtext")</em>andconfirm</p><pre><codeclass="language-jsonhljsjson"data-lang="json">curl-XGET\\https://api.ovh.com/<spanclass="hljs-number">1.0</span>/sms\\-H\'Content-Type:application/json;charset=utf<spanclass="hljs-number">-8</span>\'\\-H\'X-Ovh-Application:xxxxxx\'\\-H\'X-Ovh-Consumer:{{lf_ovh_api_app_consumer_key}}\'\\-H\'X-Ovh-Signature:{{lf_ovh_api_app_consumer_signature}}\'\\-H\'X-Ovh-Timestamp:{{lf_ovh_api_app_timestamp}}\'\\-H\'cache-control:no-cache\'</code></pre><p><imgsrc="https://thepracticaldev.s3.amazonaws.com/i/dlkneheob182kwalioaa.png"alt="importcurlrequest"></p><h3id="2-define-variables">2)Definevariables<ahref="#2-define-variables"class="permalink">#</a></h3><ul><li><p>InHeaderstab,fill<code>X-Ovh-Application</code>withyourapplicationkey<em>(e.g.AmJgcE99XcibYrV1)</em>.</p><p><imgsrc="https://thepracticaldev.s3.amazonaws.com/i/t82pp1x2ooq1yyaolqt8.png"alt="Postmanheaderstab"></p></li><li><p>Defineenv.variable</p><ul><li><code>lf_ovh_api_app_consumer_key</code>withyourconsumerkey</li><li><code>lf_ovh_api_app_secret</code>withyourappsecret</li></ul></li></ul><p><imgsrc="https://thepracticaldev.s3.amazonaws.com/i/n600ryjw1zruxnkak3en.png"alt="PostmanManageEnvironments"></p><p><em>(doc:<ahref="https://www.getpostman.com/docs/v6/postman/environments_and_globals/variables">PostmanVariables</a>)</em></p><h3id="3-try-to-run">3)Trytorun<ahref="#3-try-to-run"class="permalink">#</a></h3><p>Ifyousendtherequestasitis,theOVHAPIwillreturnanerrorbecausethesignatureandthetimestamparenotfilled.</p><p>Responseafterpress"Send"button:</p><pre><codeclass="language-jsonhljsjson"data-lang="json">{<spanclass="hljs-attr">"errorCode"</span>:<spanclass="hljs-string">"QUERY_TIME_OUT"</span>,<spanclass="hljs-attr">"httpCode"</span>:<spanclass="hljs-string">"400BadRequest"</span>,<spanclass="hljs-attr">"message"</span>:<spanclass="hljs-string">"Queryoutoftime"</span>}</code></pre><h3id="4-pre-request-script">4)Pre-requestScript<ahref="#4-pre-request-script"class="permalink">#</a></h3><p>Copy/pastecontentof<ahref="https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa#file-pre-request-script">pre-request-script</a>into"Pre-requestScript"tabtextarea.</p><p><imgsrc="https://thepracticaldev.s3.amazonaws.com/i/xvyl6sf6qboq6gy9xpfy.png"alt="pre-requestscripttab"></p><pre><codeclass="language-javascripthljsjavascript"data-lang="javascript">pm.sendRequest({<spanclass="hljs-attr">url</span>:<spanclass="hljs-string">"https://api.ovh.com/1.0/auth/time"</span>,<spanclass="hljs-attr">method</span>:<spanclass="hljs-string">"GET"</span>,<spanclass="hljs-attr">headers</span>:{<spanclass="hljs-string">\'Content-Type\'</span>:<spanclass="hljs-string">\'application/json;charset=utf-8\'</span>},<spanclass="hljs-attr">body</span>:{}},<spanclass="hljs-function"><spanclass="hljs-keyword">function</span>(<spanclass="hljs-params">err,res</span>)</span>{pm.expect(err).to.not.be.ok;pm.expect(res).to.have.property(<spanclass="hljs-string">\'code\'</span>,<spanclass="hljs-number">200</span>);pm.expect(res).to.have.property(<spanclass="hljs-string">\'status\'</span>,<spanclass="hljs-string">\'OK\'</span>);<spanclass="hljs-keyword">var</span>serverTimestamp=res.text();postman.setGlobalVariable(<spanclass="hljs-string">"lf_ovh_api_app_server_timestamp"</span>,serverTimestamp);<spanclass="hljs-keyword">var</span>time_delta=serverTimestamp-<spanclass="hljs-built_in">Math</span>.round(<spanclass="hljs-keyword">new</span><spanclass="hljs-built_in">Date</span>().getTime()/<spanclass="hljs-number">1000</span>);<spanclass="hljs-keyword">var</span>now=<spanclass="hljs-built_in">Math</span>.round(<spanclass="hljs-keyword">new</span><spanclass="hljs-built_in">Date</span>().getTime()/<spanclass="hljs-number">1000</span>)+time_delta;<spanclass="hljs-keyword">var</span>body=<spanclass="hljs-string">\'\'</span>;postman.setGlobalVariable(<spanclass="hljs-string">"lf_ovh_api_app_timestamp"</span>,now);<spanclass="hljs-keyword">var</span>toSign=environment.lf_ovh_api_app_secret+<spanclass="hljs-string">\'+\'</span>+environment.lf_ovh_api_app_consumer_key+<spanclass="hljs-string">\'+\'</span>+pm.request.method+<spanclass="hljs-string">\'+\'</span>+pm.request.url.toString()+<spanclass="hljs-string">\'+\'</span>+body+<spanclass="hljs-string">\'+\'</span>+now;<spanclass="hljs-keyword">var</span>signature=<spanclass="hljs-string">\'$1$\'</span>+CryptoJS.SHA1(toSign);postman.setGlobalVariable(<spanclass="hljs-string">"lf_ovh_api_app_consumer_signature"</span>,signature);});</code></pre><h3id="5-try-to-run">5)Trytorun<ahref="#5-try-to-run"class="permalink">#</a></h3><p>NormallyyoushouldthenhavethefollowingresponsefromOVHAPI🎉🎉</p><pre><codeclass="language-jsonhljsjson"data-lang="json">[<spanclass="hljs-string">"sms-rnXXXXX-1"</span>]</code></pre><p>😠theAPIreturnsyouanerror?checkyourcredentials,check"Possiblesissues"sectionbelow.</p><h2id="possibles-issues">Possiblesissues<ahref="#possibles-issues"class="permalink">#</a></h2><h3id="empty-response">Emptyresponse[]<ahref="#empty-response"class="permalink">#</a></h3><p>Noproblem,theserviceworksbutyouhavetoconfigureanSMSaccountinyourOVHmanager.</p><h3id="invalid-signature-400-bad-request">Invalidsignature(400BadRequest)<ahref="#invalid-signature-400-bad-request"class="permalink">#</a></h3><p>Checkifyourconsumer_keyandapp_secretarevalid.</p><h3id="this-call-has-not-been-granted-403-forbidden">Thiscallhasnotbeengranted(403Forbidden)<ahref="#this-call-has-not-been-granted-403-forbidden"class="permalink">#</a></h3><p>Makesurethatyouhavegeneratedthekeywiththepermissionsthataregoodfortheservice</p><p><em>Doc:<ahref="https://api.ovh.com/createToken/index.cgi?GET=/sms&amp;GET=/sms/*&amp;PUT=/sms/*&amp;DELETE=/sms/*&amp;POST=/sms/*">CreatingAPIKeysforyourscriptforSMSservices</a></em></p><h3id="another-issue">Anotherissue?<ahref="#another-issue"class="permalink">#</a></h3><p>Donothesitatetoleaveacommentwiththeerrorencountered.</p><h2id="evolution">Evolution<ahref="#evolution"class="permalink">#</a></h2><p>⚠️the"Pre-request"scriptonlysupportstheGETmethodforthemoment.YouarefreetoupgradethescripttosupportPOST,PUT&amp;DELETEmethods.</p><h2id="alternative">Alternative<ahref="#alternative"class="permalink">#</a></h2><p>UseandtesttheOVHAPIdirectlyfromthebrowserwithyourOVHaccount:https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/</p><p><imgsrc="https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/images/connection_api_log.jpg"alt="ovh-api-login"></p><p><imgsrc="https://docs.ovh.com/fr/private-cloud/connexion-a-l-api-ovh/images/api.jpg"alt="ovh-api-service"></p><h2id="script-sources">Scriptsources<ahref="#script-sources"class="permalink">#</a></h2><p>Check<ahref="https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa">https://gist.github.com/romainnorberg/9847a6707a26a77039358d85cce3d7aa</a></p>';
