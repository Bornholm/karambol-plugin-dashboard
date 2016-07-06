(function(KWidget, CONFIG, $, moment) {

  var $feed = $('#feed')
  var feedItemTemplate = $('#feed-item-template')[0];

  KWidget.getOptions(function(err, opts) {

    if(err) return console.error(err);

    if(!opts || !opts.feedUrl) return console.log('No feed url in options.');

    var url = __CONFIG__.fetchFeedURL+'?u='+encodeURIComponent(opts.feedUrl);

    $.getJSON(url)
      .then(function(feedData) {

        KWidget.setTitle(feedData.title);

        var locale = navigator.language ? navigator.language.split('-')[0] : 'fr';
        moment.locale(locale);

        var items = [];

        feedData.items.forEach(function(item) {
          var newItem = $(document.importNode(feedItemTemplate.content, true));
          newItem.find('a.list-group-item').attr('href', item.url);
          var momentDate = moment(item.date.date);
          newItem.find('h4.list-group-item-heading').text(item.title).append('<small> - '+momentDate.fromNow()+'</small>');
          var firstParagraphEnd = item.content.indexOf('</p>');
          var text = item.content.slice(0, firstParagraphEnd !== -1 ? firstParagraphEnd+4 : 100);
          newItem.find('p.list-group-item-text').html(text);
          items.push(newItem);
        });

        $feed.html(items);

      })
    ;

  });

}(KWidget, __CONFIG__, $, moment));
