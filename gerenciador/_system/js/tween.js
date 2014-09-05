/*
Tween class for js, like nosvara.transitions.Tween class
by Ramon Fritsch (www.ramonfritsch.com)

Ex.:
Tween.addTween(document.getElementById('div_id'), {_alpha: 40, _height: 200, _width: 100, time: 2, transition: "circOut"});
*/

function TweenClass() {
	this._tweens = new Array();
	this._is_start = false;
	this._time = 0;
	
	this.addTween = function (tmp_element, tmp_params) {
		if (!this._is_start) {
			this._start();
		}
		
		var time = ((tmp_params.time) || (tmp_params.time == 0)) ? tmp_params.time : 1;
		var transition = (tmp_params.transition) ? tmp_params.transition : "quadOut";
		
		for (var i = 0; i < this._tweens.length; i++) {
			if (this._tweens[i].element != tmp_element) {
				this._deleteTween(i);
			}
		}
		
		if (tmp_element) {
			var o = {
				element: tmp_element,
				time: time * 1000,
				transition: transition,
				time_ini: (new Date()).getTime(),
				params: new Array(),
				params_ini: new Array()
			};
			
			o.element.style.overflow = "hidden";
			
			if (!o.element.defaults) { o.element.defaults = new Array(); }
			
			for (v in tmp_params) {
				if (v.substr(0, 1) == "_") {					
					if (o.element.defaults[v] == undefined) { o.element.defaults[v] = this._getParam(o.element, v); }
					if (tmp_params[v] == "default") { tmp_params[v] = o.element.defaults[v]; }
					
					o.params[v] = tmp_params[v];
					o.params_ini[v] = this._getParam(o.element, v);
				}
			}
			
			if (time > 0) {
				this._tweens.push(o);
			} else {
				for (v in tmp_params) {
					if (v.substr(0, 1) == "_") {					
						if (o.element.defaults[v] == undefined) { o.element.defaults[v] = this._getParam(o.element, v); }
						if (tmp_params[v] == "default") { tmp_params[v] = o.element.defaults[v]; }
						
						this._setParam(o.element, v, tmp_params[v]);
					}
				}		
			}
		}
	}
	
	this._getParam = function (tmp_element, tmp_param) {
		var r;
		
		switch (tmp_param) {
			case "_height":
				r = tmp_element.style.height.replace("px", "");
				r++; r--;
				
				if (r == 0) {
					r = tmp_element.offsetHeight;
					r++; r--;
				}
				
				break;
			case "_width":
				r = tmp_element.style.width.replace("px", "");
				r++; r--;
				
				if (r == 0) {
					r = tmp_element.offsetWidth;	
					r++; r--;
				}
				
				break;
			case "_alpha":
				r = tmp_element._alpha;
				if (!r) { r = 100; }
				
				r++; r--;
				
				break;
			case "_marginLeft":
				r = tmp_element.style.marginLeft.replace("px", "");
				r++; r--;
	
				
				if (r == 0) {
					//tmp_element.getAttribute("width", tmp_value + "px");
					r = tmp_element.style.marginLeft.replace("px", "");	
					r++; r--;
				}
				break;
			case "_marginTop":
				r = tmp_element.style.marginTop.replace("px", "");
				r++; r--;
	
				
				if (r == 0) {
					r = tmp_element.style.marginTop.replace("px", "");	
					r++; r--;
				}
				
		}
		
		return r;
	}
	
	this._setParam = function (tmp_element, tmp_param, tmp_value) {
		if (tmp_value > 0 && tmp_element.style.visibility == "hidden") tmp_element.style.visibility = "visible";
		
		switch (tmp_param) {
			case "_height":
				if (tmp_value == 0) tmp_element.style.visibility = "hidden";
				tmp_element.style.height = tmp_value + "px";
				tmp_element.setAttribute("height", tmp_value + "px");
				
				break;
			case "_width":
				if (tmp_value == 0) tmp_element.style.visibility = "hidden";
				tmp_element.style.width = tmp_value + "px";
				tmp_element.setAttribute("width", tmp_value + "px");
				
				break;
			case "_alpha":
				if (tmp_value >= 100) tmp_value = 99.999;
				if (tmp_value == 0) tmp_element.style.visibility = "hidden";
				if (isIE) tmp_element.style.filter = "alpha(opacity=" + tmp_value + ")";
				tmp_element.style.opacity = (tmp_value / 100);
				tmp_element._alpha = tmp_value;
	
				break;
			case "_marginLeft":
				if (tmp_value == 0) tmp_element.style.visibility = "hidden";
				tmp_element.style.marginLeft = tmp_value + "px";
				tmp_element.setAttribute("style", "margin-left:" + tmp_value + "px");
				
				break;
			case "_marginTop":
				//if (tmp_value == 0) tmp_element.style.visibility = "hidden";
				tmp_element.style.marginTop = tmp_value + "px";
				tmp_element.setAttribute("style", "margin-top:" + tmp_value + "px");
				
				break;
		}
	}
	
	this._deleteTween = function (tmp_index) {
		var arr = new Array();
		var i2 = 0;
		for (var i = 0; i < this._tweens.length; i++) {
			if (i != tmp_index) {
				arr[i2] = this._tweens[i];
				
				i2++;
			}
		}
		
		this._tweens = arr;
	}
	
	this._start = function () {
		this._is_start = false;
		
		this._update();
	}
	
	this._update = function () {
		this._time = (new Date()).getTime();
		
		for (var i = 0; i < this._tweens.length; i++) {
			this._updateTween(i);
		}
		
		setTimeout(this._update.bind(this), 26);
	}
	
	this._updateTween = function (tmp_index) {
		var tw = this._tweens[tmp_index];
		
		var t, b, c, d;
		
		if (tw) {
			t = (this._time - tw.time_ini);
			d = tw.time;
			
			if (t >= d) {
				for (v in tw.params) {
					this._setParam(tw.element, v, tw.params[v]);
				}
				
				this._deleteTween(tmp_index);
			} else {
				for (v in tw.params) {
					b = tw.params_ini[v];
					c = tw.params[v] - b;
					
					this._setParam(tw.element, v, this._transitions[tw.transition](t, b, c, d));
				}
			}
		} else {
			this._deleteTween(tmp_index);	
		}
	}
	
	this._transitions = {
		linear: function(t, b, c, d) { 
			return c*t/d + b; 
		}, 
		quadIn: function(t, b, c, d){ 
			return c*(t/=d)*t + b; 
		}, 
		quadOut: function(t, b, c, d) {
			return -c *(t/=d)*(t-2) + b;
		},
	
		quadInOut: function(t, b, c, d){
			if ((t/=d/2) < 1) return c/2*t*t + b;
			return -c/2 * ((--t)*(t-2) - 1) + b;
		},
	
		cubicIn: function(t, b, c, d){
			return c*(t/=d)*t*t + b;
		},
	
		cubicOut: function(t, b, c, d){
			return c*((t=t/d-1)*t*t + 1) + b;
		},
	
		cubicInOut: function(t, b, c, d){
			if ((t/=d/2) < 1) return c/2*t*t*t + b;
			return c/2*((t-=2)*t*t + 2) + b;
		},
	
		quartIn: function(t, b, c, d){
			return c*(t/=d)*t*t*t + b;
		},
	
		quartOut: function(t, b, c, d){
			return -c * ((t=t/d-1)*t*t*t - 1) + b;
		},
	
		quadInOut: function(t, b, c, d){
			if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
			return -c/2 * ((t-=2)*t*t*t - 2) + b;
		},
	
		quintIn: function(t, b, c, d){
			return c*(t/=d)*t*t*t*t + b;
		},
	
		quintOut: function(t, b, c, d){
			return c*((t=t/d-1)*t*t*t*t + 1) + b;
		},
	
		quintInOut: function(t, b, c, d){
			if ((t/=d/2) < 1) return c/2*t*t*t*t*t + b;
			return c/2*((t-=2)*t*t*t*t + 2) + b;
		},
	
		sineIn: function(t, b, c, d){
			return -c * Math.cos(t/d * (Math.PI/2)) + c + b;
		},
	
		sineOut: function(t, b, c, d){
			return c * Math.sin(t/d * (Math.PI/2)) + b;
		},
	
		sineInOut: function(t, b, c, d){
			return -c/2 * (Math.cos(Math.PI*t/d) - 1) + b;
		},
	
		expoIn: function(t, b, c, d){
			return (t==0) ? b : c * Math.pow(2, 10 * (t/d - 1)) + b;
		},
	
		expoOut: function(t, b, c, d){
			return (t==d) ? b+c : c * (-Math.pow(2, -10 * t/d) + 1) + b;
		},
	
		expoInOut: function(t, b, c, d){
			if (t==0) return b;
			if (t==d) return b+c;
			if ((t/=d/2) < 1) return c/2 * Math.pow(2, 10 * (t - 1)) + b;
			return c/2 * (-Math.pow(2, -10 * --t) + 2) + b;
		},
	
		circIn: function(t, b, c, d){
			return -c * (Math.sqrt(1 - (t/=d)*t) - 1) + b;
		},
	
		circOut: function(t, b, c, d){
			return c * Math.sqrt(1 - (t=t/d-1)*t) + b;
		},
	
		circInOut: function(t, b, c, d){
			if ((t/=d/2) < 1) return -c/2 * (Math.sqrt(1 - t*t) - 1) + b;
			return c/2 * (Math.sqrt(1 - (t-=2)*t) + 1) + b;
		},
	
		elasticIn: function(t, b, c, d, a, p){
			if (t==0) return b; if ((t/=d)==1) return b+c; if (!p) p=d*.3; if (!a) a = 1;
			if (a < Math.abs(c)){ a=c; var s=p/4; }
			else var s = p/(2*Math.PI) * Math.asin(c/a);
			return -(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
		},
	
		elasticOut: function(t, b, c, d, a, p){
			if (t==0) return b; if ((t/=d)==1) return b+c; if (!p) p=d*.3; if (!a) a = 1;
			if (a < Math.abs(c)){ a=c; var s=p/4; }
			else var s = p/(2*Math.PI) * Math.asin(c/a);
			return a*Math.pow(2,-10*t) * Math.sin( (t*d-s)*(2*Math.PI)/p ) + c + b;
		},
	
		elasticInOut: function(t, b, c, d, a, p){
			if (t==0) return b; if ((t/=d/2)==2) return b+c; if (!p) p=d*(.3*1.5); if (!a) a = 1;
			if (a < Math.abs(c)){ a=c; var s=p/4; }
			else var s = p/(2*Math.PI) * Math.asin(c/a);
			if (t < 1) return -.5*(a*Math.pow(2,10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )) + b;
			return a*Math.pow(2,-10*(t-=1)) * Math.sin( (t*d-s)*(2*Math.PI)/p )*.5 + c + b;
		},
	
		backIn: function(t, b, c, d, s){
			if (!s) s = 1.70158;
			return c*(t/=d)*t*((s+1)*t - s) + b;
		},
	
		backOut: function(t, b, c, d, s){
			if (!s) s = 1.70158;
			return c*((t=t/d-1)*t*((s+1)*t + s) + 1) + b;
		},
	
		backInOut: function(t, b, c, d, s){
			if (!s) s = 1.70158;
			if ((t/=d/2) < 1) return c/2*(t*t*(((s*=(1.525))+1)*t - s)) + b;
			return c/2*((t-=2)*t*(((s*=(1.525))+1)*t + s) + 2) + b;
		},
	
		bounceIn: function(t, b, c, d){
			return c - Tween._transitions.bounceOut (d-t, 0, c, d) + b;
		},
	
		bounceOut: function(t, b, c, d){
			if ((t/=d) < (1/2.75)){
				return c*(7.5625*t*t) + b;
			} else if (t < (2/2.75)){
				return c*(7.5625*(t-=(1.5/2.75))*t + .75) + b;
			} else if (t < (2.5/2.75)){
				return c*(7.5625*(t-=(2.25/2.75))*t + .9375) + b;
			} else {
				return c*(7.5625*(t-=(2.625/2.75))*t + .984375) + b;
			}
		},
	
		bounceInOut: function(t, b, c, d){
			if (t < d/2) return Tween._transitions.bounceIn(t*2, 0, c, d) * .5 + b;
			return Tween._transitions.bounceOut(t*2-d, 0, c, d) * .5 + c*.5 + b;
		}
	}
}
var Tween = new TweenClass();