
window.onload = function () { 

  jQuery(".gfield_label:contains('FingerPrint')").parent().hide();



  var textarea='<div style="display:none; visibility:hidden"><textarea name="fornotes" style="display:none; visibility:hidden" class="fingerprintitem"></textarea></div>';
  //jQuery("#gform_" + gformid ).append(textarea);
  jQuery(".gform_body" ).append(textarea);
  var client = new ClientJS();  
  const fingerprint = client.getFingerprint();
  const person = {  
      'browserData':client.getBrowserData(), 
      'fingerprint':fingerprint,
      "userAgent": client.getUserAgent(),
      "userAgentLowerCase": client.getUserAgentLowerCase(),
      "browser": client.getBrowser(),
      "browserVersion": client.getBrowserVersion(),
      "browserMajorVersion": client.getBrowserMajorVersion(),
      "isIE": client.isIE(),
      "isChrome": client.isChrome(),
      "isFirefox": client.isFirefox(),
      "isSafari": client.isSafari(),
      "isOpera": client.isOpera(),
      "engine": client.getEngine(),
      "engineVersion": client.getEngineVersion(),
      "os": client.getOS(),
      "osVersion": client.getOSVersion(),
      "isWindows": client.isWindows(),
      "isMac": client.isMac(),
      "isLinux": client.isLinux(),
      "isUbuntu": client.isUbuntu(),
      "isSolaris": client.isSolaris(),
      "deviceType": client.getDeviceType(),
      "isMobileMajor": client.isMobile(),
      "isMobileMajor": client.isMobileMajor(),
      "isMobileAndroid": client.isMobileAndroid(),
      "isMobileOpera": client.isMobileOpera(),
      "isMobileWindows": client.isMobileWindows(),
      "isMobileBlackBerry": client.isMobileBlackBerry(),
      "isMobileIOS": client.isMobileIOS(),
      "isIphone": client.isIphone(),
      "isIpad": client.isIpad(),
      "isIpod": client.isIpod(),
      "fonts": client.getFonts(),
      "isLocalStorage": client.isLocalStorage(),
      "isSessionStorage": client.isSessionStorage(),
      "isCookie": client.isCookie(),
      "timeZone": client.getTimeZone(),
      "language": client.getLanguage(),
      "ip_address": tip,
      "form_id": gformid,
      "ip": tip
      };
  txt=JSON.stringify(person);

  jQuery(".fingerprintitem").val(txt);


}
 