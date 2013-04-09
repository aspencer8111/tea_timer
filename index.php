<!DOCTYPE HTML>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Tea Timers - The Societea</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Tea Timers">
    <meta name="author" content="Aaron L. Krauss">
    <link rel="stylesheet" href="assets/css/cyborg_bootstrap.css">
    <script src="assets/js/sprintf.js" type="text/javascript"></script>
    <script src="assets/js/howler.js" type="text/javascript"></script>
    <!--<script src="assets/js/cookies.js" type="text/javascript"></script>-->
    <style>
      body { padding-top: 60px; } /* 60px to make the container go all the way to the bottom of the topbar */
    </style>
    <link rel="shortcut icon" href="favicon.ico">
    <script type="text/javascript">

      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-38589428-1']);
      _gaq.push(['_setDomainName', 'thesocietea.org']);
      _gaq.push(['_trackPageview']);

      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();

    </script>
    <script type="text/javascript">
    // set minutes
    //var mins;

    // calculate the seconds (don't change this! unless time progresses at a different speed for you...)
    //var secs = mins * 60;
    var timer;
    var sound = new Howl({
      urls: ['assets/bell.mp3'],
    });
    var time_array = [
      [.1, 2.5, 3],
      [2, 2.5, 3],
      [2, 2.5, 3],
      [2, 2.5, 3],
      [3, 5, null],
      [3, 4, 5],
      [4, 7, null],
      [3.5, 4.5, 7],
      [4, 7, null]];

    function on_load(){
      for(var x=1;x<=4;x++){
        if(getCookie(sprintf("tea%d",x))!= null){
          //alert(sprintf("tea%d",x));
          document.getElementById(sprintf("tea%d",x)).selectedIndex = getCookie(sprintf("tea%d",x));
        }
        if(getCookie(sprintf("steeping%d",x))!= null){
          document.getElementById(sprintf("steeping%d",x)).selectedIndex = getCookie(sprintf("steeping%d",x));
        }
      }
    }

    function Decrement(num) {
      //alert(sprintf("%01d : %02d", getminutes(), getseconds()));
      div = document.getElementById(sprintf("time%d", num));
      if (document.getElementById) {
        div.innerText = sprintf("%01d : %02d", getminutes(), getseconds());
        if(secs == 0){
          clearTimeout(timer);
          sound.play();
          div.style.color = "#ff0000";
        }else{
          secs--;
          timer = setTimeout(sprintf('Decrement(%d)', num), 1000);
        }
      }
    }
    function getminutes() {
      // minutes is seconds divided by 60, rounded down
      mins = Math.floor(secs / 60);
      return mins;
    }
    function getseconds() {
      // take mins remaining (as seconds) away from total seconds remaining
      return secs-Math.round(mins *60);
    }

    function setCookie(c_name,value,exdays)
    {
      var exdate=new Date();
      exdate.setDate(exdate.getDate() + exdays);
      var c_value=escape(value) + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
      document.cookie=c_name + "=" + c_value;
    }

    function getCookie(c_name)
    {
      var i,x,y,ARRcookies=document.cookie.split(";");
      for (i=0;i<ARRcookies.length;i++)
      {
        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x=x.replace(/^\s+|\s+$/g,"");
        if (x==c_name)
          {
            return unescape(y);
          }
      }
     }

    function countdown(num) {
      clear_all(num);
      tea = document.getElementById(sprintf("tea%d", num));
      steeping = document.getElementById(sprintf("steeping%d", num));
      setCookie(sprintf("tea%d", num), tea.selectedIndex, 30);
      setCookie(sprintf("steeping%d", num), steeping.selectedIndex, 30);
      mins = time_array[tea.selectedIndex-1][steeping.selectedIndex-1]
      secs = mins * 60;
      timer = setTimeout(sprintf('Decrement(%d)', num),1000);
    }

    function clear_all(num) {
      time = document.getElementById(sprintf("time%d", num));
      time.style.color = "#999999";
      clearTimeout(timer);
      time.innerText = "0 : 00";
    }
    </script>
  </head>
  <body onload="on_load()">
    <div class="form-horizontal custom_body">
      <a style="margin-right: 10px;" class="pull-left btn btn-small btn-inverse" href="http://www.thesocietea.org/tea/">Back<i class="icon-white"></i></a>
    </div>
    <br />
    <header class="jumbotron">
      <h1 style="text-align: center; text-style: italic">Tea Timers</h1>
      <span class="" style="text-align: center;"> 
        <address>
        <a href="http://www.thesocietea.org" target="_blank">www.thesocietea.org</a><br />
        <a href="mailto:info@thesocietea.org">info@thesocietea.org</a><br />
        </address>
      </span>
<?php
  display_divs(1);
  display_divs(2);
  display_divs(3);
  display_divs(4);
?>
    </header>
  </body>
</html>

<?php

function display_divs($num){
  echo '
      <div class="custom_body_timer' . $num . '">
        <form>
          <div class="controls controls-row">
            <select id="tea' . $num . '">
              <option>Tea</option>
              <option>White</option>
              <option>Green</option>
              <option>Yellow</option>
              <option>Oolong</option>
              <option>Black</option>
              <option>Pu-erh</option>
              <option>Rooibos</option>
              <option>Mate</option>
              <option>Herbal</option>
            </select>
            <select id="steeping' . $num . '">
              <option>Steeping</option>
              <option>First</option>
              <option>Second</option>
              <option>Third</option>
            </select>
          </div>
          <button type="button" class="btn btn-warning" onclick="countdown(' . $num . ')">Start</button>
          <button type="button" class="btn btn-warning" onclick="clear_all(' . $num . ')">Clear</button>
        </form>
        <div id="time' . $num . '" class="timer_class">0 : 00</div>
      </div>';
}

?>
