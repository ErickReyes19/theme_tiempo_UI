(function () {
  const toggle = document.querySelector('.tn-drawer-toggle');
  const drawer = document.getElementById('tn-mobile-drawer');
  if (!toggle || !drawer) return;

  toggle.addEventListener('click', function () {
    const expanded = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!expanded));
    drawer.hidden = expanded;
    drawer.classList.toggle('is-open', !expanded);
  });
})();
