var enableNews = true,
    server = '//news.cascadiafest.org',
    // server = '//localhost:4000',
    feedurl = '/2016/news/list.jsonp';

if(enableNews) {
  $('.nav-news').show();

  $.ajax(server + feedurl, {
    dataType: "jsonp"
  });
}

var _cascadiafest_news_callback = function (data) {
  var months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];

  data.forEach(function (post) {
    var html = []
        classes = [
          'col-xs-12',
          'col-md-10',
          'col-lg-8',
          'offset-md-1',
          'offset-lg-2',
          'text-sm-center'
        ],
        post_date = post.date.split(' ');

    post_date.pop();
    post_date = new Date(post_date.join('T'));

    var minutes = post_date.getMinutes().toString().length == 1 ? '0'+post_date.getMinutes() : post_date.getMinutes();
    var hours = post_date.getHours().toString().length == 1 ? post_date.getHours() : post_date.getHours() - 12;
    var ampm = post_date.getHours() >= 12 ? 'pm' : 'am';

    post_date = months[post_date.getMonth()] + ' ' + post_date.getDay() + ', ' + hours + ':' + minutes + ampm;

    html.push('<h4><a href="' + server + post.url + '">' + post.title + '</a> ' + '<small>' + post_date + '</small></h4>');

    if(typeof post.abstract !== 'undefined') {
      html.push('<div class="abstract">' + post.abstract + '</div>');
    }

    html = html.join('');
    html = '<div class="' + classes.join(' ') + '">' + html + '</div>';

    $('#news-list').append(html);
  });
}