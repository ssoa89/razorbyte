
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

const canvas = document.getElementById("bg");
const ctx = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;

let particles = [];

// Criar partículas
for (let i = 0; i < 100; i++) {
  particles.push({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    vx: (Math.random() - 0.5) * 1,
    vy: (Math.random() - 0.5) * 1
  });
}

// Atualizar animação
function animate() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);

  // Desenhar partículas
  particles.forEach(p => {
    p.x += p.vx;
    p.y += p.vy;

    // rebater na tela
    if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
    if (p.y < 0 || p.y > canvas.height) p.vy *= -1;

    ctx.beginPath();
    ctx.arc(p.x, p.y, 2, 0, Math.PI * 2);
    ctx.fillStyle = "#00c3ff";
    ctx.fill();
  });

  // Linhas entre partículas
  for (let i = 0; i < particles.length; i++) {
    for (let j = i + 1; j < particles.length; j++) {
      let dx = particles[i].x - particles[j].x;
      let dy = particles[i].y - particles[j].y;
      let dist = Math.sqrt(dx * dx + dy * dy);

      if (dist < 120) {
        ctx.beginPath();
        ctx.moveTo(particles[i].x, particles[i].y);
        ctx.lineTo(particles[j].x, particles[j].y);
        ctx.strokeStyle = "rgba(0,195,255,0.2)";
        ctx.stroke();
      }
    }
  }

  requestAnimationFrame(animate);
}

animate();

// Ajustar ao redimensionar
window.addEventListener("resize", () => {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
});

   