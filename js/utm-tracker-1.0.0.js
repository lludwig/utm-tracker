var UtmCookie;

UtmCookie = (function() {
  function UtmCookie(options) {
    if (options == null) {
      options = {};
    }
    this._cookieNamePrefix = '_uc_';
    this._domain = options.domain;
    this._sessionLength = options.sessionLength || 1;
    this._cookieExpiryDays = options.cookieExpiryDays || 30;
    this._additionalParams = options.additionalParams || [];
    this._utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
    if (this.additionalParamsPresentInUrl()) {
      this.writeAdditionalParams();
    }
    if (this.utmPresentInUrl()) {
      this.writeUtmCookieFromParams();
    }
    return;
  }

  UtmCookie.prototype.createCookie = function(name, value, days, path, domain, secure) {
    var cookieDomain, cookieExpire, cookiePath, cookieSecure, date, expireDate;
    expireDate = null;
    if (days) {
      date = new Date;
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expireDate = date;
    }
    cookieExpire = expireDate != null ? '; expires=' + expireDate.toGMTString() : '';
    cookiePath = path != null ? '; path=' + path : '; path=/';
    cookieDomain = domain != null ? '; domain=' + domain : '';
    cookieSecure = secure != null ? '; secure' : '';
    document.cookie = this._cookieNamePrefix + name + '=' + escape(value) + cookieExpire + cookiePath + cookieDomain + cookieSecure;
  };

  UtmCookie.prototype.readCookie = function(name) {
    var c, ca, i, nameEQ;
    nameEQ = this._cookieNamePrefix + name + '=';
    ca = document.cookie.split(';');
    i = 0;
    while (i < ca.length) {
      c = ca[i];
      while (c.charAt(0) === ' ') {
        c = c.substring(1, c.length);
      }
      if (c.indexOf(nameEQ) === 0) {
        return c.substring(nameEQ.length, c.length);
      }
      i++;
    }
    return null;
  };

  UtmCookie.prototype.eraseCookie = function(name) {
    this.createCookie(name, '', -1, null, this._domain);
  };

  UtmCookie.prototype.getParameterByName = function(name) {
    var regex, regexS, results;
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    regexS = '[\\?&]' + name + '=([^&#]*)';
    regex = new RegExp(regexS);
    results = regex.exec(window.location.search);
    if (results) {
      return decodeURIComponent(results[1].replace(/\+/g, ' '));
    } else {
      return '';
    }
  };

  UtmCookie.prototype.additionalParamsPresentInUrl = function() {
    var j, len, param, ref;
    ref = this._additionalParams;
    for (j = 0, len = ref.length; j < len; j++) {
      param = ref[j];
      if (this.getParameterByName(param)) {
        return true;
      }
    }
    return false;
  };

  UtmCookie.prototype.utmPresentInUrl = function() {
    var j, len, param, ref;
    ref = this._utmParams;
    for (j = 0, len = ref.length; j < len; j++) {
      param = ref[j];
      if (this.getParameterByName(param)) {
        return true;
      }
    }
    return false;
  };

  UtmCookie.prototype.writeCookie = function(name, value) {
    this.createCookie(name, value, this._cookieExpiryDays, null, this._domain);
  };

  UtmCookie.prototype.writeAdditionalParams = function() {
    var j, len, param, ref, value;
    ref = this._additionalParams;
    for (j = 0, len = ref.length; j < len; j++) {
      param = ref[j];
      value = this.getParameterByName(param);
      this.writeCookie(param, value);
    }
  };

  UtmCookie.prototype.writeUtmCookieFromParams = function() {
    var j, len, param, ref, value;
    ref = this._utmParams;
    for (j = 0, len = ref.length; j < len; j++) {
      param = ref[j];
      value = this.getParameterByName(param);
      this.writeCookie(param, value);
    }
  };

  UtmCookie.prototype.writeCookieOnce = function(name, value) {
    var existingValue;
    existingValue = this.readCookie(name);
    if (!existingValue) {
      this.writeCookie(name, value);
    }
  };

  return UtmCookie;

})();

var UtmForm, _uf;

UtmForm = (function() {
  function UtmForm(options) {
    if (options == null) {
      options = {};
    }
    this._utmParamsMap = {};
    this._utmParamsMap.utm_source = options.utm_source_field || 'USOURCE';
    this._utmParamsMap.utm_medium = options.utm_medium_field || 'UMEDIUM';
    this._utmParamsMap.utm_campaign = options.utm_campaign_field || 'UCAMPAIGN';
    this._utmParamsMap.utm_content = options.utm_content_field || 'UCONTENT';
    this._utmParamsMap.utm_term = options.utm_term_field || 'UTERM';
    this._additionalParamsMap = options.additional_params_map || {};
    this._addToForm = options.add_to_form || 'all';
    this._formQuerySelector = options.form_query_selector || 'form';
    this.utmCookie = new UtmCookie({
      domain: options.domain,
      sessionLength: options.sessionLength,
      cookieExpiryDays: options.cookieExpiryDays,
      additionalParams: Object.getOwnPropertyNames(this._additionalParamsMap)
    });
    this.addAllFields();
  }

  UtmForm.prototype.addAllFields = function() {
    var allForms, i, len;
    allForms = document.querySelectorAll(this._formQuerySelector);
    if (this._addToForm === 'none') {
      len = 0;
    } else if (this._addToForm === 'first') {
      len = Math.min(1, allForms.length);
    } else {
      len = allForms.length;
    }
    i = 0;
    while (i < len) {
      this.addAllFieldsToForm(allForms[i]);
      i++;
    }
  };

  UtmForm.prototype.addAllFieldsToForm = function(form) {
    var fieldName, param, ref, ref1;
    if (form && !form._utm_tagged) {
      form._utm_tagged = true;
      ref = this._utmParamsMap;
      for (param in ref) {
        fieldName = ref[param];
        this.addFormElem(form, fieldName, this.utmCookie.readCookie(param));
      }
      ref1 = this._additionalParamsMap;
      for (param in ref1) {
        fieldName = ref1[param];
        this.addFormElem(form, fieldName, this.utmCookie.readCookie(param));
      }
    }
  };

  UtmForm.prototype.addFormElem = function(form, fieldName, fieldValue) {
    this.insertAfter(this.getFieldEl(fieldName, fieldValue), form.lastChild);
  };

  UtmForm.prototype.getFieldEl = function(fieldName, fieldValue) {
    var fieldEl;
    fieldEl = document.createElement('input');
    fieldEl.type = "hidden";
    fieldEl.name = fieldName;
    fieldEl.value = fieldValue;
    return fieldEl;
  };

  UtmForm.prototype.insertAfter = function(newNode, referenceNode) {
    return referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
  };

  return UtmForm;

})();

_uf = window._uf || {};

window.UtmForm = new UtmForm(_uf);
