(function(){
  function qs(s,c){return (c||document).querySelector(s)}
  // Countdown
  var el=qs('.otnt-countdown'); if(el){var d=el.getAttribute('data-deadline');
    function pad(n){return (n<10?'0':'')+n}
    function tick(){var dd=new Date(d.replace(' ','T'));var now=new Date();var ms=dd-now;var t=qs('.otnt-countdown__time',el);
      if(!t) return; if(ms<=0){t.textContent='Đã kết thúc'; return;}
      var s=Math.floor(ms/1000),hh=Math.floor(s/3600),mm=Math.floor((s%3600)/60),ss=s%60;
      t.textContent=pad(hh)+':'+pad(mm)+':'+pad(ss);} tick(); setInterval(tick,1000); }
  // Sticky bar
  var bar=qs('#otnt-sticky'), sum=qs('.entry-summary, .summary');
  if(bar&&sum&&'IntersectionObserver' in window){var io=new IntersectionObserver(function(es){es.forEach(function(e){
    bar.style.bottom=e.isIntersecting?'-90px':'0'; bar.setAttribute('aria-hidden', e.isIntersecting?'true':'false');
  });}); io.observe(sum);}
  // Video thumbs
  document.addEventListener('click',function(ev){var t=ev.target.closest('.otnt-video-thumb'); if(!t) return;
    var url=t.getAttribute('data-video'); if(url) window.open(url,'_blank','noopener');},false);
})();