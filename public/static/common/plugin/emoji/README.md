# jQuery-emoji
让文本框或可编辑div具备插入表情功能。  
Let textarea or editable div has ability to insert emoji.

## 预览 Preview
![image](http://www.skysun.name/images/jquery-emoji.png)

## 功能 Features
* 支持给textarea或可编辑div加上表情功能，自动识别元素类型。  
Support for adding emoji into textarea or editable div, automatic identification of element types.
* 如果是textarea，则选择表情后插入表情代码，如果是可编辑div，则直接插入表情图片。  
If it is textarea element,will insert code string of emoji, else, will insert emoji picture directly.
* 支持自定义表情代码的格式。  
Support for specifying the code format of emoji.
* 支持将表情代码转换为表情图片。  
Support for converting the code string of emoji into emoji picture.
* 支持多组表情并提供tab切换。  
Support for multiple groups of emoji and tabs to toggle.
* 示例已带有百度贴吧和qq高清2套表情。  
The demo has been with 2 sets of emojis:Baidu tieba emoji & QQ HD emoji.
* 同一页面支持多个表情实例。  
Support for multiple instances in one page.

## 示例&文档 Demo&Doc
[http://eshengsky.github.io/jQuery-emoji/](http://eshengsky.github.io/jQuery-emoji/)

## 更新日志 Changelog
####v1.2 2016/03/04
* 修改默认表情按钮图片，以解决IE下不显示svg类型base64图片的问题。  
Modify the default button image, in order to solve the problem that does not display svg type base64 image with IE.

####v1.1 2016/03/03
* 优化代码。  
Optimized code.
* 移除原先的flag和prefix配置项，新增placeholder配置项，可以完全自定义表情代码。  
Removed flag and prefix configs, a new config placeholder added, you can completely customize the emoji code.
* 现在分组名称不再是必填项。  
Now the name of the icons group is no more required.
* 插入或转换后的表情图片现在有了一个emoji_icon的class，可以自己定义样式。  
The emoji picture inserted or parsed now has a class 'emoji_icon', you can define your style.
* 优化将表情代码转换为表情图片时的正则表达式为懒惰匹配。  
Optimized the regular expression about parsing emoji code to emoji picture to lazy match.

## 许可协议 License
The MIT License (MIT)

Copyright (c) 2016 Sky

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
