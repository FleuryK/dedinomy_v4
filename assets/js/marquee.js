 /* 
	 * Définition de Marquee, fonction de défilement 
	 * @param box (string/node) le noeud marquee 
	 * @param options (map) les options
	 *		- speed : la vitesse du déplacement (default 0.5)
	 *		- dirc : la direction du déplacement (default top)
	 *		- btSpeedUp : la bouton d'accélération 
	 *		- btSpeedDown : la bouton d'esaccélération 
	 *		- speedActiveBt : vitesse d'accélaration pour le bouton (default 10)
	 *		- cssActiveBtSpeedUp : class du bouton accélération actif
	 *		- cssActiveBtSpeedUp : class du bouton desaccélération actif
	 *		- eventBt : l'évenement de l'activation de bouton (default over, sinon down)
	 *		- stopOnOver : pour stopper le difelement au survole (default false)
	 *		- scrollOnMove : pour actievr le scrolling au survole
	 *		- maxSpeedOnMove : vitesse d'accélaration pour le scrool (default 10)
	 *		- expoSpeedOnMove : comportement exponentiel de l'accélaration  (default 2)
	 *		- draggable : permet de scroller le contenue lors d'un drag  (default false)
	 *		- cursorOverDrag : définit l'url du curseur à utilisé pour spécifié que le contenue peux etre "dragger" 
	 *		- cursorOnDrag : définit l'url du curseur à utilisé pour spécifié que le contenue est en train d'etre "dragger" 
	 */
var Marquee = (function(){
    //fonction anonye pour creer les variable privé (gestion cross browser du dom), à adapter en fonctions de votre propre librarie perso
    
	
	var Cookie = {
	    read : function(name){
			var i = document.cookie.indexOf(name + "=");
			if (i > -1) {
				i += name.length + 1
				var j = document.cookie.indexOf(';', i);
				if (j < 0) 
				    j = document.cookie.length;
				return unescape(document.cookie.substring(i, j));
			}
			return '';
		},
		write : function(name, value){
		    document.cookie = name + "=" + escape(value);
		}
	};
	
	var isWebkit =  navigator.userAgent.indexOf('AppleWebKit/') > -1,
	
	isIE = !!window.attachEvent;
	
    /*------Selection--------------------------------------------------*/
	var $ = function(id) {
		return (typeof(id) == "string") ? document.getElementById(id) : id;
	}
    
	var extendIf = function(destination, source){
	    for (var property in source)
			if(destination[property] === undefined)
				destination[property] = source[property];
		return destination;
	};
	
	
	
	/*------Evenement--------------------------------------------------*/
    var Event = {
        observe : function(element, eventName, handler) {
            if(window.addEventListener){
	            element.addEventListener(eventName, handler, false);
	        }else{
		        element.attachEvent("on"+eventName, handler);
	        }
        },
        stopObserving : function(element, eventName, handler) {
            if(window.removeEventListener){
				element.removeEventListener(eventName, handler, false);
			}else if(window.detachEvent){		
				element.detachEvent("on"+eventName, handler);	
		    };		
        },
		pointer: function(event) {
            return {
				x: event.pageX || (event.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft)),
				y: event.pageY || (event.clientY + (document.documentElement.scrollTop || document.body.scrollTop))
			};
		},
		preventDefault : function(event){
			if(event.preventDefault) {
				event.preventDefault();
			} else {
				event.returnValue = false;
			}
			return false;
		}
	};
	
	var getOffset = function(forElement){
	    forElement = $(forElement);
		var element = forElement,
		value = [0,0];
		
		do {
			value[0]+=element.offsetLeft || 0;
			value[1]+=element.offsetTop || 0;
			element = element.offsetParent;
		} while (element);
		element = forElement;
		
		do {
			if((isWebkit && element.tagName != 'BODY') || (!isWebkit && element.tagName != 'HTML')){
				value[1]-=element.scrollTop || 0;
				value[0]-=element.scrollLeft || 0;
			}
		} while (element == element.parentNode);
    
		return value;
	};
	
	/*------Liaison des contextes d'éxecution des fonctions aux objets-------------------------*/
	
	var bind = function(__method){
		var  args = Array.prototype.slice.call(arguments, 1), object = args.shift();
		return function(event) {
		    return __method.apply(object, args.concat(Array.prototype.slice.call(arguments,0)));
		}
	};
	
	/*------Laison des contextes d'éxecution des fonctions aux objets , avec en 1er argument un événement-------------------------*/
	
	var bindAsEventListener = function(__method){
		var args = Array.prototype.slice.call(arguments, 1), object = args.shift();
		return function(event) {
		    return __method.apply(object, [( event || window.event)].concat(args));
		}
	};
	
	/*
	 * fonction de défilement 
	 * @param box (string/node) le noeud marquee 
	 * @param options (map) les options
	 *		- speed : la vitesse du déplacement (default 0.5)
	 *		- dirc : la direction du déplacement (default top)
	 *		- btSpeedUp : la bouton d'accélération 
	 *		- btSpeedDown : la bouton d'esaccélération 
	 *		- speedActiveBt : vitesse d'accélaration pour le bouton (default 10)
	 *		- cssActiveBtSpeedUp : class du bouton accélération actif
	 *		- cssActiveBtSpeedUp : class du bouton desaccélération actif
	 *		- eventBt : la bouton du déplacement (default over, sinon down)
	 *		- stopOnOver : pour stopper le difelement au survole (default true)
	 *		- scrollOnMove : pour actievr le scrolling au survole
	 *		- maxSpeedOnMove : vitesse d'accélaration pour le scrool (default 10)
	 *		- expoSpeedOnMove : comportement exponentiel de l'accélaration  (default 2)
	 */
	var Marquee = function(box, options){
	    this.box = $(box);
		this.content = this.box.firstChild.nodeType == 1 ? this.box.firstChild : this.box.childNodes[1];
		this.coefDirc = 1;
		
		//ini les options
		this.options = extendIf(options || {}, this.options);
		if(this.options.btSpeedUp)
		    this.options.btSpeedUp = $(this.options.btSpeedUp);
		if(this.options.btSpeedDown)
		    this.options.btSpeedDown = $(this.options.btSpeedDown);
		
		this._speed = this.options.speed;
		this.inverseDirc = this.options.dirc=='bottom' || this.options.dirc=='right';
		this.horizontalDirc = this.options.dirc=='bottom' || this.options.dirc=='top';	
		
		this.box.style.overflow = 'hidden';
		this.box.style.position = 'relative'; 
		this.content.style.position = 'absolute';
		
		//calcule la dimension du conteneur  + la dimention du contenue 
		var boxDim = this.box['client' + (this.horizontalDirc ? 'Height' : 'Width')];
		var contentDim = this.content['offset' + (this.horizontalDirc ? 'Height' : 'Width')];
		
		//on definit las position max et min
		this.maxDim = -contentDim;
		this.startStep =  boxDim;
		
		//on définit la position de départ
		
		if(this.options.activeCookie && this.box.id){
			 Event.observe(window, 'unload', bindAsEventListener(this.saveCookie, this));
			 this.currentStep = this.getCookie() || this.startStep;
		}else{		
		    this.currentStep = this.startStep;
		}
		
		
		if(this.options.btSpeedUp || this.options.btSpeedDown){
		    this.eventsBt = this.options.eventBt == 'over' ? ['mouseover', 'mouseout'] : ['mousedown', 'mouseup'];
		}
		//ajoutes les evenemnts du bouton speedUp
		if(this.options.btSpeedUp){
		    this.handlerActiveBtUp = bindAsEventListener(this.onActiveBt, this, this.inverseDirc);
			Event.observe(this.options.btSpeedUp, this.eventsBt[0] ,this.handlerActiveBtUp);
		}
		
		//ajoutes les evenemnts du bouton speedDown
		if(this.options.btSpeedDown){
		    this.handlerActiveBtDown = bindAsEventListener(this.onActiveBt, this, !this.inverseDirc, true);
			Event.observe(this.options.btSpeedDown, this.eventsBt[0], this.handlerActiveBtDown);
		}
		
		//ajoutes l' evenemnt stopOnOver
		if(this.options.stopOnOver){
		    this.handlerStopOnOver = bindAsEventListener(this.onMouseOverContent, this);
			Event.observe(this.box, 'mouseover', this.handlerStopOnOver);
			
			this.handlerActiveOnOut = bindAsEventListener(this.onMouseOutContent, this);
			Event.observe(this.box, 'mouseout', this.handlerActiveOnOut);
		}
		
		if(this.options.scrollOnMove){
		    this.middleDim = boxDim / 2;
			this.timeOut = false;
			 
		    this.handlerActiveScroll = bindAsEventListener(this.onActiveScroll, this);
			Event.observe(this.box, 'mouseover', this.handlerActiveScroll);
		    
			this.handlerInactiveScroll = bindAsEventListener(this.onInactiveScroll, this);
			Event.observe(this.box, 'mouseout', this.handlerInactiveScroll);
			
			this.handlerMouseMove = bindAsEventListener(this.scrollOnMove, this);
			Event.observe(this.box, 'mousemove', this.handlerMouseMove);
		}
		
		if(this.options.draggable){
		    if(this.options.cursorOverDrag){
			    this.handlerActveCursor = bindAsEventListener(this.setCursorOverDrag, this);
				Event.observe(this.box, 'mouseover', this.handlerActveCursor);
			
				this.handlerInactveCursor = bindAsEventListener(this.setCursorOverDrag, this, true);
				Event.observe(this.box, 'mouseout', this.handlerInactveCursor);
			}
			    
			
		    this.handlerActiveDrag = bindAsEventListener(this.onActiveDrag, this);
			Event.observe(this.box, 'mousedown', this.handlerActiveDrag);
		}
		
		this.setInterval();
		
		//bug memoire ie
		this.eventUnload = bindAsEventListener(this.onUnload, this);
        Event.observe(window, 'unload', this.eventUnload);
	}
	
	Marquee.prototype = {
	    options : {
		    speed : 0.5,
			speedActiveBt : 10,
			dirc : 'top',
		    eventBt : 'over',
			stopOnOver : false,
			draggable : false,
			maxSpeedOnMove : 10,
			expoSpeedOnMove : 2
		},
		
		onInactiveBt : function(e, down){
			this.options.speed = this._speed;
			var css = this.options['cssActiveBtSpeed' + (down ? 'Down' : 'Up')];
			if(css){
			    var bt = this.options['btSpeed' + (down ? 'Down' : 'Up')],
				cls = bt.className;
				bt.className = cls.replace(' ' + css, '');
			}
			this.toogleSelect(e, true);
			Event.stopObserving(document, 'mouseup', this['handlerInctiveBt' + (down ? 'Down' : 'Up')]);
		},
		
		onActiveBt : function(e, inverse, down){
			this.options.speed  = inverse ? -this.options.speedActiveBt : this.options.speedActiveBt;
			var css = this.options['cssActiveBtSpeed' + (down ? 'Down' : 'Up')];
			if(css)
			    this.options['btSpeed' + (down ? 'Down' : 'Up')].className += ' ' + css;
			
			var eventHandler = 'handlerInctiveBt' + (down ? 'Down' : 'Up');
 			
		    this[eventHandler] = bindAsEventListener(this.onInactiveBt, this, down);
			Event.observe(document, this.eventsBt[1], this[eventHandler]);
			this.toogleSelect(e);
		},
   
		onMouseOverContent : function(){
			this.clearInterval();
		},
		
		onMouseOutContent  : function(){
		    if(!this.isOndrag)
			    this.setInterval();
		},
		
		onActiveScroll : function(e){
		    //on passe par un setTimeout , pour eviter une émulation de mouseenter, mouseleave
			if(this.timeOut){
                clearTimeout(this.timeOut);
            }else{
                var dim = getOffset(this.box);
			    this.coor = this.options.dirc == 'top' || this.options.dirc == 'bottom' ? dim[1]: dim[0];
				
            }
		},
		
		onInactiveScroll : function(e){
		    //on passe par un setTimeout , pour eviter une émulation de mouseenter, mouseleave
		    this.timeOut = setTimeout(bind(function(){
                this.timeOut = null;
				this.options.speed = this._speed;
            }, this), 0);

		},
		
		scrollOnMove : function(e){
		    var mouseCoor = this.horizontalDirc ? Event.pointer(e).y : Event.pointer(e).x;
			
			var ratio = (this.middleDim - (mouseCoor - this.coor))/ this.middleDim,
			coefDirc = Math.pow(ratio, this.options.expoSpeedOnMove) * this.options.maxSpeedOnMove;
			
			this.options.speed = (ratio > 0 ? coefDirc : coefDirc > 0 ? -coefDirc : coefDirc) * (this.inverseDirc ? -1 : 1);
		},
		
		onActiveDrag : function(e){
		    this.isOndrag = true;
			this.clearInterval();
			
		    this.coor = this.horizontalDirc ? Event.pointer(e).y : Event.pointer(e).x;
			 
			this.handlerInactiveDrag = bindAsEventListener(this.onInactiveDrag, this);
			Event.observe(document, 'mouseup', this.handlerInactiveDrag);
			
			this.handlerDragOnMove = bindAsEventListener(this.dragOnMove, this);
			Event.observe(document, 'mousemove', this.handlerDragOnMove);
			
			if(this.options.cursorOnDrag)
			    document.documentElement.style.cursor = 'url(' + this.options.cursorOnDrag + '), auto';
			
			this.toogleSelect(e);
			
		},
		
		onInactiveDrag : function(e){
		    this.isOndrag = false;
			var coor = this.horizontalDirc ? Event.pointer(e).y : Event.pointer(e).x;
			this.currentStep = this.inverseDirc ? this.currentStep - (coor - this.coor) : this.currentStep + (coor - this.coor) ;
			
			
			if(this.isOutDrag && this.options.cursorOnDrag){
			    document.documentElement.style.cursor = 'auto';
			}else if(this.options.cursorOverDrag){
			    document.documentElement.style.cursor = 'url(' + this.options.cursorOverDrag + '), auto';
			}
			
		    Event.stopObserving(document, 'mouseup', this.handlerInactiveDrag);
			Event.stopObserving(document, 'mousemove', this.handlerDragOnMove);
			
			this.toogleSelect(e, true);
			this.setInterval();
		},
		
		dragOnMove : function(e){
		    var coor = this.horizontalDirc ? Event.pointer(e).y : Event.pointer(e).x,
			steep =  this.inverseDirc ? this.currentStep - (coor - this.coor) : this.currentStep + (coor - this.coor) ;
			
			this.content.style[this.options.dirc] =  steep + 'px';
			
			if(steep > this.startStep){
				this.currentStep = this.maxDim;
				this.coor = coor;
			}else if(steep < this.maxDim){
			   this.currentStep = this.startStep;
				this.coor = coor;
			}
		},
		
		setCursorOverDrag : function(e, del){
		    if(!this.isOndrag){
		        document.documentElement.style.cursor = del ? 'auto' : 'url(' + this.options.cursorOverDrag + '), auto';
			}else this.isOutDrag = del;
		},
		
		setSteep : function(){
		    var acc = this.options.speed;
			this.content.style[this.options.dirc] = this.currentStep - acc + 'px';
			
			this.currentStep -= acc;
			if(this.currentStep > this.startStep){
				this.currentStep = this.maxDim;
			}else if(this.currentStep < this.maxDim){
			   this.currentStep = this.startStep;
			}
		},
		
		setInterval : function(){
		    if(!this.interval)
			    this.interval = setInterval(bind(this.setSteep, this), 35);
		},
		
		clearInterval : function(){
		    if(this.interval){
			    clearInterval(this.interval);
				this.interval = null;
			}
		},
		
		toogleSelect : function(e, enable){
		    if(enable){
			    document.onselectstart = null;
				document.ondragstart = null;
			}else{
			    document.onselectstart = function(){return false;};
				document.ondragstart = function(){return false;};
				Event.preventDefault(e);
			}
		},
		
		onUnload : function(){
			this.clearInterval();
			
			if(this.options.btSpeedUp){
				Event.stopObserving(this.options.btSpeedUp, this.eventsBt[0] ,this.handlerActiveBtUp);
			}
			if(this.options.btSpeedDown){
				Event.stopObserving(this.options.btSpeedDown, this.eventsBt[0] ,this.handlerActiveBtDown);
			}
			
			if(this.options.stopOnOver){
				Event.stopObserving(this.box, 'mouseover', this.handlerStopOnOver);
				Event.stopObserving(this.box, 'mouseout', this.handlerActiveOnOut);
			}
			
			if(this.options.scrollOnMove){
			 
				Event.stopObserving(this.box, 'mouseover', this.handlerActiveScroll);
				Event.stopObserving(this.box, 'mouseout', this.handlerInactiveScroll);
				Event.stopObserving(this.box, 'mousemove', this.handlerMouseMove);
			}
		
			if(this.options.draggable){
				if(this.options.cursorOverDrag){
					Event.stopObserving(this.box, 'mouseover', this.handlerActveCursor);
					Event.stopObserving(this.box, 'mouseout', this.handlerInactveCursor);
				}
				Event.stopObserving(this.box, 'mousedown', this.handlerActiveDrag);
			}
		},
		getCookie : function(){
			return Cookie.read('marquee_'+this.box.id);
		},
		saveCookie : function(){
			Cookie.write('marquee_'+this.box.id, this.currentStep);
		}
	};
	
	return Marquee;
})();

