(window.MIP=window.MIP||[]).push({name:"mip-mustache",func:function(){!function(){var e=null,t=function(){function t(t){return t=(""+t).match(p),!t?e:new a(l(t[1]),l(t[2]),l(t[3]),l(t[4]),l(t[5]),l(t[6]),l(t[7]))}function i(t,i){return"string"==typeof t?encodeURI(t).replace(i,n):e}function n(e){return e=e.charCodeAt(0),"%"+"0123456789ABCDEF".charAt(e>>4&15)+"0123456789ABCDEF".charAt(15&e)}function o(t){if(t===e)return e;for(var i,t=t.replace(/(^|\/)\.(?:\/|$)/g,"$1").replace(/\/{2,}/g,"/"),n=s;(i=t.replace(n,"$1"))!=t;t=i);return t}function r(e,t){var i=e.R(),n=t.K();n?i.fa(t.j):n=t.V(),n?i.ca(t.m):n=t.W(),n?i.da(t.k):n=t.Y();var r=t.g,a=o(r);if(n)i.ba(t.T()),a=a&&a.replace(c,"");else if(n=!!r){if(47!==a.charCodeAt(0))var a=o(i.g||"").replace(c,""),l=a.lastIndexOf("/")+1,a=o((l?a.substring(0,l):"")+o(r)).replace(c,"")}else(a=a&&a.replace(c,""))!==r&&i.G(a);return n?i.G(a):n=t.Z(),n?i.M(t.l):n=t.X(),n&&i.ea(t.n),i}function a(e,t,i,n,o,r,a){this.j=e,this.m=t,this.k=i,this.h=n,this.g=o,this.l=r,this.n=a}function l(t){return"string"==typeof t&&0<t.length?t:e}var s=RegExp(/(\/|^)(?:[^.\/][^\/]*|\.{2,}(?:[^.\/][^\/]*)|\.{3,}[^\/]*)\/\.\.(?:\/|$)/),c=/^(?:\.\.\/)*(?:\.\.$)?/;a.prototype.toString=function(){var t=[];return e!==this.j&&t.push(this.j,":"),e!==this.k&&(t.push("//"),e!==this.m&&t.push(this.m,"@"),t.push(this.k),e!==this.h&&t.push(":",this.h.toString())),e!==this.g&&t.push(this.g),e!==this.l&&t.push("?",this.l),e!==this.n&&t.push("#",this.n),t.join("")},a.prototype.R=function(){return new a(this.j,this.m,this.k,this.h,this.g,this.l,this.n)},a.prototype.U=function(){return this.j&&decodeURIComponent(this.j).toLowerCase()},a.prototype.fa=function(t){this.j=t?t:e},a.prototype.K=function(){return e!==this.j},a.prototype.ca=function(t){this.m=t?t:e},a.prototype.V=function(){return e!==this.m},a.prototype.da=function(t){this.k=t?t:e,this.G(this.g)},a.prototype.W=function(){return e!==this.k},a.prototype.T=function(){return this.h&&decodeURIComponent(this.h)},a.prototype.ba=function(t){if(t){if((t=Number(t))!==(65535&t))throw Error("Bad port number "+t);this.h=""+t}else this.h=e},a.prototype.Y=function(){return e!==this.h},a.prototype.S=function(){return this.g&&decodeURIComponent(this.g)},a.prototype.G=function(t){t?(t=""+t,this.g=!this.k||/^\//.test(t)?t:"/"+t):this.g=e},a.prototype.M=function(t){this.l=t?t:e},a.prototype.Z=function(){return e!==this.l},a.prototype.aa=function(e){if("object"==typeof e&&!(e instanceof Array)&&(e instanceof Object||"[object Array]"!==Object.prototype.toString.call(e))){var t,i=[],n=-1;for(t in e){var o=e[t];"string"==typeof o&&(i[++n]=t,i[++n]=o)}e=i}for(var i=[],n="",r=0;r<e.length;)t=e[r++],o=e[r++],i.push(n,encodeURIComponent(t.toString())),n="&",o&&i.push("=",encodeURIComponent(o.toString()));this.l=i.join("")},a.prototype.ea=function(t){this.n=t?t:e},a.prototype.X=function(){return e!==this.n};var p=/^(?:([^:\/?#]+):)?(?:\/\/(?:([^\/?#]*)@)?([^\/?#:@]*)(?::([0-9]+))?)?([^?#]+)?(?:\?([^#]*))?(?:#(.*))?$/,d=/[#\/\?@]/g,u=/[\#\?]/g;return a.parse=t,a.create=function(t,o,r,l,s,c,p){return t=new a(i(t,d),i(o,d),"string"==typeof r?encodeURIComponent(r):e,0<l?l.toString():e,i(s,u),e,"string"==typeof p?encodeURIComponent(p):e),c&&("string"==typeof c?t.M(c.replace(/[^?&=0-9A-Za-z_\-~.%]/g,n)):t.aa(c)),t},a.$=r,a.ja=o,a.ua={oa:function(e){return/\.html$/.test(t(e).S())?"text/html":"application/javascript"},$:function(e,i){return e?r(t(e),t(i)).toString():""+i}},a}(),i={e:{NONE:0,URI:1,URI_FRAGMENT:11,SCRIPT:2,STYLE:3,HTML:12,ID:4,IDREF:5,IDREFS:6,GLOBAL_NAME:7,LOCAL_NAME:8,CLASSES:9,FRAME_TARGET:10,MEDIA_QUERY:13}};i.atype=i.e,i.w={"*::class":9,"*::dir":0,"*::draggable":0,"*::hidden":0,"*::id":4,"*::inert":0,"*::itemprop":0,"*::itemref":6,"*::itemscope":0,"*::lang":0,"*::onblur":2,"*::onchange":2,"*::onclick":2,"*::ondblclick":2,"*::onerror":2,"*::onfocus":2,"*::onkeydown":2,"*::onkeypress":2,"*::onkeyup":2,"*::onload":2,"*::onmousedown":2,"*::onmousemove":2,"*::onmouseout":2,"*::onmouseover":2,"*::onmouseup":2,"*::onreset":2,"*::onscroll":2,"*::onselect":2,"*::onsubmit":2,"*::ontouchcancel":2,"*::ontouchend":2,"*::ontouchenter":2,"*::ontouchleave":2,"*::ontouchmove":2,"*::ontouchstart":2,"*::onunload":2,"*::spellcheck":0,"*::style":3,"*::tabindex":0,"*::title":0,"*::translate":0,"a::accesskey":0,"a::coords":0,"a::href":1,"a::hreflang":0,"a::name":7,"a::onblur":2,"a::onfocus":2,"a::shape":0,"a::target":10,"a::type":0,"area::accesskey":0,"area::alt":0,"area::coords":0,"area::href":1,"area::nohref":0,"area::onblur":2,"area::onfocus":2,"area::shape":0,"area::target":10,"audio::controls":0,"audio::loop":0,"audio::mediagroup":5,"audio::muted":0,"audio::preload":0,"audio::src":1,"bdo::dir":0,"blockquote::cite":1,"br::clear":0,"button::accesskey":0,"button::disabled":0,"button::name":8,"button::onblur":2,"button::onfocus":2,"button::type":0,"button::value":0,"canvas::height":0,"canvas::width":0,"caption::align":0,"col::align":0,"col::char":0,"col::charoff":0,"col::span":0,"col::valign":0,"col::width":0,"colgroup::align":0,"colgroup::char":0,"colgroup::charoff":0,"colgroup::span":0,"colgroup::valign":0,"colgroup::width":0,"command::checked":0,"command::command":5,"command::disabled":0,"command::icon":1,"command::label":0,"command::radiogroup":0,"command::type":0,"data::value":0,"del::cite":1,"del::datetime":0,"details::open":0,"dir::compact":0,"div::align":0,"dl::compact":0,"fieldset::disabled":0,"font::color":0,"font::face":0,"font::size":0,"form::accept":0,"form::action":1,"form::autocomplete":0,"form::enctype":0,"form::method":0,"form::name":7,"form::novalidate":0,"form::onreset":2,"form::onsubmit":2,"form::target":10,"h1::align":0,"h2::align":0,"h3::align":0,"h4::align":0,"h5::align":0,"h6::align":0,"hr::align":0,"hr::noshade":0,"hr::size":0,"hr::width":0,"iframe::align":0,"iframe::frameborder":0,"iframe::height":0,"iframe::marginheight":0,"iframe::marginwidth":0,"iframe::width":0,"img::align":0,"img::alt":0,"img::border":0,"img::height":0,"img::hspace":0,"img::ismap":0,"img::name":7,"img::src":1,"img::usemap":11,"img::vspace":0,"img::width":0,"input::accept":0,"input::accesskey":0,"input::align":0,"input::alt":0,"input::autocomplete":0,"input::checked":0,"input::disabled":0,"input::inputmode":0,"input::ismap":0,"input::list":5,"input::max":0,"input::maxlength":0,"input::min":0,"input::multiple":0,"input::name":8,"input::onblur":2,"input::onchange":2,"input::onfocus":2,"input::onselect":2,"input::pattern":0,"input::placeholder":0,"input::readonly":0,"input::required":0,"input::size":0,"input::src":1,"input::step":0,"input::type":0,"input::usemap":11,"input::value":0,"ins::cite":1,"ins::datetime":0,"label::accesskey":0,"label::for":5,"label::onblur":2,"label::onfocus":2,"legend::accesskey":0,"legend::align":0,"li::type":0,"li::value":0,"map::name":7,"menu::compact":0,"menu::label":0,"menu::type":0,"meter::high":0,"meter::low":0,"meter::max":0,"meter::min":0,"meter::optimum":0,"meter::value":0,"ol::compact":0,"ol::reversed":0,"ol::start":0,"ol::type":0,"optgroup::disabled":0,"optgroup::label":0,"option::disabled":0,"option::label":0,"option::selected":0,"option::value":0,"output::for":6,"output::name":8,"p::align":0,"pre::width":0,"progress::max":0,"progress::min":0,"progress::value":0,"q::cite":1,"select::autocomplete":0,"select::disabled":0,"select::multiple":0,"select::name":8,"select::onblur":2,"select::onchange":2,"select::onfocus":2,"select::required":0,"select::size":0,"source::type":0,"table::align":0,"table::bgcolor":0,"table::border":0,"table::cellpadding":0,"table::cellspacing":0,"table::frame":0,"table::rules":0,"table::summary":0,"table::width":0,"tbody::align":0,"tbody::char":0,"tbody::charoff":0,"tbody::valign":0,"td::abbr":0,"td::align":0,"td::axis":0,"td::bgcolor":0,"td::char":0,"td::charoff":0,"td::colspan":0,"td::headers":6,"td::height":0,"td::nowrap":0,"td::rowspan":0,"td::scope":0,"td::valign":0,"td::width":0,"textarea::accesskey":0,"textarea::autocomplete":0,"textarea::cols":0,"textarea::disabled":0,"textarea::inputmode":0,"textarea::name":8,"textarea::onblur":2,"textarea::onchange":2,"textarea::onfocus":2,"textarea::onselect":2,"textarea::placeholder":0,"textarea::readonly":0,"textarea::required":0,"textarea::rows":0,"textarea::wrap":0,"tfoot::align":0,"tfoot::char":0,"tfoot::charoff":0,"tfoot::valign":0,"th::abbr":0,"th::align":0,"th::axis":0,"th::bgcolor":0,"th::char":0,"th::charoff":0,"th::colspan":0,"th::headers":6,"th::height":0,"th::nowrap":0,"th::rowspan":0,"th::scope":0,"th::valign":0,"th::width":0,"thead::align":0,"thead::char":0,"thead::charoff":0,"thead::valign":0,"tr::align":0,"tr::bgcolor":0,"tr::char":0,"tr::charoff":0,"tr::valign":0,"track::default":0,"track::kind":0,"track::label":0,"track::srclang":0,"ul::compact":0,"ul::type":0,"video::controls":0,"video::height":0,"video::loop":0,"video::mediagroup":5,"video::muted":0,"video::poster":1,"video::preload":0,"video::src":1,"video::width":0},i.ATTRIBS=i.w,i.c={OPTIONAL_ENDTAG:1,EMPTY:2,CDATA:4,RCDATA:8,UNSAFE:16,FOLDABLE:32,SCRIPT:64,STYLE:128,VIRTUALIZED:256},i.eflags=i.c,i.f={a:0,abbr:0,acronym:0,address:0,applet:272,area:2,article:0,aside:0,audio:0,b:0,base:274,basefont:274,bdi:0,bdo:0,big:0,blockquote:0,body:305,br:2,button:0,canvas:0,caption:0,center:0,cite:0,code:0,col:2,colgroup:1,command:2,data:0,datalist:0,dd:1,del:0,details:0,dfn:0,dialog:272,dir:0,div:0,dl:0,dt:1,em:0,fieldset:0,figcaption:0,figure:0,font:0,footer:0,form:0,frame:274,frameset:272,h1:0,h2:0,h3:0,h4:0,h5:0,h6:0,head:305,header:0,hgroup:0,hr:2,html:305,i:0,iframe:4,img:2,input:2,ins:0,isindex:274,kbd:0,keygen:274,label:0,legend:0,li:1,link:274,map:0,mark:0,menu:0,meta:274,meter:0,nav:0,nobr:0,noembed:276,noframes:276,noscript:276,object:272,ol:0,optgroup:0,option:1,output:0,p:1,param:274,pre:0,progress:0,q:0,s:0,samp:0,script:84,section:0,select:0,small:0,source:2,span:0,strike:0,strong:0,style:148,sub:0,summary:0,sup:0,table:0,tbody:1,td:1,textarea:8,tfoot:1,th:1,thead:1,time:0,title:280,tr:1,track:2,tt:0,u:0,ul:0,var:0,video:0,wbr:2},i.ELEMENTS=i.f,i.O={a:"HTMLAnchorElement",abbr:"HTMLElement",acronym:"HTMLElement",address:"HTMLElement",applet:"HTMLAppletElement",area:"HTMLAreaElement",article:"HTMLElement",aside:"HTMLElement",audio:"HTMLAudioElement",b:"HTMLElement",base:"HTMLBaseElement",basefont:"HTMLBaseFontElement",bdi:"HTMLElement",bdo:"HTMLElement",big:"HTMLElement",blockquote:"HTMLQuoteElement",body:"HTMLBodyElement",br:"HTMLBRElement",button:"HTMLButtonElement",canvas:"HTMLCanvasElement",caption:"HTMLTableCaptionElement",center:"HTMLElement",cite:"HTMLElement",code:"HTMLElement",col:"HTMLTableColElement",colgroup:"HTMLTableColElement",command:"HTMLCommandElement",data:"HTMLElement",datalist:"HTMLDataListElement",dd:"HTMLElement",del:"HTMLModElement",details:"HTMLDetailsElement",dfn:"HTMLElement",dialog:"HTMLDialogElement",dir:"HTMLDirectoryElement",div:"HTMLDivElement",dl:"HTMLDListElement",dt:"HTMLElement",em:"HTMLElement",fieldset:"HTMLFieldSetElement",figcaption:"HTMLElement",figure:"HTMLElement",font:"HTMLFontElement",footer:"HTMLElement",form:"HTMLFormElement",frame:"HTMLFrameElement",frameset:"HTMLFrameSetElement",h1:"HTMLHeadingElement",h2:"HTMLHeadingElement",h3:"HTMLHeadingElement",h4:"HTMLHeadingElement",h5:"HTMLHeadingElement",h6:"HTMLHeadingElement",head:"HTMLHeadElement",header:"HTMLElement",hgroup:"HTMLElement",hr:"HTMLHRElement",html:"HTMLHtmlElement",i:"HTMLElement",iframe:"HTMLIFrameElement",img:"HTMLImageElement",input:"HTMLInputElement",ins:"HTMLModElement",isindex:"HTMLUnknownElement",kbd:"HTMLElement",keygen:"HTMLKeygenElement",label:"HTMLLabelElement",legend:"HTMLLegendElement",li:"HTMLLIElement",link:"HTMLLinkElement",map:"HTMLMapElement",mark:"HTMLElement",menu:"HTMLMenuElement",meta:"HTMLMetaElement",meter:"HTMLMeterElement",nav:"HTMLElement",nobr:"HTMLElement",noembed:"HTMLElement",noframes:"HTMLElement",noscript:"HTMLElement",object:"HTMLObjectElement",ol:"HTMLOListElement",optgroup:"HTMLOptGroupElement",option:"HTMLOptionElement",output:"HTMLOutputElement",p:"HTMLParagraphElement",param:"HTMLParamElement",pre:"HTMLPreElement",progress:"HTMLProgressElement",q:"HTMLQuoteElement",s:"HTMLElement",samp:"HTMLElement",script:"HTMLScriptElement",section:"HTMLElement",select:"HTMLSelectElement",small:"HTMLElement",source:"HTMLSourceElement",span:"HTMLSpanElement",strike:"HTMLElement",strong:"HTMLElement",style:"HTMLStyleElement",sub:"HTMLElement",summary:"HTMLElement",sup:"HTMLElement",table:"HTMLTableElement",tbody:"HTMLTableSectionElement",td:"HTMLTableDataCellElement",textarea:"HTMLTextAreaElement",tfoot:"HTMLTableSectionElement",th:"HTMLTableHeaderCellElement",thead:"HTMLTableSectionElement",time:"HTMLTimeElement",title:"HTMLTitleElement",tr:"HTMLTableRowElement",track:"HTMLTrackElement",tt:"HTMLElement",u:"HTMLElement",ul:"HTMLUListElement",var:"HTMLElement",video:"HTMLVideoElement",wbr:"HTMLElement"},i.ELEMENT_DOM_INTERFACES=i.O,i.N={NOT_LOADED:0,SAME_DOCUMENT:1,NEW_DOCUMENT:2},i.ueffects=i.N,i.J={"a::href":2,"area::href":2,"audio::src":1,"blockquote::cite":0,"command::icon":1,"del::cite":0,"form::action":2,"img::src":1,"input::src":1,"ins::cite":0,"q::cite":0,"video::poster":1,"video::src":1},i.URIEFFECTS=i.J,i.L={UNSANDBOXED:2,SANDBOXED:1,DATA:0},i.ltypes=i.L,i.I={"a::href":2,"area::href":2,"audio::src":2,"blockquote::cite":2,"command::icon":1,"del::cite":2,"form::action":2,"img::src":1,"input::src":1,"ins::cite":2,"q::cite":2,"video::poster":1,"video::src":2},i.LOADERTYPES=i.I;var n=function(i){function n(e){if(k.hasOwnProperty(e))return k[e];var t=e.match(A);return t?String.fromCharCode(parseInt(t[1],10)):(t=e.match(E))?String.fromCharCode(parseInt(t[1],16)):T&&M.test(e)?(T.innerHTML="&"+e+";",t=T.textContent,k[e]=t):"&"+e+";"}function o(e,t){return n(t)}function r(e){return e.replace(L,o)}function a(e){return(""+e).replace(_,"&amp;").replace(H,"&lt;").replace(C,"&gt;").replace(D,"&#34;")}function l(e){return e.replace(P,"&amp;$1").replace(H,"&lt;").replace(C,"&gt;")}function s(t){var i={z:t.z||t.cdata,A:t.A||t.comment,B:t.B||t.endDoc,r:t.r||t.endTag,d:t.d||t.pcdata,F:t.F||t.rcdata,H:t.H||t.startDoc,v:t.v||t.startTag};return function(t,n){var o,r=/(<\/|<\!--|<[!?]|[&<>])/g;if(o=t+"",z)o=o.split(r);else{for(var a,l=[],s=0;(a=r.exec(o))!==e;)l.push(o.substring(s,a.index)),l.push(a[0]),s=a.index+a[0].length;l.push(o.substring(s)),o=l}p(i,o,0,{o:!1,C:!1},n)}}function c(e,t,i,n,o){return function(){p(e,t,i,n,o)}}function p(e,t,n,o,r){try{e.H&&0==n&&e.H(r);for(var a,l,s,p=t.length;n<p;){var f=t[n++],m=t[n];switch(f){case"&":I.test(m)?(e.d&&e.d("&"+m,r,R,c(e,t,n,o,r)),n++):e.d&&e.d("&amp;",r,R,c(e,t,n,o,r));break;case"</":if(a=/^([-\w:]+)[^\'\"]*/.exec(m))if(a[0].length===m.length&&">"===t[n+1])n+=2,s=a[1].toLowerCase(),e.r&&e.r(s,r,R,c(e,t,n,o,r));else{var h=t,g=n,b=e,w=r,v=R,x=o,y=u(h,g);y?(b.r&&b.r(y.name,w,v,c(b,h,g,x,w)),n=y.next):n=h.length}else e.d&&e.d("&lt;/",r,R,c(e,t,n,o,r));break;case"<":if(a=/^([-\w:]+)\s*\/?/.exec(m))if(a[0].length===m.length&&">"===t[n+1]){n+=2,s=a[1].toLowerCase(),e.v&&e.v(s,[],r,R,c(e,t,n,o,r));var k=i.f[s];k&j&&(n=d(t,{name:s,next:n,c:k},e,r,R,o))}else{var h=t,g=e,b=r,w=R,v=o,A=u(h,n);A?(g.v&&g.v(A.name,A.P,b,w,c(g,h,A.next,v,b)),n=A.c&j?d(h,A,g,b,w,v):A.next):n=h.length}else e.d&&e.d("&lt;",r,R,c(e,t,n,o,r));break;case"\x3c!--":if(!o.C){for(l=n+1;l<p&&(">"!==t[l]||!/--$/.test(t[l-1]));l++);if(l<p){if(e.A){var E=t.slice(n,l).join("");e.A(E.substr(0,E.length-2),r,R,c(e,t,l+1,o,r))}n=l+1}else o.C=!0}o.C&&e.d&&e.d("&lt;!--",r,R,c(e,t,n,o,r));break;case"<!":if(/^\w/.test(m)){if(!o.o){for(l=n+1;l<p&&">"!==t[l];l++);l<p?n=l+1:o.o=!0}o.o&&e.d&&e.d("&lt;!",r,R,c(e,t,n,o,r))}else e.d&&e.d("&lt;!",r,R,c(e,t,n,o,r));break;case"<?":if(!o.o){for(l=n+1;l<p&&">"!==t[l];l++);l<p?n=l+1:o.o=!0}o.o&&e.d&&e.d("&lt;?",r,R,c(e,t,n,o,r));break;case">":e.d&&e.d("&gt;",r,R,c(e,t,n,o,r));break;case"":break;default:e.d&&e.d(f,r,R,c(e,t,n,o,r))}}e.B&&e.B(r)}catch(e){if(e!==R)throw e}}function d(e,t,n,o,r,a){var s=e.length;O.hasOwnProperty(t.name)||(O[t.name]=RegExp("^"+t.name+"(?:[\\s\\/]|$)","i"));for(var p=O[t.name],d=t.next,u=t.next+1;u<s&&("</"!==e[u-1]||!p.test(e[u]));u++);if(u<s&&(u-=1),s=e.slice(d,u).join(""),t.c&i.c.CDATA)n.z&&n.z(s,o,r,c(n,e,u,a,o));else if(t.c&i.c.RCDATA)n.F&&n.F(l(s),o,r,c(n,e,u,a,o));else throw Error("bug");return u}function u(e,t){var n=/^([-\w:]+)/.exec(e[t]),o={};o.name=n[1].toLowerCase(),o.c=i.f[o.name];for(var a=e[t].substr(n[0].length),l=t+1,s=e.length;l<s&&">"!==e[l];l++)a+=e[l];if(!(s<=l)){for(var c=[];""!==a;)if(n=N.exec(a))if(n[4]&&!n[5]||n[6]&&!n[7]){for(var n=n[4]||n[6],p=!1,a=[a,e[l++]];l<s;l++){if(p){if(">"===e[l])break}else 0<=e[l].indexOf(n)&&(p=!0);a.push(e[l])}if(s<=l)break;a=a.join("")}else{var d,p=n[1].toLowerCase();if(n[2]){d=n[3];var u=d.charCodeAt(0);if(34===u||39===u)d=d.substr(1,d.length-2);d=r(d.replace(S,""))}else d="";c.push(p,d),a=a.substr(n[0].length)}else a=a.replace(/^[\s\S][^a-z\s]*/,"");return o.P=c,o.next=l+1,o}}function f(t){function n(e,t){r||t.push(e)}var o,r;return s({startDoc:function(){o=[],r=!1},startTag:function(n,l,s){if(!r&&i.f.hasOwnProperty(n)){var c=i.f[n];if(!(c&i.c.FOLDABLE)){var p=t(n,l);if(p){if("object"!=typeof p)throw Error("tagPolicy did not return object (old API?)");if("attribs"in p)l=p.attribs;else throw Error("tagPolicy gave no attribs");var d;if("tagName"in p?(d=p.tagName,p=i.f[d]):(d=n,p=c),c&i.c.OPTIONAL_ENDTAG){var u=o[o.length-1];u&&u.D===n&&(u.t!==d||n!==d)&&s.push("</",u.t,">")}for(c&i.c.EMPTY||o.push({D:n,t:d}),s.push("<",d),n=0,u=l.length;n<u;n+=2){var f=l[n],m=l[n+1];m!==e&&void 0!==m&&s.push(" ",f,'="',a(m),'"')}s.push(">"),c&i.c.EMPTY&&!(p&i.c.EMPTY)&&s.push("</",d,">")}else r=!(c&i.c.EMPTY)}}},endTag:function(e,t){if(r)r=!1;else if(i.f.hasOwnProperty(e)){var n=i.f[e];if(!(n&(i.c.EMPTY|i.c.FOLDABLE))){if(n&i.c.OPTIONAL_ENDTAG)for(n=o.length;0<=--n;){var a=o[n].D;if(a===e)break;if(!(i.f[a]&i.c.OPTIONAL_ENDTAG))return}else for(n=o.length;0<=--n&&o[n].D!==e;);if(!(0>n)){for(a=o.length;--a>n;){var l=o[a].t;i.f[l]&i.c.OPTIONAL_ENDTAG||t.push("</",l,">")}n<o.length&&(e=o[n].t),o.length=n,t.push("</",e,">")}}}},pcdata:n,rcdata:n,cdata:n,endDoc:function(e){for(;o.length;o.length--)e.push("</",o[o.length-1].t,">")}})}function m(i,n,o,r,a){if(!a)return e;try{var l=t.parse(""+i);if(l&&(!l.K()||q.test(l.U()))){var s=a(l,n,o,r);return s?s.toString():e}}catch(e){}return e}function h(e,t,i,n,o){if(i||e(t+" removed",{Q:"removed",tagName:t}),n!==o){var r="changed";n&&!o?r="removed":!n&&o&&(r="added"),e(t+"."+i+" "+r,{Q:r,tagName:t,ia:i,oldValue:n,newValue:o})}}function g(e,t,i){if(t=t+"::"+i,e.hasOwnProperty(t))return e[t];if(t="*::"+i,e.hasOwnProperty(t))return e[t]}function b(t,n,o,r,a){for(var l=0;l<n.length;l+=2){var s,c=n[l],p=n[l+1],d=p,u=e;if(s=t+"::"+c,i.w.hasOwnProperty(s)||(s="*::"+c,i.w.hasOwnProperty(s)))u=i.w[s];if(u!==e)switch(u){case i.e.NONE:break;case i.e.SCRIPT:p=e,a&&h(a,t,c,d,p);break;case i.e.STYLE:if(void 0===x){p=e,a&&h(a,t,c,d,p);break}var f=[];x(p,{declaration:function(t,n){var r=t.toLowerCase();y(r,n,o?function(e){return m(e,i.N.ga,i.L.ha,{TYPE:"CSS",CSS_PROP:r},o)}:e),n.length&&f.push(r+": "+n.join(" "))}}),p=0<f.length?f.join(" ; "):e,a&&h(a,t,c,d,p);break;case i.e.ID:case i.e.IDREF:case i.e.IDREFS:case i.e.GLOBAL_NAME:case i.e.LOCAL_NAME:case i.e.CLASSES:p=r?r(p):p,a&&h(a,t,c,d,p);break;case i.e.URI:p=m(p,g(i.J,t,c),g(i.I,t,c),{TYPE:"MARKUP",XML_ATTR:c,XML_TAG:t},o),a&&h(a,t,c,d,p);break;case i.e.URI_FRAGMENT:p&&"#"===p.charAt(0)?(p=p.substring(1),(p=r?r(p):p)!==e&&void 0!==p&&(p="#"+p)):p=e,a&&h(a,t,c,d,p);break;default:p=e,a&&h(a,t,c,d,p)}else p=e,a&&h(a,t,c,d,p);n[l+1]=p}return n}function w(e,t,n){return function(o,r){if(i.f[o]&i.c.UNSAFE)n&&h(n,o,void 0,void 0,void 0);else return{attribs:b(o,r,e,t,n)}}}function v(e,t){var i=[];return f(t)(e,i),i.join("")}var x,y;"undefined"!=typeof window&&(x=window.parseCssDeclarations,y=window.sanitizeCssProperty);var k={lt:"<",LT:"<",gt:">",GT:">",amp:"&",AMP:"&",quot:'"',apos:"'",nbsp:" "},A=/^#(\d+)$/,E=/^#x([0-9A-Fa-f]+)$/,M=/^[A-Za-z][A-za-z0-9]+$/,T="undefined"!=typeof window&&window.document?window.document.createElement("textarea"):e,S=/\0/g,L=/&(#[0-9]+|#[xX][0-9A-Fa-f]+|\w+);/g,I=/^(#[0-9]+|#[xX][0-9A-Fa-f]+|\w+);/,_=/&/g,P=/&([^a-z#]|#(?:[^0-9x]|x(?:[^0-9a-f]|$)|$)|$)/gi,H=/[<]/g,C=/>/g,D=/\"/g,N=/^\s*([-.:\w]+)(?:\s*(=)\s*((")[^"]*("|$)|(')[^']*('|$)|(?=[a-z][-\w]*\s*=)|[^"'\s]*))?/i,z=3==="a,b".split(/(,)/).length,j=i.c.CDATA|i.c.RCDATA,R={},O={},q=/^(?:https?|mailto)$/i,U={};return U.ka=U.escapeAttrib=a,U.la=U.makeHtmlSanitizer=f,U.ma=U.makeSaxParser=s,U.na=U.makeTagPolicy=w,U.pa=U.normalizeRCData=l,U.qa=U.sanitize=function(e,t,i,n){return v(e,w(t,i,n))},U.ra=U.sanitizeAttribs=b,U.sa=U.sanitizeWithPolicy=v,U.ta=U.unescapeEntities=r,U}(i);window.define?define("mip-mustache/html-sanitizer",[],function(){return n}):window.html_sanitizer=n}(),define("mip-mustache/sanitizer",["require","./html-sanitizer"],function(e){function t(e,t,i){if(0==t.indexOf("on")&&"on"!=t)return!1;if("style"==t)return!1;if(i)for(var n=i.toLowerCase().replace(/[\s,\u0000]+/g,""),o=0;o<l.length;o++)if(-1!=n.indexOf(l[o]))return!1;var r=p[e];if(r&&-1!=r.indexOf(t))return!1;var a=s[e];if(a){var c=a[t];if(c&&-1!=i.search(c))return!1}return!0}function i(e){function i(e){if(0===s)c.push(e)}var l=n.makeTagPolicy(),s=0,c=[];return n.makeSaxParser({startTag:function(e,c){if(!(s>0)){if(r[e])s++;else if(0!=e.indexOf("mip-")){var p=c.slice(0),u=l(e,c);if(!u)s++;c=u.attribs;for(var f=0;f<c.length;f+=2)if(-1!=d.indexOf(c[f]))c[f+1]=p[f+1];else if(0==c[f].search(a))c[f+1]=p[f+1]}if(!(s>0)){i("<"),i(e);for(var f=0;f<c.length;f+=2){var m=c[f],h=c[f+1];if(t(e,m,h)){if(i(" "),i(m),i('="'),h)i(n.escapeAttrib(h));i('"')}}i(">")}else if(o[e])s--}else if(!o[e])s++},endTag:function(e){if(s>0)return void s--;i("</"),i(e),i(">")},pcdata:i,rcdata:i,cdata:i})(e),c.join("")}var n=e("./html-sanitizer"),o={br:!0,col:!0,hr:!0,img:!0,input:!0,source:!0,track:!0,wbr:!0,area:!0,base:!0,command:!0,embed:!0,link:!0,meta:!0,param:!0},r={applet:!0,audio:!0,base:!0,embed:!0,form:!0,frame:!0,frameset:!0,iframe:!0,img:!0,link:!0,meta:!0,object:!0,script:!0,style:!0,svg:!0,template:!0,video:!0},a=/^data-/i,l=["javascript:","vbscript:","data:","<script","</script"],s={input:{type:/(?:image|file|password|button)/i}},c=["form","formaction","formmethod","formtarget","formnovalidate","formenctype"],p={input:c,textarea:c,select:c},d=["fallback","href","on","placeholder"];return i}),function(e,t){if("object"==typeof exports&&exports&&"string"!=typeof exports.nodeName)t(exports);else if("function"==typeof define&&define.amd)define("mip-mustache/mustache",["exports"],t);else e.Mustache={},t(e.Mustache)}(this,function(e){function t(e){return"function"==typeof e}function i(e){return h(e)?"array":typeof e}function n(e){return e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g,"\\$&")}function o(e,t){return null!=e&&"object"==typeof e&&t in e}function r(e,t){return g.call(e,t)}function a(e){return!r(b,e)}function l(e){return String(e).replace(/[&<>"'`=\/]/g,function(e){return w[e]})}function s(t,i){function o(){if(b&&!w)for(;g.length;)delete m[g.pop()];else g=[];b=!1,w=!1}function r(e){if("string"==typeof e)e=e.split(x,2);if(!h(e)||2!==e.length)throw new Error("Invalid tags: "+e);l=new RegExp(n(e[0])+"\\s*"),s=new RegExp("\\s*"+n(e[1])),u=new RegExp("\\s*"+n("}"+e[1]))}if(!t)return[];var l,s,u,f=[],m=[],g=[],b=!1,w=!1;r(i||e.tags);for(var E,M,T,S,L,I,_=new d(t);!_.eos();){if(E=_.pos,T=_.scanUntil(l))for(var P=0,H=T.length;P<H;++P){if(S=T.charAt(P),a(S))g.push(m.length);else w=!0;if(m.push(["text",S,E,E+1]),E+=1,"\n"===S)o()}if(!_.scan(l))break;if(b=!0,M=_.scan(A)||"name",_.scan(v),"="===M)T=_.scanUntil(y),_.scan(y),_.scanUntil(s);else if("{"===M)T=_.scanUntil(u),_.scan(k),_.scanUntil(s),M="&";else T=_.scanUntil(s);if(!_.scan(s))throw new Error("Unclosed tag at "+_.pos);if(L=[M,T,E,_.pos],m.push(L),"#"===M||"^"===M)f.push(L);else if("/"===M){if(!(I=f.pop()))throw new Error('Unopened section "'+T+'" at '+E);if(I[1]!==T)throw new Error('Unclosed section "'+I[1]+'" at '+E)}else if("name"===M||"{"===M||"&"===M)w=!0;else if("="===M)r(T)}if(I=f.pop())throw new Error('Unclosed section "'+I[1]+'" at '+_.pos);return p(c(m))}function c(e){for(var t,i,n=[],o=0,r=e.length;o<r;++o)if(t=e[o])if("text"===t[0]&&i&&"text"===i[0])i[1]+=t[1],i[3]=t[3];else n.push(t),i=t;return n}function p(e){for(var t,i,n=[],o=n,r=[],a=0,l=e.length;a<l;++a)switch(t=e[a],t[0]){case"#":case"^":o.push(t),r.push(t),o=t[4]=[];break;case"/":i=r.pop(),i[5]=t[2],o=r.length>0?r[r.length-1][4]:n;break;default:o.push(t)}return n}function d(e){this.string=e,this.tail=e,this.pos=0}function u(e,t){this.view=e,this.cache={".":this.view},this.parent=t}function f(){this.cache={}}var m=Object.prototype.toString,h=Array.isArray||function(e){return"[object Array]"===m.call(e)},g=RegExp.prototype.test,b=/\S/,w={"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#39;","/":"&#x2F;","`":"&#x60;","=":"&#x3D;"},v=/\s*/,x=/\s+/,y=/\s*=/,k=/\s*\}/,A=/#|\^|\/|>|\{|&|=|!/;d.prototype.eos=function(){return""===this.tail},d.prototype.scan=function(e){var t=this.tail.match(e);if(!t||0!==t.index)return"";var i=t[0];return this.tail=this.tail.substring(i.length),this.pos+=i.length,i},d.prototype.scanUntil=function(e){var t,i=this.tail.search(e);switch(i){case-1:t=this.tail,this.tail="";break;case 0:t="";break;default:t=this.tail.substring(0,i),this.tail=this.tail.substring(i)}return this.pos+=t.length,t},u.prototype.push=function(e){return new u(e,this)},u.prototype.lookup=function(e){var i,n=this.cache;if(n.hasOwnProperty(e))i=n[e];else{for(var r,a,l=this,s=!1;l;){if(e.indexOf(".")>0)for(i=l.view,r=e.split("."),a=0;null!=i&&a<r.length;){if(a===r.length-1)s=o(i,r[a]);i=i[r[a++]]}else i=l.view[e],s=o(l.view,e);if(s)break;l=l.parent}n[e]=i}if(t(i))i=i.call(this.view);return i},f.prototype.clearCache=function(){this.cache={}},f.prototype.parse=function(e,t){var i=this.cache,n=i[e];if(null==n)n=i[e]=s(e,t);return n},f.prototype.render=function(e,t,i){var n=this.parse(e),o=t instanceof u?t:new u(t);return this.renderTokens(n,o,i,e)},f.prototype.renderTokens=function(e,t,i,n){for(var o,r,a,l="",s=0,c=e.length;s<c;++s){if(a=void 0,o=e[s],"#"===(r=o[0]))a=this.renderSection(o,t,i,n);else if("^"===r)a=this.renderInverted(o,t,i,n);else if(">"===r)a=this.renderPartial(o,t,i,n);else if("&"===r)a=this.unescapedValue(o,t);else if("name"===r)a=this.escapedValue(o,t);else if("text"===r)a=this.rawValue(o);if(void 0!==a)l+=a}return l},f.prototype.renderSection=function(e,i,n,o){function r(e){return a.render(e,i,n)}var a=this,l="",s=i.lookup(e[1]);if(s){if(h(s))for(var c=0,p=s.length;c<p;++c)l+=this.renderTokens(e[4],i.push(s[c]),n,o);else if("object"==typeof s||"string"==typeof s||"number"==typeof s)l+=this.renderTokens(e[4],i.push(s),n,o);else if(t(s)){if("string"!=typeof o)throw new Error("Cannot use higher-order sections without the original template");if(null!=(s=s.call(i.view,o.slice(e[3],e[5]),r)))l+=s}else l+=this.renderTokens(e[4],i,n,o);return l}},f.prototype.renderInverted=function(e,t,i,n){var o=t.lookup(e[1]);if(!o||h(o)&&0===o.length)return this.renderTokens(e[4],t,i,n)},f.prototype.renderPartial=function(e,i,n){if(n){var o=t(n)?n(e[1]):n[e[1]];if(null!=o)return this.renderTokens(this.parse(o),i,n,o);else return}},f.prototype.unescapedValue=function(e,t){var i=t.lookup(e[1]);if(null!=i)return i},f.prototype.escapedValue=function(t,i){var n=i.lookup(t[1]);if(null!=n)return e.escape(n)},f.prototype.rawValue=function(e){return e[1]},e.name="mustache.js",e.version="2.3.0",e.tags=["{{","}}"];var E=new f;return e.clearCache=function(){return E.clearCache()},e.parse=function(e,t){return E.parse(e,t)},e.render=function(e,t,n){if("string"!=typeof e)throw new TypeError('Invalid template! Template should be a "string" but "'+i(e)+'" was given as the first argument for mustache#render(template, view, partials)');return E.render(e,t,n)},e.to_html=function(i,n,o,r){var a=e.render(i,n,o);if(t(r))r(a);else return a},e.escape=l,e.Scanner=d,e.Context=u,e.Writer=f,e}),define("mip-mustache/mip-mustache",["require","./sanitizer","./mustache","templates"],function(e){"use strict";var t=e("./sanitizer"),i=e("./mustache"),n=e("templates"),o=n.inheritTemplate();return o.prototype.cache=function(e){i.parse(e)},o.prototype.render=function(e,n){var o=i.render(e,n);return t(o)},o}),define("mip-mustache",["mip-mustache/mip-mustache"],function(e){return e}),function(){function e(e,t){e.registerMipElement("mip-mustache",t)}if(window.MIP)require(["mip-mustache"],function(t){e(window.MIP,t)});else require(["mip","mip-mustache"],e)}()}});