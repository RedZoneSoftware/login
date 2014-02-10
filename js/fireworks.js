"use strict";
/*
 * By Kearnan Kelly, kkelly@kellycode.com
 * 
 * You're welcome to do anything you like with it.  It works by drawing a stream
 * of colored short lines and then drawing black lines in the exact same place
 * to give it the fade effect.  I will eventually go through it again and make
 * it a lot more concise.
 * 
 */
var canvas;
var it = 0;
var running = true;
var fl = [];
var gravity = .09;
var friction = .05;
var streamers = 20;
var segments = 80;
var maxRockets = 3;
var wait = 1000;

function setColor(newColor) {
    color = newColor;
}

function drawStreamer(sx, sy, ex, ey, color) {
    canvas.strokeStyle = color;
    canvas.beginPath();
    canvas.moveTo(sx, sy);
    canvas.lineTo(ex, ey);
    canvas.closePath();
    canvas.stroke();
}

function randomColor() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    return 'rgb(' + r + ',' + g + ',' + b + ')';
}

function point(sx, sy) {
    this.x = sx;
    this.y = sy;
}

function vector() {
    var power = Math.random() * 5;
    var angle = (Math.random() * 6) - 3;
    this.a = angle;
    this.p = power * -1;
}

function segment() {
    this.sx;
    this.sy;
    this.ex;
    this.ey;
    this.c;
}

function path(w, h, t, c) {
    this.d = new vector();
    this.p = new point(w, h);
    this.c = new point(0, 0);

    this.path = [];
    for (var i = 0; i < t; i++) {
        this.path[i] = new segment();
        this.path[i].c = c;
        this.path[i].sx = this.p.x;
        this.path[i].sy = this.p.y;
        this.path[i].ex = this.p.x + this.d.a;
        this.path[i].ey = this.p.y + this.d.p + (gravity * i);
        this.p.x = this.path[i].ex;
        this.p.y = this.path[i].ey;
    }
    return this.path;
}

function streamer(w, h, segments) {
    this.count = 0;
    this.color = randomColor();
    this.path = new path(w, h, segments, this.color);
}

function flash(w, h, segments, idNum) {
    var id = idNum;
    this.segments = segments;
    this.eraseCount = 0;
    this.drawCount = 0;
    this.total = 0;
    this.wx = (Math.random() * (w / 2)) + w / 4;
    this.hy = (Math.random() * (h / 2)) + h / 4;
    this.streamers = [];
    this.drawList = [];

    for (var i = 0; i < streamers; i++) {
        this.streamers[i] = new streamer(this.wx, this.hy, this.segments);
    }

    this.buildSegmentList = function() {
        for (var j = 0; j < this.segments; j++) {
            for (var i = 0; i < streamers; i++) {
                this.drawList[this.drawCount] = this.streamers[i].path[j];
                this.drawCount++;
            }
        }
        this.total = this.drawCount;
        this.drawCount = 0;
    }

    this.render = function() {
        for (var i = 0; i < this.segments; i++) {
            var s = this.drawList[this.drawCount];
            this.drawCount++;
            drawStreamer(s.sx, s.sy, s.ex, s.ey, s.c);
        }
        if (this.drawCount < this.total) {
            setTimeout(function() {
                fl[id].render();
            }, 40);
        }
        setTimeout(function() {
            fl[id].erase();
        }, 300);
    }

    this.erase = function() {
        var color = 'rgb(' + 0 + ',' + 0 + ',' + 0 + ')';
        for (var i = 0; i < this.segments; i++) {
            var s = this.drawList[this.eraseCount];
            this.eraseCount++;
            drawStreamer(s.sx, s.sy, s.ex, s.ey, color);
        }
    }
}

function start(w, h) {
    var num = Math.ceil(Math.random() * maxRockets);

    canvas.clearRect(0, 0, w, h);
    if (running) {
        for (var i = it; i < it + num; i++) {
            fl[i] = new flash(w, h, segments, i);
            fl[i].buildSegmentList();
            fl[i].render();
        }
        it += num;
        setTimeout(function() {
            start(w, h);
        }, wait);
    }
}

function stop() {
    running = false;
    alert('stopped');
}
;

var initFireworks = function() {
    var w, h, wc, hc, top, left;

    w = $(document).width();
    h = $(document).height();

    wc = w / 2;
    hc = h / 2;

    $("#aCanvas").css({
        'position': 'absolute',
        'width': wc,
        'height': hc,
        'border-radius': '12px'
    });

    canvas = $("#aCanvas")[0].getContext('2d');
    canvas.canvas.width = wc;
    canvas.canvas.height = hc;

    var left = (w - $("#aCanvas").width()) / 2;
    var top = (h - $("#aCanvas").height()) / 2;

    $("#aCanvas").css({
        'left': left,
        'top': top
    });

    start(wc, hc);
}

var isCanvasSupported = function() {
    var elem = document.createElement('canvas');
    return !!(elem.getContext && elem.getContext('2d'));
}

window.onresize = function(e)
{
    location.reload();
};

$(document).ready(function() {
    if (isCanvasSupported()) {
        initFireworks();
    }
});