"use strict";

Vue.component('Timer', {
  template: "\n  \t<div class=\"x_timer\">\n      <div class=\"day\">\n        <span class=\"number\">{{ days }}</span>\n        <div class=\"format\">{{ wordString.day }}</div>\n      </div>\n      <div class=\"separator\">/</div>\n      <div class=\"hour\">\n        <span class=\"number\">{{ hours }}</span>\n        <div class=\"format\">{{ wordString.hours }}</div>\n      </div>\n      <div class=\"separator\">/</div>\n      <div class=\"min\">\n        <span class=\"number\">{{ minutes }}</span>\n        <div class=\"format\">{{ wordString.minutes }}</div>\n      </div>\n      <div class=\"separator\">/</div>\n      <div class=\"sec\">\n        <span class=\"number\">{{ seconds }}</span>\n        <div class=\"format\">{{ wordString.seconds }}</div>\n      </div>\n    </div>\n  ",
  props: ['starttime', 'endtime', 'trans'],
  data: function data() {
    return {
      timer: "",
      wordString: {},
      start: "",
      end: "",
      interval: "",
      days: "",
      minutes: "",
      hours: "",
      seconds: "",
      message: "",
      statusType: "",
      statusText: ""
    };
  },
  created: function created() {
    this.wordString = JSON.parse(this.trans);
  },
  mounted: function mounted() {
    var _this = this;

    this.start = new Date(this.starttime).getTime();
    this.end = new Date(this.endtime).getTime(); // Update the count down every 1 second

    this.timerCount(this.start, this.end);
    this.interval = setInterval(function () {
      _this.timerCount(_this.start, _this.end);
    }, 1000);
  },
  methods: {
    timerCount: function timerCount(start, end) {
      // Get todays date and time
      var now = new Date().getTime(); // Find the distance between now an the count down date

      var distance = start - now;
      var passTime = end - now;

      if (distance < 0 && passTime < 0) {
        this.message = this.wordString.expired;
        clearInterval(this.interval);
        return false;
      } else if (distance < 0 && passTime > 0) {
        this.calcTime(passTime);
      } else if (distance > 0 && passTime > 0) {
        this.calcTime(distance);
      }
    },
    calcTime: function calcTime(dist) {
      // Time calculations for days, hours, minutes and seconds
      this.days = this.fillNumber(Math.floor(dist / (1000 * 60 * 60 * 24)), 2);
      this.hours = this.fillNumber(Math.floor(dist % (1000 * 60 * 60 * 24) / (1000 * 60 * 60)), 2);
      this.minutes = this.fillNumber(Math.floor(dist % (1000 * 60 * 60) / (1000 * 60)), 2);
      this.seconds = this.fillNumber(Math.floor(dist % (1000 * 60) / 1000), 2);
      if (this.days > 99) this.days = 99;
    },
    fillNumber: function fillNumber(num, max) {
      max = typeof max === 'undefined' ? 4 : max;
      var currentLetters = num.toString().length;

      while (currentLetters < max) {
        num = "0".concat(num);
        currentLetters++;
      }

      return num;
    }
  }
});