// Pilih semua elemen yang memiliki kelas "hidden"
const hiddenElements = document.querySelectorAll('.hidden');

// Buat Observer
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('show'); // Tambahkan kelas "show" saat terlihat
            observer.unobserve(entry.target); // Setelah muncul, berhenti mengamati
        }
    });
}, { threshold: 0.1 }); // 10% dari elemen harus terlihat untuk memicu animasi

// Observasi setiap elemen
hiddenElements.forEach(el => observer.observe(el));

// Menambahkan event listener untuk highlight pada card
document.addEventListener("DOMContentLoaded", () => {
    const teamCards = document.querySelectorAll(".chef-card");

    teamCards.forEach(card => {
        card.addEventListener("click", () => {
            // Hapus highlight dari semua card
            teamCards.forEach(c => c.classList.remove("highlight"));
            
            // Tambahkan highlight ke card yang diklik
            card.classList.add("highlight");
        });
    });
});

