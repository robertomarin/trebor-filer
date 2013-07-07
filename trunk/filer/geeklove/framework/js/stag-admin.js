var j = jQuery;
j(document).ready(function($){
  var hash = window.location.hash;
  if(hash !== ''){
    $('#page-'+ hash.replace(/#/, '')).show();
    $('.stag-sidebar ul li a[href="'+hash+'"]').addClass('active');
  } else {
    $('.stag-main-content .page:first').show();
    $('.stag-sidebar ul li a:first').addClass('active');
  }

  $('.stag-sidebar ul li a').bind('click', function(){
    $('.stag-content .page').hide();
    var lock = $(this).attr('href');
    $('#page-' + lock.replace(/#/, '')).fadeIn(45).show();
    $('.stag-sidebar ul li a').removeClass('active');
    $(this).addClass('active');
  });

  $('#stag-admin-wrap #stag-form').submit(function(){
    var form = $(this);
    form.trigger('stag-before-save');
    var button = $('#stag-admin-wrap #save-button');
    var buttonVal = button.val();
    button.val('Saving...');
    $("#settings-saved").fadeIn(300);
    setTimeout(function(){
      $("#settings-saved").fadeOut();
    }, 1000);
    $.post(form.attr("action"), form.serialize(), function(data){
      button.val(buttonVal);
      if(data.error){
        $("#settings-saved").text('Error saving the data '+data.message);
      }else{
        $("#settings-saved").text(data.message);
        if(hasAdded){
          $(".changed").remove();
          hasAdded = false;
        }
      }
      form.trigger('stag-saved');
    }, 'json');
    return false;
  });

  $('#stag-admin-wrap #reset-button').live('click', function(){
    if(confirm('Click to reset. All settings will be lost.')){
      $(this).val('Resetting...');
      $.post(ajaxurl, {action: 'stag_framework_reset', nonce:$("#stag_noncename").val() }, function(data){
        if(data.error){
          console.log("Something went wrong - "+data.error);
        }else{
          window.location.reload(true);
        }
      }, 'json');
    }
    return false;
  });

  // WP3.5 Colorpicker
  $('.colorpicker').each(function(){
    $(this).wpColorPicker();
  });

  // Layout Switcher
  $("#stag-admin-wrap .main-layout br").remove();
  $('#stag-admin-wrap .main-layout input[type="radio"]').each(function(){
    var label = $(this).parent();
    label.addClass($(this).val());
    if($(this).is(':checked')) label.addClass('checked');
  });
  $('#stag-admin-wrap .main-layout label').live('click', function(){
    $("#stag-admin-wrap .main-layout label").removeClass('checked');
    $('#stag-admin-wrap .main-layout input[type="radio"]').attr('checked', false);
    var id = $(this).attr('for');
    $(this).addClass('checked');
    $('#stag-admin-wrap .main-layout #'+id).attr('checked', true);
  });

  var hasAdded = false;
  $("#stag-form input, #stag-form textarea, #stag-form select").live("keyup change input paste", function(){
    if(hasAdded === false){
      $("<span class='changed'><span></span>You have unsaved changes!</span>").insertBefore("#stag-admin-wrap");
    }
    hasAdded = true;
  });

  $("#import_code").click(function(){
    $(this).select();
  });

  $("#download_export_data").click(function(e){
    e.preventDefault();
    var code = localStorage.getItem("stag_theme_settings_data");
    if(typeof(code) === 'undefined'){
      $("output").text("Unable to geneated text file due to some error, please contact to the support team.");
      return false;
    }else{
      downloadFile(code, 'download_export_data_output');
    }
  });

  $("#download_debug_info").click(function(e){
    e.preventDefault();
    var code = localStorage.getItem("stag_debug_info_data");
    if(typeof(code) === 'undefined'){
      $("output").text("Unable to geneated text file due to some error, please contact to the support team.");
      return false;
    }else{
      downloadFile(code, 'download_debug_info_output');
    }
  });

  localStorage.setItem("stag_theme_settings_data", $("#theme_settings_data").text());
  localStorage.setItem("stag_debug_info_data", $("#debug_info_data").text());

  var wyButtons = ['bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', '|', 'link', 'fontcolor', 'backcolor', '|', 'html'];
  $(".wysiwyg_editor").redactor({
    buttons: wyButtons
  });

});


var downloadFile = function(code, id){
  const MIME_TYPE = "text/plain";
  var output = document.getElementById(id);

  window.URL = window.webkitURL || window.URL;
  window.BlobBuilder = window.BlobBuilder || window.WebKitBlobBuilder || window.MozBlobBuilder;
  var bb = new BlobBuilder();

  var time = new Date();
  var filename = "stag_"+time.getMonth()+"/"+time.getDate()+"/"+time.getFullYear()+"-"+time.getHours()+":"+time.getMinutes()+":"+time.getSeconds();

  bb.append(code);
  var a = document.createElement("a");
  a.download = filename+".txt";
  a.href = window.URL.createObjectURL(bb.getBlob(MIME_TYPE));
  a.target = "_blank";
  a.textContent = filename+".txt";
  output.appendChild(a);
}

var BlobBuilder=BlobBuilder||self.WebKitBlobBuilder||self.MozBlobBuilder||(function(j){"use strict";var c=function(v){return Object.prototype.toString.call(v).match(/^\[object\s(.*)\]$/)[1]},u=function(){this.data=[]},t=function(x,v,w){this.data=x;this.size=x.length;this.type=v;this.encoding=w},k=u.prototype,s=t.prototype,n=j.FileReaderSync,a=function(v){this.code=this[this.name=v]},l=("NOT_FOUND_ERR SECURITY_ERR ABORT_ERR NOT_READABLE_ERR ENCODING_ERR NO_MODIFICATION_ALLOWED_ERR INVALID_STATE_ERR SYNTAX_ERR").split(" "),r=l.length,o=j.URL||j.webkitURL||j,p=o.createObjectURL,b=o.revokeObjectURL,e=o,i=j.btoa,f=j.atob,m=false,h=function(v){m=!v},d=j.ArrayBuffer,g=j.Uint8Array;u.fake=s.fake=true;while(r--){a.prototype[l[r]]=r+1}try{if(g){h.apply(0,new g(1))}}catch(q){}if(!o.createObjectURL){e=j.URL={}}e.createObjectURL=function(w){var x=w.type,v;if(x===null){x="application/octet-stream"}if(w instanceof t){v="data:"+x;if(w.encoding==="base64"){return v+";base64,"+w.data}else{if(w.encoding==="URI"){return v+","+decodeURIComponent(w.data)}}if(i){return v+";base64,"+i(w.data)}else{return v+","+encodeURIComponent(w.data)}}else{if(real_create_object_url){return real_create_object_url.call(o,w)}}};e.revokeObjectURL=function(v){if(v.substring(0,5)!=="data:"&&real_revoke_object_url){real_revoke_object_url.call(o,v)}};k.append=function(z){var B=this.data;if(g&&z instanceof d){if(m){B.push(String.fromCharCode.apply(String,new g(z)))}else{var A="",w=new g(z),x=0,y=w.length;for(;x<y;x++){A+=String.fromCharCode(w[x])}}}else{if(c(z)==="Blob"||c(z)==="File"){if(n){var v=new n;B.push(v.readAsBinaryString(z))}else{throw new a("NOT_READABLE_ERR")}}else{if(z instanceof t){if(z.encoding==="base64"&&f){B.push(f(z.data))}else{if(z.encoding==="URI"){B.push(decodeURIComponent(z.data))}else{if(z.encoding==="raw"){B.push(z.data)}}}}else{if(typeof z!=="string"){z+=""}B.push(unescape(encodeURIComponent(z)))}}}};k.getBlob=function(v){if(!arguments.length){v=null}return new t(this.data.join(""),v,"raw")};k.toString=function(){return"[object BlobBuilder]"};s.slice=function(y,v,x){var w=arguments.length;if(w<3){x=null}return new t(this.data.slice(y,w>1?v:this.data.length),x,this.encoding)};s.toString=function(){return"[object Blob]"};return u}(self));
var saveAs=saveAs||(function(h){"use strict";var r=h.document,l=function(){return h.URL||h.webkitURL||h},e=h.URL||h.webkitURL||h,n=r.createElementNS("http://www.w3.org/1999/xhtml","a"),g="download" in n,j=function(t){var s=r.createEvent("MouseEvents");s.initMouseEvent("click",true,false,h,0,0,0,0,0,false,false,false,false,0,null);return t.dispatchEvent(s)},o=h.webkitRequestFileSystem,p=h.requestFileSystem||o||h.mozRequestFileSystem,m=function(s){(h.setImmediate||h.setTimeout)(function(){throw s},0)},c="application/octet-stream",k=0,b=[],i=function(){var t=b.length;while(t--){var s=b[t];if(typeof s==="string"){e.revokeObjectURL(s)}else{s.remove()}}b.length=0},q=function(t,s,w){s=[].concat(s);var v=s.length;while(v--){var x=t["on"+s[v]];if(typeof x==="function"){try{x.call(t,w||t)}catch(u){m(u)}}}},f=function(t,u){var v=this,B=t.type,E=false,x,w,s=function(){var F=l().createObjectURL(t);b.push(F);return F},A=function(){q(v,"writestart progress write writeend".split(" "))},D=function(){if(E||!x){x=s(t)}w.location.href=x;v.readyState=v.DONE;A()},z=function(F){return function(){if(v.readyState!==v.DONE){return F.apply(this,arguments)}}},y={create:true,exclusive:false},C;v.readyState=v.INIT;if(!u){u="download"}if(g){x=s(t);n.href=x;n.download=u;if(j(n)){v.readyState=v.DONE;A();return}}if(h.chrome&&B&&B!==c){C=t.slice||t.webkitSlice;t=C.call(t,0,t.size,c);E=true}if(o&&u!=="download"){u+=".download"}if(B===c||o){w=h}else{w=h.open()}if(!p){D();return}k+=t.size;p(h.TEMPORARY,k,z(function(F){F.root.getDirectory("saved",y,z(function(G){var H=function(){G.getFile(u,y,z(function(I){I.createWriter(z(function(J){J.onwriteend=function(K){w.location.href=I.toURL();b.push(I);v.readyState=v.DONE;q(v,"writeend",K)};J.onerror=function(){var K=J.error;if(K.code!==K.ABORT_ERR){D()}};"writestart progress write abort".split(" ").forEach(function(K){J["on"+K]=v["on"+K]});J.write(t);v.abort=function(){J.abort();v.readyState=v.DONE};v.readyState=v.WRITING}),D)}),D)};G.getFile(u,{create:false},z(function(I){I.remove();H()}),z(function(I){if(I.code===I.NOT_FOUND_ERR){H()}else{D()}}))}),D)}),D)},d=f.prototype,a=function(s,t){return new f(s,t)};d.abort=function(){var s=this;s.readyState=s.DONE;q(s,"abort")};d.readyState=d.INIT=0;d.WRITING=1;d.DONE=2;d.error=d.onwritestart=d.onprogress=d.onwrite=d.onabort=d.onerror=d.onwriteend=null;h.addEventListener("unload",i,false);return a}(self));