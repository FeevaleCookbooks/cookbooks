function ColorPicker(tmp_id, tmp_defaultcolor, tmp_output,evt) {
	if (document.getElementById('div_id')) {

		if ($S('plugin').display == 'none') {
				toggle('plugin',tmp_defaultcolor);
		}
		return;
	}

	if (!tmp_defaultcolor) {
		tmp_defaultcolor = 'FFFFFF';
	}
	
	if (agent('msie')) {	
		mouseX = event.clientX;
		mouseY = event.clientY;
	
		mouseY++;
		mouseY += 4;
	} else {
		mouseX = 500;
		mouseY = 300;
	}

	inner = '<div id="plugin" onmousedown="HSVslide(\'drag\',\'plugin\',event)" style="Z-INDEX:102; TOP:'+mouseY+'px;left:'+mouseX+'px; DISPLAY: none;">';
	inner += '<div id="plugHEX" onmousedown="stop=0; setTimeout(\'stop=1\',100);">#'+ tmp_defaultcolor +'</div><div id="plugCLOSE" onmousedown="toggle(\'plugin\',\''+tmp_defaultcolor+'\')"><font style="color:000000">x</font></div><br>';
	inner += '<div id="SV" onmousedown="HSVslide(\'SVslide\',\'plugin\',event)" title="Saturation + Value">';
	inner += '<div id="SVslide" style="TOP: -4px; LEFT: -4px;"><br /></div>';
	inner += '</div>';
	inner += '<form id="H" onmousedown="HSVslide(\'Hslide\',\'plugin\',event)" title="Hue">';
	inner += '<div id="Hslide" style="TOP: -7px; LEFT: -8px;"><br /></div>';
	inner += '<div id="Hmodel"></div>';
	inner += '</form><div id="plugCURI"></div><div id="plugCUR"></div>';
	inner += '</div>';

	var div = document.createElement('DIV');
	div.setAttribute("id", "div_id");
	div.setAttribute("style", "z-index: 101");

	div.innerHTML = inner;
	
	document.getElementsByTagName('body')[0].appendChild(div);
	
	if (!document.getElementById('div_all_combo')) {
		var div2 = document.createElement('div');
		div2.id = 'div_all_combo';
		div2.className = 'div_all';
		div2.style.display = '';
		div2.innerHtml = '&nbsp; ';
		div2.onclick = function () {
			toggle('plugin',tmp_defaultcolor);
		}
		document.getElementsByTagName('body')[0].appendChild(div2);
	}

	$S('plugCUR').background='#'+tmp_defaultcolor;
	$S('plugCURI').background='#'+tmp_defaultcolor;
	global_output = tmp_output;

	//LOAD
	loadSV();
	if (agent('msie')) {
		$S('plugin').display='block';
	}
}

function positionPlugin(e) {
	if (document.getElementById('plugin')) {
		if ($S('plugin').display == 'none') {
			mouseY = e.pageY;
			mouseY++;
			mouseY+=4;
			$S('plugin').left=e.pageX;
			$S('plugin').top=mouseY;
			$S('plugin').display='none';
			document.onmousedown = null;
		}
	}
}

if (!agent('msie')) {
	document.onmousedown=positionPlugin;
}

// DHTML Color Picker
// Programming by Ulyses
// ColorJack.com

function $S(v) { return(document.getElementById(v).style); }
function agent(v) { return(Math.max(navigator.userAgent.toLowerCase().indexOf(v),0)); }
function toggle(v,tmp_defaultcolor) {
	if ($S(v).display == 'none') {
		$S('div_all_combo').display = '';
		$S(v).display = 'block';
		$S('plugCURI').background='#'+tmp_defaultcolor;
		
	} else {
		$S('div_all_combo').display = 'none';
		$S(v).display = 'none';		
	}
}
function within(v,a,z) { return((v>=a && v<=z)?true:false); }
function XY(e,v) { var z=agent('msie')?[event.clientX+document.body.scrollLeft,event.clientY+document.body.scrollTop]:[e.pageX,e.pageY]; return(z[zero(v)]); }
function XYwin(v) { var z=agent('msie')?[document.body.clientHeight,document.body.clientWidth]:[window.innerHeight,window.innerWidth]; return(!isNaN(v)?z[v]:z); }
function zero(v) { v=parseInt(v); return(!isNaN(v)?v:0); }

/* PLUGIN */

var maxValue={'h':360,'s':100,'v':100}, HSV={0:360,1:100,2:100};
var hSV=165, wSV=162, hH=163, slideHSV={0:360,1:100,2:100}, zINDEX=15, stop=1;

function HSVslide(d,o,e) {

	function tXY(e) { tY=XY(e,1)-top; tX=XY(e)-left; }
	function mkHSV(a,b,c) { return(Math.min(a,Math.max(0,Math.ceil((parseInt(c)/b)*a)))); }
	function ckHSV(a,b) { if(within(a,0,b)) return(a); else if(a>b) return(b); else if(a<0) return('-'+oo); }
	function drag(e) { if(!stop) { if(d!='drag') tXY(e);
	
		if(d=='SVslide') { ds.left=ckHSV(tX-oo,wSV)+'px'; ds.top=ckHSV(tY-oo,wSV)+'px';
		
			slideHSV[1]=mkHSV(100,wSV,ds.left); slideHSV[2]=100-mkHSV(100,wSV,ds.top); HSVupdate();

		}
		else if(d=='Hslide') { var ck=ckHSV(tY-oo,hH), j, r='hsv', z={};
		
			ds.top=(ck-5)+'px'; slideHSV[0]=mkHSV(360,hH,ck);
 
			for(var i=0; i<=r.length-1; i++) { j=r.substr(i,1); z[i]=(j=='h')?maxValue[j]-mkHSV(maxValue[j],hH,ck):HSV[i]; }

			HSVupdate(z); $S('SV').backgroundColor='#'+hsv2hex([HSV[0],100,100]);

		}
		else if(d=='drag') { ds.left=XY(e)+oX-eX+'px'; ds.top=XY(e,1)+oY-eY+'px'; }

	}}

	if(stop) { stop=''; var ds=$S(d!='drag'?d:o);

		if(d=='drag') { var oX=parseInt(ds.left), oY=parseInt(ds.top), eX=XY(e), eY=XY(e,1); $S(o).zIndex=zINDEX++; }
		else { var left=(document.getElementById(o).offsetLeft+10), top=(document.getElementById(o).offsetTop+22), tX, tY, oo=(d=='Hslide')?2:4; if(d=='SVslide') slideHSV[0]=HSV[0]; }

		document.onmousemove=drag; document.onmouseup=function(){ stop=1; document.onmousemove=''; document.onmouseup=''; }; drag(e);

	}
}

function HSVupdate(v) { 

	v=hsv2hex(HSV=v?v:slideHSV);
	document.getElementById('plugHEX').innerHTML='#'+v;
	$S('plugCUR').background='#'+v;
	$S('div_color_'+global_output).background='#'+v;
	
	document.getElementById(global_output).value=v;
	
	
	return(v);

}

function loadSV() { var z='';

	for(var i=hSV; i>=0; i--) z+="<div style=\"BACKGROUND: #"+hsv2hex([Math.round((360/hSV)*i),100,100])+";\"><br /><\/div>";
	
	document.getElementById('Hmodel').innerHTML=z;
	
}

/* CONVERSIONS */

function toHex(v) { v=Math.round(Math.min(Math.max(0,v),255)); return("0123456789ABCDEF".charAt((v-v%16)/16)+"0123456789ABCDEF".charAt(v%16)); }
function rgb2hex(r) { return(toHex(r[0])+toHex(r[1])+toHex(r[2])); }
function hsv2hex(h) { return(rgb2hex(hsv2rgb(h))); }	

function hsv2rgb(r) { // easyrgb.com/math.php?MATH=M21#text21


    var R,B,G,S=r[1]/100,V=r[2]/100,H=r[0]/360;

    if(S>0) { if(H>=1) H=0;

        H=6*H; F=H-Math.floor(H);
        A=Math.round(255*V*(1.0-S));
        B=Math.round(255*V*(1.0-(S*F)));
        C=Math.round(255*V*(1.0-(S*(1.0-F))));
        V=Math.round(255*V); 

        switch(Math.floor(H)) {

            case 0: R=V; G=C; B=A; break;
            case 1: R=B; G=V; B=A; break;
            case 2: R=A; G=V; B=C; break;
            case 3: R=A; G=B; B=V; break;
            case 4: R=C; G=A; B=V; break;
            case 5: R=V; G=A; B=B; break;

        }

        return([R?R:0,G?G:0,B?B:0]);

    }
    else return([(V=Math.round(V*255)),V,V]);

}