(function(JSRPC, KWidget, window) {

  'use strict';

  var parentWindow = window.parent;

  if(!parentWindow) throw new Error('A Karambol widget must embedded within a frame !');

  var pendingMessages = [];
  var isPageLoaded = false;
  window.addEventListener('load', function() {
    console.log('page loaded');
    setTimeout(function() {
      console.log('send pending messages');
      isPageLoaded = true;
      pendingMessages.forEach(sendHandler);
      pendingMessages.length = 0;
    }, 0);
  }, false);

  var client = new JSRPC.Client(sendHandler);

  KWidget.setTitle = function(title, cb) {
    client.invoke('setTitle', {title: title}, cb);
    return this;
  };

  KWidget.setPreferredHeight = function(height, cb) {
    client.invoke('setPreferredHeight', {height: height}, cb);
    return this;
  };

  function sendHandler(message) {
    if(isPageLoaded) {
      console.log('client', message);
      parentWindow.postMessage(message, '*');
    } else {
      pendingMessages.push(message);
    }
  }

  window.addEventListener('message', function onParentMessage(evt) {
    console.log('message from parent', evt);
    client.handleMessage(evt.data);
  }, false);

}(JSRPC, this.KWidget = this.KWidget || {}, window));
