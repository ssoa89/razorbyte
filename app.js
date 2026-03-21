const textos = [
  "agilidade natural",
  "precisão digital",
  "tecnologia avançada"
];

let i = 0; // texto atual
let j = 0; // letra atual
let apagando = false;

function escrever() {
  const elemento = document.getElementById("typing");

  if (!apagando) {
    elemento.innerHTML = textos[i].substring(0, j++);
    
    if (j > textos[i].length) {
      apagando = true;
      setTimeout(escrever, 1500);
      return;
    }
  } else {
    elemento.innerHTML = textos[i].substring(0, j--);
    
    if (j < 0) {
      apagando = false;
      i = (i + 1) % textos.length;
    }
  }

  setTimeout(escrever, apagando ? 50 : 100);
}

escrever();


/* coisa chegano */

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    // Se o elemento está visível na tela...
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    } else {
      // Opcional: remover a classe se quiser que a animação 
      // aconteça toda vez que o usuário subir e descer.
      // entry.target.classList.remove('show');
    }
  });
});

// Seleciona tudo que deve ser animado
const elements = document.querySelectorAll('.hidden');
elements.forEach((el) => observer.observe(el));