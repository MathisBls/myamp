import tkinter as tk
import subprocess
import os
from tkinter import messagebox, simpledialog

class ServerManagerApp:
    def __init__(self, master):
        self.master = master
        master.title("Server Manager")

        # Style de la fenêtre
        master.geometry("800x600")
        master.configure(bg='#F0F0F0')

        # Header
        self.header_frame = tk.Frame(master, bg='#4CAF50')
        self.header_frame.pack(fill='x')

        self.header_label = tk.Label(self.header_frame, text="Server Manager", bg='#4CAF50', fg='white', font=("Helvetica", 18))
        self.header_label.pack(pady=10)

        # Status Apache
        self.apache_frame = tk.Frame(master, bg='#F0F0F0')
        self.apache_frame.pack(pady=10, fill='x')

        self.apache_label = tk.Label(self.apache_frame, text="Apache Server", font=("Helvetica", 14), bg='#F0F0F0')
        self.apache_label.grid(row=0, column=0, padx=20)

        self.apache_status = tk.Label(self.apache_frame, text="Stopped", font=("Helvetica", 12), bg='#F0F0F0', fg='red')
        self.apache_status.grid(row=0, column=1, padx=20)

        self.apache_start_button = tk.Button(self.apache_frame, text="Start Apache", command=self.start_apache)
        self.apache_start_button.grid(row=1, column=0, padx=20, pady=5)

        self.apache_stop_button = tk.Button(self.apache_frame, text="Stop Apache", command=self.stop_apache)
        self.apache_stop_button.grid(row=1, column=1, padx=20, pady=5)
        self.apache_stop_button.config(state=tk.DISABLED)

        # Status MySQL
        self.mysql_frame = tk.Frame(master, bg='#F0F0F0')
        self.mysql_frame.pack(pady=10, fill='x')

        self.mysql_label = tk.Label(self.mysql_frame, text="MySQL Server", font=("Helvetica", 14), bg='#F0F0F0')
        self.mysql_label.grid(row=0, column=0, padx=20)

        self.mysql_status = tk.Label(self.mysql_frame, text="Stopped", font=("Helvetica", 12), bg='#F0F0F0', fg='red')
        self.mysql_status.grid(row=0, column=1, padx=20)

        self.mysql_start_button = tk.Button(self.mysql_frame, text="Start MySQL", command=self.start_mysql)
        self.mysql_start_button.grid(row=1, column=0, padx=20, pady=5)

        self.mysql_stop_button = tk.Button(self.mysql_frame, text="Stop MySQL", command=self.stop_mysql)
        self.mysql_stop_button.grid(row=1, column=1, padx=20, pady=5)
        self.mysql_stop_button.config(state=tk.DISABLED)

        # Logs
        self.log_frame = tk.Frame(master, bg='#F0F0F0')
        self.log_frame.pack(pady=10, fill='x')

        self.log_label = tk.Label(self.log_frame, text="Server Logs:", font=("Helvetica", 14), bg='#F0F0F0')
        self.log_label.pack()

        self.log_text = tk.Text(self.log_frame, height=8, width=60)
        self.log_text.pack()

        # Boutons supplémentaires
        self.bottom_frame = tk.Frame(master, bg='#F0F0F0')
        self.bottom_frame.pack(pady=10, fill='x')

        self.url_button = tk.Button(self.bottom_frame, text="Open Localhost", command=self.open_url)
        self.url_button.pack(side='left', padx=10)

        self.settings_button = tk.Button(self.bottom_frame, text="Settings", command=self.open_settings_window)
        self.settings_button.pack(side='right', padx=10)

        # Démarrer la mise à jour automatique
        self.update_buttons()
        self.update_status()

    def log(self, message):
        """Ajoute un message dans la section des logs."""
        self.log_text.insert(tk.END, message + "\n")
        self.log_text.see(tk.END)

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
        self.log("Apache stopped.")

    def start_mysql(self):
        self.log("Starting MySQL...")
        subprocess.Popen(['mysqld', '--console'])
        self.log("MySQL started.")

    def stop_mysql(self):
        self.log("Stopping MySQL...")
        subprocess.run(['taskkill', '/IM', 'mysqld.exe', '/F'])
        self.log("MySQL stopped.")

    def open_url(self):
        """Ouvre l'URL localhost dans le navigateur."""
        os.system("start http://localhost/index.php")

    def open_settings_window(self):
        """Ouvre une nouvelle fenêtre pour les paramètres."""
        settings_window = tk.Toplevel(self.master)
        settings_window.title("Settings")
        settings_window.geometry("400x300")

        # Chemin d'Apache
        self.apache_path_label = tk.Label(settings_window, text="Apache Path:", font=("Helvetica", 12))
        self.apache_path_label.pack(pady=5)

        self.apache_path_entry = tk.Entry(settings_window, width=50)
        self.apache_path_entry.pack(pady=5)
        self.apache_path_entry.insert(0, "C:/path/to/apache")

        # Chemin de MySQL
        self.mysql_path_label = tk.Label(settings_window, text="MySQL Path:", font=("Helvetica", 12))
        self.mysql_path_label.pack(pady=5)

        self.mysql_path_entry = tk.Entry(settings_window, width=50)
        self.mysql_path_entry.pack(pady=5)
        self.mysql_path_entry.insert(0, "C:/path/to/mysql")

        # Changer de port
        self.change_port_button = tk.Button(settings_window, text="Change Port", command=self.change_port)
        self.change_port_button.pack(pady=10)

        # Installer un nouveau package PHP
        self.install_package_button = tk.Button(settings_window, text="Install PHP Package", command=self.install_php_package)
        self.install_package_button.pack(pady=10)

    def change_port(self):
        """Fonction pour changer le port du serveur Apache."""
        new_port = simpledialog.askstring("Change Port", "Enter new port:")
        if new_port:
            # Logique pour changer le port dans les fichiers de configuration
            self.log(f"Port changed to {new_port}. You may need to restart Apache.")
            messagebox.showinfo("Info", f"Port changed to {new_port}. You may need to restart Apache.")

    def install_php_package(self):
        """Fonction pour installer un nouveau package PHP."""
        package_name = simpledialog.askstring("Install PHP Package", "Enter package name:")
        if package_name:
            # Logique pour installer le package (à définir selon votre environnement)
            self.log(f"Installing PHP package: {package_name}.")

if __name__ == "__main__":
    root = tk.Tk()
    app = ServerManagerApp(root)
    root.mainloop()
