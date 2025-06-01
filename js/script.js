document.addEventListener("DOMContentLoaded", function () {
  console.log("Script loaded!");

  // 🔹 Переключение видимости пароля
  function toggleVisibility(buttonId, inputId) {
      const button = document.getElementById(buttonId);
      const input = document.getElementById(inputId);

      if (button && input) {
          button.addEventListener("click", function () {
              const type = input.getAttribute("type") === "password" ? "text" : "password";
              input.setAttribute("type", type);
              this.classList.toggle("bx-show");
              this.classList.toggle("bx-hide");
          });
      }
  }

  toggleVisibility("togglePassword", "password");
  toggleVisibility("toggleConfirmPassword", "confirm-password");

  // 🔹 Анимация появления изображений при скролле
  let images = document.querySelectorAll(".cards img");

  function checkScroll() {
      images.forEach((img) => {
          let rect = img.getBoundingClientRect();
          if (rect.top < window.innerHeight - 100) {
              img.style.opacity = "1";
              img.style.transform = "translateX(0)";
          }
      });
  }

  checkScroll();
  window.addEventListener("scroll", checkScroll);
});

// 🔹 Параллакс-эффект для picture4.svg
document.addEventListener("mousemove", function(e) {
    const img = document.querySelector('.parallax-img');
    if (!img) return;
    // Настрой интенсивность параллакса:
    const intensity = 20; // меньше — сильнее эффект, больше — слабее
    const rotateIntensity = 40; // меньше — сильнее вращение

    const x = (window.innerWidth / 2 - e.clientX) / intensity;
    const y = (window.innerHeight / 2 - e.clientY) / intensity;
    const rotateY = (window.innerWidth / 2 - e.clientX) / rotateIntensity;
    const rotateX = (window.innerHeight / 2 - e.clientY) / rotateIntensity;

    img.style.transform = `
        translate(${x}px, ${y}px)
        rotateY(${rotateY}deg)
        rotateX(${-rotateX}deg)
    `;
});

let cards = document.querySelectorAll(".block");

function checkScroll() {
    let windowHeight = window.innerHeight;

    cards.forEach((card, index) => {
        let rect = card.getBoundingClientRect();
        let nextCard = cards[index + 1];

        // Показываем карточку, когда она входит в видимость
        if (rect.top < windowHeight * 0.8) {
            card.classList.add("visible");
        }

        // Скрываем карточку, если на неё накладывается следующая
        if (nextCard) {
            let nextRect = nextCard.getBoundingClientRect();
            if (nextRect.top < rect.bottom - 30) {
                card.classList.add("hidden");
            } else {
                card.classList.remove("hidden");
            }
        }
    });
}

checkScroll();
window.addEventListener("scroll", checkScroll);