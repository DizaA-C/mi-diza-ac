document.addEventListener("DOMContentLoaded", () => {
    // Modo Oscuro/Claro
    const toggleThemeBtn = document.getElementById("toggle-theme");
    const body = document.body;
    const currentTheme = localStorage.getItem("theme") || "light";
    body.classList.add(currentTheme);

    toggleThemeBtn.addEventListener("click", () => {
        body.classList.toggle("dark-mode");
        const newTheme = body.classList.contains("dark-mode") ? "dark-mode" : "light";
        localStorage.setItem("theme", newTheme);
    });

    // Animaciones al hacer scroll
    const scrollElements = document.querySelectorAll(".scroll-animation");
    const scrollHandler = () => {
        scrollElements.forEach(el => {
            if (el.getBoundingClientRect().top < window.innerHeight * 0.85) {
                el.classList.add("visible");
            }
        });
    };
    window.addEventListener("scroll", scrollHandler);
    scrollHandler();

    // Resaltar sección activa en el menú
    const sections = document.querySelectorAll("section");
    const navLinks = document.querySelectorAll("nav ul li a");
    
    window.addEventListener("scroll", () => {
        let current = "";
        sections.forEach(section => {
            const sectionTop = section.offsetTop - 50;
            if (window.scrollY >= sectionTop) {
                current = section.getAttribute("id");
            }
        });
        navLinks.forEach(link => {
            link.classList.remove("active");
            if (link.getAttribute("href").includes(current)) {
                link.classList.add("active");
            }
        });
    });

    // Carrusel de imágenes avanzado
    const carousel = document.querySelector(".carousel");
    if (carousel) {
        let index = 0;
        const slides = document.querySelectorAll(".carousel-item");
        setInterval(() => {
            slides.forEach(slide => slide.classList.remove("active"));
            slides[index].classList.add("active");
            index = (index + 1) % slides.length;
        }, 3000);
    }

    // Formulario de Contacto con efecto de validación en tiempo real
    const form = document.querySelector(".contact-form");
    if (form) {
        const nameInput = document.getElementById("name");
        const emailInput = document.getElementById("email");
        const messageInput = document.getElementById("message");
        const errorDiv = document.querySelector(".form-error");
        const successDiv = document.querySelector(".form-success");

        const validateInput = () => {
            if (!nameInput.value.trim() || !emailInput.value.trim() || !messageInput.value.trim()) {
                errorDiv.textContent = "Por favor, completa todos los campos.";
                errorDiv.style.display = "block";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value)) {
                errorDiv.textContent = "Por favor, ingresa un correo válido.";
                errorDiv.style.display = "block";
            } else {
                errorDiv.style.display = "none";
            }
        };
        
        nameInput.addEventListener("input", validateInput);
        emailInput.addEventListener("input", validateInput);
        messageInput.addEventListener("input", validateInput);

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            validateInput();
            if (errorDiv.style.display === "none") {
                successDiv.textContent = "¡Mensaje enviado con éxito!";
                successDiv.style.display = "block";
                form.reset();
            }
        });
    }

    // Botón Volver Arriba con animación
    const backToTopBtn = document.getElementById("back-to-top");
    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            backToTopBtn.classList.add("visible");
        } else {
            backToTopBtn.classList.remove("visible");
        }
    });
    backToTopBtn.addEventListener("click", () => {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    // Menú móvil desplegable
    const menuToggle = document.getElementById("menu-toggle");
    const navMenu = document.querySelector(".nav-menu");
    if (menuToggle) {
        menuToggle.addEventListener("click", () => {
            navMenu.classList.toggle("open");
        });
    }

    // Efectos de hover interactivos
    const hoverElements = document.querySelectorAll(".hover-effect");
    hoverElements.forEach(el => {
        el.addEventListener("mouseenter", () => {
            el.classList.add("hovered");
        });
        el.addEventListener("mouseleave", () => {
            el.classList.remove("hovered");
        });
    });
});

