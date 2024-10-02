import tkinter as tk
from tkinter import messagebox
import subprocess
import os
import glob
import sys
import webbrowser
import time

class ServerManagerApp:
    def __init__(self, master):
        self.master = master
        master.title("Server Manager")
        self.project_directory = "C:/tools/www"  # Dossier par défaut

        # Style de la fenêtre
        master.geometry("1000x600")
        master.configure(bg='#2E2E2E')

        # Sidebar (Liste des projets dans www)
        self.sidebar_frame = tk.Frame(master, bg='#3C3C3C', width=200)
        self.sidebar_frame.pack(side='left', fill='y')

        self.sidebar_label = tk.Label(self.sidebar_frame, text="PROJECTS", bg='#3C3C3C', fg='white', font=("Helvetica", 12))
        self.sidebar_label.pack(pady=10)

        self.site_listbox = tk.Listbox(self.sidebar_frame, bg='#3C3C3C', fg='white', font=("Helvetica", 10), height=20)
        self.site_listbox.pack(fill='y', padx=10, pady=5)

        # Charger les projets du dossier spécifié
        self.load_projects()

        # Header (boutons style MAMP)
        self.header_frame = tk.Frame(master, bg='#1F1F1F')
        self.header_frame.pack(fill='x')

        # Section des boutons Open Localhost et Settings
        self.top_frame = tk.Frame(master, bg='#2E2E2E')
        self.top_frame.pack(pady=10, fill='x')

        self.url_button = tk.Button(self.top_frame, text="Open Localhost", command=self.open_url, bg='#4CAF50', fg='white', width=15)
        self.url_button.pack(side='left', padx=10)

        self.settings_button = tk.Button(self.top_frame, text="Settings", command=self.open_settings_window, bg='#1E88E5', fg='white', width=15)
        self.settings_button.pack(side='right', padx=10)

        # Apache Server Status
        self.apache_frame = tk.Frame(master, bg='#2E2E2E')
        self.apache_frame.pack(pady=10, fill='x')

        self.apache_label = tk.Label(self.apache_frame, text="Apache Server", font=("Helvetica", 14), bg='#2E2E2E', fg='white')
        self.apache_label.grid(row=0, column=0, padx=20)

        self.apache_status = tk.Label(self.apache_frame, text="Stopped", font=("Helvetica", 12), bg='#2E2E2E', fg='red')
        self.apache_status.grid(row=0, column=1, padx=20)

        self.apache_start_button = tk.Button(self.apache_frame, text="Start Apache", command=self.start_apache, bg='#4CAF50', fg='white')
        self.apache_start_button.grid(row=1, column=0, padx=20, pady=5)

        self.apache_stop_button = tk.Button(self.apache_frame, text="Stop Apache", command=self.stop_apache, bg='#FF6B6B', fg='white')
        self.apache_stop_button.grid(row=1, column=1, padx=20, pady=5)
        self.apache_stop_button.config(state=tk.DISABLED)

        # MySQL Server Status
        self.mysql_frame = tk.Frame(master, bg='#2E2E2E')
        self.mysql_frame.pack(pady=10, fill='x')

        self.mysql_label = tk.Label(self.mysql_frame, text="MySQL Server", font=("Helvetica", 14), bg='#2E2E2E', fg='white')
        self.mysql_label.grid(row=0, column=0, padx=20)

        self.mysql_status = tk.Label(self.mysql_frame, text="Stopped", font=("Helvetica", 12), bg='#2E2E2E', fg='red')
        self.mysql_status.grid(row=0, column=1, padx=20)

        self.mysql_start_button = tk.Button(self.mysql_frame, text="Start MySQL", command=self.start_mysql, bg='#4CAF50', fg='white')
        self.mysql_start_button.grid(row=1, column=0, padx=20, pady=5)

        self.mysql_stop_button = tk.Button(self.mysql_frame, text="Stop MySQL", command=self.stop_mysql, bg='#FF6B6B', fg='white')
        self.mysql_stop_button.grid(row=1, column=1, padx=20, pady=5)
        self.mysql_stop_button.config(state=tk.DISABLED)

        # Logs Section
        self.log_frame = tk.Frame(master, bg='#2E2E2E')
        self.log_frame.pack(pady=10, fill='x')

        self.log_label = tk.Label(self.log_frame, text="Server Logs:", font=("Helvetica", 14), bg='#2E2E2E', fg='white')
        self.log_label.pack()

        self.log_text = tk.Text(self.log_frame, height=8, width=90, bg='#1F1F1F', fg='white')
        self.log_text.pack(fill='x')

        # Start updating buttons
        self.update_buttons()
        self.update_status()

        # Démarrer le system tray
        self.start_system_tray()

    def log(self, message):
        """Ajoute un message dans la section des logs."""
        self.log_text.insert(tk.END, message + "\n")
        self.log_text.see(tk.END)

    def load_projects(self):
        """Charge les projets depuis le dossier spécifié et cherche un index.php."""
        self.site_listbox.delete(0, tk.END)  # Efface la liste précédente
        project_paths = glob.glob(os.path.join(self.project_directory, "*"))
        projects = [os.path.basename(p) for p in project_paths if os.path.isdir(p)]
        self.project_mapping = {}  # Pour stocker les chemins vers index.php

        for project in projects:
            index_path = self.find_index_php(os.path.join(self.project_directory, project))
            if index_path:
                self.site_listbox.insert(tk.END, project)
                self.project_mapping[project] = index_path

    def find_index_php(self, project_path):
        """Cherche récursivement un fichier index.php dans le projet."""
        for root, dirs, files in os.walk(project_path):
            if 'index.php' in files:
                return root  # Retourne le chemin du dossier contenant index.php
        return None  # Aucun index.php trouvé

    def update_buttons(self):
        """Met à jour l'état des boutons selon le statut des serveurs."""
        if self.is_apache_running():
            self.apache_start_button.config(state=tk.DISABLED)
            self.apache_stop_button.config(state=tk.NORMAL)
            self.apache_status.config(text="Running", fg='green')
        else:
            self.apache_start_button.config(state=tk.NORMAL)
            self.apache_stop_button.config(state=tk.DISABLED)
            self.apache_status.config(text="Stopped", fg='red')

        if self.is_mysql_running():
            self.mysql_start_button.config(state=tk.DISABLED)
            self.mysql_stop_button.config(state=tk.NORMAL)
            self.mysql_status.config(text="Running", fg='green')
        else:
            self.mysql_start_button.config(state=tk.NORMAL)
            self.mysql_stop_button.config(state=tk.DISABLED)
            self.mysql_status.config(text="Stopped", fg='red')

    def update_status(self):
        """Met à jour le statut des serveurs toutes les 2 secondes."""
        self.update_buttons()
        self.master.after(2000, self.update_status)  # Vérifier toutes les 2 secondes

    def is_apache_running(self):
        result = subprocess.run(['tasklist'], capture_output=True, text=True)
        return 'httpd.exe' in result.stdout

    def is_mysql_running(self):
        result = subprocess.run(['tasklist'], capture_output=True, text=True)
        return 'mysqld.exe' in result.stdout

    def start_apache(self):
        self.log("Starting Apache...")
        subprocess.Popen(['httpd', '-k', 'start'])
        self.log("Apache started.")

    def stop_apache(self):
        self.log("Stopping Apache...")
        subprocess.Popen(['httpd', '-k', 'stop'])

        # Attendre que le serveur soit arrêté
        while self.is_apache_running():
            self.master.after(100)  # Attendre un court instant

        self.log("Apache stopped. Restarting...")
        self.start_apache()  # Redémarrer Apache

    def start_mysql(self):
        self.log("Starting MySQL...")
        try:
            subprocess.Popen(['mysqld', '--console'])
            self.log("MySQL started.")
        except Exception as e:
            self.log(f"Error starting MySQL: {e}")

    def stop_mysql(self):
        self.log("Stopping MySQL...")
        try:
            subprocess.run(['mysqladmin', 'shutdown'], check=True)
            self.log("MySQL stopped.")
        except subprocess.CalledProcessError as e:
            self.log(f"Error stopping MySQL: {e}")

        # Attendre que MySQL soit complètement arrêté
        while self.is_mysql_running():
            time.sleep(0.1)  # Attendre un court instant

    def open_url(self):
        selected_site = self.site_listbox.get(tk.ACTIVE)
        if selected_site:
            index_path = self.project_mapping.get(selected_site)
            if index_path:  # Vérifie si index.php a été trouvé
                # Construire l'URL en utilisant le chemin du projet
                url = f"http://localhost/{selected_site}/index.php"
                webbrowser.open(url)
            else:
                messagebox.showerror("Error", f"No index.php found for {selected_site}.")

    def open_settings_window(self):
        """Ouvre une fenêtre de paramètres pour modifier le dossier de projet."""
        settings_window = tk.Toplevel(self.master)
        settings_window.title("Settings")
        settings_window.geometry("300x150")

        def save_settings():
            new_directory = project_entry.get()
            if os.path.isdir(new_directory):
                self.project_directory = new_directory
                self.load_projects()
                settings_window.destroy()
            else:
                messagebox.showerror("Error", "Invalid directory. Please enter a valid path.")

        project_label = tk.Label(settings_window, text="Project Directory:")
        project_label.pack(pady=10)

        project_entry = tk.Entry(settings_window)
        project_entry.insert(0, self.project_directory)
        project_entry.pack(pady=5)

        save_button = tk.Button(settings_window, text="Save", command=save_settings)
        save_button.pack(pady=10)

    def start_system_tray(self):
        """Démarre le système de tray."""
        self.log("Starting system tray...")
        subprocess.Popen([sys.executable, 'system_tray.py'])

if __name__ == "__main__":
    root = tk.Tk()
    app = ServerManagerApp(root)
    root.mainloop()
