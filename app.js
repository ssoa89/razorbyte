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
const box = document.querySelector(".hero-text-box");

box.addEventListener("mousemove", (e) => {
    const { x, y } = box.getBoundingClientRect();
    const mouseX = e.clientX - x;
    const mouseY = e.clientY - y;

    // Cria um efeito de lanterna que segue o mouse dentro do fundo
    box.style.background = `radial-gradient(
        circle at ${mouseX}px ${mouseY}px, 
        rgba(90, 180, 253, 0.15) 0%, 
        transparent 80%
    )`;
});

box.addEventListener("mouseleave", () => {
    box.style.background = "rgba(255, 255, 255, 0.03)";
});

   