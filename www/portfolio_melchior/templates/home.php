<?php
function ignoreSpecificTags($html, $tag = 'div') {
    return preg_replace('/<\/?' . $tag . '[^>]*>/', '', $html);
}
function stripHtmlTags($html) {
    return strip_tags($html);
}

include 'components/header.php';
include 'send_mail.php';
?>

<section id="biography">
    <div class="bg-gray p-5">
        <div class="container">
            <div class="row">
                <h2 class="text-center font-family-della-respira titre-glob mb-5"><?= $content[0]['title_bio']; ?></h2>
                <div class="col-md-7">
                    <p class="font-family-montserrat font-weight-semi-bold color-dark-blue fs-15px">
                    <?= ignoreSpecificTags($content[0]['description_bio'], 'div'); ?>
                    </p>
                </div>
                <div class="col-md-5">
                    <img src="/portfolio_melchior/public/img/melchior_1024.jpg" alt="Image photo de profil Melchior" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="<?= $content[0]['video_bio']; ?>" allow="autoplay; fullscreen" allowfullscreen></iframe>
    </div>
</div>
</section>

<section id="mes-oeuvres">
<div class="bg-gray p-0 mt-5 p-md-5">
        <?php
        include 'components/artworks.php';
        ?>
    </div>
</section>

<section id="contact" class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 class="contact-title titre-glob">Formulaire de contact</h2>
                <form id="contactForm" class="contact-form">
                    <div class="form-group">
                        <label for="name">Votre nom</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Votre nom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse mail</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Adresse mail" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Sujet</label>
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Sujet" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Votre message</label>
                        <textarea id="message" name="message" class="form-control" rows="4" placeholder="Votre message" required></textarea>
                    </div>
                    <p id="formMessage" style="display:none; color: green;"></p>
                    <button type="submit" class="contact-submit-btn">Envoyer</button>
                </form>

            </div>
            <div class="col-md-6 container-social">
                <h3 class="contact-social-title">Réseaux sociaux</h3>
                <ul class="contact-social-list">
                    <li><a href="javascript:void(0);" class="contact-social-link"><i class="fas fa-envelope"></i></a></li>
                    <li><a href="https://www.instagram.com/melchior_reynaud/" class="contact-social-link" target="_blank"><i class="fab fa-instagram"></i></a></li>
                    <li><a href="https://soundcloud.com/melchiorcompositeur" class="contact-social-link" target="_blank"><i class="fab fa-soundcloud"></i></a></li>
                    <li><a href="https://open.spotify.com/intl-fr/artist/1EcY671rk7p6B1BhKlTIPn?si=6RefckL3SDufBFfqzHjghQ" class="contact-social-link" target="_blank"><i class="fab fa-spotify"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('contactForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const submitBtn = this.querySelector('button[type="submit"]');
    const formMessage = document.getElementById('formMessage');
    const formData = new FormData(this);

    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi en cours...';
    submitBtn.disabled = true;

    fetch('index.php?ajaxRequest=sendMail', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(data => {
        formMessage.style.display = 'block';

        if (data.includes('succès')) {
            formMessage.style.color = 'green';
            formMessage.textContent = "Votre message a été envoyé avec succès.";
            this.reset();
        } else {
            formMessage.style.color = 'red';
            formMessage.textContent = "Une erreur est survenue. Veuillez réessayer.";
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        formMessage.style.display = 'block';
        formMessage.style.color = 'red';
        formMessage.textContent = "Une erreur de connexion est survenue. Veuillez réessayer.";
    })
    .finally(() => {
        submitBtn.innerHTML = 'Envoyer';
        submitBtn.disabled = false;
    });
});
</script>
