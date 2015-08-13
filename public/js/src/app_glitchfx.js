var GlitchFX;

GlitchFX = (function() {
  'use strict';
  GlitchFX.canvas;

  GlitchFX.context;

  GlitchFX.img;

  GlitchFX.offset = void 0;

  GlitchFX.w = void 0;

  GlitchFX.h = void 0;

  GlitchFX.glitchInterval = void 0;

  function GlitchFX(id, src) {
    id = id ? id : 'glitch_canvas';
    src = src ? src : '/images/logo.png';
    this.img = new Image;
    this.img.src = src;
    this.canvas = document.getElementById(id);
    this.context = this.canvas.getContext('2d');
    this.img.onload = (function(_this) {
      return function() {
        _this.glitching();
      };
    })(this);
    return;
  }

  GlitchFX.prototype.glitching = function() {
    this.canvas.width = this.w = $(window).width();
    this.offset = this.w * .1;
    this.canvas.height = this.h = ~~(175 * (this.w - (this.offset * 2)) / this.img.width);
    $(window).resize((function(_this) {
      return function() {
        _this.canvas.width = _this.w = $(window).width();
        _this.offset = _this.w * .1;
        _this.canvas.height = _this.h = ~~(175 * (_this.w - (_this.offset * 2)) / _this.img.width);
      };
    })(this));
    clearInterval(this.glitchInterval);
    this.glitchInterval = setInterval((function(_this) {
      return function() {
        _this.clear();
        _this.context.drawImage(_this.img, 0, 110, _this.img.width, 175, _this.offset, 0, _this.w - (_this.offset * 2), _this.h);
        setTimeout(function() {
          _this.glitchImg(_this.context, _this.canvas);
        }, _this.randInt(250, 1000));
      };
    })(this), 500);
  };

  GlitchFX.prototype.glitchImg = function(context, canvas) {
    var a, b, i, spliceHeight, spliceWidth, x, y;
    i = 0;
    a = this.randInt(1, 13);
    b = this.randInt(5, this.h / 3);
    while (i < a) {
      x = Math.random() * this.w;
      y = Math.random() * this.h;
      spliceWidth = this.w - x;
      spliceHeight = b;
      context.drawImage(canvas, 0, y, spliceWidth, spliceHeight, x, y, spliceWidth, spliceHeight);
      context.drawImage(canvas, spliceWidth, y, x, spliceHeight, 0, y, x, spliceHeight);
      i++;
    }
  };

  GlitchFX.prototype.randInt = function(a, b) {
    return ~~(Math.random() * (b - a) + a);
  };

  GlitchFX.prototype.clear = function() {
    this.context.rect(0, 0, this.w, this.h);
    this.context.fill();
  };

  return GlitchFX;

})();
