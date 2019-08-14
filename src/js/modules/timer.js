Vue.component('Timer', {
    template: `
  	<div class="x_timer">
      <div class="day">
        <span class="number">{{ days }}</span>
        <div class="format">{{ wordString.day }}</div>
      </div>
      <div class="separator">/</div>
      <div class="hour">
        <span class="number">{{ hours }}</span>
        <div class="format">{{ wordString.hours }}</div>
      </div>
      <div class="separator">/</div>
      <div class="min">
        <span class="number">{{ minutes }}</span>
        <div class="format">{{ wordString.minutes }}</div>
      </div>
      <div class="separator">/</div>
      <div class="sec">
        <span class="number">{{ seconds }}</span>
        <div class="format">{{ wordString.seconds }}</div>
      </div>
    </div>
  `,
    props: ['starttime', 'endtime', 'trans'],
    data: function () {
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
            statusText: "",

        };
    },
    created: function () {
        this.wordString = JSON.parse(this.trans);
    },
    mounted() {
        this.start = new Date(this.starttime).getTime();
        this.end = new Date(this.endtime).getTime();
        // Update the count down every 1 second
        this.timerCount(this.start, this.end);
        this.interval = setInterval(() => {
            this.timerCount(this.start, this.end);
        }, 1000);
    },
    methods: {
        timerCount: function (start, end) {
            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now an the count down date
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
        calcTime: function (dist) {
            // Time calculations for days, hours, minutes and seconds
            this.days = this.fillNumber(Math.floor(dist / (1000 * 60 * 60 * 24)), 2);
            this.hours = this.fillNumber(Math.floor((dist % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)), 2);
            this.minutes = this.fillNumber(Math.floor((dist % (1000 * 60 * 60)) / (1000 * 60)), 2);
            this.seconds = this.fillNumber(Math.floor((dist % (1000 * 60)) / 1000), 2);

            if(this.days > 99) this.days = 99;
        },
        fillNumber(num, max) {
            max = (typeof max === 'undefined') ? 4 : max;
            let currentLetters = num.toString().length;
            while (currentLetters < max) {
                num = `0${num}`;
                currentLetters++;
            }
            return num;
        }
    }
});