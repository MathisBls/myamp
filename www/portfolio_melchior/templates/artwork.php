<?php
function ignoreSpecificTags($html, $tag = 'div') {
    return preg_replace('/<\/?' . $tag . '[^>]*>/', '', $html);
}
function stripHtmlTags($html) {
    return strip_tags($html);
}
include 'components/header.php';
?>

<section id="artwork" class="bg-gray p-0 p-md-5">
    <div class="container-fluid mb-5">
        <div class="row">
            <?php if (isset($selectedArtwork) && isset($_GET['id'])): ?>
                <h1 class="text-center font-family-della-respira titre-glob mb-5"><?= htmlspecialchars($selectedArtwork['title']); ?></h1>
                <div class="col-md-6">
                    <img src="<?= htmlspecialchars($selectedArtwork['main_image']); ?>" class="artwork-main-image" alt="<?= htmlspecialchars($selectedArtwork['title']); ?>">
                </div>
                <div class="col-md-6">
                <div class="audio-player mb-4">
                <button class="play-pause" id="play-pause">
                    <i class="fas fa-play"></i>
                </button>
                <div class="progress-container">
                    <div class="progress" id="progress"></div>
                </div>
                <span class="current-time" id="current-time">0:00</span>
                <span class="duration" id="duration">0:00</span>
            </div>
            <audio id="audio" src="<?= htmlspecialchars($selectedArtwork['audio_artwork']); ?>" type="audio/mpeg"></audio>
                    <p class="font-family-montserrat fs-15px">
                        <?= ignoreSpecificTags($selectedArtwork['description'], 'div'); ?>
                    </p>
                </div>
            <?php else: ?>
                <p>Aucune œuvre sélectionnée. Veuillez choisir une œuvre à partir des filtres.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php include 'components/artworks.php'; ?>
</section>
<script>
const audio = document.getElementById('audio');
const playPauseBtn = document.getElementById('play-pause');
const progressContainer = document.querySelector('.progress-container');
const progress = document.getElementById('progress');
const currentTimeEl = document.getElementById('current-time');
const durationEl = document.getElementById('duration');

playPauseBtn.addEventListener('click', () => {
    if (audio.paused) {
        audio.play();
        playPauseBtn.innerHTML = '<i class="fas fa-pause"></i>';
    } else {
        audio.pause();
        playPauseBtn.innerHTML = '<i class="fas fa-play"></i>';
    }
});

audio.addEventListener('timeupdate', () => {
    const currentTime = audio.currentTime;
    const duration = audio.duration;

    const progressPercentage = (currentTime / duration) * 100;
    progress.style.width = `${progressPercentage}%`;

    currentTimeEl.innerText = formatTime(currentTime);
    durationEl.innerText = formatTime(duration);
});

progressContainer.addEventListener('click', (event) => {
    const rect = progressContainer.getBoundingClientRect();
    const clickX = event.clientX - rect.left;
    const percentage = clickX / progressContainer.offsetWidth;

    audio.currentTime = percentage * audio.duration;
});

function formatTime(seconds) {
    const minutes = Math.floor(seconds / 60);
    const secs = Math.floor(seconds % 60);
    return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
}

</script>
