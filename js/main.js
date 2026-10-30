// Skrivmaskinseffekt i rubriken på startsidan
(function () {
  var el = document.querySelector('.typed');
  if (!el) return;
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var words = el.getAttribute('data-words').split('|');
  var w = 1; // börja med "Förmå." som redan visas
  var text = words[w];
  var deleting = true;

  function tick() {
    if (deleting) {
      text = text.slice(0, -1);
      if (!text) { deleting = false; w = (w + 1) % words.length; }
    } else {
      text = words[w].slice(0, text.length + 1);
      if (text === words[w]) { deleting = true; el.textContent = text; return setTimeout(tick, 2200); }
    }
    el.textContent = text;
    setTimeout(tick, deleting ? 70 : 150);
  }
  setTimeout(tick, 2200);
})();

// Summa i beställningsformuläret
(function () {
  var antal = document.getElementById('antal');
  var summa = document.getElementById('summa');
  if (!antal || !summa) return;
  function update() {
    var n = Math.max(0, parseInt(antal.value, 10) || 0);
    summa.textContent = 'Summa: ' + (n * 595).toLocaleString('sv-SE') + ' SEK + frakt';
  }
  antal.addEventListener('input', update);
  update();
})();

// Felmeddelande om beställningen inte gick igenom
(function () {
  var el = document.getElementById('form-status');
  if (!el) return;
  if (new URLSearchParams(location.search).get('status') === 'error') {
    el.className = 'notice';
    el.textContent = 'Något gick fel. Kontrollera att alla obligatoriska fält är ifyllda och försök igen, eller mejla goddag@bhs-konstverket.se.';
  }
})();

// Årtal i sidfoten
(function () {
  var y = document.getElementById('year');
  if (y) y.textContent = new Date().getFullYear();
})();
