/*
 * @auth:  lidian
 * @email: dainli@outlook.com
 * @desc:  print all image file names(gif,jpg,png)
 */

var fs = require('fs');
var path = require('path');

fs.readdir(__dirname, function(err, files){
  data = files.filter(function(item){
    return /\.(gif|jpg|jpeg|png|GIF|JPG|PNG)$/.test(item);
  });
  console.info(data);
})
