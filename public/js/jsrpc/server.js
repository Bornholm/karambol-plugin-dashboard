(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory();
  } else {
    root.JSRPC = root.JSRPC || {};
    root.JSRPC.Server = factory();
  }
}(this, function () {

  'use strict';

  var Server = function(sendHandler) {
    this._sendHandler = sendHandler;
    this._methods = {};
  };

  Server.prototype.expose = function(methods, cb) {
    if(typeof methods === 'object') {
      for(var key in methods) {
        if(methods.hasOwnProperty(key)) {
          this.expose(key, methods[key]);
        }
      }
    } else {
      this._methods[methods] = cb;
      return this;
    }
  };

  Server.prototype.handleMessage = function(message, context) {

    if(!message || !message.method) return this;

    var methodHandler = this._methods[message.method];
    var context = context || {};

    if(typeof methodHandler !== 'function') return this;
    if(!('id' in message)) methodHandler(method.params, context, function noOp(){});

    var response = { id: message.id };
    try {
      var self = this;
      methodHandler(message.params || {}, context, function(err, result) {
        if(err) {
          response.error = err;
        } else {
          response.result = result;
        }
        return self._sendHandler(response, context);
      });
    } catch(err) {
      response.error = err;
      this._sendHandler(response, context);
    }

    return this;

  };

  return Server;

}));
