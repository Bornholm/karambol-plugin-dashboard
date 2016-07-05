(function (root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof module === 'object' && module.exports) {
    module.exports = factory();
  } else {
    root.JSRPC = root.JSRPC || {};
    root.JSRPC.Client = factory();
  }
}(this, function () {

  'use strict';

  var Client = function(sendHandler) {
    this._sendHandler = sendHandler;
    this._nextMessageId = 0;
    this._pendingResults = {};
  };

  Client.prototype.invoke = function(method, params, cb) {

    var isNotification = typeof cb !== 'function';
    var message = {
      method: method,
      params: params,
      id: isNotification ? undefined : this._nextMessageId
    };

    if(!isNotification) {
      this._pendingResults[this._nextMessageId] = cb;
      this._nextMessageId++;
    }

    this._sendHandler(message);

    return this;

  };

  Client.prototype.handleMessage = function(message) {
    if(!message || !('id' in message)) return this;
    var resultHandler = this._pendingResults[message.id];
    if(typeof resultHandler !== 'function') return;
    delete this._pendingResults[message.id];
    resultHandler(message.error, message.result);
    return this;
  };

  return Client;

}));
