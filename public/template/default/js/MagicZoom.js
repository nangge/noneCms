var MagicZoom_ua = 'msie';
var W = navigator.userAgent.toLowerCase();
if (W.indexOf("opera") != -1) {
    MagicZoom_ua = 'opera'
} else if (W.indexOf("msie") != -1) {
    MagicZoom_ua = 'msie'
} else if (W.indexOf("safari") != -1) {
    MagicZoom_ua = 'safari'
} else if (W.indexOf("mozilla") != -1) {
    MagicZoom_ua = 'gecko'
}
var MagicZoom_zooms = new Array();
function _el(id) {
    return document.getElementById(id)
};
function MagicZoom_getBounds(e) {
    if (e.getBoundingClientRect) {
        var r = e.getBoundingClientRect();
        var wx = 0;
        var wy = 0;
        if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
            wy = document.body.scrollTop;
            wx = document.body.scrollLeft
        } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
            wy = document.documentElement.scrollTop;
            wx = document.documentElement.scrollLeft
        }
        return {
            'left': r.left + wx,
            'top': r.top + wy,
            'right': r.right + wx,
            'bottom': r.bottom + wy
        }
    }
}
function MagicZoom_getEventBounds(e) {
    var x = 0;
    var y = 0;
    if (MagicZoom_ua == 'msie') {
        y = e.clientY;
        x = e.clientX;
        if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
            y = e.clientY + document.body.scrollTop;
            x = e.clientX + document.body.scrollLeft
        } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
            y = e.clientY + document.documentElement.scrollTop;
            x = e.clientX + document.documentElement.scrollLeft
        }
    } else {
        y = e.clientY;
        x = e.clientX;
        y += window.pageYOffset;
        x += window.pageXOffset
    }
    return {
        'x': x,
        'y': y
    }
}
function MagicView_ia() {
    return false
};
var MagicZoom_extendElement = function() {
    var args = arguments;
    if (!args[1]) args = [this, args[0]];
    for (var property in args[1]) args[0][property] = args[1][property];
    return args[0]
};
function MagicZoom_addEventListener(obj, event, listener) {
    if (MagicZoom_ua == 'gecko' || MagicZoom_ua == 'opera' || MagicZoom_ua == 'safari') {
        try {
            obj.addEventListener(event, listener, false)
        } catch(e) {
            alert("MagicZoom error: " + e + ", event=" + event)
        }
    } else if (MagicZoom_ua == 'msie') {
        obj.attachEvent("on" + event, listener)
    }
};
function MagicZoom_removeEventListener(obj, event, listener) {
    if (MagicZoom_ua == 'gecko' || MagicZoom_ua == 'opera' || MagicZoom_ua == 'safari') {
        obj.removeEventListener(event, listener, false)
    } else if (MagicZoom_ua == 'msie') {
        obj.detachEvent("on" + event, listener)
    }
};
function MagicZoom_concat() {
    var result = [];
    for (var i = 0; i < arguments.length; i++) for (var j = 0; j < arguments[i].length; j++) result.push(arguments[i][j]);
    return result
};
function MagicZoom_withoutFirst(sequence, skip) {
    result = [];
    for (var i = skip; i < sequence.length; i++) result.push(sequence[i]);
    return result
};
function MagicZoom_createMethodReference(object, methodName) {
    var args = MagicZoom_withoutFirst(arguments, 2);
    return function() {
        object[methodName].apply(object, MagicZoom_concat(arguments, args))
    }
};
function MagicZoom_stopEventPropagation(e) {
    if (MagicZoom_ua == 'gecko' || MagicZoom_ua == 'safari' || MagicZoom_ua == 'opera') {
        e.cancelBubble = true;
        e.preventDefault();
        e.stopPropagation()
    } else if (MagicZoom_ua == 'msie') {
        window.event.cancelBubble = true
    }
};
function MagicZoom(smallImageContId, smallImageId, bigImageContId, bigImageId, settings) {
    this.recalculating = false;
    this.smallImageCont = _el(smallImageContId);
    this.smallImage = _el(smallImageId);
    this.bigImageCont = _el(bigImageContId);
    this.bigImage = _el(bigImageId);
    this.pup = 0;
    this.settings = settings;
    if (!this.settings["header"]) {
        this.settings["header"] = ""
    }
    this.bigImageSizeX = 0;
    this.bigImageSizeY = 0;
    this.smallImageSizeX = 0;
    this.smallImageSizeY = 0;
    this.popupSizeX = 20;
    this.popupSizey = 20;
    this.positionX = 0;
    this.positionY = 0;
    this.bigImageContStyleLeft = '';
    this.loadingCont = null;
    if (this.settings["loadingImg"] != '') {
        this.loadingCont = document.createElement('DIV');
        this.loadingCont.style.position = 'absolute';
        this.loadingCont.style.visibility = 'hidden';
        this.loadingCont.className = 'MagicZoomLoading';
        this.loadingCont.style.display = 'block';
        this.loadingCont.style.textAlign = 'center';
        this.loadingCont.innerHTML = this.settings["loadingText"] + '<br/><img border="0" alt="' + this.settings["loadingText"] + '" src="' + this.settings["loadingImg"] + '"/>';
        this.smallImageCont.appendChild(this.loadingCont)
    }
    this.baseuri = '';
    this.safariOnLoadStarted = false;
    MagicZoom_zooms.push(this);
    this.checkcoords_ref = MagicZoom_createMethodReference(this, "checkcoords")
};
MagicZoom.prototype.stopZoom = function() {
    MagicZoom_removeEventListener(window.document, "mousemove", this.checkcoords_ref);
    if (this.settings["position"] == "custom") {
        _el(this.smallImageCont.id + "-big").removeChild(this.bigImageCont)
    }
};
MagicZoom.prototype.checkcoords = function(e) {
    var y = 0;
    var x = 0;
    r = MagicZoom_getEventBounds(e);
    x = r['x'];
    y = r['y'];
    var smallY = 0;
    var smallX = 0;
    var tag = this.smallImage;
    while (tag && tag.tagName != "BODY" && tag.tagName != "HTML") {
        smallY += tag.offsetTop;
        smallX += tag.offsetLeft;
        tag = tag.offsetParent
    }
    if (MagicZoom_ua == 'msie') {
        r = MagicZoom_getBounds(this.smallImage);
        smallX = r['left'];
        smallY = r['top']
    }
    if (x > parseInt(smallX + this.smallImageSizeX)) {
        this.hiderect();
        return false
    }
    if (x < parseInt(smallX)) {
        this.hiderect();
        return false
    }
    if (y > parseInt(smallY + this.smallImageSizeY)) {
        this.hiderect();
        return false
    }
    if (y < parseInt(smallY)) {
        this.hiderect();
        return false
    }
    if (MagicZoom_ua == 'msie') {
        this.smallImageCont.style.zIndex = 1
    }
    return true
};
MagicZoom.prototype.mousedown = function(e) {
    MagicZoom_stopEventPropagation(e);
    this.smallImageCont.style.cursor = 'move'
};
MagicZoom.prototype.mouseup = function(e) {
    MagicZoom_stopEventPropagation(e);
    this.smallImageCont.style.cursor = 'default'
};
MagicZoom.prototype.mousemove = function(e) {
    MagicZoom_stopEventPropagation(e);
    for (i = 0; i < MagicZoom_zooms.length; i++) {
        if (MagicZoom_zooms[i] != this) {
            MagicZoom_zooms[i].checkcoords(e)
        }
    }
    if (this.settings && this.settings["drag_mode"] == true) {
        if (this.smallImageCont.style.cursor != 'move') {
            return
        }
    }
    if (this.recalculating) {
        return
    }
    if (!this.checkcoords(e)) {
        return
    }
    this.recalculating = true;
    var smallImg = this.smallImage;
    var smallX = 0;
    var smallY = 0;
    if (MagicZoom_ua == 'gecko' || MagicZoom_ua == 'opera' || MagicZoom_ua == 'safari') {
        var tag = smallImg;
        while (tag.tagName != "BODY" && tag.tagName != "HTML") {
            smallY += tag.offsetTop;
            smallX += tag.offsetLeft;
            tag = tag.offsetParent
        }
    } else {
        r = MagicZoom_getBounds(this.smallImage);
        smallX = r['left'];
        smallY = r['top']
    }
    r = MagicZoom_getEventBounds(e);
    x = r['x'];
    y = r['y'];
    this.positionX = x - smallX;
    this.positionY = y - smallY;
    if ((this.positionX + this.popupSizeX / 2) >= this.smallImageSizeX) {
        this.positionX = this.smallImageSizeX - this.popupSizeX / 2
    }
    if ((this.positionY + this.popupSizeY / 2) >= this.smallImageSizeY) {
        this.positionY = this.smallImageSizeY - this.popupSizeY / 2
    }
    if ((this.positionX - this.popupSizeX / 2) <= 0) {
        this.positionX = this.popupSizeX / 2
    }
    if ((this.positionY - this.popupSizeY / 2) <= 0) {
        this.positionY = this.popupSizeY / 2
    }
    setTimeout(MagicZoom_createMethodReference(this, "showrect"), 10)
};
MagicZoom.prototype.showrect = function() {
    this.pup.style.left = (this.positionX - this.popupSizeX / 2) + 'px';
    this.pup.style.top = (this.positionY - this.popupSizeY / 2) + 'px';
    this.pup.style.visibility = "visible";
    perX = parseInt(this.pup.style.left) * (this.bigImageSizeX / this.smallImageSizeX);
    perY = parseInt(this.pup.style.top) * (this.bigImageSizeY / this.smallImageSizeY);
    this.bigImage.style.left = ( - perX) + 'px';
    this.bigImage.style.top = ( - perY) + 'px';
    this.bigImageCont.style.display = 'block';
    this.bigImageCont.style.visibility = 'visible';
    this.bigImage.style.display = 'block';
    this.bigImage.style.visibility = 'visible';
    this.recalculating = false;
    this.bigImageCont.style.left = this.bigImageContStyleLeft
};
MagicZoom.prototype.hiderect = function() {
    if (this.settings && this.settings["bigImage_always_visible"] == true) return;
    if (this.pup) {
        this.pup.style.visibility = "hidden"
    }
    this.bigImageCont.style.left = '-10000px';
    this.bigImageCont.style.visibility = 'hidden';
    if (MagicZoom_ua == 'msie') {
        this.smallImageCont.style.zIndex = 0
    }
};
MagicZoom.prototype.recalculatePopupDimensions = function() {
    this.popupSizeX = (parseInt(this.bigImageCont.style.width) - 0) / (this.bigImageSizeX / this.smallImageSizeX);
    if (this.settings && this.settings["header"] != "") {
        this.popupSizeY = (parseInt(this.bigImageCont.style.height) - 0 - 0) / (this.bigImageSizeY / this.smallImageSizeY)
    } else {
        this.popupSizeY = (parseInt(this.bigImageCont.style.height) - 0) / (this.bigImageSizeY / this.smallImageSizeY)
    }
    if (this.popupSizeX > this.smallImageSizeX) {
        this.popupSizeX = this.smallImageSizeX
    }
    if (this.popupSizeY > this.smallImageSizeY) {
        this.popupSizeY = this.smallImageSizeY
    }
    this.pup.style.width = this.popupSizeX + 'px';
    this.pup.style.height = this.popupSizeY + 'px'
};
MagicZoom.prototype.initPopup = function() {
    this.pup = document.createElement("DIV");
    this.pup.className = 'MagicZoomPup';
    this.pup.style.zIndex = 10;
    this.pup.style.visibility = 'hidden';
    this.pup.style.position = 'absolute';
    this.pup.style["opacity"] = parseFloat(this.settings['opacity'] / 100.0);
    this.pup.style["-moz-opacity"] = parseFloat(this.settings['opacity'] / 100.0);
    this.pup.style["-html-opacity"] = parseFloat(this.settings['opacity'] / 100.0);
    this.pup.style["filter"] = "alpha(Opacity=" + this.settings['opacity'] + ")";
    this.recalculatePopupDimensions();
    this.smallImageCont.appendChild(this.pup);
    this.smallImageCont.unselectable = "on";
    this.smallImageCont.style.MozUserSelect = "none";
    this.smallImageCont.onselectstart = MagicView_ia;
    this.smallImageCont.oncontextmenu = MagicView_ia
};
MagicZoom.prototype.initBigContainer = function() {
    var bigimgsrc = this.bigImage.src;
    while (this.bigImageCont.firstChild) {
        this.bigImageCont.removeChild(this.bigImageCont.firstChild)
    }
    if (MagicZoom_ua == 'msie') {
        var f = document.createElement("IFRAME");
        f.style.left = '0px';
        f.style.top = '0px';
        f.style.position = 'absolute';
        f.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(style=0,opacity=0)';
        f.style.width = this.bigImageCont.style.width;
        f.style.height = this.bigImageCont.style.height;
        f.frameBorder = 0;
        this.bigImageCont.appendChild(f)
    }
    var ar1 = document.createElement("DIV");
    ar1.style.overflow = "hidden";
    this.bigImageCont.appendChild(ar1);
    this.bigImage = document.createElement("IMG");
    this.bigImage.src = bigimgsrc;
    this.bigImage.style.position = 'relative';
    ar1.appendChild(this.bigImage)
};
MagicZoom.prototype.initZoom = function() {
    if (this.loadingCont != null && !this.bigImage.complete && this.smallImage.width != 0 && this.smallImage.height != 0) {
        this.loadingCont.style.left = (parseInt(this.smallImage.width) / 2 - parseInt(this.loadingCont.offsetWidth) / 2) + 'px';
        this.loadingCont.style.top = (parseInt(this.smallImage.height) / 2 - parseInt(this.loadingCont.offsetHeight) / 2) + 'px';
        this.loadingCont.style.visibility = 'visible'
    }
    if (MagicZoom_ua == 'safari') {
        if (!this.safariOnLoadStarted) {
            MagicZoom_addEventListener(this.bigImage, "load", MagicZoom_createMethodReference(this, "initZoom"));
            this.safariOnLoadStarted = true;
            return
        }
    } else {
        if (!this.bigImage.complete || !this.smallImage.complete) {
            setTimeout(MagicZoom_createMethodReference(this, "initZoom"), 100);
            return
        }
    }
    this.bigImageSizeX = this.bigImage.width;
    this.bigImageSizeY = this.bigImage.height;
    this.smallImageSizeX = this.smallImage.width;
    this.smallImageSizeY = this.smallImage.height;
    if (this.bigImageSizeX == 0 || this.bigImageSizeY == 0 || this.smallImageSizeX == 0 || this.smallImageSizeY == 0) {
        setTimeout(MagicZoom_createMethodReference(this, "initZoom"), 100);
        return
    }
    if (this.loadingCont != null) this.loadingCont.style.visibility = 'hidden';
    this.smallImageCont.style.width = this.smallImage.width + 'px';
    this.bigImageCont.style.left = this.smallImage.width + 15 + 'px';
    this.bigImageCont.style.top = '0px';
    switch (this.settings['position']) {
    case 'left':
        this.bigImageCont.style.left = '-' + (15 + parseInt(this.bigImageCont.style.width)) + 'px';
        break;
    case 'bottom':
        this.bigImageCont.style.top = this.smallImage.height + 15 + 'px';
        this.bigImageCont.style.left = '0px';
        break;
    case 'top':
        this.bigImageCont.style.top = '-' + (15 + parseInt(this.bigImageCont.style.height)) + 'px';
        this.bigImageCont.style.left = '0px';
        break;
    case 'custom':
        this.bigImageCont.style.left = '0px';
        this.bigImageCont.style.top = '0px';
        break;
    case 'inner':
        this.bigImageCont.style.left = '0px';
        this.bigImageCont.style.top = '0px';
        break
    }
    this.bigImageContStyleLeft = this.bigImageCont.style.left;
    if (this.pup) {
        this.recalculatePopupDimensions();
        return
    }
    this.initBigContainer();
    this.initPopup();
    MagicZoom_addEventListener(window.document, "mousemove", this.checkcoords_ref);
    MagicZoom_addEventListener(this.smallImageCont, "mousemove", MagicZoom_createMethodReference(this, "mousemove"));
    if (this.settings && this.settings["drag_mode"] == true) {
        MagicZoom_addEventListener(this.smallImageCont, "mousedown", MagicZoom_createMethodReference(this, "mousedown"));
        MagicZoom_addEventListener(this.smallImageCont, "mouseup", MagicZoom_createMethodReference(this, "mouseup"));
        this.positionX = this.smallImageSizeX / 2;
        this.positionY = this.smallImageSizeY / 2;
        this.showrect()
    }
};
MagicZoom.prototype.replaceZoom = function(e, ael) {
    if (ael.href == this.bigImage.src) return;
    var newBigImage = document.createElement("IMG");
    newBigImage.id = this.bigImage.id;
    newBigImage.src = ael.getElementsByTagName("img")[0].getAttribute("tsImgS");
    var p = this.bigImage.parentNode;
    p.replaceChild(newBigImage, this.bigImage);
    this.bigImage = newBigImage;
    this.bigImage.style.position = 'relative';
    this.smallImage.src = ael.getElementsByTagName("img")[0].src;
    this.safariOnLoadStarted = false;
    this.initZoom()
};
function MagicZoom_findSelectors(id, zoom) {
    var aels = window.document.getElementsByTagName("li");
    for (var i = 0; i < aels.length; i++) {
        if (aels[i].getAttribute("rel") == id) {
            MagicZoom_addEventListener(aels[i], "click",
            function(event) {
                if (MagicZoom_ua != 'msie') {
                    this.blur()
                } else {
                    window.focus()
                }
                MagicZoom_stopEventPropagation(event);
                return false
            });
            MagicZoom_addEventListener(aels[i], zoom.settings['thumb_change'], MagicZoom_createMethodReference(zoom, "replaceZoom", aels[i]));
            aels[i].style.outline = '0';
            aels[i].mzextend = MagicZoom_extendElement;
            aels[i].mzextend({
                zoom: zoom,
                selectThisZoom: function() {
                    this.zoom.replaceZoom(null, this)
                }
            })
        }
    }
};
function MagicZoom_stopZooms() {};
function MagicZoom_findZooms() {
    var loadingText = 'Loading Zoom';
    var loadingImg = '';
    var iels = window.document.getElementsByTagName("IMG");
    for (var i = 0; i < iels.length; i++) {
        if (/MagicZoomLoading/.test(iels[i].className)) {
            if (iels[i].alt != '') loadingText = iels[i].alt;
            loadingImg = iels[i].src;
            break
        }
    }
    var aels = window.document.getElementsByTagName("A");
    for (var i = 0; i < aels.length; i++) {
        if (/MagicZoom/.test(aels[i].className)) {
            while (aels[i].firstChild) {
                if (aels[i].firstChild.tagName != 'IMG') {
                    aels[i].removeChild(aels[i].firstChild)
                } else {
                    break
                }
            }
            if (aels[i].firstChild.tagName != 'IMG') throw "Invalid MagicZoom invocation!";
            var rand = Math.round(Math.random() * 1000000);
            aels[i].style.position = "relative";
            aels[i].style.display = 'block';
            aels[i].style.outline = '0';
            aels[i].style.textDecoration = 'none';
            MagicZoom_addEventListener(aels[i], "click",
            function(event) {
                if (MagicZoom_ua != 'msie') {
                    this.blur()
                } else {
                    window.focus()
                }
                MagicZoom_stopEventPropagation(event);
                return false
            });
            if (aels[i].id == '') {
                aels[i].id = "sc" + rand
            }
            if (MagicZoom_ua == 'msie') {
                aels[i].style.zIndex = 0
            }
            var smallImg = aels[i].firstChild;
            smallImg.id = "sim" + rand;
            var bigCont = document.createElement("DIV");
            bigCont.id = "bc" + rand;
            re = new RegExp(/opacity(\s+)?:(\s+)?(\d+)/i);
            matches = re.exec(aels[i].rel);
            var opacity = 50;
            if (matches) {
                opacity = parseInt(matches[3])
            }
            re = new RegExp(/thumb\-change(\s+)?:(\s+)?(click|mouseover)/i);
            matches = re.exec(aels[i].rel);
            var thumb_change = 'click';
            if (matches) {
                thumb_change = matches[3]
            }
            re = new RegExp(/zoom\-width(\s+)?:(\s+)?(\w+)/i);
            matches = re.exec(aels[i].rel);
            bigCont.style.width = '300px';
            if (matches) {
                bigCont.style.width = matches[3]
            }
            re = new RegExp(/zoom\-height(\s+)?:(\s+)?(\w+)/i);
            matches = re.exec(aels[i].rel);
            bigCont.style.height = '297px';
            if (matches) {
                bigCont.style.height = matches[3]
            }
            re = new RegExp(/zoom\-position(\s+)?:(\s+)?(\w+)/i);
            matches = re.exec(aels[i].rel);
            bigCont.style.left = aels[i].firstChild.width + 15 + 'px';
            bigCont.style.top = '0px';
            var position = 'right';
            if (matches) {
                switch (matches[3]) {
                case 'left':
                    position = 'left';
                    break;
                case 'bottom':
                    position = 'bottom';
                    break;
                case 'top':
                    position = 'top';
                    break;
                case 'custom':
                    position = 'custom';
                    break;
                case 'inner':
                    position = 'inner';
                    break
                }
            }
            re = new RegExp(/drag\-mode(\s+)?:(\s+)?(true|false)/i);
            matches = re.exec(aels[i].rel);
            var drag_mode = false;
            if (matches) {
                if (matches[3] == 'true') drag_mode = true
            }
            re = new RegExp(/always\-show\-zoom(\s+)?:(\s+)?(true|false)/i);
            matches = re.exec(aels[i].rel);
            var bigImage_always_visible = false;
            if (matches) {
                if (matches[3] == 'true') bigImage_always_visible = true
            }
            bigCont.style.overflow = 'hidden';
            bigCont.className = "MagicZoomBigImageCont";
            bigCont.style.zIndex = 100;
            bigCont.style.visibility = 'hidden';
            if (position != 'custom') {
                bigCont.style.position = 'absolute'
            } else {
                bigCont.style.position = 'relative'
            }
            var bigImg = document.createElement("IMG");
            bigImg.id = "bim" + rand;
            bigImg.src = aels[i].href;
            bigCont.appendChild(bigImg);
            if (position != 'custom') {
                aels[i].appendChild(bigCont)
            } else {
                _el(aels[i].id + '-big').appendChild(bigCont)
            }
            var settings = {
                bigImage_always_visible: bigImage_always_visible,
                drag_mode: drag_mode,
                header: aels[i].title,
                opacity: opacity,
                thumb_change: thumb_change,
                position: position,
                loadingText: loadingText,
                loadingImg: loadingImg
            };
            var zoom = new MagicZoom(aels[i].id, 'sim' + rand, bigCont.id, 'bim' + rand, settings);
            aels[i].mzextend = MagicZoom_extendElement;
            aels[i].mzextend({
                zoom: zoom
            });
            zoom.initZoom();
            MagicZoom_findSelectors(aels[i].id, zoom)
        }
    }
};
if (MagicZoom_ua == 'msie') try {
    document.execCommand("BackgroundImageCache", false, true)
} catch(e) {};
MagicZoom_addEventListener(window, "load", MagicZoom_findZooms);