(function(KWidget) {

  KWidget.setTitle('test-'+Date.now());
  KWidget.setPreferredHeight(Math.random()*500, function(err) {
    console.log(err);
    console.log('done');
  });

}(KWidget));
