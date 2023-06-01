const links = document.querySelectorAll('#droit a');

links.forEach(link => {
  link.addEventListener('click', e => {
    e.preventDefault();

    const target = document.querySelector(link.getAttribute('href'));
    const sections = document.querySelectorAll('.pr');
    sections.forEach(section => section.style.display = 'none');
    target.style.display = 'block';
    target.style.height = '100vh';
  });
});


const toggleSwitch = document.querySelector('#toggle');

// Fonction pour basculer le thème
function switchTheme(e) {
  if (e.target.checked) {
    document.documentElement.setAttribute('data-theme', 'dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.setAttribute('data-theme', 'light');
    localStorage.setItem('theme', 'light');
  }    
}

// Écouter l'événement de changement d'état du bouton bascule
toggleSwitch.addEventListener('change', switchTheme, false);

// Vérifier le thème actuel au chargement de la page
if (localStorage.getItem('theme') === 'dark') {
  document.documentElement.setAttribute('data-theme', 'dark');
  toggleSwitch.checked = true;
}