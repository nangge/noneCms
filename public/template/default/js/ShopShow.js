// JavaScript Document

//单击图片列表
function showPic(num)
{
	//将所有的li样式赋值为空
	var objUl=FulS();
	for(var i=0;i<objUl.length;i++)
	{
		objUl[i].className="";
	}
	
	//对单击的进行样式应用
	FliS(num).className="tsSelectImg";
		
	//得到单击后的图片值
	var src=Fpic(num).getAttribute("tsImgS");
	
	//进行赋值
	var Objimg=FimgS();
	
	Objimg.src=Fpic(num).src;
	
	
	document.getElementById("tsImgS").getElementsByTagName("a")[0].href=src;
	
	//图片等比例
	tsScrollResize();

	//设置导航
	tsScrollDh(num);
	
	
	//滚动图片定位
	FulSs().style.marginLeft="-"+(tsNum()*tsRowNum()*FliS(0).offsetWidth)+"px";

	
}
//上一页
function tsScrollArrLeft()
{
	if(tsNum()+1>1)
	{
		//设置导航
		tsScrollDh((tsNum()-1)*tsRowNum());
		
		//滚动图片定位
		FulSs().style.marginLeft="-"+(tsNum())*tsRowNum()*FliS(0).offsetWidth+"px";
	
	}
}

//下一页
function tsScrollArrRight()
{
	if(tsNum()+2<=tsRowCount())
	{
		//设置导航
		tsScrollDh((tsNum()+1)*tsRowNum());
		//滚动图片定位
		FulSs().style.marginLeft="-"+(tsNum())*tsRowNum()*FliS(0).offsetWidth+"px";
		
	}
}



//设置导航,如果不对上面的Img进行操作,那么imgno就要有参数进来
function tsScrollDh(i)
{
	//设置上一页导航
	document.getElementById("tsImgSArrL").setAttribute("showPicNum",i);
	
	//设置下一页导航
	document.getElementById("tsImgSArrR").setAttribute("showPicNum",i);
	
}


function tsScrollResize()
{
   var maxWidth=300;
   var maxHeight=300;
	
   var myimg = FimgS();

	var imgNew = new Image();
	imgNew.src = myimg.src;
	
	//将myimg存起来，相当于一个参数，不然异步的时候执行太快，一直是最后一张图
	imgNew.preImg=myimg;
				
			
	//这个是为了防遨游等浏览器，图片宽、高加为0执行
	if (imgNew.width == 0 || imgNew.height == 0) {
			imgNew.onload=function(){
				tsScrollResizeHd(this,maxWidth,maxHeight,this.preImg);
			};
	}
	else
	{
		tsScrollResizeHd(imgNew,maxWidth,maxHeight,myimg);
	}
	
}

function tsScrollResizeHd(imgNew,maxWidth,maxHeight,myimg)
{
	var hRatio;
	var wRatio;
	var Ratio = 1;
	var w = imgNew.width;
	var h = imgNew.height;
	wRatio = maxWidth / w;
	hRatio = maxHeight / h;
	if (maxWidth == 0 && maxHeight == 0) {
		Ratio = 1;
	} else if (maxWidth == 0) {
		if (hRatio < 1) Ratio = hRatio;
	} else if (maxHeight == 0) {
		if (wRatio < 1) Ratio = wRatio;
	} else if (wRatio < 1 || hRatio < 1) {
		Ratio = (wRatio <= hRatio ? wRatio: hRatio);
	}
	if (Ratio < 1) {
		
		w = w * Ratio;
		h = h * Ratio;
	}
	
	if(h%2!=0)
	{
		h=h-1;
	}
	
	myimg.height = h;
	myimg.width = w;
	
	
	var tsImgsBox=document.getElementById("tsImgS");
	if(myimg.height<300)
	{
		var TopBottom=(300-myimg.height)/2;
		tsImgsBox.style.paddingTop=TopBottom+"px";
		tsImgsBox.style.paddingBottom=TopBottom+"px";
	}
	else
	{
		tsImgsBox.style.paddingTop="0px";
		tsImgsBox.style.paddingBottom="0px";
	}
}

//一行显示几个
function tsRowNum()
{
	return document.getElementById("tsImgSCon").offsetWidth/FliS(0).offsetWidth;
}

//第几行 从0开始
function tsNum()
{
	return Math.floor(document.getElementById("tsImgSArrL").getAttribute("showPicNum")/tsRowNum());
}
//共几行
function tsRowCount()
{
	return Math.ceil(FulS().length/tsRowNum());
}

//返回图片对象
function Fpic(i)
{
	var tsImgSCon=document.getElementById("tsImgSCon").getElementsByTagName("li");
	return src=tsImgSCon.item(i).getElementsByTagName("img")[0];
}
//返回li对象
function FliS(i)
{
	return document.getElementById("tsImgSCon").getElementsByTagName("li")[i];
}

//返回图片列表对象
function FulS()
{
	return document.getElementById("tsImgSCon").getElementsByTagName("li");
}
//查找最大的图
function FimgS(){
	return document.getElementById("tsImgS").getElementsByTagName("img")[0];
}
//查找Ul对象
function FulSs()
{
	return document.getElementById("tsImgSCon").getElementsByTagName("ul")[0];
}
	
//图片集外面的DIV宽
document.getElementById("tsImgSCon").style.width=FliS(0).offsetWidth*4+"px";
	
//Ul宽
FulSs().style.width=FliS(0).offsetWidth*FulS().length+"px";

//图片等比例
tsScrollResize();