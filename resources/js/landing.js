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

// Mapa de Google Maps con la ubicación del taller.
const mapa = document.querySelector("[data-map]");

if (mapa) {
    const { lat, lng, title, key } = mapa.dataset;
    const aviso = document.querySelector("[data-map-fallback]");

    const mostrarAviso = () => {
        mapa.hidden = true;
        if (aviso) aviso.hidden = false;
    };

    if (!key) {
        mostrarAviso();
    } else {
        // Google llama a esta función si la clave es inválida o está mal restringida.
        window.gm_authFailure = mostrarAviso;

        // Google llama a esta función cuando termina de cargar su script.
        window.iniciarMapa = async () => {
            try {
                const centro = { lat: Number(lat), lng: Number(lng) };
                const { Map } = await google.maps.importLibrary("maps");
                const { AdvancedMarkerElement } =
                    await google.maps.importLibrary("marker");

                const mapaGoogle = new Map(mapa, {
                    center: centro,
                    zoom: 15,
                    mapId: "DEMO_MAP_ID",
                    mapTypeControl: false,
                    streetViewControl: false,
                });

                new AdvancedMarkerElement({
                    map: mapaGoogle,
                    position: centro,
                    title,
                });
            } catch (error) {
                console.error("No se pudo mostrar el mapa:", error);
                mostrarAviso();
            }
        };

        const script = document.createElement("script");
        script.src =
            "https://maps.googleapis.com/maps/api/js?key=" +
            encodeURIComponent(key) +
            "&loading=async&callback=iniciarMapa";
        script.async = true;
        script.onerror = mostrarAviso;
        document.head.appendChild(script);
    }
}
