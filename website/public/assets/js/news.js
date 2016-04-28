var _cascadiafest_news_callback = function (data) {
  console.log(data);
}

$.ajax('//news.cascadiafest.org/2016/news/list.jsonp', {
  dataType: "jsonp"
});