(function($, window, JSRPC) {

  'use strict';

  var server = new JSRPC.Server(sendHandler);

  server.expose({

    setPreferredHeight: function(params, context, cb) {
      if(!('height' in params)) throw new Error('You must provide a "height" parameter.');
      if(params.height !== +params.height) throw new Error('The height parameter must be a number.');
      $(context.widgetFrame).height(params.height);
      return cb();
    },

    setTitle: function(params, context, cb) {
      if(!('title' in params)) throw new Error('You must provide a "title" parameter.');
      $(context.widgetFrame)
        .parents('.karambol-widget-panel')
        .find('.panel-title')
        .text(params.title)
      ;
      return cb();
    }

  });

  window.addEventListener('message', onWidgetMessage, false);

  function onWidgetMessage(evt) {
    console.log('message from client', evt);
    var widgetFrame = getSourceWidget(evt.source);
    if(widgetFrame) server.handleMessage(evt.data, {widgetFrame: widgetFrame});
  }

  function sendHandler(message, context) {
    context.widgetFrame.contentWindow.postMessage(message, '*');
  }

  function getSourceWidget(frameWindow) {
    var $widgets = $('iframe.karambol-widget');
    for(var widget, i = 0; (widget = $widgets[i]); i++) {
      if(widget.contentWindow === frameWindow) return widget;
    }
  }

}($, window, JSRPC));
