document.querySelectorAll("[data-scroll-video]").forEach(async (seccion) => {
    const video = seccion.querySelector("video");
    let objetivo = 0;
    let actual = 0;

    const calcular = () => {
        const rect = seccion.getBoundingClientRect();
        const recorrido = seccion.offsetHeight - window.innerHeight;
        const progreso = Math.min(Math.max(-rect.top / recorrido, 0), 1);
        objetivo = progreso * video.duration;
    };

    const animar = () => {
        actual += (objetivo - actual) * 0.1;
        if (Math.abs(video.currentTime - actual) > 0.01) {
            video.currentTime = actual;
        }
        requestAnimationFrame(animar);
    };

    video.addEventListener("loadedmetadata", () => {
        calcular();
        animar();
    });

    window.addEventListener("scroll", calcular, { passive: true });

    const respuesta = await fetch(video.dataset.src);
    const blob = await respuesta.blob();
    video.src = URL.createObjectURL(blob);
});
