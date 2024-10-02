import webbrowser
from pystray import Icon, Menu, MenuItem
from PIL import Image
import subprocess
import sys

# Fonction pour ouvrir phpMyAdmin
def open_phpmyadmin(icon, item):
    webbrowser.open('http://localhost/phpmyadmin/index.php')

# Fonction pour ouvrir localhost
def open_localhost(icon, item):
    webbrowser.open('http://localhost/index.php')

# Fonction pour quitter l'application
def quit_app(icon, item):
    icon.stop()

# Charger une icône pour la barre des tâches
image = Image.open("icon.png")

# Créer le menu contextuel
menu = Menu(
    MenuItem("Ouvrir phpMyAdmin", open_phpmyadmin),
    MenuItem("Ouvrir localhost", open_localhost),
    MenuItem("Quitter", quit_app)
)

# Créer l'icône de la barre des tâches
icon = Icon("MyAMP", image, menu=menu)

# Démarrer l'application
icon.run()
