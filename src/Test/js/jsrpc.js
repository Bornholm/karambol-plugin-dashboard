var Client = require('../../public/js/jsrpc/client');
var Server = require('../../public/js/jsrpc/server');
var EventEmitter = require('events').EventEmitter;

exports.setUp = function(done) {

  var clientProxy = new EventEmitter();
  var serverProxy = new EventEmitter();

  var clientMessageHandler = function(message) { clientProxy.emit('message', message); };
  var serverMessageHandler = function(message) { serverProxy.emit('message', message); };

  var server = this.server = new Server(serverMessageHandler);
  var client = this.client = new Client(clientMessageHandler);

  clientProxy.on('message', function(message) { server.handleMessage(message); });
  serverProxy.on('message', function(message) { client.handleMessage(message); });

  // clientProxy.on('message', console.log.bind(console, 'client'));
  // serverProxy.on('message', console.log.bind(console, 'server'));

  done();

}

exports.testEchoInvoke = function(test) {

  this.server.expose({
    echo: function(params, context, cb) {
      test.equal(params.message, 'foo');
      return cb(null, params.message);
    }
  });

  this.client.invoke('echo', {message: 'foo'}, function(err, result) {
    test.ifError(err);
    test.equal(result, 'foo');
    test.done();
  });

};

exports.testRemoteSyncError = function(test) {

  this.server.expose({
    unexpectedSyncError: function(params, context, cb) {
      throw new Error('foo');
    }
  });

  this.client.invoke('unexpectedSyncError', null, function(err, result) {
    test.notEqual(err, null);
    test.equal(err.message, 'foo');
    test.done();
  });

};

exports.testRemoteAsyncError = function(test) {

  this.server.expose({
    unexpectedAsyncError: function(params, context, cb) {
      setTimeout(function() {
        return cb(new Error('foo'));
      }, 0);
    }
  });

  this.client.invoke('unexpectedAsyncError', null, function(err, result) {
    test.notEqual(err, null);
    test.equal(err.message, 'foo');
    test.done();
  });

};
