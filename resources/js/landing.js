const historia = document.querySelector("[data-video-story]");
const video = document.querySelector("[data-hero-video]");

if (historia && video) {
    let objetivo = 0;

    const actualizar = () => {
        const recorrido = historia.offsetHeight - window.innerHeight;
        const progreso = Math.min(
            1,
            Math.max(0, -historia.getBoundingClientRect().top / recorrido),
        );
        historia.style.setProperty("--story-progress", progreso);
        if (Number.isFinite(video.duration)) {
            objetivo = progreso * Math.max(0, video.duration - 0.05);
        }
    };

    const animar = () => {
        if (
            video.readyState >= 2 &&
            Math.abs(video.currentTime - objetivo) > 0.02
        ) {
            video.currentTime += (objetivo - video.currentTime) * 0.18;
        }
        requestAnimationFrame(animar);
    };

    video.addEventListener("loadeddata", () => video.classList.add("is-ready"));
    video.addEventListener("loadedmetadata", () => {
        video.currentTime = 0.01;
        actualizar();
    });

    window.addEventListener("scroll", actualizar, { passive: true });
    window.addEventListener("resize", actualizar);
    actualizar();
    requestAnimationFrame(animar);

    fetch(video.dataset.src)
        .then((respuesta) => respuesta.blob())
        .then((blob) => {
            video.src = URL.createObjectURL(blob);
        });
}
