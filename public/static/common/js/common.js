;
/*localstorage*/
!function (a, b, c) {
    var d = {
        set: function (a, c) {
            null !== this.get(a) && this.remove(a), b.setItem(a, c)
        }, get: function (a) {
            var d = b.getItem(a);
            return d === c ? null : d
        }, remove: function (a) {
            b.removeItem(a)
        }, clear: function () {
            b.clear()
        }, each: function (a) {
            for (var e, c = b.length, d = 0, a = a || function () {
                }; c > d && (e = b.key(d), a.call(this, e, this.get(e)) !== !1); d++)b.length < c && (c--, d--)
        }
    };
    a.LS = a.LS || d
}(window, window.localStorage);
/*localstorage End*/

/*asstouch*/

$(function () {
    "use strict";
    function h() {
        e = LS.get("eid"), f = LS.get("sid"), g = LS.get("cid")
    }
    
    var a, b, c, d, e, f, g, i;
    /*h();
    //v2.0
      $(".go-index").on("tap",function(){
      	window.location.href = "/shoplist/go_shoplist.do?entityId=" + e + "&shopId=" + s;
      });*/
    if (typeof userImg == "string" && userImg != '') {
        a = userImg;
        LS.set("uImg", userImg);
    } else {
        a = LS.get("uImg");
    }
    b = "", a && (b = 'style="background-image:url(' + a + ')"'), c = $("#main-bg"), d = '<div class="asstouch" id="asstouch" isshow="hide" ;><div class="asslist left"><span id="go-index" class="ass-home ass-link"></span><span id="go-cart" class="ass-cart ass-link"></span><span id="go-account" class="ass-center ass-link"></span></div><div class="assbtn"' + b + "></div></div>", c.append(d), i = !1, $("body").bind("touchend", "#go-index", function () {
        //return i === !0 ? !1 : (i = !0, h(), window.location.href = "/shoplist/go_shoplist.do?entityId=" + e + "&shopId=" + f , void 0)
    	h(); window.location.href = "/shoplist/go_shoplist.do?entityId=" + e + "&shopId=" + f + "&time="+ new Date().getTime();
    }), $("body").on("tap", "#go-account", function () {
        return i === !0 ? !1 : (i = !0, h(), window.location.href = "/accountCenter/my.do?entityId=" + e + "&shopId=" + f , void 0)
    }), $("body").on("tap", "#go-cart", function () {
        var a, b, c;
        return i === !0 ? !1 : (i = !0, h(), a = {}, /*i = !0 b = LS.get("aryId"), b = b ? b.split("||") : [], */a.entityId = e, a.shopId = f, a.customerId = g, /*a.goodsIds = b,*/ a = JSON.stringify(a), c = "<form id='myform' style='display: none' action='/shopcart/go_shopcart.do' method='get' enctype='application/x-www-form-urlencoded'><textarea name='datas'>" + a + "</textarea></form>", $("body").append(c), $("#myform").submit(), void 0)
    }), $("body").on("tap", "#asstouch",  function (event) {
        var a = $(this).attr("isshow");
        "hide" === a ? ($(".assbtn").addClass("active"), $(".asslist").show().animate({opacity: 1}, 300), $(this).removeAttr("isshow"),$("body").append('<div id="avatar" style="position:fixed;top:0;left:0;z-index:0;width:100%;height:100%"></div>')) : ($(".assbtn").removeClass("active"), $(".asslist").animate({opacity: 0}, 300, function () {
            $(".asslist").hide(), $("#asstouch").attr("isshow", "hide"),$("#avatar").remove();
            
        }))
        
    }),$("body").on("tap", "#avatar", function () {
        var a = $("#asstouch").attr("isshow");
        "hide" === a ? '' : ($(".assbtn").removeClass("active"), $(".asslist").animate({opacity: 0}, 300, function () {
            $(".asslist").hide(), $("#asstouch").attr("isshow", "hide"),$("#avatar").remove();
        }))
    }), function () {
        function l(a, b) {
            var c = a, d = b;
            !function () {
                var a = setInterval(function () {
                    10 == c ? 0 > d ? (d = 17, k.style.left = d + "px", clearInterval(a)) : (d -= 10, k.style.left = d + "px", c >= d && clearInterval(a)) : d > i ? (d = c, clearInterval(a)) : (d += 17, k.style.left = d + "px", d >= c && clearInterval(a))
                }, 1e3 / 60)
            }()
        }

        function m() {
            g > 10 && h > 5 && (i / 2 > e ? l(10, e) : l(i - 60, e)), g = 0, h = 0
        }

        function n(l) {
            e = a + l.touches[0].clientX - c, f = b + l.touches[0].clientY - d, e >= 0 && i - 60 >= e && (k.style.left = e + "px"), j - 50 >= f && f >= 10 && (k.style.top = f + "px"), i / 2 > e ? $(".asslist").addClass("left") : $(".asslist").removeClass("left"), g = Math.abs(a - l.touches[0].clientX), h = Math.abs(b - l.touches[0].clientY), l.preventDefault()
        }

        function o(e) {
            a = +k.offsetLeft, b = +k.offsetTop, c = e.touches[0].clientX, d = e.touches[0].clientY, e.preventDefault()
        }

        var a, b, c, d, e, f, g, h, i = window.innerWidth, j = window.innerHeight, k = document.getElementById("asstouch");
        k && (k.addEventListener("touchstart", o), k.addEventListener("touchmove", n), k.addEventListener("touchend", m), k.addEventListener("touchcancel", m))
    }()
});
/*asstouch End*/
window.confirms = function (a, b, c, d) {
    var l, m, e = a || "",
        f = b || "",
        g = "function" == typeof c ? c : function () {
        }, h = "function" == typeof d ? d : function () {
        }, i = '<div id="fm-mask" class="fm-mask"><div class="fm-check-bg"><div class="fm-check-confirm"><div class="fm-confirm-title">' + e + "</div>" + '<div class="fm-confirm-opt">' + f + "</div>" + '<div class="fm-confirm-bot">' + '<div class="fm-confirm-cal fm-confirm-btn" id="fm-cancle">取消</div>' + '<div class="fm-confirm-ok fm-confirm-btn" id="fm-ok">确定</div>' + "</div>" + "</div>" + "</div>" + "</div>",
        j = '<style>.confirmcheck{} .fm-mask { display: table; position: fixed; width: 100%; height: 100%; z-index: 10001; background-color: rgba(0, 0, 0, 0.35); top: 0; left: 0; } .fm-check-bg { display: table-cell; vertical-align: middle; } .fm-check-confirm { width: 300px; background-color: #fff; line-height: 50px; border-radius: 5px; margin: 0 auto; } .fm-confirm-title { text-align: center; font-size: 15px; font-weight: 600; line-height: 20px; padding: 12px 0 10px; color: red; } .fm-confirm-opt { font-size: 15px; color: #333; margin: 0 20px 10px; position: relative; line-height: 20px; text-align: center; } .fm-confirm-bot {line-height: 30px; background-color: #d8d8d8; border-radius: 0 0 5px 5px; border-top: 1px solid #d8d8d8; } .fm-confirm-cal {border-right: 1px solid #d8d8d8;border-radius: 0 0 0 5px }#fm-cancle{color:#666666;} .fm-confirm-btn { font-weight: 500;height:50px;cursor:pointer;line-height:50px; width: 149px; float: left; text-align: center; font-size: 15px; background-color: #fff; color: #0072C6; } .fm-confirm-ok { border-radius: 0 0 5px 0; } .fm-confirm-bot:after { display: block; clear: both; content: ""; } </style>',
        k = $("head");
    0 === k.length ? (k = "<head>" + j + "</head>", $("html").append(k)) : (l = $("style").html() || "",
    l.indexOf("confirmcheck") > -1 || k.append(j)), $("body").append(i), m = $("#fm-mask"),
        $("#fm-cancle").bind("click", function (event) {
            m.remove(), g();
            event.preventDefault();
        }), $("#fm-ok").bind("click", function (event) {
        m.remove(), h();
        event.preventDefault();
    });
}, window.alerts = function (a, b,time) {
    /* b || LS.get("shopName") || ""*/
    var h, i, c = "", d = a || "", e = '<div id="at-mask" class="at-mask"><div class="at-check-bg"><div class="at-check-alert"><div class="at-alert-title">' + c + "</div>" + '<div class="at-alert-opt">' + d + "</div>" + '<div class="at-alert-bot">' + '<div class="at-alert-ok at-alert-btn" id="at-ok">确定</div>' + "</div>" + "</div>" + "</div>" + "</div>", f = '<style>.alertcheck{} .at-mask { display: table; position: fixed; width: 100%; height: 100%; z-index: 10001; background-color: rgba(0, 0, 0, 0.5); top: 0; left: 0; } .at-check-bg { display: table-cell; vertical-align: middle; } .at-check-alert { width:300px; background-color: #fff; line-height: 30px; border-radius: 5px; margin: 0 auto; } .at-alert-title { text-align: center; font-size: 15px; font-weight: 600; line-height: 20px; padding: 15px 0 10px; color: #000; } .at-alert-opt { font-size: 15px; color: #333; margin: 0 15px 20px; position: relative; line-height: 25px; text-align: center; } .at-alert-bot {line-height: 30px; background-color: #b2b2b2; border-radius: 0 0 5px 5px; border-top: 1px solid #d8d8d8; } .at-alert-cal { margin-right: 10px; border-radius: 0 0 0 5px; } .at-alert-btn { font-weight: 500;cursor:pointer; height:50px;line-height:50px;width: 300px; float: left; text-align: center; font-size: 15px; background-color: #fff; color: #0072C6; } .at-alert-ok { border-radius: 0 0 5px 5px; font-weight: 600; } .at-alert-bot:after { display: block; clear: both; content: ""; } </style>', g = $("head");
    0 === g.length ? (g = "<head>" + f + "</head>", $("html").append(g)) : (h = $("style").html() || "", h.indexOf("alertcheck") > -1 || g.append(f)), $("body").append(e), i = $("#at-mask"), $("#at-ok").click(function (event) {
        i.remove();
        event.stopPropagation();
    })
}, window.alertw = function (a, url) {
    /* b || LS.get("shopName") || ""*/
    var h, i, c = "", d = a || "", e = '<div id="at-mask" class="at-mask"><div class="at-check-bg"><div class="at-check-alert"><div class="at-alert-title">' + c + "</div>" + '<div class="at-alert-opt">' + d + "</div>" + '<div class="at-alert-bot">' + '<div class="at-alert-ok at-alert-btn" id="at-ok">确定</div>' + "</div>" + "</div>" + "</div>" + "</div>", f = '<style>.alertcheck{} .at-mask { display: table; position: fixed; width: 100%; height: 100%; z-index: 10001; background-color: rgba(0, 0, 0, 0.5); top: 0; left: 0; } .at-check-bg { display: table-cell; vertical-align: middle; } .at-check-alert { width: 300px; background-color: #fff; line-height: 30px; border-radius: 5px; margin: 0 auto; } .at-alert-title { text-align: center; font-size: 15px; font-weight: 600; line-height: 20px; padding: 15px 0 10px; color: #000; } .at-alert-opt { font-size: 15px; color: #333; margin: 0 15px 20px; position: relative; line-height: 25px; text-align: center; } .at-alert-bot {line-height: 30px; background-color: #b2b2b2; border-radius: 0 0 5px 5px; border-top: 1px solid #d8d8d8; } .at-alert-cal { margin-right: 10px; border-radius: 0 0 0 5px; } .at-alert-btn { font-weight: 500; cursor:pointer;height:50px;line-height:50px;width: 300px; float: left; text-align: center; font-size: 15px; background-color: #fff; color: #0072C6; } .at-alert-ok { border-radius: 0 0 5px 5px; font-weight: 600; } .at-alert-bot:after { display: block; clear: both; content: ""; } </style>', g = $("head");
    0 === g.length ? (g = "<head>" + f + "</head>", $("html").append(g)) : (h = $("style").html() || "", h.indexOf("alertcheck") > -1 || g.append(f)), $("body").append(e), i = $("#at-mask"), $("#at-ok").click(function () {
        i.remove();
        if(url){
            window.location.href=url;
        }else{
            location.reload();
        }
    })
};
function objAryToString(ary) {
    var Len = ary.length;
    if (Len === 0) {
        return [];
    } else if (Len === 1) {
        return [JSON.stringify(ary[0])];
    } else {
        var temAry = [];
        for (var i = 0; i < Len; i++) {
            temAry[i] = JSON.stringify(ary[i]);
        }
        return temAry;
    }
}
function fixed2(pnumber) {
    // alert(11);
    // alert(pnumber);
    if (isNaN(pnumber)) {
        return 0;
    }
    if (pnumber == '') {
        return 0;
    }
    var whole = String(pnumber).split('.')[0];
    var snum = String(pnumber * 1000);
    var sec = snum.split('.');
    var wholeStr = sec[0];
    var result = '';
    var firstDes = '0';
    var secondDes = '0';
    var thirdDes = '0';

    if (wholeStr.length - 2 > 0) {
        firstDes = wholeStr.substring(wholeStr.length - 3, wholeStr.length - 2);
    }

    if (wholeStr.length - 1 > 0) {
        secondDes = wholeStr.substring(wholeStr.length - 2, wholeStr.length - 1);
    }

    if (wholeStr.length > 0) {
        thirdDes = wholeStr.substring(wholeStr.length - 1, wholeStr.length);
    }

    firstDes = parseInt(firstDes);
    secondDes = parseInt(secondDes);
    thirdDes = parseInt(thirdDes);
    if (thirdDes > 4) {
        secondDes += 1;
        if (secondDes >= 10) {
            secondDes = secondDes - 10;
            firstDes += 1;
            if (firstDes >= 10) {
                whole = String(parseInt(whole) + 1);
            }
        }
    }
    if (firstDes == 0 && secondDes == 0) {
        result = whole + ".00";
    } else {
        result = whole + "." + String(firstDes) + String(secondDes);
    }
    return result;
}
/**
 * 简单封装ajax函数
 * @param array\obiect datas 提交参数
 * @param string url 跳转url
 * @param string su_msg 成功提示语
 * @param string err_msg error提示语
 * @param string method 提交方式
 */
	function ajax(datas, url, su_msg, err_msg, method){
		type=method?method : 'post';
		$.ajax({
            type: type,
            data: {datas : datas},
            dataType: "json",
            url: url,
            success: function (data) {
           	 if(data.status==1){
           		 alerts(su_msg);
           	 }else{
           		 alerts(data.msg);
           	 }
            },error : function(){
            	 alerts(err_msg);
            }
        });
	}
	
	
	//验证手机号 验证13*、145、147、15*（不包括153、154）、18*、170号段
	function isMobile(a)
	{
		var reg =/1((3\d)|(4[57])|(5[01256789])|(8\d)|(70))\d{8}/;
		return reg.test(a);
	}
	//数字正则验证 
	function isNum(a)
	{
		var reg =/^[0-9]\d*$/;
		return reg.test(a);
	}
	//tips
	var tips = function (a, time) {
	    var h, i, c = "", d = a || "", e = '<div id="at-mask" class="at-mask"><div class="pdiv"><div class="at-alert-opt2">' + d + "</div>" +  "</div>" +  "</div>", f = '<style>.pdiv{margin:0 auto;margin-top:70%;text-align: center;} .at-mask { display: block; position: fixed; width: 100%; height: 100%; z-index: 10001; top: 0; left: 0; } .at-alert-opt2 {padding: 10px;background-color: rgba(0, 0, 0, 0.5); font-size: 0.4rem; color: #fff; margin: 0 auto;width: auto; max-width:280px; display:inline-block; text-align: center; } </style>', g = $("head");
	    0 === g.length ? (g = "<head>" + f + "</head>", $("html").append(g)) : (h = $("style").html() || "", h.indexOf("alertcheck") > -1 || g.append(f)), $("body").append(e), i = $("#at-mask"),i.on("tap",function(){
	    	i.remove();
	    });
	    setTimeout(tiph, 1000*parseInt(time));
	}
	function tiph() {
		$("#at-mask").remove();
	}
	//H5 pushState
	function pushHistory(title,hash) {
		  var state = {
		    title: title,
		    url: "#"
		  };
		  window.history.pushState(state, title, "#" +hash);
		}
/*通用方法End*/
