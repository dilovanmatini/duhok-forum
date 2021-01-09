/**
 * 
 * Duhok Forum 3.0
 * @author		Dilovan Matini (original founder)
 * @copyright	2007 - 2021 Dilovan Matini
 * @see			df.lelav.com
 * @see			https://github.com/dilovanmatini/duhok-forum
 * @license		http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note		This program is distributed in the hope that it will be useful - WITHOUT ANY WARRANTY;
 * 
 */
if(!DF) DF={};
DF.share={
	list:new Array('scriptandstyle','blinklist','delicious','digg','diigo','reddit','yahoobuzz','stumbleupon','technorati','mixx','myspace','designfloat','facebook','twitter','twittley','linkedin','newsvine','devmarks','misterwong','friendfeed','blogmarks','yahoo','livefavorites','pixelgroovy','simpy','propeller','yigg','linkarena','hatena'),
	urlList:{
		scriptandstyle:'http://scriptandstyle.com/submit?url=PERMALINK&amp;title=TITLE',
		blinklist:'http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Url=PERMALINK&amp;Title=TITLE',
		delicious:'http://del.icio.us/post?url=PERMALINK&amp;title=TITLE;notes=DESC',
		digg:'http://digg.com/submit?phase=2&amp;url=PERMALINK&amp;title=TITLE&amp;bodytext=DESC',
		diigo:'http://www.diigo.com/post?url=PERMALINK&amp;title=TITLE&amp;desc=DESC',
		reddit:'http://reddit.com/submit?url=PERMALINK&amp;title=TITLE',
		yahoobuzz:'http://buzz.yahoo.com/submit/?submitUrl=PERMALINK&amp;submitHeadline=TITLE&amp;submitSummary=DESC&amp;submitCategory=&amp;submitAssetType=',
		stumbleupon:'http://www.stumbleupon.com/submit?url=PERMALINK&amp;title=TITLE',
		technorati:'http://technorati.com/faves?add=PERMALINK',
		mixx:'http://www.mixx.com/submit?page_url=PERMALINK&amp;title=TITLE',
		myspace:'http://www.myspace.com/Modules/PostTo/Pages/?u=PERMALINK&amp;t=TITLE',
		designfloat:'http://www.designfloat.com/submit.php?url=PERMALINK&amp;title=TITLE',
		facebook:'http://www.facebook.com/share.php?u=PERMALINK&amp;t=TITLE',
		twitter:'http://www.twitter.com/home?status=TWITTER_TEXT',
		twittley:'http://twittley.com/submit/?title=TITLE&url=PERMALINK&desc=DESC&pcat=&tags=',
		linkedin:'http://www.linkedin.com/shareArticle?mini=true&amp;url=PERMALINK&amp;title=TITLE&amp;summary=DESC&amp;source=SITE_NAME',
		newsvine:'http://www.newsvine.com/_tools/seed&amp;save?u=PERMALINK&amp;h=TITLE',
		devmarks:'http://devmarks.com/index.php?posttext=DESC&amp;posturl=PERMALINK&amp;posttitle=TITLE',
		misterwong:'http://www.mister-wong.com/addurl/?bm_url=PERMALINK&amp;bm_description=TITLE&amp;plugin=',
		friendfeed:'http://www.friendfeed.com/share?title=TITLE&amp;link=PERMALINK',
		blogmarks:'http://blogmarks.net/my/new.php?mini=1&amp;simple=1&amp;url=PERMALINK&amp;title=TITLE',
		yahoo:'http://myweb2.search.yahoo.com/myresults/bookmarklet?t=TITLE&amp;d=DESC&amp;tag=&amp;u=PERMALINK',
		livefavorites:'http://favorites.live.com/quickAdd.aspx?url=PERMALINK&title=TITLE&text=DESC',
		pixelgroovy:'http://www.pixelgroovy.com/submit.php?url=PERMALINK',
		simpy:'http://www.simpy.com/simpy/LinkAdd.do?title=TITLE&amp;tags=&amp;note=DESC&amp;href=PERMALINK',
		propeller:'http://www.propeller.com/submit/?U=PERMALINK&amp;T=TITLE',
		yigg:'http://yigg.de/neu?exturl=PERMALINK',
		linkarena:'http://linkarena.com/bookmarks/addlink/?url=PERMALINK&amp;title=TITLE&amp;desc=DESC&amp;tags=',
		hatena:'http://b.hatena.ne.jp/add?url=PERMALINK'
	},
	gotoShare:function(name){
		var url=this.checkUrl(this.urlList[name]);
		window.open(url,"sharing","",true);
	},
	checkUrl:function(url){
		var href=encodeURIComponent(top.location.href);
		var desc=this.desc();
		var title=encodeURIComponent(top.document.title);
		var twitterText=this.twitterText();
		var re=[/PERMALINK/,/DESC/,/TITLE/,/TWITTER_TEXT/];
		var to=[href,desc,title,twitterText];
		for(var i=0;i<re.length;i++){
			url=url.replace(re[i],to[i]);
		}
		return url;
	},
	twitterText:function(){
		var title=top.document.title;
		var href=top.location.href;
		var hrefLen=href.length+4;
		var text=title+"+at+"+href;
		if(title+hrefLen>140){
			var t=title.substring(0,140+hrefLen);
			var dot=t.lastIndexOf(".");
			var space=t.lastIndexOf(" ");
			if(dot>-1){
				t=t.substring(0,dot);
			}
			else if(space>-1){
				t=t.substring(0,space);
			}
			text=t+"+at+"+href;
		}
		text=text.replace(/\s/g,"+");
		return text;
	},
	desc:function(){
		var desc="";
		var head=top.document.getElementsByTagName("head")[0];
		var metas=head.getElementsByTagName("meta");
		for(var i=0;i<metas.length;i++){
			if(metas[i].name){
				if(metas[i].name.toLowerCase() == "description"){
					desc=metas[i].content;
					break;
				}
			}
		}
		return encodeURIComponent(desc);
	},
	gotoSharingList:function(n){
		var panel=$I('#sharePanel'+n);
		if(panel&&panel.style.visibility == 'hidden'){
			var text="<table cellpadding=\"4\" cellspacing=\"0\" align=\"center\"><tr>";
			for(var x=0;x<this.list.length;x++){
				text+="<td><a href=\"javascript:DF.share.gotoShare('"+this.list[x]+"');\"><img src=\"images/share/"+this.list[x]+".gif\" width=\"16\" height=\"16\" border=\"0\"></a></td>";
			}
			text+="</tr></table>";
			panel.innerHTML=text;
			panel.style.position='';
			panel.style.visibility='visible';
		}
		else{
			panel.style.position='absolute';
			panel.style.visibility='hidden';
		}
	}
};